<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Http\Requests\App\StoreInviteRequest;
use App\Http\Requests\App\UpdateWorkspaceSettingsRequest;
use App\Mail\WorkspaceInviteMail;
use App\Models\Invite;
use App\Services\PlanService;
use App\Services\WorkspaceContext;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class WorkspaceMemberController extends Controller
{
    public function __construct(
        protected WorkspaceContext $context,
        protected PlanService $plans,
    ) {
    }

    public function index(Request $request)
    {
        $workspace = $this->context->current($request->user());
        $this->authorize('manage', $workspace);

        return view('app.workspaces.members', [
            'workspace' => $workspace->load('members'),
            'canInvite' => $this->plans->canInviteClients($workspace),
        ]);
    }

    public function store(StoreInviteRequest $request)
    {
        $workspace = $this->context->current($request->user());
        $this->authorize('manage', $workspace);

        if (!$this->plans->canInviteClients($workspace)) {
            return redirect()->route('app.billing')->with('status', 'Upgrade to Agency to invite clients.');
        }

        $invite = $workspace->invites()->create([
            'email' => $request->string('email')->toString(),
            'role' => $request->string('role')->toString(),
            'status' => 'pending',
            'expires_at' => now()->addDays(7),
        ]);

        Mail::to($invite->email)->send(new WorkspaceInviteMail($invite));

        return back()->with('status', 'Invite sent.');
    }

    public function accept(Request $request, string $token)
    {
        $invite = Invite::query()->where('token', $token)->firstOrFail();
        if ($invite->isExpired() || $invite->status !== 'pending') {
            return redirect()->route('login')->withErrors(['email' => 'Invite has expired.']);
        }

        $user = $request->user();
        if (!$user) {
            return redirect()->route('register', ['invite' => $token]);
        }

        $invite->workspace->members()->syncWithoutDetaching([
            $user->id => ['role' => $invite->role],
        ]);

        $invite->update(['status' => 'accepted']);

        return redirect()->route('app.dashboard');
    }

    public function updateSettings(UpdateWorkspaceSettingsRequest $request)
    {
        $workspace = $this->context->current($request->user());
        $this->authorize('manage', $workspace);

        $data = $request->validated();

        if (!$this->plans->canWhiteLabel($workspace)) {
            unset($data['white_label_name']);
        } elseif ($request->hasFile('white_label_logo')) {
            $path = $request->file('white_label_logo')->store("private/workspaces/{$workspace->id}");
            $data['white_label_logo_path'] = $path;
        }

        $workspace->update($data);

        return back()->with('status', 'Workspace settings updated.');
    }

    public function createWorkspace(Request $request)
    {
        $request->validate(['name' => ['required', 'string', 'max:120']]);
        $current = $this->context->current($request->user());

        if (!$this->plans->canInviteClients($current)) {
            return redirect()->route('app.billing')->with('status', 'Upgrade to Agency to create multiple workspaces.');
        }

        $workspace = $request->user()->ownedWorkspaces()->create([
            'name' => $request->string('name')->toString(),
            'created_by' => $request->user()->id,
        ]);

        $workspace->members()->attach($request->user()->id, ['role' => 'OWNER']);
        $this->context->switch($request->user(), $workspace->id);

        return redirect()->route('app.dashboard')->with('status', 'Workspace created.');
    }
}
