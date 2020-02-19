<template>
  <MglMap
    :container="container"
    :accessToken="accessToken"
    :mapStyle.sync="mapStyle"
    :center="coordinates"
    :zoom="zoom"
    @load="onMapLoaded"
  >
    <MglMarker :coordinates="coordinates" color="blue" />
    <MglGeolocateControl position="top-right" :positionOptions="positionOptions" :trackUserLocation="trackUserLocation" :fitBoundsOptions="fitBoundsOptions" @geolocate="onGeolocate"/>
  </MglMap>
</template>

<script>
import Mapbox from "mapbox-gl";
import { MglMap, MglMarker, MglGeolocateControl } from "vue-mapbox";
import MapboxLanguage from "@mapbox/mapbox-gl-language";

export default {
  components: {
    MglMap,
    MglMarker,
    MglGeolocateControl
  },

  data() {
    return {
      container: "map",
      accessToken:
        "pk.eyJ1IjoiZmFiaWVuYW5kcmUiLCJhIjoiY2s2Z2lxNXBjMHlhbDNqcXB6eDAyZnhvNyJ9.p7K1EMcW_ODNIn7q9Xf17A", // your access token. Needed if you using Mapbox maps
      mapStyle: "mapbox://styles/mapbox/streets-v10", // your map style
      zoom: 17,
      coordinates: [-3, 48],
      positionOptions: { enableHighAccuracy: true, timeout: 1000},
      trackUserLocation: true,
      fitBoundsOptions: { maxZoom:18 }
    };
  },

  created() {
    this.map = null;
  },

  methods: {
    async onMapLoaded(event) {
      // in component
      this.map = event.map;
      var language = new MapboxLanguage();
      this.map.setStyle(language.setLanguage(this.map.getStyle(), "fr"));
    },

    async onGeolocate(data) {
      var textLoc = 'Latitude: ' + data.mapboxEvent.coords.latitude + ' / ' + 'Longitude: ' + data.mapboxEvent.coords.longitude + ' / ' + 'Altitude: ' + data.mapboxEvent.coords.altitude + ' / ' + 'Vitesse: ' + data.mapboxEvent.coords.speed + ' / ' + 'Direction: ' + data.mapboxEvent.coords.heading + ' / ' + 'Précision: ' + data.mapboxEvent.coords.accuracy;
      document.querySelector('#message').textContent = "";
      document.querySelector('#message').textContent = textLoc;
    }
  }
};
</script>
