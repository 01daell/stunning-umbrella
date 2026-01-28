<?php

namespace App\Http\Requests\App;

use Illuminate\Foundation\Http\FormRequest;

class StoreBrandKitRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:120'],
            'tagline' => ['nullable', 'string', 'max:160'],
            'description' => ['nullable', 'string', 'max:500'],
            'voice_keywords_text' => ['nullable', 'string'],
            'usage_do_text' => ['nullable', 'string'],
            'usage_dont_text' => ['nullable', 'string'],
        ];
    }
}
