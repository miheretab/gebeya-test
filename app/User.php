<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'is_admin', 'active'
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
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //=======Impersonate functions======
    public function setImpersonating($id)
    {
        \Session::put('impersonate', $id);
    }

    public function stopImpersonating()
    {
        \Session::forget('impersonate');
    }

    public function isImpersonating()
    {
        return \Session::has('impersonate');
    }

    /**
     * Get the products associated with the user.
     */
    public function products()
    {
        return $this->hasMany('App\Product');
    }

    /**
     * Get the categories associated with the user.
     */
    public function categories()
    {
        return $this->hasMany('App\Category');
    }

}
