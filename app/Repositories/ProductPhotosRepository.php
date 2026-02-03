<?php

namespace App\Repositories;

use App\Models\ProductPhotos;

class ProductPhotosRepository extends BaseRepository
{
    public function __construct(ProductPhotos $model)
    {
        parent::__construct($model);
    }

    /**
     * @param int $id
     * @param array $data
     * @return ProductPhotos|null
     */
    public function update(int $id, array $data): ?ProductPhotos
    {
        $model = $this->model->find($id);

        if ($model) {
            $model->title = $data['title'];
            $model->alt = $data['alt'];

            if ($data['thumbnail']) {
                $model->thumbnail = $data['thumbnail'];
            }

            if ($data['origin']) {
                $model->origin = $data['origin'];
            }

            $model->product_id = (int)$data['product_id'];
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
