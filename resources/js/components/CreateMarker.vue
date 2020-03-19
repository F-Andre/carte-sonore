<template>
  <div>
    <div id="map" style="width: 50vw; height: 50vh;">
      <map-box
        v-on:newDraggedMarker="draggedMarkerCoord = $event"
        :add-marker="'{!! json_encode($newMarker) !!}'"
      ></map-box>
    </div>
    <p>{{ draggedMarkerCoord[0] }}</p>
    <p id="geocoder"></p>
  </div>
</template>

<script>
export default {
  data() {
    return {
      draggedMarkerCoord: [0, 0],
      draggedMarkerAddress: String
    };
  }
};
</script>