<?php

namespace App\Http\Controllers;

use App\Models\ShareLink;
use App\Services\PlanService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ShareController extends Controller
{
    public function __construct(protected PlanService $plans)
    {
    }

    public function show(Request $request, string $token)
    {
        $link = ShareLink::where('token', $token)->firstOrFail();
        if (!$link->isActive()) {
            abort(404);
        }

        $kit = $link->kit()->with(['colors', 'assets', 'fontSelection', 'templates'])->firstOrFail();
        $workspace = $kit->workspace;

        return view('share.show', [
            'kit' => $kit,
            'link' => $link,
            'canZip' => $this->plans->canZipExport($workspace),
        ]);
    }

    public function downloadZip(Request $request, string $token)
    {
        $link = ShareLink::where('token', $token)->firstOrFail();
        if (!$link->isActive()) {
            abort(404);
        }

        $kit = $link->kit;
        if (!$this->plans->canZipExport($kit->workspace)) {
            abort(403);
        }

        $path = "private/exports/{$kit->id}/brand-kit.zip";
        if (!Storage::disk('local')->exists($path)) {
            abort(404);
        }

        return Storage::disk('local')->download($path, "{$kit->name}-brand-kit.zip");
    }
}
