<?php

namespace App\Repositories;

use App\Models\DetectedGases;
use App\Models\Products;
use Illuminate\Support\Collection;

class DetectedGasesRepository extends BaseRepository
{
    public function __construct(DetectedGases $model)
    {
        parent::__construct($model);
    }

    /**
     * @param int $id
     * @param array $data
     * @return DetectedGases|null
     */
    public function update(int $id, array $data): ?DetectedGases
    {
        $model = $this->model->find($id);

        if ($model) {
            $model->name = $data['name'];
            $model->formula = $data['formula'];
            $model->volume_fraction = $data['volume_fraction'] ?? null;
            $model->product_id = (int) $data['product_id'];
            $model->save();

            return $model;
        }
        return null;
    }


    /**
     * @param int $product_id
     * @return Collection|null
     */
    public function getProducts(int $product_id): ?Collection
    {
        return  Products::query()
            ->where('published', 1)
            ->where('id', '!=', $product_id)
            ->orderBy('title')
            ->get();
    }
}
