<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\BrandKit;
use App\Services\ExportService;
use App\Services\PlanService;
use App\Services\TemplateGeneratorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BrandKitExportController extends Controller
{
    public function __construct(
        protected ExportService $exporter,
        protected TemplateGeneratorService $templates,
        protected PlanService $plans,
    ) {
    }

    public function export(Request $request, BrandKit $kit)
    {
        $this->authorize('view', $kit);

        $workspace = $kit->workspace;
        $path = $this->exporter->generatePdf(
            $kit,
            $this->plans->requiresWatermark($workspace),
            $this->plans->canWhiteLabel($workspace) ? [
                'name' => $workspace->white_label_name,
                'logo' => $workspace->white_label_logo_path,
            ] : null
        );

        return Storage::disk('local')->download($path, "{$kit->name}-brand-guide.pdf");
    }

    public function zip(Request $request, BrandKit $kit)
    {
        $this->authorize('view', $kit);

        if (!$this->plans->canZipExport($kit->workspace)) {
            return redirect()->route('app.billing')->with('status', 'Upgrade to Pro to export ZIP packages.');
        }

        $path = $this->exporter->generateZip($kit);

        return Storage::disk('local')->download($path, "{$kit->name}-brand-kit.zip");
    }

    public function templates(Request $request, BrandKit $kit)
    {
        $this->authorize('view', $kit);

        $allowed = $this->plans->allowsTemplates($kit->workspace);

        $templates = [];
        if (in_array('SOCIAL_PROFILE', $allowed, true)) {
            $templates['SOCIAL_PROFILE'] = $this->templates->generateSocialProfile($kit);
        }
        if (in_array('SOCIAL_BANNER', $allowed, true)) {
            $templates['SOCIAL_BANNER'] = $this->templates->generateSocialBanner($kit);
        }
        if (in_array('FAVICON', $allowed, true)) {
            $paths = $this->templates->generateFaviconPack($kit);
            $templates['FAVICON'] = json_encode(['paths' => $paths]);
        }
        if (in_array('EMAIL_SIGNATURE', $allowed, true)) {
            $templates['EMAIL_SIGNATURE'] = $this->templates->generateEmailSignature($kit);
        }

        foreach ($templates as $type => $path) {
            $kit->templates()->updateOrCreate([
                'type' => $type,
                'brand_kit_id' => $kit->id,
            ], [
                'path' => $path,
                'meta' => ['generated_at' => now()->toDateTimeString()],
            ]);
        }

        return back()->with('status', 'Templates regenerated.');
    }
}
