<template>
  <div v-if="images.length" class="carousel gallery-wrapper">
    <carousel
      :items="4"
      :nav="false"
      :mouseDrag="false"
      :stagePadding="50"
      :margin="10"
      :autoplay="true"
      :responsive="{
        0: {
          items: 2,
          nav: false,
          autoWidth: true,
        },
        1000: { items: 4, nav: false },
        2500: { items: 4, nav: false },
      }"
    >
      <img
        v-for="image in images"
        v-preview:scope-a
        :src="orginalImage(image.name)"
        :alt="image.highlights"
        class="single__gallery-img"
      />
    </carousel>
  </div>
</template>

<style>
.gallery-wrapper .owl-carousel .owl-item {
  max-width: 191.5px !important;
  display: block;
  width: 100%;
}

.single__gallery-img {
  min-width: 150px;
  border: 1px solid rgba(250, 250, 250, 0.4);
  max-height: 139px;
  min-height: 139px;
}
</style>

<script>
import PhotoSwipe from 'photoswipe/dist/photoswipe';
import PhotoSwipeUI from 'photoswipe/dist/photoswipe-ui-default';
import 'photoswipe/dist/photoswipe.css';
import 'photoswipe/dist/default-skin/default-skin.css';
import createPreviewDirective from 'vue-photoswipe-directive';

import carousel from 'vue-owl-carousel';

export default {
  components: { carousel },

  props: ['images'],

  directives: {
    preview: createPreviewDirective(null, PhotoSwipe, PhotoSwipeUI),
  },

  methods: {
    orginalImage(image) {
      return image.replace('_450x250', '');
    },
  },
};
</script>
