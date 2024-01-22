<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Storage;

class Products extends Model
{
    protected $table = 'products';

    protected $primaryKey = 'id';

    protected $fillable = [
        'title',
        'description',
        'full_description',
        'catalog_id',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'slug',
        'seo_h1',
        'seo_url_canonical',
        'thumbnail',
        'origin',
        'image_title',
        'image_alt'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function catalog()
    {
        return $this->belongsTo(Catalog::class, 'catalog_id', 'id');
    }

    /**
     * @return mixed
     */
    public function getThumbnailUrl()
    {
        return Storage::disk('public')->url('products/' . $this->thumbnail);
    }

    /**
     * @return mixed
     */
    public function getOriginUrl()
    {
        return Storage::disk('public')->url('products/' . $this->origin);
    }

    /**
     * @param int $category_id
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function parameterByCategoryId(int $category_id)
    {
        return $this->hasMany(ProductParameters::class, 'product_id', 'id')->where('category_id', $category_id);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function parameters()
    {
        return $this->hasMany(ProductParameters::class, 'product_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function photos()
    {
        return $this->hasMany(ProductPhotos::class, 'product_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function documents()
    {
        return $this->hasMany(ProductDocuments::class, 'product_id', 'id');
    }


    /**
     * @return void
     * @throws \Exception
     */
    public function scopeRemove()
    {

        if (Storage::disk('public')->exists('products/' . $this->thumbnail) === true) Storage::disk('public')->delete('products/' . $this->thumbnail);
        if (Storage::disk('public')->exists('products/' . $this->origin) === true) Storage::disk('public')->delete('products/' . $this->origin);

        foreach ($this->photos as $photo) {
            if (Storage::disk('public')->exists('images/' . $photo->thumbnail) === true) Storage::disk('public')->delete('images/' . $photo->thumbnail);
            if (Storage::disk('public')->exists('images/' . $photo->origin) === true) Storage::disk('public')->delete('images/' . $photo->origin);
        }

        $this->photos()->delete();

        foreach ($this->documents as $document) {
            if (Storage::disk('public')->exists('documents/' . $document->path) === true) Storage::disk('public')->delete('documents/' . $document->path);
        }

        $this->documents()->delete();
        $this->parameters()->delete();
        $this->delete();
    }

}
