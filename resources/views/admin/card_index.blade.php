@extends('layouts.admin_layout')

@section('admin_content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header h4">Marqueurs</div>
        <div class="card-body">
          <div class="col-lg-6">
            <a class="btn btn-success" href={{ route('card.create') }} role="button">Créer un nouveau marqueur</a>
          </div>
          @if(count($cards) > 0)
          <div class="admin-card d-flex justify-content-between flex-wrap">
            <div class="list-group col-lg-6 py-0">
              @foreach ($cards as $key => $card)
              @if (fmod($key, 2) == 1)
              <a href={{ route('card.show', $card) }} class="card-list list-group-item list-group-item-action flex-fill">
                <div class="d-flex w-100 justify-content-between">
                  <h5 class="mb-1">{{ $card->title }}</h5>
                  <small>{{ Carbon\Carbon::parse($card->created_at)->locale('fr')->diffForHumans() }}</small>
                </div>
                <p class="mb-1">{{ $card->description }}</p>
                <p class="mb-1">{{ $card->address }}</p>
                <p class="mb-1">Catégorie: {{ $card->category->name }}</p>
              </a>
              @endif
              @endforeach
            </div>
            <div class="list-group col-lg-6 py-0">
              @foreach ($cards as $key => $card)
              @if (fmod($key, 2) == 0)
              <a href={{ route('card.show', $card) }} class="card-list list-group-item list-group-item-action flex-fill">
                <div class="d-flex w-100 justify-content-between">
                  <h5 class="mb-1">{{ $card->title }}</h5>
                  <small>{{ Carbon\Carbon::parse($card->created_at)->locale('fr')->diffForHumans() }}</small>
                </div>
                <p class="mb-1">{{ $card->description }}</p>
                <p class="mb-1">{{ $card->address }}</p>
                <p class="mb-1">Catégorie: {{ $card->category->name }}</p>
              </a>
              @endif
              @endforeach
            </div>
            @else
            <div class="col mb-2 mx-auto">
              <div class="card card-default">
                <div class="card-body">
                  <h4 class="card-title">Il n'y pas de marqueurs</h4>
                  <p class="card-text">Pour en créer un, cliquez sur le bouton ci-dessus.</p>
                </div>
              </div>
            </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection