@extends('layouts.app')

@section('content')
<div class="d-flex px-4">
  <ul class="nav nav-pills nav-stacked flex-column">
    <li class="nav-item">
      <a href="#" class="nav-link active">Accueil admin</a>
    </li>
    <li class="nav-item">
      <a href="#" class="nav-link">Marqueurs</a>
    </li>
    <li class="nav-item disabled">
      <a href="#" class="nav-link">Parcours</a>
    </li>
  </ul>
  <section class="flex-fill">
    @yield('admin_content')
  </section>
</div>
@endsection