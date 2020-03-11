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
  <section class="flex-fill">
    @yield('admin_content')
  </section>
</div>
@endsection