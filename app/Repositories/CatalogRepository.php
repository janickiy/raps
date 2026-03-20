<?php

namespace App\Repositories;

use App\DTO\Admin\CatalogData;
use App\Models\Catalog;
use Illuminate\Support\Collection;

class CatalogRepository extends BaseRepository
{
    public function __construct(Catalog $model)
    {
        parent::__construct($model);
    }

    public function createFromDto(CatalogData $data): Catalog
    {
        /** @var Catalog $catalog */
        $catalog = $this->model->create($data->toArray());

        return $catalog;
    }

    public function updateFromDto(int $id, CatalogData $data): ?Catalog
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

    public function getCatalogsByParentId(int $parent_id): ?Collection
    {
        return Catalog::query()
            ->where('parent_id', $parent_id)
            ->orderBy('name')
            ->get();
    }

    public function getOptions(): array
    {
        $options[0] = 'Выберите';

        return Catalog::ShowTree($options, 0);
    }

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

    public function getChildren($category): array
    {
        $ids = [];

        foreach ($category->children ?? [] as $row) {
            $ids[] = $row->id;
            $ids = array_merge($ids, $this->getChildren($row));
        }

        return $ids;
    }

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
