<?php

namespace App\Repositories;

use App\Photo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class PhotoRepository extends DataRepository
{
  public function __construct(Photo $photo)
  {
    $this->model = $photo;
  }

  public function savePhoto($photo)
  {
    Storage::makeDirectory('public/images/');

    //$photoFileExt = $photo->getClientOriginalExtension();
    $photoFileExt = 'webp';
    $photoFileName = Str::random(15);
    while (Storage::exists('public/images/' . $photoFileName . '.' . $photoFileExt)) {
      $photoFileName = Str::random(15);
    }

    $photoPath = Storage::url('public/images/' . $photoFileName . '.' . $photoFileExt);

    $photoPathUrl = '/storage/images/' . $photoFileName . '.' . $photoFileExt;
    $photoMake = Image::make($photo);
    $photoMake->widen(900, function ($constraint) {
      $constraint->upsize();
    });
    $photoMake->save('.' . $photoPath);

    return ['photoPathUrl' => $photoPathUrl, 'photoFileExt' => $photoFileExt];
  }

  public function deletePhoto($photo)
  {
    $url = preg_replace('/(\/storage)/', 'public', $photo->path);
    $photoDeleted = Storage::delete($url);

    return $photoDeleted;
  }
}
