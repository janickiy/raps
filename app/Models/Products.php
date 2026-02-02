<?php

namespace App\Models;


use App\Http\Traits\File;
use App\Http\Traits\StaticTableName;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Collection;

class Products extends Model
{
    use StaticTableName, File;

    protected $table = 'products';

    protected $fillable = [
        'title',
        'description',
        'full_description',
        'catalog_id',
        'price',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'slug',
        'seo_h1',
        'seo_url_canonical',
        'seo_sitemap',
        'thumbnail',
        'origin',
        'published',
        'image_title',
        'image_alt',
        'explosion_protection',
        'gases',
        'dust_protection'
    ];

    /**
     * @param $query
     * @return mixed
     */
    public function scopePublished($query)
    {
        return $query->where('published', 1);
    }

    /**
     * @return string
     */
    public function getPublishedAttribute(): string
    {
        return $this->attributes['published'] ? 'публикован' : 'не опубликован';
    }

    /**
     * @return mixed
     */
    public function getStatusAttribute()
    {
        return $this->attributes['published'];
    }

    /**
     * @return BelongsTo
     */
    public function catalog(): BelongsTo
    {
        return $this->belongsTo(Catalog::class, 'catalog_id', 'id');
    }

    /**
     * @return string|null
     */
    public function getThumbnailUrl(): ?string
    {
        return $this->thumbnail ? File::getFile($this->thumbnail, $this->table) : null;
    }

    /**
     * @return string|null
     */
    public function getOriginUrl(): ?string
    {
        return $this->origin ? File::getFile($this->origin, $this->table) : null;
    }

    /**
     * @param int $category_id
     * @return Collection|null
     */
    public function parameterByCategoryId(int $category_id): ?Collection
    {
        return ProductParameters::where('product_id', $this->id)->where('category_id', $category_id)->orderBy('name')->get();
    }

    /**
     * @param array $productIds
     * @return Collection|null
     */
    public static function productsListByIds(array $productIds): ?Collection
    {
        return self::whereIn('id', $productIds)->orderBy('title')->get();
    }

    /**
     * @return HasMany
     */
    public function parameters(): HasMany
    {
        return $this->hasMany(ProductParameters::class, 'product_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function detected_gases(): HasMany
    {
        return $this->hasMany(DetectedGases::class, 'product_id', 'id')->orderBy('name');
    }

    /**
     * @return HasMany
     */
    public function photos(): HasMany
    {
        return $this->hasMany(ProductPhotos::class, 'product_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function documents(): HasMany
    {
        return $this->hasMany(ProductDocuments::class, 'product_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function soft(): HasMany
    {
        return $this->hasMany(ProductSoft::class, 'product_id', 'id');
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function scopeRemove(): void
    {
        File::deleteFile($this->thumbnail, $this->table);
        File::deleteFile($this->origin, $this->table);

        foreach ($this->photos as $photo) {
            File::deleteFile($photo->thumbnail, $this->table);
            File::deleteFile($photo->origin, $this->table);
        }

        $this->photos()->delete();

        foreach ($this->documents as $document) {
            File::deleteFile($document->path, $this->table);
        }

        $this->documents()->delete();
        $this->parameters()->delete();
        $this->detected_gases()->delete();
        $this->delete();
    }

    /**
     * @return array
     */
    public static function getOption(): array
    {
        return self::orderBy('title')->get()->pluck('title', 'id')->toArray();
    }
}
