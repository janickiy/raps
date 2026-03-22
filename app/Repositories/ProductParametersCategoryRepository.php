<?php

namespace App\Repositories;

use App\Models\ProductParametersCategory;

class ProductParametersCategoryRepository extends BaseRepository
{
    public function __construct(ProductParametersCategory $model)
    {
        parent::__construct($model);
    }

    /**
     * @param int $id
     * @param array $data
     * @return ProductParametersCategory|null
     */
    public function update(int $id, array $data): ?ProductParametersCategory
    {
        $model = $this->model->find($id);

        if ($model) {
            $model->name = $data['name'];
            $model->save();

            return $model;
        }

        return null;
    }
}
