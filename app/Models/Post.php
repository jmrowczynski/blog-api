<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Post extends Model
{
    use HasFactory, Sluggable;

    protected $fillable = ['title', 'content', 'tags', 'slug'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'category_id',
        'author_id'
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function category()
    {
        return $this->hasOne(Category::class);
    }
}
