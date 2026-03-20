<?php

namespace App\Http\Requests\Admin\Users;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'login' => 'required|string|max:255|unique:users,login',
            'name' => 'required|string|max:255',
            'role' => ['required', 'string', Rule::in(['admin', 'moderator', 'editor'])],
            'password' => 'required|string|min:6|max:255',
            'password_again' => 'required|string|min:6|same:password',
        ];
    }
}
