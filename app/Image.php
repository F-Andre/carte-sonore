<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
  protected $fillable = [
    'name', 'ext', 'size', 'path', 'card_id', 'user_id'
  ];

  public function user()
  {
    return $this->belongsTo('App\User');
  }

  public function card()
  {
    return $this->belongsTo('App\Card');
  }
}
