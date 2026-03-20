<?php

namespace App\Repositories;

use App\DTO\Admin\PageData;
use App\Models\Pages;

class PagesRepository extends BaseRepository
{
    public function __construct(Pages $model)
    {
        parent::__construct($model);
    }

    public function createFromDto(PageData $data): Pages
    {
        $payload = $data->toArray();

        if ($payload['main'] === 1) {
            Pages::where('main', 1)->update(['main' => 0]);
        }

        /** @var Pages $page */
        $page = $this->model->create($payload);

        return $page;
    }

    public function updateFromDto(int $id, PageData $data): ?Pages
    {
        $model = $this->model->find($id);

        if (!$model) {
            return null;
        }

        $payload = $data->toArray();

        if ($payload['main'] === 1) {
            Pages::where('main', 1)->where('id', '!=', $id)->update(['main' => 0]);
        }

        $model->title = $payload['title'];
        $model->text = $payload['text'];
        $model->meta_title = $payload['meta_title'];
        $model->meta_description = $payload['meta_description'];
        $model->meta_keywords = $payload['meta_keywords'];
        $model->slug = $payload['slug'];
        $model->seo_h1 = $payload['seo_h1'];
        $model->seo_url_canonical = $payload['seo_url_canonical'];
        $model->published = $payload['published'];
        $model->main = $payload['main'];
        $model->seo_sitemap = $payload['seo_sitemap'];
        $model->parent_id = $payload['parent_id'];
        $model->image_title = $payload['image_title'];
        $model->image_alt = $payload['image_alt'];

        if ($payload['image'] !== null) {
            $model->image = $payload['image'];
        }

        $model->save();

        return $model;
    }

    /**
     * @return array
     */
    public function getOption(): array
    {
        $options = [];

        foreach (Pages::orderBy('id')->published()->get() ?? [] as $page) {
            $options[$page->id] = $page->title;
        }

        return $options;
    }

    public function remove(int $id): void
    {
        $model = $this->model->find($id);

        if ($model) {
            $model->remove();
        }
    }
}
