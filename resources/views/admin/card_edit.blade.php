@extends('layouts.admin_layout')

@section('admin_content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header h4">Création d'un marqueur</div>
        <div class="card-body">
          <edit-marker-form route="{{ route('card.update', $card) }}" :points_old='{!! json_encode($points) !!}' :categories='{!! json_encode($categoriesName) !!}'></edit-marker-form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection