<?php

namespace App\Models;

use App\Notifications\ResetPasswordNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Storage;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'avatar'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['avatar_url'];

    protected $with = [
        'roles:id,name'
    ];

    public function isAdmin()
    {
        return $this->roles()->wherePivot('id', '=', 1)->exists();
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'author_id');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * Interact with the user's first name.
     *
     * @return Attribute
     */
    protected function avatarUrl(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                return asset(Storage::url($attributes['avatar']));
            }
        );
    }

    public function sendPasswordResetNotification($token)
    {
//        TODO: add frontend site url environment variable
        $url = 'http://localhost:3000/reset-password?token='.$token;

        $this->notify(new ResetPasswordNotification($url));
    }
}
