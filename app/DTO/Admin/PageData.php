<?php

namespace App\DTO\Admin;

use App\Http\Requests\Admin\Pages\EditRequest;
use App\Http\Requests\Admin\Pages\StoreRequest;

final class PageData
{
    public function __construct(
        public readonly string $title,
        public readonly string $text,
        public readonly ?string $metaTitle,
        public readonly ?string $metaDescription,
        public readonly ?string $metaKeywords,
        public readonly ?string $seoH1,
        public readonly ?string $seoUrlCanonical,
        public readonly int $seoSitemap,
        public readonly string $slug,
        public readonly int $main,
        public readonly int $published,
        public readonly int $parentId,
        public readonly ?string $imageTitle,
        public readonly ?string $imageAlt,
        public readonly ?string $image,
    ) {
    }

    public static function fromRequest(StoreRequest|EditRequest $request, ?string $image = null): self
    {
        return new self(
            title: (string) $request->string('title'),
            text: (string) $request->string('text'),
            metaTitle: $request->filled('meta_title') ? (string) $request->string('meta_title') : null,
            metaDescription: $request->filled('meta_description') ? (string) $request->string('meta_description') : null,
            metaKeywords: $request->filled('meta_keywords') ? (string) $request->string('meta_keywords') : null,
            seoH1: $request->filled('seo_h1') ? (string) $request->string('seo_h1') : null,
            seoUrlCanonical: $request->filled('seo_url_canonical') ? (string) $request->string('seo_url_canonical') : null,
            seoSitemap: $request->boolean('seo_sitemap') ? 1 : 0,
            slug: (string) $request->string('slug'),
            main: $request->boolean('main') ? 1 : 0,
            published: $request->boolean('published') ? 1 : 0,
            parentId: (int) $request->integer('parent_id', 0),
            imageTitle: $request->filled('image_title') ? (string) $request->string('image_title') : null,
            imageAlt: $request->filled('image_alt') ? (string) $request->string('image_alt') : null,
            image: $image,
        );
    }

    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'text' => $this->text,
            'meta_title' => $this->metaTitle,
            'meta_description' => $this->metaDescription,
            'meta_keywords' => $this->metaKeywords,
            'seo_h1' => $this->seoH1,
            'seo_url_canonical' => $this->seoUrlCanonical,
            'seo_sitemap' => $this->seoSitemap,
            'slug' => $this->slug,
            'main' => $this->main,
            'published' => $this->published,
            'parent_id' => $this->parentId,
            'image_title' => $this->imageTitle,
            'image_alt' => $this->imageAlt,
            'image' => $this->image,
        ];
    }
}
