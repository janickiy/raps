<?php

namespace App\Repositories;

use App\DTO\Admin\ServiceData;
use App\Models\Services;

class ServicesRepository extends BaseRepository
{
    public function __construct(Services $model)
    {
        parent::__construct($model);
    }

    public function createFromDto(ServiceData $data): Services
    {
        /** @var Services $service */
        $service = $this->model->create($data->toArray());

        return $service;
    }

    public function updateFromDto(int $id, ServiceData $data): ?Services
    {
        $model = $this->model->find($id);

        if (!$model) {
            return null;
        }

        $payload = $data->toArray();
        $model->fill(array_filter(
            $payload,
            static fn (mixed $value, string $key): bool => $key !== 'image' || $value !== null,
            ARRAY_FILTER_USE_BOTH,
        ));
        $model->save();

        return $model;
    }

    public function remove(int $id): void
    {
        $model = $this->model->find($id);

        if ($model) {
            $model->remove();
        }
    }
}
