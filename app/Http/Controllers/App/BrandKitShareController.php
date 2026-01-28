<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\BrandKit;
use App\Models\ShareLink;
use App\Services\PlanService;
use Illuminate\Http\Request;

class BrandKitShareController extends Controller
{
    public function __construct(protected PlanService $plans)
    {
    }

    public function index(Request $request, BrandKit $kit)
    {
        $this->authorize('view', $kit);

        return view('app.kits.share', [
            'kit' => $kit->load('shareLinks'),
            'canShare' => $this->plans->canShareLinks($kit->workspace),
        ]);
    }

    public function store(Request $request, BrandKit $kit)
    {
        $this->authorize('view', $kit);

        if (!$this->plans->canShareLinks($kit->workspace)) {
            return redirect()->route('app.billing')->with('status', 'Upgrade to Pro to enable share links.');
        }

        $kit->shareLinks()->create();

        return back()->with('status', 'Share link created.');
    }

    public function revoke(Request $request, BrandKit $kit, ShareLink $link)
    {
        $this->authorize('view', $kit);

        if ($link->brand_kit_id !== $kit->id) {
            abort(403);
        }

        $link->update(['revoked_at' => now()]);

        return back()->with('status', 'Share link revoked.');
    }
}
