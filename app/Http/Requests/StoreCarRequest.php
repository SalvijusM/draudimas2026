<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCarRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'admin';
    }

    public function rules(): array
    {
        $carId = $this->route('car') ? $this->route('car')->id : null;

        return [
            'reg_number' => [
                'required',
                'string',
                'max:20',
                Rule::unique('cars', 'reg_number')->ignore($carId),
                'regex:/^[A-Z]{3}\d{3}$/i',
            ],
            'brand' => 'required|string|min:3|max:50',
            'model' => 'required|string|min:2|max:50',
            'owner_id' => 'required|exists:owners,id',
        ];
    }

    public function messages(): array
    {
        return [
            'reg_number.required' => __('validation_messages.reg_number_required'),
            'reg_number.unique'   => __('validation_messages.reg_number_unique'),
            'reg_number.regex'    => __('validation_messages.reg_number_incorrect'),
            'brand.required'      => __('validation_messages.brand_required'),
            'brand.min'           => __('validation_messages.brand_too_short', ['min' => 3]), // Pridėtas pranešimas
            'model.required'      => __('validation_messages.model_required'),
            'model.min'           => __('validation_messages.model_too_short', ['min' => 2]), // Pridėtas pranešimas
            'owner_id.required'   => __('validation_messages.owner_required'),
            'owner_id.exists'     => __('validation_messages.owner_not_found'),
        ];
    }
}
