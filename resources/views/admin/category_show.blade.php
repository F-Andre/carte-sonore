@extends('layouts.admin_layout')

@section('admin_content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header h4">Catégorie en détail</div>
        <div class="card-body">
          <div>
            <p class="h5">Nom: <b>{{ $category->name }}</b></p>
            <p class="h5">Description: <b>{{ $category->description }}</b></p>
            <p class="marker-color"><span class="mr-2">Marqueur:</span>
              <svg display="block" height="41px" width="27px" viewBox="0 0 27 41">
                <g fill-rule="nonzero">
                  <g transform="translate(3.0, 29.0)" fill="#000000">
                    <ellipse opacity="0.04" cx="10.5" cy="5.80029008" rx="10.5" ry="5.25002273"></ellipse>
                    <ellipse opacity="0.04" cx="10.5" cy="5.80029008" rx="10.5" ry="5.25002273"></ellipse>
                    <ellipse opacity="0.04" cx="10.5" cy="5.80029008" rx="9.5" ry="4.77275007"></ellipse>
                    <ellipse opacity="0.04" cx="10.5" cy="5.80029008" rx="8.5" ry="4.29549936"></ellipse>
                    <ellipse opacity="0.04" cx="10.5" cy="5.80029008" rx="7.5" ry="3.81822308"></ellipse>
                    <ellipse opacity="0.04" cx="10.5" cy="5.80029008" rx="6.5" ry="3.34094679"></ellipse>
                    <ellipse opacity="0.04" cx="10.5" cy="5.80029008" rx="5.5" ry="2.86367051"></ellipse>
                    <ellipse opacity="0.04" cx="10.5" cy="5.80029008" rx="4.5" ry="2.38636864"></ellipse>
                  </g>
                  <g fill="{{ $category->marker }}">
                    <path d="M27,13.5 C27,19.074644 20.250001,27.000002 14.75,34.500002 C14.016665,35.500004 12.983335,35.500004 12.25,34.500002 C6.7499993,27.000002 0,19.222562 0,13.5 C0,6.0441559 6.0441559,0 13.5,0 C20.955844,0 27,6.0441559 27,13.5 Z"></path>
                  </g>
                  <g opacity="0.25" fill="#000000">
                    <path d="M13.5,0 C6.0441559,0 0,6.0441559 0,13.5 C0,19.222562 6.7499993,27 12.25,34.5 C13,35.522727 14.016664,35.500004 14.75,34.5 C20.250001,27 27,19.074644 27,13.5 C27,6.0441559 20.955844,0 13.5,0 Z M13.5,1 C20.415404,1 26,6.584596 26,13.5 C26,15.898657 24.495584,19.181431 22.220703,22.738281 C19.945823,26.295132 16.705119,30.142167 13.943359,33.908203 C13.743445,34.180814 13.612715,34.322738 13.5,34.441406 C13.387285,34.322738 13.256555,34.180814 13.056641,33.908203 C10.284481,30.127985 7.4148684,26.314159 5.015625,22.773438 C2.6163816,19.232715 1,15.953538 1,13.5 C1,6.584596 6.584596,1 13.5,1 Z"></path>
                  </g>
                  <g transform="translate(6.0, 7.0)" fill="#FFFFFF"></g>
                  <g transform="translate(8.0, 8.0)">
                    <circle fill="#000000" opacity="0.25" cx="5.5" cy="5.5" r="5.4999962"></circle>
                    <circle fill="#FFFFFF" cx="5.5" cy="5.5" r="5.4999962"></circle>
                  </g>
                </g>
              </svg>
            </p>
            <p>Créée le {{ Carbon\Carbon::parse($category->created_at)->timezone('Europe/Paris')->locale('fr')->isoFormat('dddd DD MMMM YYYY \à HH:mm') }} par {{ $category->creator->name }}</p>
            @if (isset($category->editor_id))
            <p>Dernière modification le {{ Carbon\Carbon::parse($category->updated_at)->timezone('Europe/Paris')->locale('fr')->isoFormat('dddd DD MMMM YYYY \à HH:mm') }} par {{ $category->editor->name }}</p>
            @endif
            <hr>
            <p class="h5">Marqueurs:</p>
            <table class="table table-striped table-inverse table-responsive">
              <thead class="thead-dark">
                <tr>
                  <th>Titre</th>
                  <th>Adresse</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                @foreach ($category->cards as $card)
                <tr>
                  <td scope="row">{{ $card->title }}</td>
                  <td>{{ $card->address }}</td>
                  <td><a class="btn btn-sm btn-info" href={{ route('card.show', $card) }} role="button">Voir</a>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
        <div class="card-footer">
          <div class="d-flex">
            <a class="btn btn-warning mr-2" href={{ route('category.edit', $category) }} role="button">Editer</a>
            <div class="dropdown open">
              <button class="btn btn-danger dropdown-toggle" type="button" id="deleteCategory" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" @if (count($category->cards) > 0)
                disabled title="Suppression impossible tant que des marqueurs font partis de cette categorie"
                @endif>
                Effacer
              </button>
              <div class="dropdown-menu" aria-labelledby="deleteCategory">
                <form action={{ route('category.destroy', $category) }} method="POST">
                  @csrf
                  @method('DELETE')
                  <button class="dropdown-item text-danger" type="submit">Valider</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
@endsection