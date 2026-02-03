<?php

namespace App\Http\Requests\Admin\Photos;

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
            'id'    => 'required|integer|exists:photos,id',
            'image' => 'image|mimes:jpeg,jpg,png,gif|max:2048|nullable',
            'photoalbum_id' => 'required|integer|exists:photoalbum,id',
        ];
    }
}
