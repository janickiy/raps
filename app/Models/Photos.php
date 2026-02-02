<?php

namespace App\Models;


use App\Http\Traits\StaticTableName;
use App\Http\Traits\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Photos extends Model
{
    use StaticTableName, File;

    protected $table = 'photos';

    protected $fillable = [
        'title',
        'description',
        'alt',
        'thumbnail',
        'origin',
        'photoalbum_id',
    ];

    /**
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(PhotoAlbum::class, 'photoalbum_id', 'id');
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
     * @return void
     */
    public function scopeRemove(): void
    {
        if ($this->thumbnail) File::deleteFile($this->thumbnail, $this->table);
        if ($this->origin) File::deleteFile($this->origin, $this->table);

        $this->delete();
    }
}
