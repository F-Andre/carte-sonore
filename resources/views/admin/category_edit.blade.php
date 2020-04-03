@extends('layouts.admin_layout')

@section('admin_content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header h4">Edition d'une catégorie</div>
        <div class="card-body">
          <edit-category-form route="{{ route('category.update', $category) }}" :names-array='{!! json_encode($namesArray, JSON_HEX_QUOT | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_UNESCAPED_SLASHES) !!}' :category='{!! json_encode($category, JSON_HEX_QUOT | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_UNESCAPED_SLASHES) !!}'></edit-category-form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection