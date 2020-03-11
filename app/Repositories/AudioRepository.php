<?php

namespace App\Repositories;

use App\Audio;

class AudioRepository extends DataRepository
{
  public function __construct(Audio $audio)
  {
    $this->model = $audio;
  }
}
