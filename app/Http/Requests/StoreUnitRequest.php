<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUnitRequest extends FormRequest
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
            'name' => 'required|max:255',
            'description' => 'required|max:1023',
            'city' => 'required|max:255',
            'price' => 'required|numeric|max:10000000',
            'type' => 'required|max:255',
            'location' => 'required|max:1023',
            'rooms' => 'required|numeric|max:50',
            'bathrooms' => 'required|numeric|max:55',
            'size' => 'required|numeric|max:1500',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_sold' => 'boolean',
        ];
    }
}
