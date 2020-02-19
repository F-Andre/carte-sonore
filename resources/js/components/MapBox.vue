<template>
  <MglMap
    :container="container"
    :accessToken="accessToken"
    :mapStyle.sync="mapStyle"
    :center="coordinates"
    :zoom="zoom"
    @load="onMapLoaded"
  >
    <MglGeolocateControl
      position="top-right"
      :positionOptions="positionOptions"
      :trackUserLocation="trackUserLocation"
      :fitBoundsOptions="fitBoundsOptions"
      @geolocate="onGeolocate"
    />
    <MglNavigationControl position="top-left" />
    <MglMarker :coordinates="coordinates" color="blue" anchor="bottom" />
    <MglPopup :coordinates="coordinates" anchor="top" :showed="showed">
      <div>Bingo !</div>
    </MglPopup>
  </MglMap>
</template>

<script>
import Mapbox from "mapbox-gl";
import {
  MglMap,
  MglMarker,
  MglGeolocateControl,
  MglNavigationControl,
  MglPopup
} from "vue-mapbox";
import MapboxLanguage from "@mapbox/mapbox-gl-language";

export default {
  components: {
    MglMap,
    MglMarker,
    MglGeolocateControl,
    MglNavigationControl,
    MglPopup
  },

  data() {
    return {
      container: "map",
      accessToken:
        "pk.eyJ1IjoiZmFiaWVuYW5kcmUiLCJhIjoiY2s2Z2lxNXBjMHlhbDNqcXB6eDAyZnhvNyJ9.p7K1EMcW_ODNIn7q9Xf17A", // your access token. Needed if you using Mapbox maps
      mapStyle: "mapbox://styles/mapbox/streets-v10", // your map style
      zoom: 16,
      coordinates: [-3.8773302850858045, 48.358303879093285],
      positionOptions: { enableHighAccuracy: true, timeout: 1000 },
      trackUserLocation: true,
      fitBoundsOptions: { maxZoom: 18 },
      showed: false
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
      this.map.on("click", e => {
        document.querySelector("#message").textContent = "";
        document.querySelector("#message").textContent = e.lngLat.wrap();
      });
    },

    async onGeolocate(data) {
      const asyncActions = data.component.actions;
      await asyncActions.flyTo({
        center: [
          data.mapboxEvent.coords.longitude,
          data.mapboxEvent.coords.latitude
        ]
      });

      await asyncActions.easeTo({ bearing: data.mapboxEvent.coords.heading });

      var textLoc =
        "Latitude: " +
        data.mapboxEvent.coords.latitude.toFixed(4) +
        " / " +
        "Longitude: " +
        data.mapboxEvent.coords.longitude.toFixed(4) +
        "<br>" +
        "Mark Lat: " +
        this.coordinates[1].toFixed(4) +
        " / " +
        "Mark Long: " +
        this.coordinates[0].toFixed(4) +
        "<br>" +
        "Direction: " +
        data.mapboxEvent.coords.heading +
        "<br>" +
        "Vitesse: " +
        data.mapboxEvent.coords.speed +
        "<br>" +
        "Altitude: " +
        data.mapboxEvent.coords.altitude +
        "<br>" +
        "Précision: " +
        data.mapboxEvent.coords.accuracy;
      document.querySelector("#message").innerHTML = "";
      document.querySelector("#message").innerHTML = textLoc;

      if (data.mapboxEvent.coords.latitude.toFixed(4) == this.coordinates[0].toFixed(4) && data.mapboxEvent.coords.longitude.toFixed(4) == this.coordinates[1].toFixed(4)) {
        this.showed = true;
      }
    }
  }
};
</script>
