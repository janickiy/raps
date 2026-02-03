<?php

namespace App\Repositories;

use App\Models\Services;

class ServicesRepository extends BaseRepository
{
    public function __construct(Services $model)
    {
        parent::__construct($model);
    }

    /**
     * @param int $id
     * @param array $data
     * @return Services|null
     */
    public function update(int $id, array $data): ?Services
    {
        $model = $this->model->find($id);

        if ($model) {
            $model->title = $data['title'];
            $model->description = $data['description'];

            if ($data['image']) {
                $model->image = $data['image'];
            }

            $model->full_description = $data['full_description'];
            $model->image_title = $data['image_title'];
            $model->image_alt = $data['image_alt'];
            $model->meta_title = $data['meta_title'] ?? null;
            $model->meta_description = $data['meta_description'] ?? null;
            $model->meta_keywords = $data['meta_keywords'] ?? null;
            $model->slug = $data['slug'];
            $model->seo_h1 = $data['seo_h1'];
            $model->seo_url_canonical = $data['seo_url_canonical'];
            $model->published = (int)$data['published'];
            $model->seo_sitemap = (int)$data['seo_sitemap'];
            $model->save();

            return $model;
        }
        return null;
    }

    /**
     * @param int $id
     * @return void
     */
    public function remove(int $id): void
    {
        $model = $this->model->find($id);

        if ($model) {
            $model->remove();
        }
    }
}
