<?php

namespace App\Repositories;

use App\Models\Photos;

class PhotosRepository extends BaseRepository
{
    public function __construct(Photos $model)
    {
        parent::__construct($model);
    }

    /**
     * @param int $id
     * @param array $data
     * @return Photos|null
     */
    public function update(int $id, array $data): ?Photos
    {
        $model = $this->model->find($id);

        if ($model) {
            $model->title = $data['title'] ?? null;
            $model->description = $data['description'] ?? null;
            $model->alt = $data['alt'] ?? null;

            if ($data['thumbnail']) {
                $model->thumbnail = $data['thumbnail'];
            }

            if ($data['origin']) {
                $model->origin = $data['origin'];
            }

            $model->photoalbum_id = (int)$data['photoalbum_id'];
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
