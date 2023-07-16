<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTravelRequest extends FormRequest
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
            'name' => ['required','unique:travels'],
            'slug' => ['required','unique:travels','regex:/^[a-z0-9\-]+$/'],
            'description' => ['required'],
            'numberOfDays' => ['required','integer'],
            'nature' => ['required','integer'] ,
            'relax' => ['required','integer'],
            'history' => ['required','integer'],
            'culture' => ['required','integer'],
            'party' => ['required','integer']
        ];
    }
}
