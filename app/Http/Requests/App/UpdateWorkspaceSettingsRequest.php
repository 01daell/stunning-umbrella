<?php

namespace App\Http\Requests\App;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWorkspaceSettingsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:120'],
            'white_label_name' => ['nullable', 'string', 'max:120'],
            'white_label_logo' => ['nullable', 'file', 'mimes:png,jpg,jpeg,svg', 'max:2048'],
        ];
    }
}
