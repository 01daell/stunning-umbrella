<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Http\Requests\App\StoreBrandAssetRequest;
use App\Http\Requests\App\StoreBrandKitRequest;
use App\Http\Requests\App\StoreColorRequest;
use App\Http\Requests\App\UpdateBrandKitRequest;
use App\Models\BrandKit;
use App\Models\BrandAsset;
use App\Models\Color;
use App\Models\FontSelection;
use App\Services\ContrastService;
use App\Services\PlanService;
use App\Services\WorkspaceContext;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BrandKitController extends Controller
{
    public function __construct(
        protected WorkspaceContext $context,
        protected PlanService $plans,
        protected ContrastService $contrast,
    ) {
    }

    public function create(Request $request)
    {
        $workspace = $this->context->current($request->user());
        if (!$this->plans->canCreateKit($workspace)) {
            return redirect()->route('app.billing')->with('status', 'Upgrade your plan to create more kits.');
        }

        return view('app.kits.create', [
            'workspace' => $workspace,
        ]);
    }

    public function store(StoreBrandKitRequest $request)
    {
        $workspace = $this->context->current($request->user());
        if (!$this->plans->canCreateKit($workspace)) {
            return redirect()->route('app.billing')->with('status', 'Upgrade your plan to create more kits.');
        }

        $data = $this->normalizeKitData($request->validated());
        $kit = $workspace->kits()->create($data);

        return redirect()->route('app.kits.show', $kit);
    }

    public function show(Request $request, BrandKit $kit)
    {
        $this->authorize('view', $kit);

        $kit->load(['assets', 'colors', 'fontSelection', 'templates']);

        $contrasts = [];
        $colors = $kit->colors;
        foreach ($colors as $i => $primary) {
            foreach ($colors as $j => $secondary) {
                if ($i >= $j) {
                    continue;
                }
                $ratio = $this->contrast->ratio($primary->hex, $secondary->hex);
                $contrasts[] = [
                    'pair' => "{$primary->name} / {$secondary->name}",
                    'ratio' => $ratio,
                    'passes' => $this->contrast->passesAA($ratio),
                ];
            }
        }

        return view('app.kits.show', [
            'workspace' => $this->context->current($request->user()),
            'kit' => $kit,
            'plan' => $this->plans->getPlan($kit->workspace),
            'contrasts' => $contrasts,
        ]);
    }

    public function update(UpdateBrandKitRequest $request, BrandKit $kit)
    {
        $this->authorize('update', $kit);
        $kit->update($this->normalizeKitData($request->validated()));

        return back()->with('status', 'Brand kit updated.');
    }

    public function destroy(BrandKit $kit)
    {
        $this->authorize('delete', $kit);
        $kit->delete();

        return redirect()->route('app.dashboard')->with('status', 'Brand kit deleted.');
    }

    public function storeAsset(StoreBrandAssetRequest $request, BrandKit $kit)
    {
        $this->authorize('update', $kit);

        $file = $request->file('asset');
        $path = $file->store("private/logos/{$kit->id}");

        $asset = $kit->assets()->create([
            'type' => $request->string('type')->toString(),
            'path' => $path,
            'mime' => $file->getClientMimeType(),
            'size' => $file->getSize(),
            'original_name' => $file->getClientOriginalName(),
        ]);

        return back()->with('status', 'Logo uploaded.');
    }

    public function destroyAsset(BrandKit $kit, BrandAsset $asset)
    {
        $this->authorize('update', $kit);

        if ($asset->brand_kit_id !== $kit->id) {
            abort(403);
        }

        Storage::disk('local')->delete($asset->path);
        $asset->delete();

        return back()->with('status', 'Logo removed.');
    }

    public function storeColor(StoreColorRequest $request, BrandKit $kit)
    {
        $this->authorize('update', $kit);

        $kit->colors()->create($request->validated());

        return back()->with('status', 'Color added.');
    }

    public function destroyColor(BrandKit $kit, Color $color)
    {
        $this->authorize('update', $kit);

        if ($color->brand_kit_id !== $kit->id) {
            abort(403);
        }

        $color->delete();

        return back()->with('status', 'Color removed.');
    }

    public function updateFonts(Request $request, BrandKit $kit)
    {
        $this->authorize('update', $kit);

        $validated = $request->validate([
            'heading_font' => ['required', 'string', 'max:100'],
            'body_font' => ['required', 'string', 'max:100'],
            'heading_weights' => ['nullable', 'array'],
            'body_weights' => ['nullable', 'array'],
            'source' => ['required', 'string', 'max:60'],
        ]);

        $kit->fontSelection()->updateOrCreate([
            'brand_kit_id' => $kit->id,
        ], $validated);

        return back()->with('status', 'Fonts updated.');
    }

    protected function normalizeKitData(array $data): array
    {
        $data['voice_keywords'] = $this->splitLines($data['voice_keywords_text'] ?? '');
        $data['usage_do'] = $this->splitLines($data['usage_do_text'] ?? '');
        $data['usage_dont'] = $this->splitLines($data['usage_dont_text'] ?? '');

        unset($data['voice_keywords_text'], $data['usage_do_text'], $data['usage_dont_text']);

        return $data;
    }

    protected function splitLines(string $value): array
    {
        return collect(preg_split('/[\\r\\n,]+/', $value))
            ->map(fn ($item) => trim($item))
            ->filter()
            ->values()
            ->all();
    }
}
