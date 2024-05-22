<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Storage;
use URL;

class Catalog extends Model
{

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

        return Storage::disk('public')->url('catalog/' . $image);
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
        $allChildren = [$this->id];

        self::getAllChildren(Catalog::query()->orderBy('name')->get(), $allChildren, $this->id);

        return Products::query()->whereIn('catalog_id', $allChildren)->count();
    }

    /**
     * @param object $catalog
     * @return void
     */
    private static function removeCatalog(object $catalog): void
    {
        if (Storage::disk('public')->exists('catalog/' . $catalog->image) === true) Storage::disk('public')->delete('catalog/' . $catalog->image);
        if (Storage::disk('public')->exists('catalog/' . '2x_' . $catalog->image) === true) Storage::disk('public')->delete('catalog/' . '2x_' . $catalog->image);

        foreach ($catalog->products as $product) {
            $product->remove();
        }

        $catalog->delete();
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function scopeRemove(): void
    {
        if (Storage::disk('public')->exists('catalog/' . $this->image) === true) Storage::disk('public')->delete('catalog/' . $this->image);
        if (Storage::disk('public')->exists('catalog/' . '2x_' . $this->image) === true) Storage::disk('public')->delete('catalog/' . '2x_' . $this->image);

        foreach ($this->products as $product) {
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

        foreach ($category->children as $row) {
            $ids[] = $row->id;
            $ids = array_merge($ids, self::getChildren($row));
        }

        return $ids;
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo($this, 'parent_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
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
     * @return string|null
     */
    public static function buildTree(array $catalogs, int $parent_id, bool $only_parent = false): string
    {
        $cl = '';

        if (isset($catalogs[$parent_id])) {
            $cl .= '<ul>';
            if ($only_parent === false) {
                foreach ($catalogs[$parent_id] as $catalog) {
                    $cl .= '<li>' . $catalog['name'] . ' <a title="Добавить подкатегорию" href="' . URL::route('cp.catalog.create', ['parent_id' => $catalog['id']]) . '"> <span class="fa fa-plus"></span> </a> <a title="Редактировать" href="' . URL::route('cp.catalog.edit', ['id' => $catalog['id']]) . '"> <span class="fa fa-pencil"></span> </a> <a title="Удалить" href="' . URL::route('cp.catalog.destroy', $catalog['id']) . '"> <span class="fa fa-trash-o"></span> </a>';
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
                $cl .= '<a class="header__product-menu-sublink" href="' . URL::route('frontend.catalog', ['slug' => $catalog['slug']]) . '">' . $catalog['name'] . '<span>' . Products::where('catalog_id', $catalog['id'])->where('published', 1)->count() . '</span></a>';
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
                $cl .= '<a class="header__mobile-submenu-sublink" href="' . URL::route('frontend.catalog', ['slug' => $catalog['slug']]) . '">' . $catalog['name'] . '<span>' . Products::where('catalog_id', $catalog['id'])->where('published', 1)->count() . '</span></a>';
                $cl .= self::categoryTree($catalogs, $catalog['id']);
                $cl .= '</li>';
            }
            $cl .= '</ul>';
        }

        return $cl;
    }

    /**
     * @param object $categories
     * @param array $allChildren
     * @param int $parent_id
     * @return void
     */
    public static function getAllChildren(object $categories, array &$allChildren, int $parent_id = 0): void
    {
        $cats = $categories->filter(function ($item) use ($parent_id) {
            return $item->parent_id == $parent_id;
        });

        foreach ($cats as $cat) {
            array_push($allChildren, $cat->id);
            self::getAllChildren($categories, $allChildren, $cat->id);
        }
    }
}
