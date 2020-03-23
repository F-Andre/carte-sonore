<template>
  <div>
    <div id="map" style="width: 50vw; height: 50vh;">
      <map-box
        v-on:newDraggedMarker="draggedMarkerCoord = $event"
        :add-marker="'{!! json_encode($newMarker) !!}'"
      ></map-box>
    </div>
    <form class="col-lg-10 mx-auto" method="POST" :action="route" enctype="multipart/form-data">
      <input type="hidden" name="_token" :value="csrf" />
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
      <div class="card-deck col-lg-10 mx-auto">
        <div class="card">
          <div class="card-img-head" :style="'background-image:url(\'' + imageInput + '\');'">
            <label class="file-label" for="image"></label>
            <input
              type="file"
              name="image"
              id="image"
              @change="processImageFile($event)"
              accept="image/*"
              hidden
              required
            />
          </div>
          <div class="card-body">
            <div class="form-group card-title">
              <input
                type="text"
                class="form-control"
                id="title"
                placeholder="Titre"
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
                  placeholder="Description"
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
                  required
                />
                <label class="custom-file-label" for="audioFile">{{ audioInput }}</label>
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
      draggedMarkerCoord: [0, 0],
      imageInput: "/images/image.webp",
      audioInput: "Fichier audio",
      csrf: document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content")
    };
  },

  props: ["route"],

  methods: {
    processImageFile(event) {
      const file = event.target.files[0];
      this.imageInput = URL.createObjectURL(file);
    },

    processAudioFile(event) {
      const file = event.target.files[0];
      this.audioInput = file.name;
    }
  }
};
</script>