<?php

namespace App\Http\Requests;

use App\Models\Unit;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class BuyUnitRequest extends FormRequest
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
            'unit_id' => [
                'required',
                'numeric',
                Rule::exists('units', 'id'),
            ],
            'price'=>[
                'required',
                'numeric',
            ],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function ($validator) {
            $unitId = $this->input('unit_id');
            $unit = Unit::find($unitId);
            if (! $unit) {
                $validator->errors()->add('unit_id', 'The selected unit does not exist.');
            } elseif ($unit->is_sold) {
                $validator->errors()->add('unit_id', 'The selected unit has already been sold.');
            }
        });
    }
}
