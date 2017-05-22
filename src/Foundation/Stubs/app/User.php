<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get the URL of the user profile picture.
     *
     * @param  string|null  $value
     * @return string
     */
    public function getPhotoUrlAttribute($value)
    {
        return empty($value) ? url('images/default/avatar.svg') : url($value);
    }
}
