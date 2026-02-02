<?php

namespace App\Http\Requests\Admin\ProductParameters;

use Illuminate\Foundation\Http\FormRequest;

class EditRequest extends FormRequest
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
     * @return array
     */
    public function rules(): array
    {
        return [
            'id'    => 'required|integer|exists:product_parameters,id',
            'name' => 'required',
            'value' => 'required',
            'category_id' => 'nullable|integer|exists:product_parameters_category,id',
        ];
    }
}
