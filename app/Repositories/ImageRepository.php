<?php

namespace App\Repositories;

use App\Image;

class ImageRepository extends DataRepository
{
  public function __construct(Image $image)
  {
    $this->model = $image;
  }
}
