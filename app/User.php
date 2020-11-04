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
        'name', 'email', 'password',
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

    public function document()
    {
        return $this->hasOne('App\Document');
    }

    /**
    * Fetch user by Credentials
    *
    * @param array $credentials
    * @return Illuminate\Contracts\Auth\Authenticatable
    */
    public function fetchUserByCredentials(Array $credentials)
    {
        $document = \App\Document::where('number', 'like', $credentials['number'])->first();

        if($document) {
            return $document->user;
        }
    }

    /**
    * {@inheritDoc}
    * @see \Illuminate\Contracts\Auth\Authenticatable::getAuthIdentifierName()
    */
    // public function getAuthIdentifierName()
    // {
    //     return "number";
    // }

    /**
    * {@inheritDoc}
    * @see \Illuminate\Contracts\Auth\Authenticatable::getAuthIdentifier()
    */
    public function getAuthIdentifier()
    {
        return $this->document->{$this->getAuthIdentifierName()};
    }

    /**
    * {@inheritDoc}
    * @see \Illuminate\Contracts\Auth\Authenticatable::getAuthPassword()
    */
    public function getAuthPassword()
    {
        return $this->password;
    }

    /**
    * {@inheritDoc}
    * @see \Illuminate\Contracts\Auth\Authenticatable::getRememberToken()
    */
    public function getRememberToken()
    {
        if (! empty($this->getRememberTokenName())) {
          return $this->{$this->getRememberTokenName()};
        }
    }

    /**
    * {@inheritDoc}
    * @see \Illuminate\Contracts\Auth\Authenticatable::setRememberToken()
    */
    public function setRememberToken($value)
    {
        if (! empty($this->getRememberTokenName())) {
          $this->{$this->getRememberTokenName()} = $value;
        }
    }

    /**
    * {@inheritDoc}
    * @see \Illuminate\Contracts\Auth\Authenticatable::getRememberTokenName()
    */
    public function getRememberTokenName()
    {
        return $this->rememberTokenName;
    }
}
