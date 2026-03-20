<?php

namespace App\DTO\Admin;

use App\Http\Requests\Admin\Services\EditRequest;
use App\Http\Requests\Admin\Services\StoreRequest;

final class ServiceData
{
    public function __construct(
        public readonly string  $title,
        public readonly string  $description,
        public readonly string  $fullDescription,
        public readonly ?string $image,
        public readonly ?string $imageTitle,
        public readonly ?string $imageAlt,
        public readonly ?string $metaTitle,
        public readonly ?string $metaDescription,
        public readonly ?string $metaKeywords,
        public readonly string  $slug,
        public readonly ?string $seoH1,
        public readonly ?string $seoUrlCanonical,
        public readonly int     $published,
        public readonly int     $seoSitemap,
    )
    {
    }

    public static function fromRequest(StoreRequest|EditRequest $request, ?string $image = null): self
    {
        return new self(
            title: (string)$request->string('title'),
            description: (string)$request->string('description'),
            fullDescription: (string)$request->string('full_description'),
            image: $image,
            imageTitle: $request->filled('image_title') ? (string)$request->string('image_title') : null,
            imageAlt: $request->filled('image_alt') ? (string)$request->string('image_alt') : null,
            metaTitle: $request->filled('meta_title') ? (string)$request->string('meta_title') : null,
            metaDescription: $request->filled('meta_description') ? (string)$request->string('meta_description') : null,
            metaKeywords: $request->filled('meta_keywords') ? (string)$request->string('meta_keywords') : null,
            slug: (string)$request->string('slug'),
            seoH1: $request->filled('seo_h1') ? (string)$request->string('seo_h1') : null,
            seoUrlCanonical: $request->filled('seo_url_canonical') ? (string)$request->string('seo_url_canonical') : null,
            published: $request->boolean('published') ? 1 : 0,
            seoSitemap: $request->boolean('seo_sitemap') ? 1 : 0,
        );
    }

    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'full_description' => $this->fullDescription,
            'image' => $this->image,
            'image_title' => $this->imageTitle,
            'image_alt' => $this->imageAlt,
            'meta_title' => $this->metaTitle,
            'meta_description' => $this->metaDescription,
            'meta_keywords' => $this->metaKeywords,
            'slug' => $this->slug,
            'seo_h1' => $this->seoH1,
            'seo_url_canonical' => $this->seoUrlCanonical,
            'published' => $this->published,
            'seo_sitemap' => $this->seoSitemap,
        ];
    }
}
