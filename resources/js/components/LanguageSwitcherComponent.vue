<template>
  <!-- desktop -->

  <div class="nav__lang-select desk">
    <div class="nav__lang">{{ defualt.toUpperCase() }}</div>
    <ul class="nav__lang-popover">
        
      <li>
        <a
          @click.prevent="changeLanguage('de')"
          v-bind:class="[defualt == 'de' ? 'active' : '']"
        >
          Deutsch
        </a>
      </li>
      <li>
        <a
          @click.prevent="changeLanguage('hr')"
          v-bind:class="[defualt == 'hr' ? 'active' : '']"
        >
          Hrvatski
        </a>
      </li>
    <li>
        <a
          class=""
          @click.prevent="changeLanguage('en')"
          v-bind:class="[defualt == 'en' ? 'active' : '']"
        >
          English
        </a>
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  mounted(){
  },

  props: ['defualt'],
  methods: {
    changeLanguage(lang) {
      axios.post('/set_session', { language: lang }).then((response)=>{
      location.reload();
      }).catch((error)=>{
          console.log("error");
      });
    },
  },
};
</script>

<style scoped></style>
