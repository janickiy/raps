<?php

namespace App\Http\Requests\Admin\Pages;

use Illuminate\Foundation\Http\FormRequest;

class EditRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id' => 'required|integer|exists:pages,id',
            'title' => 'required|string|max:255',
            'text' => 'required|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:255',
            'meta_keywords' => 'nullable|string|max:255',
            'seo_h1' => 'nullable|string|max:255',
            'seo_url_canonical' => 'nullable|string|max:255',
            'slug' => 'required|string|max:255|unique:pages,slug,' . $this->id,
            'main' => 'nullable|boolean',
            'published' => 'nullable|boolean',
            'parent_id' => 'nullable|integer',
            'image_title' => 'nullable|string|max:255',
            'image_alt' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
            'seo_sitemap' => 'nullable|boolean',
        ];
    }
}
