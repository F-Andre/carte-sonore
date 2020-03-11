@extends('layouts.app')

@section('content')
<ul class="nav nav-pills nav-stacked">
  <li class="nav-item">
    <a href="#" class="nav-link active">Active</a>
  </li>
  <li class="nav-item">
    <a href="#" class="nav-link">Link</a>
  </li>
  <li class="nav-item disabled">
    <a href="#" class="nav-link">Disabled</a>
  </li>
</ul>
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">Dashboard</div>

        <div class="card-body">
          @if (session('status'))
          <div class="alert alert-success" role="alert">
            {{ session('status') }}
          </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>
@endsection