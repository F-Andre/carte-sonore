<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
  public function user()
  {
    return $this->belongsTo('App\User');
  }

  public function pathways()
  {
    return $this->hasMany('App\Pathway');
  }

  public function cards()
  {
    return $this->hasMany('App\Card');
  }
}
