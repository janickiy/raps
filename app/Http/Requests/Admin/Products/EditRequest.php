<?php

namespace App\Http\Requests\Admin\Products;

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
            'id' => 'required|integer|exists:products,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'full_description' => 'required|string',
            'catalog_id' => 'required|integer|exists:catalog,id',
            'price' => 'nullable|integer|min:0',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:255',
            'meta_keywords' => 'nullable|string|max:255',
            'slug' => 'required|string|max:255|unique:products,slug,' . $this->id,
            'seo_url_canonical' => 'nullable|string|max:255',
            'seo_h1' => 'nullable|string|max:255',
            'seo_sitemap' => 'nullable|boolean',
            'image_title' => 'nullable|string|max:255',
            'image_alt' => 'nullable|string|max:255',
            'published' => 'nullable|boolean',
            'explosion_protection' => 'nullable|string|max:255',
            'gases' => 'nullable|string|max:255',
            'dust_protection' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
        ];
    }
}
