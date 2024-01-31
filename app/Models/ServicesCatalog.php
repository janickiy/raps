<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Storage;

class ServicesCatalog extends Model
{
    protected $table = 'services_catalog';

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
    public function services()
    {
        return $this->hasMany(Services::class, 'catalog_id', 'id');
    }

    /**
     * @return mixed
     */
    public static function getOption()
    {
        return self::orderBy('name')->get()->pluck('name', 'id');
    }


    /**
     * @param string|null $x
     * @return mixed
     */
    public function getImage(?string $x = null)
    {
        $image = $x ? $x . $this->image : $this->image;

        return Storage::disk('public')->url('services_catalog/' . $image);
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function scopeRemove()
    {
        if (Storage::disk('public')->exists('services_catalog/' . $this->image) === true) Storage::disk('public')->delete('services_catalog/' . $this->image);
        if (Storage::disk('public')->exists('services_catalog/' . '2x_' . $this->image) === true) Storage::disk('public')->delete('services_catalog/' . '2x_' . $this->image);

        foreach ($this->services as $service) {
            $service->remove();
        }

        $this->delete();
    }
}
