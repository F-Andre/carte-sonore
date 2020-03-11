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
          title: "Edn",
          description: "Centre équestre",
          image: "./images/brest.jpg",
          coordinates: [-3.8770151406342848, 48.3583926165185],
          audio: "./Fichiers/Trompette.mp3"
        },
        {
          title: "Super U",
          description: "Centre commercial",
          image: "./images/brest.jpg",
          coordinates: [-4.503249831105336, 48.384794966193766],
          audio: "./Fichiers/Trompette.mp3"
        },
        {
          title: "Keroriou",
          description: "Quartier",
          image: "./images/brest.jpg",
          coordinates: [-4.4804386822013385, 48.39098379760787],
          audio: "./Fichiers/Trompette.mp3"
        },
        {
          title: "Test loc",
          description: "Geoloc connexion",
          image: "./images/brest.jpg",
          coordinates: [2.6370463521272995, 48.84992158564938],
          audio: "./Fichiers/Trompette.mp3"
        }
      ]
    };
  },

  created() {
    this.map = null;
    this.popup = null;
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

      for (const point of this.points) {
        const cardPopup = this.createPopupDiv(point);

        const popup = new Mapbox.Popup({
          closeOnClick: false,
          anchor: "center"
        }).setDOMContent(cardPopup);

        const marker = new Mapbox.Marker()
          .setLngLat(point.coordinates)
          .setPopup(popup)
          .addTo(this.map);
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
            .setMaxWidth("80vw")
            .setDOMContent(div)
            .addTo(this.map);

          this.popupClose = false;

          popup.on("close", () => {
            setTimeout(() => {
              this.popupClose = true;
            }, 5000);
          });
        }
      }
    },

    createPopupDiv(point) {
      let popupDiv = document.createElement("div");
      popupDiv.className = "card card-popup";
      popupDiv.style = "width: 18rem;";
      let img = document.createElement("img");
      img.className = "card-img-top";
      img.setAttribute("src", point.image);
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
    }
  }
};
</script>
