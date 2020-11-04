<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = ['number', 'user_id'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
