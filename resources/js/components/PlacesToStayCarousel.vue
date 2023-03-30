<template>
  <div class="pts-wrapper">
    <!-- ssss -->
    <carousel
      :items="1"
      :nav="false"
      :dots="false"
      :mouseDrag="true"
      :stagePadding="5"
      :margin="30"
      :autoplay="true"
      :autoplayHoverPause="true"
      :loop="true"
      :autoWidth="true"
      :responsive="{
        0: { items: 1.5, nav: false, margin: 30, stagePadding: 15 },
        700: { items: 3, nav: false, margin: 52, stagePadding: 20 },
        2500: { items: 3, nav: false },
      }"
    >
      <slot></slot>
    </carousel>

    <!-- ssss -->
  </div>
</template>

<style>
.pts-wrapper .owl-carousel .owl-item {
  max-width: 273px !important;
  margin-bottom: 50px;
}
</style>

<script>
import carousel from 'vue-owl-carousel';

export default {
  components: { carousel },
  mounted() {
    console.log('Component mounted.');
  },
};
</script>
