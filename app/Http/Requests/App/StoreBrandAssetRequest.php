<?php

namespace App\Http\Requests\App;

use Illuminate\Foundation\Http\FormRequest;

class StoreBrandAssetRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'type' => ['required', 'in:PRIMARY_LOGO,ICON,MONO,OTHER'],
            'asset' => ['required', 'file', 'mimes:png,jpg,jpeg,svg,pdf', 'max:4096'],
        ];
    }
}
