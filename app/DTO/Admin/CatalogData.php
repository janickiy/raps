<?php

namespace App\DTO\Admin;

use App\Http\Requests\Admin\Catalog\EditRequest;
use App\Http\Requests\Admin\Catalog\StoreRequest;

final class CatalogData
{
    public function __construct(
        public readonly string  $name,
        public readonly ?string $description,
        public readonly ?string $metaTitle,
        public readonly ?string $metaDescription,
        public readonly ?string $metaKeywords,
        public readonly ?string $image,
        public readonly string  $slug,
        public readonly ?string $seoH1,
        public readonly ?string $seoUrlCanonical,
        public readonly int     $seoSitemap,
        public readonly ?string $imageTitle,
        public readonly ?string $imageAlt,
        public readonly int     $parentId,
    )
    {
    }

    public static function fromRequest(StoreRequest|EditRequest $request, ?string $image = null): self
    {
        return new self(
            name: (string)$request->string('name'),
            description: $request->filled('description') ? (string)$request->string('description') : null,
            metaTitle: $request->filled('meta_title') ? (string)$request->string('meta_title') : null,
            metaDescription: $request->filled('meta_description') ? (string)$request->string('meta_description') : null,
            metaKeywords: $request->filled('meta_keywords') ? (string)$request->string('meta_keywords') : null,
            image: $image,
            slug: (string)$request->string('slug'),
            seoH1: $request->filled('seo_h1') ? (string)$request->string('seo_h1') : null,
            seoUrlCanonical: $request->filled('seo_url_canonical') ? (string)$request->string('seo_url_canonical') : null,
            seoSitemap: $request->boolean('seo_sitemap') ? 1 : 0,
            imageTitle: $request->filled('image_title') ? (string)$request->string('image_title') : null,
            imageAlt: $request->filled('image_alt') ? (string)$request->string('image_alt') : null,
            parentId: (int)$request->integer('parent_id', 0),
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'meta_title' => $this->metaTitle,
            'meta_description' => $this->metaDescription,
            'meta_keywords' => $this->metaKeywords,
            'image' => $this->image,
            'slug' => $this->slug,
            'seo_h1' => $this->seoH1,
            'seo_url_canonical' => $this->seoUrlCanonical,
            'seo_sitemap' => $this->seoSitemap,
            'image_title' => $this->imageTitle,
            'image_alt' => $this->imageAlt,
            'parent_id' => $this->parentId,
        ];
    }
}
