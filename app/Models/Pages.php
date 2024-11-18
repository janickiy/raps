<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Helpers\StringHelper;
use Storage;

class Pages extends Model
{
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
    public function getPublishedAttribute()
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
     * @return mixed
     */
    public function getPagePathAttribute()
    {
        return $this->attributes['page_path'];
    }

    /**
     * @param string $lang
     * @return mixed
     */
    public function excerpt()
    {
        $content = $this->text;
        $content = preg_replace("/<img(.*?)>/si", "", $content);
        $content = preg_replace('/(<.*?>)|(&.*?;)/', '', $content)  ;

        return StringHelper::shortText($content,500);
    }

    /**
     * @return string
     */
    public function getUrlPathAttribute()
    {
        return ($this->attributes['page_path'] ? 'page/' : 'path/') . $this->attributes['slug'];
    }

    /**
     * @return mixed
     */
    public function rootPage()
    {
        return $this->where('parent_id', 0)->with('catalog')->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
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
     * @return mixed
     */
    public function getImage(?string $x = null)
    {
        $image = $x ? $x . $this->image : $this->image;

        return Storage::disk('public')->url('pages/' . $image);
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function scopeRemove(): void
    {
        if (Storage::disk('public')->exists('pages/' . $this->image) === true) Storage::disk('public')->delete('pages/' . $this->image);
        if (Storage::disk('public')->exists('pages/' . '2x_' . $this->image) === true) Storage::disk('public')->delete('pages/' . '2x_' . $this->image);

        $this->delete();
    }
}
