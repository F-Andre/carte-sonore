<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
  protected $fillable = [
    'name', 'description', 'marker', 'creator_id', 'editor_id'
  ];

  public function card()
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
}
