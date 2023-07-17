<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTravelRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'isPublic' => 'boolean',
            'name' => ['nullable', 'unique:travels', 'string'],
            'slug' => ['nullable', 'unique:travels', 'regex:/^[a-z0-9\-]+$/'],
            'description' => ['nullable', 'string'],
            'numberOfDays' => ['nullable', 'integer'],
            'nature' => ['nullable', 'integer'],
            'relax' => ['nullable', 'integer'],
            'history' => ['nullable', 'integer'],
            'culture' => ['nullable', 'integer'],
            'party' => ['nullable', 'integer'],
        ];
    }
}
