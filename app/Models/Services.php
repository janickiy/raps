<?php

namespace App\Models;

use App\Http\Traits\File;
use App\Http\Traits\StaticTableName;
use Illuminate\Database\Eloquent\Model;


class Services extends Model
{
    use StaticTableName, File;

    protected $table = 'services';

    protected $fillable = [
        'title',
        'description',
        'full_description',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'slug',
        'seo_h1',
        'seo_url_canonical',
        'seo_sitemap',
        'image',
        'image_title',
        'image_alt',
        'published',
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
     * @param string|null $x
     * @return string|null
     */
    public function getImage(?string $x = null): ?string
    {
        $image = $x ? $x . $this->image : $this->image;

        return $this->image ? File::getFile($image, $this->table) : null;
    }

    /**
     * @return void
     */
    public function scopeRemove(): void
    {
        File::deleteFile($this->image, $this->table);
        File::deleteFile('2x_' . $this->image, $this->table);

        $this->delete();
    }
}
