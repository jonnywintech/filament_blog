<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'tags' => 'array',
    ];

    public function categories()
    {
        return $this->belongsTo(Category::class);
    }

}
