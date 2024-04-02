<?php

namespace App\Http\Request\Admin\Catalog;

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

            'name' => 'required',
            'image' => 'image|mimes:jpeg,jpg,png,gif|max:2048|nullable',
            'slug' => 'required|unique:catalog,slug,' . $this->id,
        ];
    }
}
