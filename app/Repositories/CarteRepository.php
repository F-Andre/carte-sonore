<?php

namespace App\Repositories;

use App\Carte;

class CarteRepository extends DataRepository
{
    public function __construct(Carte $carte)
    {
        $this->model = $carte;
    }
}
