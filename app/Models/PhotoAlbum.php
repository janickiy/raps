<?php

namespace App\Models;

use App\Http\Traits\StaticTableName;
use App\Http\Traits\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Storage;

class PhotoAlbum extends Model
{
    use StaticTableName, File;

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
     */
    public function scopeRemove(): void
    {
        foreach ($this->photos as $photo) {
            File::deleteFile($photo->thumbnail, $this->table);
            File::deleteFile($photo->origin, $this->table);
        }

        $this?->photos()->delete();
        $this->delete();
    }
}
