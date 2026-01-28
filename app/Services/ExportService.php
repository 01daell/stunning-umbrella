<?php

namespace App\Services;

use App\Models\BrandKit;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class ExportService
{
    public function generatePdf(BrandKit $kit, bool $watermark, ?array $whiteLabel = null): string
    {
        $pdf = \PDF::loadView('app.kits.pdf', [
            'kit' => $kit,
            'watermark' => $watermark,
            'whiteLabel' => $whiteLabel,
        ])->setPaper('a4');

        $path = "private/exports/{$kit->id}/brand-guide.pdf";
        Storage::disk('local')->put($path, $pdf->output());

        return $path;
    }

    public function generateZip(BrandKit $kit): string
    {
        $zipPath = storage_path("app/private/exports/{$kit->id}/brand-kit.zip");
        if (!is_dir(dirname($zipPath))) {
            mkdir(dirname($zipPath), 0755, true);
        }

        $zip = new ZipArchive();
        $zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE);

        $zip->addFromString('colors.txt', $kit->colors->map(fn ($color) => "{$color->name}: {$color->hex}")->implode("\n"));
        $zip->addFromString('colors.json', $kit->colors->toJson());
        $zip->addFromString('fonts.txt', $this->fontSummary($kit));
        $zip->addFromString('README.txt', "StudioKit export for {$kit->name}.\nGenerated at ".now()->toDateTimeString());

        foreach ($kit->assets as $asset) {
            if (Storage::disk('local')->exists($asset->path)) {
                $zip->addFile(Storage::disk('local')->path($asset->path), "logos/{$asset->original_name}");
            }
        }

        foreach ($kit->templates as $template) {
            if (Storage::disk('local')->exists($template->path)) {
                $zip->addFile(Storage::disk('local')->path($template->path), "templates/".basename($template->path));
            }
        }

        $signature = "private/templates/{$kit->id}/email-signature.html";
        if (Storage::disk('local')->exists($signature)) {
            $zip->addFile(Storage::disk('local')->path($signature), 'email-signature.html');
        }

        $zip->close();

        return "private/exports/{$kit->id}/brand-kit.zip";
    }

    protected function fontSummary(BrandKit $kit): string
    {
        $font = $kit->fontSelection;
        if (!$font) {
            return 'No font selections yet.';
        }

        return "Heading: {$font->heading_font} (".implode(',', $font->heading_weights ?? []).")\n".
            "Body: {$font->body_font} (".implode(',', $font->body_weights ?? []).")\n".
            "Source: {$font->source}";
    }
}
