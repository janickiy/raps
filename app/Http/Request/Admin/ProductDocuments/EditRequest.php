<?php

namespace App\Http\Request\Admin\ProductDocuments;

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
            'file' => 'nullable|file|mimes:jpg,png,doc,pdf,docx,txt,pdf,xls,xlsx,odt,ods',
            'description' => 'required',
        ];
    }
}
