<?php

namespace App\Repositories;

use App\Card;

class CardRepository extends DataRepository
{
    public function __construct(Card $card)
    {
        $this->model = $card;
    }
}
