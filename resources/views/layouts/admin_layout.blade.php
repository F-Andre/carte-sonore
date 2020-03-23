@extends('layouts.app')

@section('content')
<div class="d-flex px-4">
  <ul class="nav nav-pills nav-stacked flex-column mt-3">
    <li class="nav-item">
      <a href="{{ route('admin.home') }}" class="nav-link {{ $indexActive ?? '' }}">Accueil admin</a>
    </li>
    <li class="nav-item">
      <a href="{{ route('card.index') }}" class="nav-link {{ $cardActive ?? '' }}">Marqueurs</a>
    </li>
    <li class="nav-item disabled">
      <a href="{{ route('pathway.index') }}" class="nav-link {{ $pathwayActive ?? '' }}">Parcours</a>
    </li>
    <li class="nav-item">
      <a href="{{ route('group.index') }}" class="nav-link {{ $groupActive ?? '' }}">Groupes</a>
    </li>
  </ul>
  <section class="flex-fill" id="admin-content">
    @if (session()->has('ok'))
    <div class="alert alert-success alert-dismissible col-lg-8 mx-auto fade show mt-3" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        <span class="sr-only">Fermer</span>
      </button>
      {{ session('ok') }}
    </div>
    @endif
    @if (session()->has('error'))
    <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        <span class="sr-only">Fermer</span>
      </button>
      {{ session('error') }}
    </div>
    @endif
    @yield('admin_content')
  </section>
</div>
@endsection