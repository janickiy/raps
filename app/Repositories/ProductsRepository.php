<?php

namespace App\Repositories;

use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProductsRepository extends BaseRepository
{
    public function __construct(Products $model)
    {
        parent::__construct($model);
    }

    /**
     * @param int $id
     * @param array $data
     * @return Products|null
     */
    public function update(int $id, array $data): ?Products
    {
        $model = $this->model->find($id);

        if ($model) {
            $model->title = $data['title'];
            $model->description = $data['description'];

            if ($data['thumbnail']) {
                $model->thumbnail = $data['thumbnail'];
            }

            if ($data['origin']) {
                $model->origin = $data['origin'];
            }

            $model->category_id = (int)$data['category_id'];
            $model->price = (int)$data['price'];
            $model->meta_title = $data['meta_title'] ?? null;
            $model->meta_description = $data['meta_description'] ?? null;
            $model->meta_keywords = $data['meta_keywords'] ?? null;
            $model->seo_h1 = $data['seo_h1'] ?? null;
            $model->seo_url_canonical = $data['seo_url_canonical'] ?? null;
            $model->seo_sitemap = (int)$data['seo_sitemap'];
            $model->slug = $data['slug'];
            $model->full_description = $data['full_description'];
            $model->image_title = $data['image_title'] ?? null;
            $model->image_alt  = $data['image_alt'] ?? null;
            $model->explosion_protection = $data['explosion_protection'] ?? null;
            $model->gases = $data['gases'] ?? null;
            $model->dust_protection = $data['dust_protection'] ?? null;

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

    /**
     * @param Request $request
     * @param int $id
     * @return array|null
     */
    public function setViewed(Request $request, int $id): ?array
    {
        $product = $this->model->find($id);
        $productIds = null;

        if ($product) {
            if ($request->session()->has('productIds')) {
                $productIds = $request->session()->get('productIds');
                array_push($productIds, $product->id);
                $productIds = array_unique($productIds);
                $request->session()->put(['productIds' => $productIds]);
            } else {
                $productIds = [$product->id];
                $request->session()->put(['productIds' => $productIds]);
            }
        }

        return $productIds;
    }

    /**
     * @return array|null
     */
    public function viewedProducts(): ?array
    {
        if (request()->session()->has('productIds')) {
            return request()->session()->get('productIds');
        } else {
            return null;
        }
    }

    /**
     * @param array $catalogIds
     * @param int $limit
     * @return LengthAwarePaginator
     */
    public function getProducts(array $catalogIds, int $limit = 10): LengthAwarePaginator
    {
        return Products::query()->whereIn('catalog_id', $catalogIds)->paginate($limit);
    }
}
