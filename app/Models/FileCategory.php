<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FileCategory extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'order'
    ];

    public function files()
    {
        return $this->hasMany(DepartmentFile::class);
    }

    /**
     * Get all categories ordered by order column
     */
    public static function getOrdered()
    {
        return self::orderBy('order')->get();
    }
}
