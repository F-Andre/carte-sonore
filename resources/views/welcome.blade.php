@extends('layouts.app')

@section('content')
<div id="map" style="width: 90vw; height: 80vh;">
  <map-box></map-box>
</div>
<div class="card col-lg-8 mx-auto mt-3">
  <div class="card-body text-center">
    <h4 class="card-title" id="message"></h4>
  </div>
</div>
@endsection