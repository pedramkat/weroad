<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTourRequest extends FormRequest
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
     * @return non-empty-array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'unique:tours'],
            'startingDate' => ['required', 'date:Y-m-d'],
            'endingDate' => ['required', 'date:Y-m-d', 'after:startingDate'],
            'price' => ['required', 'numeric'],
        ];
    }
}
