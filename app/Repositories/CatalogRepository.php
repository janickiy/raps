<?php

namespace App\Repositories;

use App\Models\Catalog;
use Illuminate\Support\Collection;

class CatalogRepository extends BaseRepository
{
    public function __construct(Catalog $model)
    {
        parent::__construct($model);
    }
    /**
     * @param int $id
     * @param array $data
     * @return Catalog|null
     */
    public function update(int $id, array $data): ?Catalog
    {
        $model = $this->model->find($id);

        if ($model) {
            $model->name = $data['name'];
            $model->slug = $data['slug'];

            if ($data['image']) {
                $model->image = $data['image'];
            }

            $model->meta_title = $data['meta_title'] ?? null;
            $model->meta_description = $data['meta_description'] ?? null;
            $model->meta_keywords = $data['meta_keywords'] ?? null;
            $model->seo_h1 = $data['seo_h1'] ?? null;
            $model->seo_url_canonical = $data['seo_url_canonical'] ?? null;
            $model->parent_id = (int)$data['parent_id'] ?? null;
            $model->seo_sitemap = $data['seo_sitemap'] ?? null;
            $model->save();

            return $model;
        }
        return null;
    }

    /**
     * @param int $parent_id
     * @return Collection|null
     */
    public function getCatalogsByParentId(int $parent_id): ?Collection
    {
        return Catalog::query()
            ->where('parent_id', $parent_id)
            ->orderBy('name')
            ->get();
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        $options[0] = 'Выберите';

        return Catalog::ShowTree($options, 0);
    }
    /**
     * @param int $parent_id
     * @return void
     */
    public function remove(int $parent_id): void
    {
        $parent = Catalog::findOrFail($parent_id);
        $array_of_ids = $this->getChildren($parent);
        array_push($array_of_ids, $parent_id);

        $catalogs = Catalog::whereIn('id', $array_of_ids)->get();

        foreach ($catalogs as $catalog) {
            $this->delete($catalog->id);
        }

        $this->delete($parent_id);
    }

    /**
     * @param $category
     * @return array
     */
    public function getChildren($category): array
    {
        $ids = [];

        foreach ($category->children ?? [] as $row) {
            $ids[] = $row->id;
            $ids = array_merge($ids, $this->getChildren($row));
        }

        return $ids;
    }

    /**
     * @param int $catalog_id
     * @return string
     */
    public function topbarMenu(int $catalog_id): string
    {
        $pathway = '';
        $topbar = [];

        Catalog::topbarMenu($topbar, $catalog_id);

        for ($i = 0; $i < count($topbar); $i++) {
            if ($topbar[$i][0] != $catalog_id) {
                $pathway .= '<li><a href="' . route('frontend.catalog', ['slug' => $topbar[$i][2]]) . '">' . $topbar[$i][1] . '</a></li>';
            }
        }

        return $pathway;
    }

    /**
     * @return array
     */
    public function getCatalogsList(): array
    {
        $catalogs = Catalog::query()->orderBy('name')->get();
        $catalogsList = [];

        foreach ($catalogs?->toArray() ?? [] as $catalog) {
            $catalogsList[$catalog['parent_id']][$catalog['id']] = $catalog;
        }

        return $catalogsList;
    }
}
