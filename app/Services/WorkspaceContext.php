<?php

namespace App\Services;

use App\Models\User;
use App\Models\Workspace;
use Illuminate\Support\Facades\Session;

class WorkspaceContext
{
    public function current(User $user): Workspace
    {
        $workspaceId = Session::get('workspace_id');

        if ($workspaceId) {
            $workspace = $user->workspaces()->where('workspaces.id', $workspaceId)->first();
            if ($workspace) {
                return $workspace;
            }
        }

        $workspace = $user->workspaces()->first();
        if ($workspace) {
            Session::put('workspace_id', $workspace->id);
            return $workspace;
        }

        return $user->ownedWorkspaces()->firstOrFail();
    }

    public function switch(User $user, int $workspaceId): void
    {
        $workspace = $user->workspaces()->where('workspaces.id', $workspaceId)->firstOrFail();
        Session::put('workspace_id', $workspace->id);
    }
}
