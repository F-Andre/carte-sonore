<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Audio extends Model
{
  public function user()
  {
    return $this->belongsTo('App\User');
  }

  public function card()
  {
    return $this->belongsTo('App\Card');
  }
}