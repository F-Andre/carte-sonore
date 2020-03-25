<?php

namespace App\Repositories;

use App\Audio;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AudioRepository extends DataRepository
{
  public function __construct(Audio $audio)
  {
    $this->model = $audio;
  }

  public function saveAudio($audio)
  {
    $audioFileExt = $audio->getClientOriginalExtension();
    $audioFileName = Str::random(15);
    while (Storage::exists('public/audios/' . $audioFileName . '.' . $audioFileExt)) {
      $audioFileName = Str::random(15);
    }
    $audioPathUrl = '/storage/audios/' . $audioFileName . '.' . $audioFileExt;
    $audioPath = $audio->storeAs('public/audios', $audioFileName . '.' . $audioFileExt);

    return ['audioFileExt' => $audioFileExt, 'audioPathUrl' => $audioPathUrl];
  }
}
