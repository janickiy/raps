<?php

namespace App\Repositories;

use App\Models\PhotoAlbum;

class PhotoAlbumRepository extends BaseRepository
{
    public function __construct(PhotoAlbum $model)
    {
        parent::__construct($model);
    }

    /**
     * @param int $id
     * @param array $data
     * @return PhotoAlbum|null
     */
    public function update(int $id, array $data): ?PhotoAlbum
    {
        $model = $this->model->find($id);

        if ($model) {
            $model->title = $data['title'];
            $model->description = $data['description'] ?? null;
            $model->meta_title = $data['meta_title'] ?? null;
            $model->meta_description = $data['meta_description'] ?? null;
            $model->meta_keywords = $data['meta_keywords'] ?? null;
            $model->seo_h1 = $data['seo_h1'] ?? null;
            $model->seo_url_canonical = $data['seo_url_canonical'] ?? null;
            $model->seo_sitemap = (int) $data['seo_sitemap'];
            $model->slug = $data['slug'];
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
