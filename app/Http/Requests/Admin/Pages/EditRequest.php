<?php

namespace App\Http\Requests\Admin\Pages;

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
            'id'    => 'required|integer|exists:pages,id',
            'title' => 'required',
            'text' => 'required',
            'image' => 'image|mimes:jpeg,jpg,png,gif|max:2048|nullable',
            'slug' => 'required|unique:pages,slug,' . $this->id,
            'main' => 'integer|nullable'
        ];
    }
}
