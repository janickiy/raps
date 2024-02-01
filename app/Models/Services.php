<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Storage;

class Services extends Model
{
    protected $table = 'services';

    protected $primaryKey = 'id';

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
     * @param string|null $x
     * @return mixed
     */
    public function getImage(?string $x = null)
    {
        $image = $x ? $x . $this->image : $this->image;

        return Storage::disk('public')->url('services/' . $image);
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function scopeRemove()
    {

        if (Storage::disk('public')->exists('services/' . $this->image) === true) Storage::disk('public')->delete('services/' . $this->image);
        if (Storage::disk('public')->exists('services/' . '2x_' . $this->image) === true) Storage::disk('public')->delete('services/' . '2x_' . $this->image);

        $this->delete();
    }
}
