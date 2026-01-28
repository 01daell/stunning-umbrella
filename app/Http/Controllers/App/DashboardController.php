<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Services\PlanService;
use App\Services\WorkspaceContext;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(
        protected WorkspaceContext $context,
        protected PlanService $plans,
    ) {
    }

    public function index(Request $request)
    {
        $workspace = $this->context->current($request->user());
        $query = $workspace->kits()->with('colors');

        if ($search = $request->string('search')->toString()) {
            $query->where('name', 'like', "%{$search}%");
        }

        $sort = $request->string('sort')->toString();
        if ($sort === 'name') {
            $query->orderBy('name');
        } else {
            $query->orderByDesc('created_at');
        }

        return view('app.dashboard', [
            'workspace' => $workspace,
            'kits' => $query->paginate(10),
            'plan' => $this->plans->getPlan($workspace),
            'canCreateKit' => $this->plans->canCreateKit($workspace),
        ]);
    }
}
