<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Services\WorkspaceContext;
use Illuminate\Http\Request;

class WorkspaceSwitchController extends Controller
{
    public function __construct(protected WorkspaceContext $context)
    {
    }

    public function __invoke(Request $request)
    {
        $request->validate([
            'workspace_id' => ['required', 'integer'],
        ]);

        $this->context->switch($request->user(), (int) $request->input('workspace_id'));

        return back();
    }
}
