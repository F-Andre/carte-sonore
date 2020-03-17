<template>
  <MglMap
    :container="container"
    :accessToken="accessToken"
    :mapStyle.sync="mapStyle"
    :center="points[0].coordinates"
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
    <MglMarker
      v-for="point in points"
      :key="point.id"
      :coordinates="point.coordinates"
      @click="selectMarker"
    >
      <MglPopup :closeOnClick="false" anchor="center">
        <div class="card card-popup">
          <div class="card-img-head" :data-img="point.image"></div>
          <div class="card-body">
            <h4>{{ point.title }}</h4>
            <p>{{ point.description }}</p>
            <audio :data-src="point.audio" controls="true" autoplay="true" class="card-player"></audio>
          </div>
        </div>
      </MglPopup>
    </MglMarker>
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
      mapStyle:
        new Date().getHours() >= 19
          ? "mapbox://styles/mapbox/dark-v9"
          : new Date().getHours() <= 8
          ? "mapbox://styles/mapbox/dark-v9"
          : "mapbox://styles/mapbox/streets-v10",
      zoom: 10,
      positionOptions: { enableHighAccuracy: true, timeout: 1000 },
      trackUserLocation: true,
      fitBoundsOptions: { maxZoom: 18 },
      popupClose: true,
      points: [
        {
          id: 0,
          title: "Edn",
          description: "Centre équestre",
          image: "./images/brest.jpg",
          coordinates: [-3.8770151406342848, 48.3583926165185],
          audio: "./Fichiers/Trompette.mp3"
        },
        {
          id: 1,
          title: "Super U",
          description: "Centre commercial",
          image: "./images/brest.jpg",
          coordinates: [-4.503249831105336, 48.384794966193766],
          audio: "./Fichiers/Trompette.mp3"
        },
        {
          id: 2,
          title: "Keroriou",
          description: "Quartier",
          image: "./images/brest.jpg",
          coordinates: [-4.4804386822013385, 48.39098379760787],
          audio: "./Fichiers/Trompette.mp3"
        },
        {
          id: 3,
          title: "Test loc",
          description: "Geoloc connexion",
          image: "./images/brest.jpg",
          coordinates: [2.6370463521272995, 48.84992158564938],
          audio: "./Fichiers/Trompette.mp3"
        }
      ]
    };
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
      const asyncMapbox = data.component.mapbox;

      await asyncActions.flyTo({
        center: [
          data.mapboxEvent.coords.longitude,
          data.mapboxEvent.coords.latitude
        ],
        speed: 0.8
      });

      await asyncActions.easeTo({ bearing: data.mapboxEvent.coords.heading });

      var textLoc =
        "Latitude: " +
        data.mapboxEvent.coords.latitude.toFixed(4) +
        " / " +
        "Longitude: " +
        data.mapboxEvent.coords.longitude.toFixed(4) +
        "<br>" +
        "Direction: " +
        parseInt(data.mapboxEvent.coords.heading) +
        "°" +
        "<br>" +
        "Vitesse: " +
        (data.mapboxEvent.coords.speed !== null
          ? data.mapboxEvent.coords.speed.toFixed(3)
          : 0) +
        "m/s" +
        "<br>" +
        "Altitude: " +
        parseInt(data.mapboxEvent.coords.altitude) +
        "m" +
        "<br>" +
        "Précision: " +
        data.mapboxEvent.coords.accuracy.toFixed(4) +
        "m";
      document.querySelector("#message").innerHTML = "";
      document.querySelector("#message").innerHTML = textLoc;

      for (const point of this.points) {
        if (
          data.mapboxEvent.coords.latitude.toFixed(4) ===
            point.coordinates[1].toFixed(4) &&
          data.mapboxEvent.coords.longitude.toFixed(4) ===
            point.coordinates[0].toFixed(4) &&
          document.querySelectorAll(".card-popup").length === 0 &&
          this.popupClose
        ) {
          let index = indexOf(point);

          this.popupClose = false;

          popup.on("close", () => {
            setTimeout(() => {
              this.popupClose = true;
            }, 5000);
          });
        }
      }
    },

    selectMarker(e) {
      this.popupClose = false;

      this.map.flyTo({
        center: [e.marker.getLngLat().lng, e.marker.getLngLat().lat]
      });

      const popupContent = e.marker.getPopup()._content;

      let imgDiv = popupContent.childNodes[1].childNodes[0];
      imgDiv.style.backgroundImage =
        "url('" + imgDiv.getAttribute("data-img") + "')";

      let audioElem = popupContent.getElementsByTagName("audio")[0];
      audioElem.src = audioElem.getAttribute("data-src");

      let audioDuration = Number;
      const audioElemLoaded = new Promise((resolve, reject) => {
        let testAudio = setInterval(() => {
          console.log(typeof audioElem.duration);
          if (
            typeof audioElem.duration === "number" &&
            audioElem.duration > 0
          ) {
            console.log(audioElem.duration);
            resolve(audioElem.duration);
            clearInterval(testAudio);
          }
        }, 10);
      });

      audioElemLoaded.then(duration => {
        audioDuration = duration * 1200;

        setTimeout(() => {
          e.marker.togglePopup();
        }, audioDuration);
      });

      e.marker.getPopup().on("close", () => {
        setTimeout(() => {
          this.popupClose = true;
        }, 5000);
      });
    }
  }
};
</script>
