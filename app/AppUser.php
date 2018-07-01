<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class AppUser extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'app_users';

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded= [
        'id'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

}
