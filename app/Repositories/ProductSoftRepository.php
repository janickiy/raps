<?php

namespace App\Repositories;


use App\Models\ProductSoft;
use App\Models\Products;
use Illuminate\Support\Collection;

class ProductSoftRepository extends BaseRepository
{
    public function __construct(ProductSoft $model)
    {
        parent::__construct($model);
    }

    /**
     * @param int $id
     * @param array $data
     * @return ProductSoft|null
     */
    public function update(int $id, array $data): ?ProductSoft
    {
        $model = $this->model->find($id);

        if ($model) {
            $model->url = $data['url'];
            $model->description = $data['description'] ?? null;
            $model->product_id = (int)$data['product_id'];
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
        return Products::query()
            ->where('published', 1)
            ->where('id', '!=', $product_id)
            ->orderBy('title')
            ->get();
    }
}
