<?php

namespace App\Http\Controllers;

use App\Card;
use App\Repositories\AudioRepository;
use App\Repositories\CardRepository;
use App\Repositories\ImageRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class CardController extends Controller
{
  protected $card;
  protected $image;
  protected $audio;

  public function __construct(CardRepository $card, ImageRepository $image, AudioRepository $audio)
  {
    $this->card = $card;
    $this->image = $image;
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

    if ($request->image->isValid()) {

      $titleName = preg_replace('/\s/', '_', $request->title);
      Storage::makeDirectory('public/images/');

      //$imageFileExt = $request->image->getClientOriginalExtension();
      $imageFileExt = 'webp';
      $imageFileName = Str::random(15);
      while (Storage::exists('public/images/' . $imageFileName . '.' . $imageFileExt)) {
        $imageFileName = Str::random(15);
      }

      $imagePath = Storage::url('public/images/' . $imageFileName . '.' . $imageFileExt);

      $imagePathUrl = '/storage/images/' . $imageFileName . '.' . $imageFileExt;
      $imageMake = Image::make($request->file('image'));
      $imageMake->widen(900, function ($constraint) {
        $constraint->upsize();
      });
      $imageMake->save('.' . $imagePath);

      $audioFileExt = $request->audio->getClientOriginalExtension();
      $audioFileName = Str::random(15);
      while (Storage::exists('public/audios/' . $audioFileName . '.' . $audioFileExt)) {
        $audioFileName = Str::random(15);
      }
      $audioPathUrl = '/storage/audios/' . $audioFileName . '.' . $audioFileExt;
      $audioPath = $request->file('audio')->storeAs('public/audios', $audioFileName . '.' . $audioFileExt);

      $cardInputs = ['title' => $request->title, 'description' => $request->description, 'coordinates' => $request->coordinates, 'address' => $request->address, 'creator_id' => auth()->user()->id];
      $cardStored = $this->card->store($cardInputs);

      if ($cardStored) {
        $imageInputs = ['name' => $request->file('image')->getClientOriginalName(), 'ext' => $imageFileExt, 'size' => $request->file('image')->getSize(), 'path' => $imagePathUrl, 'card_id' => $cardStored->id, 'user_id' => auth()->user()->id];
        $imageStored = $this->image->store($imageInputs);
      }

      if ($cardStored) {
        $audioInputs = ['name' => $request->file('audio')->getClientOriginalName(), 'ext' => $request->file('audio')->extension(), 'size' => $request->file('audio')->getSize(), 'duration' => 0, 'path' => $audioPathUrl, 'card_id' => $cardStored->id, 'user_id' => auth()->user()->id];
        $audioStored = $this->audio->store($audioInputs);
      }

      if ($cardStored && $imageStored && $audioStored) {
        return redirect(route('card.index'))->with('ok', 'La carte a bien été enregistrée.');
      } else {
        $cardStored ? $this->card->destroy($cardStored->id) : '';
        $imageStored ? $this->image->destroy($imageStored->id) : '';
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
    if ($card->image) {
      $imageDestroyed = $card->image->destroy($card->image->id);
    } else {
      $imageDestroyed = true;
    }

    if ($card->audio) {
      $audioDestroyed = $card->audio->destroy($card->audio->id);
    } else {
      $audioDestroyed = true;
    }

    if ($imageDestroyed && $audioDestroyed) {
      $card->destroy($card->id);
      return redirect()->back()->with('ok', 'La carte a bien été effacée.');
    }

    return redirect()->back()->with('error', 'La carte n\'a pas été effacée correctement.');
  }
}
