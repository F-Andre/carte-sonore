<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
  protected $fillable = [
    'title', 'description', 'coordinates', 'address', 'creator_id', 'editor_id'
  ];

  public function photo()
  {
    return $this->hasOne('App\Photo');
  }

  public function audio()
  {
    return $this->hasOne('App\Audio');
  }

  public function catogory()
  {
    return $this->belongsTo('App\Category');
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
