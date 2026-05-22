<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Director extends Model
{
    protected $fillable = ['title', 'name'];

    public function divisions()
    {
        return $this->hasMany(Division::class);
    }
}
