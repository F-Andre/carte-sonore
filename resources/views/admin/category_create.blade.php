@extends('layouts.admin_layout')

@section('admin_content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header h4">Création d'une catégorie</div>
        <div class="card-body">
          <create-category-form route="{{ route('category.store') }}" :names-array='{!! json_encode($namesArray) !!}'></create-category-form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection