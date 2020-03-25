<?php

namespace App\Http\Controllers;

use App\Card;
use App\Repositories\AudioRepository;
use App\Repositories\CardRepository;
use App\Repositories\PhotoRepository;
use Illuminate\Http\Request;

class CardController extends Controller
{
  protected $card;
  protected $photo;
  protected $audio;

  public function __construct(CardRepository $card, PhotoRepository $photo, AudioRepository $audio)
  {
    $this->card = $card;
    $this->photo = $photo;
    $this->audio = $audio;
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
    $cards = $this->card->getCollection();

    return view('admin.card_create', compact('newMarker', 'cardActive', 'cards'));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $cards = $this->card->getCollection();

    foreach ($cards as $card) {
      if ($card->title === $request->title) {
        return redirect()->back()->with('error', 'Ce titre existe déjà.');
      }
    }

    if ($request->photo->isValid()) {
      $photoSaved = $this->photo->savePhoto($request->file('photo'));
      $photoPathUrl = $photoSaved['photoPathUrl'];
      $photoFileExt = $photoSaved['photoFileExt'];

      $audioSaved= $this->audio->saveAudio($request->file('audio'));
      $audioFileExt = $audioSaved['audioFileExt'];
      $audioPathUrl = $audioSaved['audioPathUrl'];

      $cardInputs = ['title' => $request->title, 'description' => $request->description, 'coordinates' => $request->coordinates, 'address' => $request->address, 'creator_id' => auth()->user()->id];
      $cardStored = $this->card->store($cardInputs);

      if ($cardStored) {
        $photoInputs = ['name' => $request->file('photo')->getClientOriginalName(), 'ext' => $photoFileExt, 'size' => $request->file('photo')->getSize(), 'path' => $photoPathUrl, 'card_id' => $cardStored->id, 'user_id' => auth()->user()->id];
        $photoStored = $this->photo->store($photoInputs);
      }

      if ($cardStored) {
        $audioInputs = ['name' => $request->file('audio')->getClientOriginalName(), 'ext' => $request->file('audio')->extension(), 'size' => $request->file('audio')->getSize(), 'duration' => 0, 'path' => $audioPathUrl, 'card_id' => $cardStored->id, 'user_id' => auth()->user()->id];
        $audioStored = $this->audio->store($audioInputs);
      }

      if ($cardStored && $photoStored && $audioStored) {
        return redirect(route('card.index'))->with('ok', 'La carte a bien été enregistrée.');
      } else {
        $cardStored ? $this->card->destroy($cardStored->id) : '';
        $photoStored ? $this->photo->destroy($photoStored->id) : '';
        $audioStored ? $this->audio->destroy($audioStored->id) : '';
      }

      return redirect()->back()->with('error', 'Une erreur s\'est produite lors de l\'enregistrement de la carte.');
    }
    return redirect()->back()->with('error', 'Une erreur s\'est produite lors de l\'enregistrement de la carte.');
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
    if ($card->photo) {
      $photoDestroyed = $card->photo->destroy($card->photo->id);
    } else {
      $photoDestroyed = true;
    }

    if ($card->audio) {
      $audioDestroyed = $card->audio->destroy($card->audio->id);
    } else {
      $audioDestroyed = true;
    }

    if ($photoDestroyed && $audioDestroyed) {
      $card->destroy($card->id);
      return redirect()->back()->with('ok', 'La carte a bien été effacée.');
    }

    return redirect()->back()->with('error', 'La carte n\'a pas été effacée correctement.');
  }
}
