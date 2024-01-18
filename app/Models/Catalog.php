<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Storage;

class Catalog extends Model
{

    protected $table = 'catalog';

    protected $primaryKey = 'id';

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
        'image_alt'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany(Products::class, 'catalog_id', 'id');
    }

    /**
     * @return mixed
     */
    public static function getOption()
    {
        return self::orderBy('name')->get()->pluck('name', 'id');
    }

    /**
     * @return int
     */
    public function getProductCount()
    {
        return (int)Products::where('catalog_id', $this->id)->count();
    }

    /**
     * @param string|null $x
     * @return mixed
     */
    public function getImage(?string $x = null)
    {
        $image = $x ? $x . $this->image : $this->image;

        return Storage::disk('public')->url('app/public/catalog/' . $image);
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function scopeRemove()
    {
        if (Storage::disk('public')->exists('catalog/' . $this->image) === true) Storage::disk('public')->delete('catalog/' . $this->image);
        if (Storage::disk('public')->exists('catalog/' . '2x_' . $this->image) === true) Storage::disk('public')->delete('catalog/' . '2x_' . $this->image);

        foreach ($this->products as $product) {
            $product->remove();
        }

        $this->delete();
    }

}
