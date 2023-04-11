<template>
  <!-- desktop -->
  <div class="nav__mobile-lang">
    <a
      @click.prevent="changeLanguage('hr')"
      v-bind:class="[defualt == 'hr' ? 'active' : '']"
      >HR</a
    >
    <a
      @click.prevent="changeLanguage('de')"
      v-bind:class="[defualt == 'de' ? 'active' : '']"
      >DE</a
    >
    
      <a
      class=""
      @click.prevent="changeLanguage('en')"
      v-bind:class="[defualt == 'en' ? 'active' : '']"
    >
      ENG
    </a>
     
  </div>
</template>

<script>
export default {
  props: ['defualt'],
  mounted(){
    
  },
  methods: {
    changeLanguage(lang) {
      axios.post('/set_session', { language: lang }).then((response)=>
      {
       location.reload();
      }).catch((error)=>{
        console.log("error",error)
      });
    },
  },
};
</script>

<style scoped></style>
