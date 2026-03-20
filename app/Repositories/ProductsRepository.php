<?php

namespace App\Repositories;

use App\DTO\Admin\ProductData;
use App\Models\Products;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class ProductsRepository extends BaseRepository
{
    public function __construct(Products $model)
    {
        parent::__construct($model);
    }

    public function createFromDto(ProductData $data): Products
    {
        /** @var Products $product */
        $product = $this->model->create($data->toArray());

        return $product;
    }

    public function updateFromDto(int $id, ProductData $data): ?Products
    {
        $model = $this->model->find($id);

        if (!$model) {
            return null;
        }

        $payload = $data->toArray();

        $model->title = $payload['title'];
        $model->description = $payload['description'];
        $model->full_description = $payload['full_description'];
        $model->catalog_id = $payload['catalog_id'];
        $model->price = $payload['price'];
        $model->meta_title = $payload['meta_title'];
        $model->meta_description = $payload['meta_description'];
        $model->meta_keywords = $payload['meta_keywords'];
        $model->seo_h1 = $payload['seo_h1'];
        $model->seo_url_canonical = $payload['seo_url_canonical'];
        $model->seo_sitemap = $payload['seo_sitemap'];
        $model->slug = $payload['slug'];
        $model->image_title = $payload['image_title'];
        $model->image_alt = $payload['image_alt'];
        $model->published = $payload['published'];
        $model->explosion_protection = $payload['explosion_protection'];
        $model->gases = $payload['gases'];
        $model->dust_protection = $payload['dust_protection'];

        if ($payload['thumbnail'] !== null) {
            $model->thumbnail = $payload['thumbnail'];
        }

        if ($payload['origin'] !== null) {
            $model->origin = $payload['origin'];
        }

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

    public function viewedProducts(): ?array
    {
        if (request()->session()->has('productIds')) {
            return request()->session()->get('productIds');
        }

        return null;
    }

    public function getProducts(array $catalogIds, int $limit = 10): LengthAwarePaginator
    {
        return Products::query()->whereIn('catalog_id', $catalogIds)->paginate($limit);
    }
}
