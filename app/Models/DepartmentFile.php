<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DepartmentFile extends Model
{
    protected $fillable = [
        'department_id',
        'file_category_id',
        'file_name',
        'file_path',
        'file_size',
        'file_type',
        'approval_status'
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function category()
    {
        return $this->belongsTo(FileCategory::class, 'file_category_id');
    }
}
