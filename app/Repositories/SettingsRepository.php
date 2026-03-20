<?php

namespace App\Repositories;

use App\DTO\Admin\SettingData;
use App\Models\Settings;

class SettingsRepository extends BaseRepository
{
    public function __construct(Settings $model)
    {
        parent::__construct($model);
    }

    public function createFromDto(SettingData $data): Settings
    {
        /** @var Settings $settings */
        $settings = $this->model->create($data->toArray());

        return $settings;
    }

    public function updateFromDto(int $id, SettingData $data): ?Settings
    {
        $model = $this->model->find($id);

        if (!$model) {
            return null;
        }

        $model->fill($data->toArray());
        $model->save();

        return $model;
    }

    public function remove(int $id): void
    {
        $settings = $this->model->find($id);

        if ($settings) {
            $settings->remove();
        }
    }
}
