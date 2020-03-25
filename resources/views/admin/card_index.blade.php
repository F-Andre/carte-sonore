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
          <div class="row row-cols-1 row-cols-md-2">
            @if (count($cards) > 0)
            @foreach ($cards as $card)
            <div class="col mb-2">
              <div class="card card-admin">
                <img class="card-img-top" src={{ $card->photo->path }} alt={{ $card->photo->name }}>
                <div class="card-body">
                  <h4 class="card-title">{{ $card->title }}</h4>
                  <p class="card-text">{{ $card->description }}</p>
                  <audio class="card-player" src={{ $card->audio->path }} controls></audio>
                  {{-- <p>{{ $card->group->name }}</p> --}}
                </div>
                <div class="card-footer ">
                  <div>
                    <p>{{ $card->address }}</p>
                  </div>
                  <div class="d-flex justify-content-between">
                    <a class="btn btn-warning" href={{ route('card.edit', $card) }} role="button">Editer</a>
                    <div class="dropdown">
                      <button class="btn btn-danger dropdown-toggle" type="button" id="deleteBtn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Supprimer
                      </button>
                      <div class="dropdown-menu" aria-labelledby="deleteBtn">
                        <form method="POST" action={{ route('card.destroy', $card) }}>
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="text-danger dropdown-item" href="{{ route('card.destroy', $card) }}" role="button">Valider</button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            @endforeach
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