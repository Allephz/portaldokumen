<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    protected $fillable = ['director_id', 'name'];

    public function director()
    {
        return $this->belongsTo(Director::class);
    }

    public function departments()
    {
        return $this->hasMany(Department::class);
    }}