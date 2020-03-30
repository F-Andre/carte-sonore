<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\CardRepository;

class FrontController extends Controller
{
  protected $card;

  public function __construct(CardRepository $card)
  {
    $this->card = $card;
  }

  public function index()
  {
    $cards = $this->card->getCollection();
    $points = [];
    foreach ($cards as $key => $card) {
      $coordinates = explode(' ,', $card->coordinates);

      array_push(
        $points,
        [
          "key" => $key,
          "id" => $card->id,
          "title" => $card->title,
          "description" => $card->description,
          "coordinates" => $coordinates,
          "image" => $card->photo->path,
          "audio" => $card->audio->path,
          "color" => $card->category->marker
        ]
      );
    }

    return view('welcome', compact('points'));
  }
}
