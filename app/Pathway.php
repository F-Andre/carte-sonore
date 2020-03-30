<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pathway extends Model
{
  protected $fillable = [
    'title', 'description', 'points', 'misc', 'creator_id', 'editor_id'
  ];

  public function cards()
  {
    return $this->hasMany('App\Card');
  }

  public function creator()
  {
    return $this->belongsTo('App\User', 'creator_id');
  }

  public function editor()
  {
    return $this->belongsTo('App\User', 'editor_id');
  }

  public function group()
  {
    return $this->belongsTo('App\Group');
  }
}
