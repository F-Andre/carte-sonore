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
      v-bind:point="point"
      :coordinates="point.coordinates"
      @click="selectMarker"
    ></MglMarker>
    <MglMarker
      @dragend="dragend"
      v-if="addMarker"
      :coordinates="center"
      color="green"
      :draggable="true"
    ></MglMarker>
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
import MapboxGeocoder from "@mapbox/mapbox-gl-geocoder";

export default {
  components: {
    MglMap,
    MglMarker,
    MglGeolocateControl,
    MglNavigationControl,
    MglPopup
  },

  props: {
    addMarker: {
      type: String,
      value: "false"
    }
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
      zoom: 8,
      center: [0, 0],
      positionOptions: { enableHighAccuracy: true, timeout: 1000 },
      trackUserLocation: true,
      fitBoundsOptions: { maxZoom: 18 },
      popupClose: true,
      newMarker: this.addMarker,
      newMarkerPos: [0, 0],
      points: [
        {
          id: 0,
          title: "Edn",
          description: "Centre équestre",
          image: "/images/brest.jpg",
          coordinates: [-3.8770151406342848, 48.3583926165185],
          audio: "/Fichiers/Trompette.mp3"
        },
        {
          id: 1,
          title: "Super U",
          description: "Centre commercial",
          image: "/images/brest.jpg",
          coordinates: [-4.503249831105336, 48.384794966193766],
          audio: "/Fichiers/Trompette.mp3"
        },
        {
          id: 2,
          title: "Keroriou",
          description: "Quartier",
          image: "/images/brest.jpg",
          coordinates: [-4.4804386822013385, 48.39098379760787],
          audio: "/Fichiers/Trompette.mp3"
        },
        {
          id: 3,
          title: "Test loc",
          description: "Geoloc connexion",
          image: "/images/brest.jpg",
          coordinates: [2.6370463521272995, 48.84992158564938],
          audio: "/Fichiers/Trompette.mp3"
        },
        {
          id: 4,
          title: "Test loc 2",
          description: "Geoloc fixe",
          image: "/images/brest.jpg",
          coordinates: [2.3387194638617075, 48.85818100483493],
          audio: "/Fichiers/Trompette.mp3"
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
      if (this.newMarker) {
        this.center = [this.map.getCenter().lng, this.map.getCenter().lat];
        this.map.on("moveend", e => {
          this.center = [this.map.getCenter().lng, this.map.getCenter().lat];
          this.$emit("newDraggedMarker", this.center);
        });

        const geocoder = new MapboxGeocoder({
          accessToken: this.accessToken,
          language: "fr",
          countries: "fr",
          types: "place, locality, locality, address",
          mapboxgl: Mapbox
        });
        this.map.addControl(geocoder);
      }
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
        if (this.map.getBounds().contains(point.coordinates)) {
          if (
            data.mapboxEvent.coords.latitude.toFixed(4) ==
              point.coordinates[1].toFixed(4) &&
            data.mapboxEvent.coords.longitude.toFixed(4) ==
              point.coordinates[0].toFixed(4) &&
            document.querySelectorAll(".card-popup").length == 0 &&
            this.popupClose
          ) {
            let div = this.createPopupDiv(point);

            let popup = new Mapbox.Popup({
              closeOnClick: false,
              anchor: "center"
            })
              .setLngLat([
                data.mapboxEvent.coords.longitude,
                data.mapboxEvent.coords.latitude
              ])
              .setDOMContent(div)
              .addTo(this.map);

            this.popupClose = false;

            this.closePopupAtAudioEnd(popup);

            popup.on("close", () => {
              setTimeout(() => {
                this.popupClose = true;
              }, 5000);
            });
          }
        }
      }
    },

    selectMarker(e) {
      const marker = e.marker;
      const markerCoords = [marker.getLngLat().lng, marker.getLngLat().lat];

      this.map.flyTo({
        center: markerCoords
      });

      this.popupShow = true;
      this.popupCoord = markerCoords;

      for (const key in this.points) {
        if (this.points.hasOwnProperty(key)) {
          const element = this.points[key];
          if (
            element.coordinates[0] === markerCoords[0] &&
            element.coordinates[1] === markerCoords[1]
          ) {
            let div = this.createPopupDiv(element);

            let popup = new Mapbox.Popup({
              closeOnClick: false,
              anchor: "center"
            })
              .setLngLat(element.coordinates)
              .setDOMContent(div)
              .addTo(this.map);

            this.popupClose = false;

            this.closePopupAtAudioEnd(popup);

            popup.on("close", () => {
              setTimeout(() => {
                this.popupClose = true;
              }, 5000);
            });
          }
        }
      }
    },

    createPopupDiv(point) {
      let popupDiv = document.createElement("div");
      popupDiv.className = "card card-popup";
      let img = document.createElement("div");
      img.className = "card-img-head";
      img.style.backgroundImage = "url('" + point.image + "')";
      let cardBody = document.createElement("div");
      cardBody.className = "card-body";
      let cardTitle = document.createElement("h4");
      cardTitle.textContent = point.title;
      let cardText = document.createElement("p");
      cardText.textContent = point.description;
      let audioPlayer = document.createElement("audio");
      audioPlayer.src = point.audio;
      audioPlayer.setAttribute("controls", "true");
      audioPlayer.setAttribute("autoplay", "true");
      audioPlayer.className = "card-player";

      cardBody.appendChild(cardTitle);
      cardBody.appendChild(cardText);
      cardBody.appendChild(audioPlayer);
      popupDiv.appendChild(img);
      popupDiv.appendChild(cardBody);

      return popupDiv;
    },

    closePopupAtAudioEnd(popup) {
      const audioElem = popup.getElement().querySelectorAll(".card-player")[0];
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
          popup.remove();
        }, audioDuration);
      });
    },

    dragend(e) {
      const marker = e.marker;
      this.newMarkerPos = [e.marker.getLngLat().lng, e.marker.getLngLat().lat];
      this.$emit("newDraggedMarker", this.newMarkerPos);
    }
  }
};
</script>
