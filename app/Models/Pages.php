<?php

namespace App\Models;


use App\Http\Traits\StaticTableName;
use App\Http\Traits\File;
use App\Helpers\StringHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Collection;

class Pages extends Model
{
    use StaticTableName, File;

    protected $table = 'pages';

    protected $fillable = [
        'title',
        'text',
        'image',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'main',
        'slug',
        'parent_id',
        'published',
        'seo_h1',
        'seo_url_canonical',
        'seo_sitemap',
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
     * @return string
     */
    public function getPagePathAttribute(): string
    {
        return $this->attributes['page_path'];
    }

    /**
     * @return string
     */
    public function excerpt(): string
    {
        $content = $this->text;
        $content = preg_replace("/<img(.*?)>/si", "", $content);
        $content = preg_replace('/(<.*?>)|(&.*?;)/', '', $content)  ;

        return StringHelper::shortText($content,500);
    }

    /**
     * @return string
     */
    public function getUrlPathAttribute(): string
    {
        return ($this->attributes['page_path'] ? 'page/' : 'path/') . $this->attributes['slug'];
    }

    /**
     * @return Collection
     */
    public function rootPage(): Collection
    {
        return $this->where('parent_id', 0)->with('catalog')->get();
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
     * @param string|null $x
     * @return string
     */
    public function getImage(?string $x = null): string
    {
        $image = $x ? $x . $this->image : $this->image;

        return File::getFile($image, $this->table);
    }

    /**
     * @return void
     */
    public function scopeRemove(): void
    {
        if ($this->image) {
            File::deleteFile($this->image, $this->table);
            File::deleteFile('2x_' . $this->image,$this->table);
        }

        $this->delete();
    }
}
