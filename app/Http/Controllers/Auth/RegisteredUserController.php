<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Workspace;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisteredUserController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', 'min:8'],
            'workspace_name' => ['required_without:invite_token', 'string', 'max:120'],
            'invite_token' => ['nullable', 'string'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        if (!empty($validated['invite_token'])) {
            $invite = \App\Models\Invite::query()->where('token', $validated['invite_token'])->first();
            if ($invite && !$invite->isExpired() && $invite->status === 'pending') {
                $invite->workspace->members()->syncWithoutDetaching([
                    $user->id => ['role' => $invite->role],
                ]);
                $invite->update(['status' => 'accepted']);
            }
        } else {
            $workspace = Workspace::create([
                'name' => $validated['workspace_name'],
                'created_by' => $user->id,
            ]);

            $workspace->members()->attach($user->id, ['role' => 'OWNER']);
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('app.dashboard');
    }
}
