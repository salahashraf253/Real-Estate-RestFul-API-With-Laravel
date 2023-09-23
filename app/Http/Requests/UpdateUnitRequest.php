<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUnitRequest extends FormRequest
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
            'name' => 'sometimes|required|max:255',
            'description' => 'sometimes|required|max:1023',
            'city' => 'sometimes|required|max:255',
            'price' => 'sometimes|required|numeric|max:10000000',
            'type' => 'sometimes|required|max:255',
            'location' => 'sometimes|required|max:1023',
            'rooms' => 'sometimes|required|numeric|max:50',
            'bathrooms' => 'sometimes|required|numeric|max:55',
            'size' => 'sometimes|required|numeric|max:1500',
        ];
    }
}
