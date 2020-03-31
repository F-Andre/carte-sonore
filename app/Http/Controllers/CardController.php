<?php

namespace App\Http\Controllers;

use App\Card;
use App\Repositories\AudioRepository;
use App\Repositories\CardRepository;
use App\Repositories\PhotoRepository;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;

class CardController extends Controller
{
  protected $card;
  protected $photo;
  protected $audio;

  public function __construct(CardRepository $card, PhotoRepository $photo, AudioRepository $audio, CategoryRepository $category)
  {
    $this->card = $card;
    $this->photo = $photo;
    $this->audio = $audio;
    $this->category = $category;
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
    $categoriesName = $this->category->getColumn('name');

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

    return view('admin.card_create', compact('newMarker', 'cardActive', 'cards', 'points', 'categoriesName'));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $cardsTitle = $this->card->getColumn('title');
    $category = $this->category->getByName($request->category);

    foreach ($cardsTitle as $title) {
      if ($title === $request->title) {
        return redirect()->back()->with('error', 'Ce titre existe déjà.');
      }
    }

    if ($request->photo->isValid()) {
      $photoSaved = $this->photo->savePhoto($request->file('photo'));
      $photoPathUrl = $photoSaved['photoPathUrl'];
      $photoFileExt = $photoSaved['photoFileExt'];

      $audioSaved = $this->audio->saveAudio($request->file('audio'));
      $audioFileExt = $audioSaved['audioFileExt'];
      $audioPathUrl = $audioSaved['audioPathUrl'];

      $cardInputs = ['category_id' => $category->id, 'title' => $request->title, 'description' => $request->description, 'coordinates' => $request->coordinates, 'address' => $request->address, 'creator_id' => auth()->user()->id];
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
    $cardActive = 'active';

    $points = [];
    $coordinates = explode(' ,', $card->coordinates);
    array_push(
      $points,
      [
        "key" => 0,
        "id" => $card->id,
        "title" => $card->title,
        "description" => $card->description,
        "coordinates" => $coordinates,
        "image" => $card->photo->path,
        "audio" => $card->audio->path,
        "color" => $card->category->marker,
      ]
    );

    return view('admin.card_show', compact('card', 'cardActive', 'points'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Card  $card
   * @return \Illuminate\Http\Response
   */
  public function edit(Card $card)
  {
    $cardActive = 'active';
    $newMarker = true;
    $categoriesName = $this->category->getColumn('name');

    $points = [];
    $coordinates = explode(' ,', $card->coordinates);
    array_push(
      $points,
      [
        "key" => 0,
        "id" => $card->id,
        "title" => $card->title,
        "description" => $card->description,
        "coordinates" => $coordinates,
        "address" => $card->address,
        "image" => $card->photo->path,
        "audio" => $card->audio->path,
        "audioName" => $card->audio->name,
        "color" => $card->category->marker,
        "category" => $card->category->name
      ]
    );

    return view('admin.card_edit', compact('card', 'cardActive', 'points', 'categoriesName'));
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
    $cardsTitle = $this->card->getColumn('title');
    $category = $this->category->getByName($request->category);

    foreach ($cardsTitle as $title) {
      if ($title === $request->title && $card->title !== $request->title) {
        return redirect()->back()->with('error', 'Ce titre existe déjà.');
      }
    }

    $cardInputs = ['category_id' => $category->id, 'title' => $request->title, 'description' => $request->description, 'coordinates' => $request->coordinates, 'address' => $request->address, 'editor_id' => auth()->user()->id];
    $cardUpdated = $this->card->update($cardInputs);

    if ($request->newImage === "true") {
      $this->photo->deletePhoto($card->photo);
      $photoSaved = $this->photo->savePhoto($request->file('photo'));
      $photoPathUrl = $photoSaved['photoPathUrl'];
      $photoFileExt = $photoSaved['photoFileExt'];
      $photoInputs = ['name' => $request->file('photo')->getClientOriginalName(), 'ext' => $photoFileExt, 'size' => $request->file('photo')->getSize(), 'path' => $photoPathUrl, 'user_id' => auth()->user()->id];
      $photoUpdated = $this->photo->update($photoInputs);
    }

    if ($request->newAudio === "true") {
      $this->audio->deleteAudio($card->audio);
      $audioSaved = $this->audio->saveAudio($request->file('audio'));
      $audioFileExt = $audioSaved['audioFileExt'];
      $audioPathUrl = $audioSaved['audioPathUrl'];
      $audioInputs = ['name' => $request->file('audio')->getClientOriginalName(), 'ext' => $request->file('audio')->extension(), 'size' => $request->file('audio')->getSize(), 'duration' => 0, 'path' => $audioPathUrl, 'user_id' => auth()->user()->id];
      $audioUpdated = $this->audio->update($audioInputs);
    }

    return redirect(route('card.index'))->with('ok', 'La carte a bien été enregistrée.');
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
      $photoDeleted = $this->photo->deletePhoto($card->photo);
      if ($photoDeleted) {
        $photoDestroyed = $card->photo->destroy($card->photo->id);
      } else {
        $photoDestroyed = false;
      }
    } else {
      $photoDestroyed = true;
    }

    if ($card->audio) {
      $audioDeleted = $this->audio->deleteAudio($card->audio);
      if ($audioDeleted) {
        $audioDestroyed = $card->audio->destroy($card->audio->id);
      } else {
        $audioDestroyed = false;
      }
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
