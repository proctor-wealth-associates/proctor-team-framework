<?php

namespace Elegon\Foundation\Models;

class User extends Model
{
    use Authenticatable, CanResetPassword;
    
    protected $guarded = [];

    protected $table = 'users';
}