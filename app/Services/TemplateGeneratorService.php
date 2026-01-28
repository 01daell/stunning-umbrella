<?php

namespace App\Services;

use App\Models\BrandKit;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class TemplateGeneratorService
{
    public function generateSocialProfile(BrandKit $kit): string
    {
        return $this->generateImage($kit, 800, 800, 'SOCIAL_PROFILE');
    }

    public function generateSocialBanner(BrandKit $kit): string
    {
        return $this->generateImage($kit, 1500, 500, 'SOCIAL_BANNER');
    }

    public function generateFaviconPack(BrandKit $kit): array
    {
        $icon = $kit->assets()->where('type', 'ICON')->first();
        $sizes = [16, 32, 48, 64, 128, 256];
        $paths = [];

        foreach ($sizes as $size) {
            $canvas = Image::canvas($size, $size, $this->primaryHex($kit));
            if ($icon && Storage::disk('local')->exists($icon->path)) {
                $logo = Image::make(Storage::disk('local')->path($icon->path))
                    ->resize($size * 0.6, $size * 0.6, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                $canvas->insert($logo, 'center');
            }
            $path = "private/templates/{$kit->id}/favicon-{$size}.png";
            Storage::disk('local')->put($path, (string) $canvas->encode('png'));
            $paths[] = $path;
        }

        $icoCanvas = Image::canvas(64, 64, $this->primaryHex($kit));
        if ($icon && Storage::disk('local')->exists($icon->path)) {
            $ico = Image::make(Storage::disk('local')->path($icon->path))
                ->resize(48, 48, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
            $icoCanvas->insert($ico, 'center');
        }
        $icoPath = "private/templates/{$kit->id}/favicon.ico";
        Storage::disk('local')->put($icoPath, (string) $icoCanvas->encode('ico'));
        $paths[] = $icoPath;

        return $paths;
    }

    public function generateEmailSignature(BrandKit $kit): string
    {
        $primary = $this->primaryHex($kit);
        $content = view('app.kits.email-signature', [
            'kit' => $kit,
            'primary' => $primary,
        ])->render();

        $path = "private/templates/{$kit->id}/email-signature.html";
        Storage::disk('local')->put($path, $content);

        return $path;
    }

    protected function generateImage(BrandKit $kit, int $width, int $height, string $type): string
    {
        $canvas = Image::canvas($width, $height, $this->primaryHex($kit));
        $logo = $kit->assets()->where('type', 'PRIMARY_LOGO')->first();

        if ($logo && Storage::disk('local')->exists($logo->path)) {
            $image = Image::make(Storage::disk('local')->path($logo->path))
                ->resize($width * 0.4, $height * 0.4, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
            $canvas->insert($image, 'center');
        }

        $path = "private/templates/{$kit->id}/".strtolower($type).".png";
        Storage::disk('local')->put($path, (string) $canvas->encode('png'));

        return $path;
    }

    protected function primaryHex(BrandKit $kit): string
    {
        $color = $kit->colors()->first();

        return $color ? $color->hex : '#4F46E5';
    }
}
