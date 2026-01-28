<?php

namespace App\Http\Requests\App;

use Illuminate\Foundation\Http\FormRequest;

class StoreColorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:40'],
            'hex' => ['required', 'regex:/^#([A-Fa-f0-9]{6})$/'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'locked' => ['nullable', 'boolean'],
        ];
    }
}
