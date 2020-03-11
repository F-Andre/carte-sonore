<?php

namespace App\Repositories;

use App\Pathway;

class PathwayRepository extends DataRepository
{
  public function __construct(Pathway $pathway)
  {
    $this->model = $pathway;
  }
}
