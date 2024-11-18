<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Storage;

class Photoalbum extends Model
{
    protected $table = 'photoalbum';

    protected $fillable = [
        'name',
        'description',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'seo_h1',
        'seo_url_canonical',
        'seo_sitemap',
        'slug',
    ];

    /**
     * @return HasMany
     */
    public function photos(): HasMany
    {
        return $this->hasMany(Photos::class, 'photoalbum_id', 'id');
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function scopeRemove(): void
    {
        foreach ($this->photos as $photo) {
            if (Storage::disk('public')->exists('images/' . $photo->thumbnail) === true) Storage::disk('public')->delete('images/' . $photo->thumbnail);
            if (Storage::disk('public')->exists('images/' . $photo->origin) === true) Storage::disk('public')->delete('images/' . $photo->origin);
        }

        $this->photos()->delete();
        $this->delete();
    }
}
