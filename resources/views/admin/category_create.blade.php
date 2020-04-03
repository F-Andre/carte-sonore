@extends('layouts.admin_layout')

@section('admin_content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header h4">Création d'une catégorie</div>
        <div class="card-body">
          <create-category-form route="{{ route('category.store') }}" :names-array='{!! json_encode($namesArray, JSON_HEX_QUOT | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_UNESCAPED_SLASHES) !!}'></create-category-form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection