<template>
    <GmapMap
            :center="center"
            :zoom="15"
            map-type-id="roadmap"
            style="width: 100%; height: 500px">
        <GmapCircle
                :center="center"
                :radius="300"
                :visible="true"
                :options="{fillColor:'#009FDA',  strokeColor: '#009FDA', fillOpacity:0.35}"
               >
        </GmapCircle>
      <!--  <GmapMarker
                    :key="1"
                    :position="center"
        />-->
    </GmapMap>
</template>

<script>
    export default {

        props: ['location'],

        created(){

            this.center.lat = parseFloat(this.location.latitude),
            this.center.lng = parseFloat(this.location.longitude)
        },

        data() {
            return {
                center: {

                    lat: {type: Number},
                    lng:  {type: Number}
                }
            }
        }

    }
</script>

<style scoped>

</style>
