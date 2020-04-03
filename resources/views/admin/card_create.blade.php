@extends('layouts.admin_layout')

@section('admin_content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header h4">Création d'un marqueur</div>
        <div class="card-body">
          <create-marker-form route="{{ route('card.store') }}" :points_old='{!! json_encode($points, JSON_HEX_QUOT | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_UNESCAPED_SLASHES) !!}' :categories='{!! json_encode($categoriesName, JSON_HEX_QUOT | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_UNESCAPED_SLASHES) !!}'></create-marker-form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection