<template>
  <div>
    <div id="map" style="width: 50vw; height: 50vh;">
      <map-box
        v-on:newDraggedMarker="draggedMarkerCoord = $event"
        v-on:newMarkerAddress="markerAddress = $event"
        :add-marker="'{!! json_encode($newMarker) !!}'"
        :points="points_old"
      ></map-box>
    </div>
    <form
      class="col-lg-10 mx-auto"
      method="POST"
      :action="route"
      enctype="multipart/form-data"
    >
      <input type="hidden" name="_token" :value="csrf" />
      <input type="hidden" name="_method" value="PATCH" />
      <input type="hidden" name="newAudio" :value="newAudio" />
      <input type="hidden" name="newImage" :value="newImage" />

      <div class="form-group">
        <label for="coordinates">Coordonnées du point</label>
        <input
          type="text"
          class="form-control"
          name="coordinates"
          id="coordinates"
          :value="draggedMarkerCoord[0] + ' , ' + draggedMarkerCoord[1]"
          readonly
        />
      </div>
      <div class="form-group">
        <label for="address">Adresse du point</label>
        <input
          type="text"
          class="form-control"
          name="address"
          id="address"
          :value="markerAddress"
          readonly
        />
      </div>
      <div class="form-group">
        <label for="category">Catégorie</label>
        <select class="custom-select" name="category" id="category">
          <option
            v-for="(category, index) in categories"
            :key="index"
            :value="category"
            :selected="points_old[0].category == category ? true : false"
            >{{ category }}</option
          >
        </select>
      </div>
      <div class="card-deck col-lg-10 mx-auto">
        <div class="card">
          <div
            class="card-img-head"
            :style="'background-image:url(\'' + imageInput + '\');'"
          >
            <label class="file-label" for="photo"></label>
            <input
              type="file"
              name="photo"
              id="photo"
              @change="processImageFile($event)"
              accept="image/*"
              hidden
            />
          </div>
          <div class="card-body">
            <div class="form-group card-title">
              <input
                type="text"
                class="form-control"
                id="title"
                :value="points_old[0].title"
                name="title"
                required
              />
            </div>
            <div class="card-text">
              <div class="form-group">
                <textarea
                  class="form-control"
                  name="description"
                  id="description"
                  :value="points_old[0].description"
                  rows="3"
                  required
                ></textarea>
              </div>
            </div>
            <div class="form-group">
              <div class="custom-file">
                <input
                  type="file"
                  name="audio"
                  class="custom-file-input"
                  id="audioFile"
                  @change="processAudioFile($event)"
                  lang="fr"
                  accept="audio/*"
                />
                <label class="custom-file-label" for="audioFile">{{
                  audioInput
                }}</label>
              </div>
            </div>
            <button type="submit" class="btn btn-success">Valider</button>
          </div>
        </div>
      </div>
    </form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      draggedMarkerCoord: this.points_old[0].coordinates,
      markerAddress: this.points_old[0].address,
      imageInput: this.points_old[0].image,
      audioInput: this.points_old[0].audioName,
      newAudio: false,
      newImage: false,
      csrf: document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content")
    };
  },

  props: {
    route: String,
    points_old: Array,
    categories: Array
  },

  methods: {
    processImageFile(event) {
      const file = event.target.files[0];
      this.imageInput = URL.createObjectURL(file);
      this.newImage = true;
    },

    processAudioFile(event) {
      const file = event.target.files[0];
      this.audioInput = file.name;
      this.newAudio = true;
    }
  }
};
</script>
