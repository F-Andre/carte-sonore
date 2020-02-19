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
    <MglMarker :coordinates="[-3.8777128, 48.3581740]" color="blue" anchor="bottom" />
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
      coordinates: [-3.87711116, 48.3584854],
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
      this.map.on("mousemove", e => {
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

      if (data.mapboxEvent.coords.longitude == this.coordinates[0] && data.mapboxEvent.coords.latitude == this.coordinates[1]) {
        this.showed = true;
      }

      var textLoc =
        "Latitude: " +
        data.mapboxEvent.coords.latitude +
        " / " +
        "Longitude: " +
        data.mapboxEvent.coords.longitude +
        " / " +
        "Altitude: " +
        data.mapboxEvent.coords.altitude +
        " / " +
        "Vitesse: " +
        data.mapboxEvent.coords.speed +
        " / " +
        "Direction: " +
        data.mapboxEvent.coords.heading +
        " / " +
        "Précision: " +
        data.mapboxEvent.coords.accuracy;
      document.querySelector("#message").textContent = "";
      document.querySelector("#message").textContent = textLoc;
    }
  }
};
</script>
