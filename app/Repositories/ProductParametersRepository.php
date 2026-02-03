<?php

namespace App\Repositories;

use App\Models\ProductParameters;

class ProductParametersRepository extends BaseRepository
{
    public function __construct(ProductParameters $model)
    {
        parent::__construct($model);
    }

    /**
     * @param int $id
     * @param array $data
     * @return ProductParameters|null
     */
    public function update(int $id, array $data): ?ProductParameters
    {
        $model = $this->model->find($id);

        if ($model) {
            $model->name = $data['name'];
            $model->value = $data['value'];
            $model->product_id = (int) $data['product_id'];
            $model->category_id = (int) $data['category_id'];
            $model->save();

            return $model;
        }
        return null;
    }
}
