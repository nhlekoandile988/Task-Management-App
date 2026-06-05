<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryAKL extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'name',
        'color',
    ];

    public function tasks()
    {
        return $this->hasMany(TaskAKL::class, 'category_id');
    }
}

