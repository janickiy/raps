<?php

namespace App\Http\Request\Admin\Products;

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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required',
            'description' => 'required',
            'full_description' => 'required',
            'slug' => 'required|unique:products,slug,' . $this->id,
            'image' => 'image|mimes:jpeg,jpg,png,gif|max:2048|nullable',
            'price' => 'nullable|integer',
            'catalog_id' => 'integer|required|exists:catalog,id',
        ];
    }
}
