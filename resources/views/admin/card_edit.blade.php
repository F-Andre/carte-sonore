@extends('layouts.admin_layout')

@section('admin_content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header h4">Edition d'un marqueur</div>
        <div class="card-body">
          <edit-marker-form route="{{ route('card.update', $card) }}" :points_old='{!! json_encode($points, JSON_HEX_QUOT | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_UNESCAPED_SLASHES) !!}' :categories='{!! json_encode($categoriesName, JSON_HEX_QUOT | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_UNESCAPED_SLASHES) !!}'></edit-marker-form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection