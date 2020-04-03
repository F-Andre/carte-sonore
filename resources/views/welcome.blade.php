@extends('layouts.app')

@section('content')
<div id="map" style="width: 90vw; height: 80vh;">
  <map-box :add-marker="false" :points='{!! json_encode($points, JSON_HEX_QUOT | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_UNESCAPED_SLASHES) !!}'></map-box>
</div>
<div class="card col-lg-8 mx-auto mt-3">
  <div class="card-body text-center">
    <p class="card-title" id="message"></p>
  </div>
</div>
@endsection