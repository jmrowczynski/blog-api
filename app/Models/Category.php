<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name'];

    protected $hidden = ['updated_at', 'created_at'];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
