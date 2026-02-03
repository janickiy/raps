<?php

namespace App\Repositories;

use App\Models\Settings;

class SettingsRepository extends BaseRepository
{
    public function __construct(Settings $model)
    {
        parent::__construct($model);
    }

    /**
     * @param int $id
     * @param array $data
     * @return Settings|null
     */
    public function update(int $id, array $data): ?Settings
    {
        $model = $this->model->find($id);

        if ($model) {
            $model->key_cd = $data['key_cd'] ?? null;
            $model->name = $data['name'] ;
            $model->display_value = $data['display_value'] ?? null;
            $model->value = $data['value'] ?? null;
            $model->published = (int) $data['published'];
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
        $settings = $this->model->find($id);

        if ($settings) {
            $settings->remove();
        }
    }
}
