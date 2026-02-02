<?php

namespace App\Repositories;

use App\Models\Seo;

class SeoRepository extends BaseRepository
{
    public function __construct(Seo $model)
    {
        parent::__construct($model);
    }

    /**
     * @param int $id
     * @param array $data
     * @return Seo|null
     */
    public function update(int $id, array $data): ?Seo
    {
        $model = $this->model->find($id);

        if ($model) {
            $model->h1 = $data['h1'];
            $model->title = $data['title'];
            $model->keyword = $data['keyword'];
            $model->description = $data['description'];
            $model->url_canonical = $data['url_canonical'];
            $model->save();

            return $model;
        }
        return null;
    }
}
