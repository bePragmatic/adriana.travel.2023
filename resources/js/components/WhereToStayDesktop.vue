<template>
  <div>
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
        0: { items: 1, nav: false, margin: 30, stagePadding: 15 },
        700: { items: 2, nav: false, margin: 50, stagePadding: 20 },
        2500: { items: 2, nav: false },
      }"
    >
      <slot></slot>
    </carousel>
  </div>
</template>

<script>
import carousel from 'vue-owl-carousel';
export default {
  components: {
    carousel,
  },
};
</script>
