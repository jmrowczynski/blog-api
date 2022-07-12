<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'category', 'content', 'tags', 'slug'];

    public function user()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
