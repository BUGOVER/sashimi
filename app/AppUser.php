<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppUser extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'app_users';

    protected $fillable = [
        'name',
        'email',
        'bonus',
        'avatar',
        'dob',
        'phone',
        'address',
        'porch',
        'floor',
    ];

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [
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
