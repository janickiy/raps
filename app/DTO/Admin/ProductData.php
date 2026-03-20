<?php

namespace App\DTO\Admin;

use App\Http\Requests\Admin\Products\EditRequest;
use App\Http\Requests\Admin\Products\StoreRequest;

final class ProductData
{
    public function __construct(
        public readonly string $title,
        public readonly string $description,
        public readonly string $fullDescription,
        public readonly ?string $thumbnail,
        public readonly ?string $origin,
        public readonly int $catalogId,
        public readonly int $price,
        public readonly ?string $metaTitle,
        public readonly ?string $metaDescription,
        public readonly ?string $metaKeywords,
        public readonly ?string $slug,
        public readonly ?string $seoUrlCanonical,
        public readonly ?string $seoH1,
        public readonly int $seoSitemap,
        public readonly ?string $imageTitle,
        public readonly ?string $imageAlt,
        public readonly int $published,
        public readonly ?string $explosionProtection,
        public readonly ?string $gases,
        public readonly ?string $dustProtection,
    ) {
    }

    public static function fromRequest(StoreRequest|EditRequest $request, ?string $thumbnail = null, ?string $origin = null): self
    {
        return new self(
            title: (string) $request->string('title'),
            description: (string) $request->string('description'),
            fullDescription: (string) $request->string('full_description'),
            thumbnail: $thumbnail,
            origin: $origin,
            catalogId: (int) $request->integer('catalog_id'),
            price: (int) $request->integer('price', 0),
            metaTitle: $request->filled('meta_title') ? (string) $request->string('meta_title') : null,
            metaDescription: $request->filled('meta_description') ? (string) $request->string('meta_description') : null,
            metaKeywords: $request->filled('meta_keywords') ? (string) $request->string('meta_keywords') : null,
            slug: $request->filled('slug') ? (string) $request->string('slug') : null,
            seoUrlCanonical: $request->filled('seo_url_canonical') ? (string) $request->string('seo_url_canonical') : null,
            seoH1: $request->filled('seo_h1') ? (string) $request->string('seo_h1') : null,
            seoSitemap: $request->boolean('seo_sitemap') ? 1 : 0,
            imageTitle: $request->filled('image_title') ? (string) $request->string('image_title') : null,
            imageAlt: $request->filled('image_alt') ? (string) $request->string('image_alt') : null,
            published: $request->boolean('published') ? 1 : 0,
            explosionProtection: $request->filled('explosion_protection') ? (string) $request->string('explosion_protection') : null,
            gases: $request->filled('gases') ? (string) $request->string('gases') : null,
            dustProtection: $request->filled('dust_protection') ? (string) $request->string('dust_protection') : null,
        );
    }

    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'full_description' => $this->fullDescription,
            'thumbnail' => $this->thumbnail,
            'origin' => $this->origin,
            'catalog_id' => $this->catalogId,
            'price' => $this->price,
            'meta_title' => $this->metaTitle,
            'meta_description' => $this->metaDescription,
            'meta_keywords' => $this->metaKeywords,
            'slug' => $this->slug,
            'seo_url_canonical' => $this->seoUrlCanonical,
            'seo_h1' => $this->seoH1,
            'seo_sitemap' => $this->seoSitemap,
            'image_title' => $this->imageTitle,
            'image_alt' => $this->imageAlt,
            'published' => $this->published,
            'explosion_protection' => $this->explosionProtection,
            'gases' => $this->gases,
            'dust_protection' => $this->dustProtection,
        ];
    }
}
