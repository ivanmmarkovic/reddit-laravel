<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Contracts\Auth\Authenticatable;

class User extends Model implements Authenticatable
{
    //

    use \Illuminate\Auth\Authenticatable;

    protected $fillable = [
        'name', 'email'
    ];

    public function posts()
    {
        return $this->hasMany('App\Post');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }
}
