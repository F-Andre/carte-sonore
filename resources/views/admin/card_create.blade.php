@extends('layouts.admin_layout')

@section('admin_content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header h4">Création d'un marqueur</div>
        <div class="card-body">
          @if (session('status'))
          <div class="alert alert-success" role="alert">
            {{ session('status') }}
          </div>
          @endif
          <create-marker-form route="{{ route('card.store') }}"></create-marker-form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection