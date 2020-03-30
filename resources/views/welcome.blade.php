@extends('layouts.app')

@section('content')
<div id="map" style="width: 90vw; height: 80vh;">
  <map-box :add-marker="false" :points='{!! json_encode($points) !!}'></map-box>
</div>
<div class="card col-lg-8 mx-auto mt-3">
  <div class="card-body text-center">
    <p class="card-title" id="message"></p>
  </div>
</div>
@endsection