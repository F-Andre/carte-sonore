<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pathway extends Model
{
  public function cards()
  {
    return $this->hasMany('App\Card');
  }

  public function creator()
  {
    return $this->belongsTo('App\User', 'id', 'creator_id');
  }

  public function editor()
  {
    return $this->belongsTo('App\User', 'id', 'editor_id');
  }

  public function group()
  {
    return $this->belongsTo('App\Group');
  }
}
