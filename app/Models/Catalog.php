<?php

namespace App\Models;


use App\Http\Traits\StaticTableName;
use App\Http\Traits\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Catalog extends Model
{
    use StaticTableName, File;

    protected $table = 'catalog';

    protected $fillable = [
        'name',
        'description',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'image',
        'slug',
        'seo_h1',
        'seo_url_canonical',
        'seo_sitemap',
        'image_title',
        'image_alt',
        'parent_id',
    ];


    /**
     * @return HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(Products::class, 'catalog_id', 'id')->where('published', 1);
    }

    /**
     * @return mixed
     */
    public static function getOption()
    {
        return self::orderBy('name')->get()->pluck('name', 'id');
    }

    /**
     * @return bool
     */
    public function hasChildren(): bool
    {
        return self::where('parent_id', $this->id)->count() > 0 ? true : false;
    }

    /**
     * @param array $topbar
     * @param int $parent_id
     * @return array
     */
    public static function topbarMenu(array &$topbar, int $parent_id): array
    {
        $result = self::where('id', $parent_id);

        if ($result->count() > 0) {
            $catalog = $result->first();
            $topbar[] = [$catalog->id, $catalog->name, $catalog->slug];

            self::topbarMenu($topbar, $catalog->parent_id);
        }

        sort($topbar);

        return $topbar;
    }

    /**
     * @return int
     */
    public function getProductCount(): int
    {
        return (int)Products::where('catalog_id', $this->id)->where('published', 1)->count();
    }

    /**
     * @param string|null $x
     * @return mixed
     */
    public function getImage(?string $x = null)
    {
        $image = $x ? $x . $this->image : $this->image;

        return $this->image ? File::getFile($image, $this->table ) : null;
    }

    /**
     * @param int $parent_id
     * @return void
     */
    public static function removeCatalogs(int $parent_id): void
    {
        $parent = self::findOrFail($parent_id);
        $array_of_ids = self::getChildren($parent);
        array_push($array_of_ids, $parent_id);

        $catalogs = self::whereIn('id', $array_of_ids)->get();

        foreach ($catalogs as $catalog) {
            self::removeCatalog($catalog);
        }

        self::removeCatalog($parent);
    }

    /**
     * @return int
     */
    public function getTotalProductCount(): int
    {
        $allChildren = self::getAllChildren($this->id);
        $allChildren[] = $this->id;

        return Products::query()->whereIn('catalog_id', $allChildren)->count();
    }

    /**
     * @return void
     */
    public function scopeRemove(): void
    {
        if ($this->image)  {
            File::deleteFile($this->image, self::getTableName());
            File::deleteFile('2x_' . $this->image, self::getTableName());
        }

        foreach ($this->products ?? [] as $product) {
            $product->remove();
        }

        $this->delete();
    }

    /**
     * @param $category
     * @return array
     */
    private static function getChildren($category): array
    {
        $ids = [];

        foreach ($category->children ?? [] as $row) {
            $ids[] = $row->id;
            $ids = array_merge($ids, self::getChildren($row));
        }

        return $ids;
    }

    /**
     * @return BelongsTo
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo($this, 'parent_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function children(): HasMany
    {
        return $this->hasMany($this, 'parent_id', 'id');
    }

    /**
     * @param array $option
     * @param int $parent_id
     * @param int $lvl
     * @return array
     */
    public static function showTree(array &$option, int $parent_id, int &$lvl = 0)
    {
        $lvl++;
        $rows = self::where('parent_id', $parent_id)->orderBy('name')->get();

        foreach ($rows as $row) {
            $indent = '';
            for ($i = 1; $i < $lvl; $i++) $indent .= '-';

            $option[$row->id] = $indent . " " . $row->name;
            self::showTree($option, $row->id, $lvl);
            $lvl--;
        }

        return $option;
    }

    /**
     * @param array $catalogs
     * @param int $parent_id
     * @param bool $only_parent
     * @return string
     */
    public static function buildTree(array $catalogs, int $parent_id, bool $only_parent = false): string
    {
        $cl = '';

        if (isset($catalogs[$parent_id])) {
            $cl .= '<ul>';
            if ($only_parent === false) {
                foreach ($catalogs[$parent_id] as $catalog) {
                    $cl .= '<li>' . $catalog['name'] . ' <a title="Добавить подкатегорию" href="' . route('cp.catalog.create', ['parent_id' => $catalog['id']]) . '"> <span class="fa fa-plus"></span> </a> <a title="Редактировать" href="' . route('cp.catalog.edit', ['id' => $catalog['id']]) . '"> <span class="fa fa-pencil"></span> </a> <a title="Удалить" href="' . route('cp.catalog.destroy', $catalog['id']) . '"> <span class="fa fa-trash-o"></span> </a>';
                    $cl .= self::buildTree($catalogs, $catalog['id']);
                    $cl .= '</li>';
                }
            } else {
                $catalog = $catalogs[$parent_id][$only_parent];
                $cl .= '<li>' . $catalog['name'] . ' #' . $catalog['id'];
                $cl .= self::buildTree($catalogs, $catalog['id'], true);
                $cl .= '</li>';
            }
            $cl .= '</ul>';
        }

        return $cl;
    }

    /**
     * @param array $catalogs
     * @param int $parent_id
     * @return string
     */
    public static function categoryTree(array $catalogs, int $parent_id): string
    {
        $cl = '';

        if (isset($catalogs[$parent_id])) {
            $cl .= '<ul class="header__product-menu-submenu-item ml-16">';
            foreach ($catalogs[$parent_id] as $catalog) {
                $cl .= '<li class="header__product-menu-submenu-item">';
                $cl .= '<a class="header__product-menu-sublink" href="' . route('frontend.catalog', ['slug' => $catalog['slug']]) . '">' . $catalog['name'] . '<span>' . Products::where('catalog_id', $catalog['id'])->where('published', 1)->count() . '</span></a>';
                $cl .= self::categoryTree($catalogs, $catalog['id']);
                $cl .= '</li>';
            }
            $cl .= '</ul>';
        }

        return $cl;
    }

    /**
     * @param array $catalogs
     * @param int $parent_id
     * @return string
     */
    public static function categoryMobileTree(array $catalogs, int $parent_id): string
    {
        $cl = '';

        if (isset($catalogs[$parent_id])) {
            $cl .= '<ul class="ml-16">';
            foreach ($catalogs[$parent_id] as $catalog) {
                $cl .= '<li>';
                $cl .= '<a class="header__mobile-submenu-sublink" href="' . route('frontend.catalog', ['slug' => $catalog['slug']]) . '">' . $catalog['name'] . '<span>' . Products::where('catalog_id', $catalog['id'])->where('published', 1)->count() . '</span></a>';
                $cl .= self::categoryTree($catalogs, $catalog['id']);
                $cl .= '</li>';
            }
            $cl .= '</ul>';
        }

        return $cl;
    }

    /**
     * @param int $id
     * @return array
     */
    public static function getAllChildren(int $id): array
    {
        $children = self::where('parent_id', $id)->with('children')->get();
        $ids = [];
        foreach ($children as $child) {
            $ids[] = $child->id;

            if ($child->children->count()) {
                $ids = array_merge($ids, self::getAllChildren($child->id));
            }
        }
        return $ids;
    }

    /**
     * @return array
     */
    public static function getCatalogList(): array
    {
        $catalogs = Catalog::query()->orderBy('name')->get();
        $catalogsList = [];

        foreach ($catalogs?->toArray() ?? [] as $catalog) {
            $catalogsList[$catalog['parent_id']][$catalog['id']] = $catalog;
        }

        return $catalogsList;
    }
}
