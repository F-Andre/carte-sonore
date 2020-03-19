<?php

namespace App\Http\Controllers;

use App\Card;
use App\Repositories\CardRepository;
use Illuminate\Http\Request;

class CardController extends Controller
{
  protected $card;

  public function __construct(CardRepository $card)
  {
    $this->card = $card;
    $this->middleware('auth');
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $cardActive = 'active';
    $cards = $this->card->getCollection();

    return view('admin.card_index', compact('cards', 'cardActive'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    $cardActive = 'active';
    $newMarker = true;

    return view('admin.card_create', compact('newMarker', 'cardActive'));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    //
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Card  $card
   * @return \Illuminate\Http\Response
   */
  public function show(Card $card)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Card  $card
   * @return \Illuminate\Http\Response
   */
  public function edit(Card $card)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Card  $card
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Card $card)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Card  $card
   * @return \Illuminate\Http\Response
   */
  public function destroy(Card $card)
  {
    //
  }
}
