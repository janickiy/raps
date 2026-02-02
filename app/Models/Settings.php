<?php

namespace App\Models;

use App\Http\Traits\File;
use App\Http\Traits\StaticTableName;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    use StaticTableName, File;

    protected $table = 'settings';

    protected $fillable = [
        'key_cd',
        'name',
        'type',
        'display_value',
        'value',
        'published',
    ];

    /**
     * @param string $value
     * @return void
     */
    public function setKeyCdAttribute(string $value): void
    {
        $this->attributes['key_cd'] = str_replace(' ', '_', strtoupper($value));
    }

    /**
     * @return string
     */
    public function getTypeAttribute(): string
    {
        return $this->attributes['type'] = strtoupper($this->attributes['type']);
    }

    /**
     * @return string
     */
    public function getValueAttribute(): string
    {
        if ($this->attributes['type'] == 'FILE') {
            return File::getFile($this->attributes['value'], $this->table);
        }

        return $this->attributes['value'];
    }

    /**
     * @return string
     */
    public function filePath(): string
    {
        return $this->attributes['value'];
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopePublished($query)
    {
        return $query->where('published', 1);
    }

    /**
     * @return void
     */
    public function scopeRemove(): void
    {
        File::deleteFile($this->filePath(), $this->table);

        $this->delete();
    }
}
