<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
  public function image()
  {
    return $this->hasOne('App\Image');
  }

  public function audio()
  {
    return $this->hasOne('App\Audio');
  }

  public function group()
  {
    return $this->belongsTo('App\Group');
  }

  public function pathway()
  {
    return $this->belongsTo('App\Pathway');
  }

  public function creator()
  {
    return $this->belongsTo('App\User', 'id', 'creator_id');
  }

  public function editor()
  {
    return $this->belongsTo('App\User', 'id', 'editor_id');
  }
}
