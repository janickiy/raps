<?php

namespace App\Http\Requests\Admin\Services;

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
            'id' => 'required|integer|exists:services,id',
            'title' => 'required',
            'description' => 'required',
            'full_description' => 'required',
            'slug' => 'required|unique:services,slug,' . $this->id,
            'image' => 'image|mimes:jpeg,jpg,png|max:2048|nullable',
        ];
    }
}
