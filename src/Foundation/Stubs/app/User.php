<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password',
    ];

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
