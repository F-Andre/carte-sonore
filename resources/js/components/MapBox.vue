<template>
  <MglMap
    :accessToken="accessToken"
    :mapStyle.sync="mapStyle"
    :center="coordinates"
    :zoom="zoom"
    @load="onMapLoaded"
  />
</template>

<script>
import Mapbox from "mapbox-gl";
import { MglMap } from "vue-mapbox";

export default {
  components: {
    MglMap
  },
  data() {
    return {
      accessToken:
        "pk.eyJ1IjoiZmFiaWVuYW5kcmUiLCJhIjoiY2s2Z2lxNXBjMHlhbDNqcXB6eDAyZnhvNyJ9.p7K1EMcW_ODNIn7q9Xf17A", // your access token. Needed if you using Mapbox maps
      mapStyle: "mapbox://styles/mapbox/streets-v11", // your map style
      zoom: 12,
      coordinates: [-3.876758, 48.358431]
    };
  },

  created() {
    this.map = null;
    navigator.geolocation.getCurrentPosition(pos => {
      this.coordinates = [pos.coords.longitude, pos.coords.latitude];
    });
    var watchID = navigator.geolocation.watchPosition(pos => {
      this.coordinates = [pos.coords.longitude, pos.coords.latitude];
    });
  },
  methods: {
    async onMapLoaded(event) {
      // in component
      this.map = event.map;
    }
  }
};
</script>