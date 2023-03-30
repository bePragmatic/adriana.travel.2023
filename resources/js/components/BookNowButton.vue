<template>
  <div :class="screen == 'desktop' ? 'asideMediaDesktop' : 'asideMediaMobile'">
    <div>
      <button
        class="btn btn--primary custom-button--sticky"
        id="show-modal"
        @click="showModal = true"
      >
        {{ $t('messages.inbox.book_now') }}
      </button>
    </div>
    <modal v-if="showModal == true">
      <div class="modal-mask">
        <div class="search__popover--guests active">
          <div
            class="search__popover__close nav__close"
            @click="savePost()"
          ></div>

          <slot></slot>
        </div>
      </div>
    </modal>
  </div>
</template>

<script>
export default {
  props: ['screen'],
  data() {
    return {
      showModal: false,
    };
  },
  methods: {
    savePost: function() {
      // Some save logic goes here...
      this.showModal = false;
      //   this.$emit('close');
    },
  },

  mounted() {
    console.log('Component mounted.');
  },
};
</script>

<style scoped>
.modal-mask {
  position: fixed;
  z-index: 9998;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  transition: opacity 0.3s ease;
}

.modal-container {
  margin: 40px auto 0;
  padding: 20px 30px 30px 30px;
  background-color: #fff;
  border-radius: 2px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.33);
  animation-name: fadeInModal;
  animation-duration: 1s;
  position: relative;
  border-radius: 24px;
}

@keyframes fadeInModal {
  from {
    opacity: 0;
  }
  to {
    opacity: 1;
  }
}

.x--exit-modal {
  color: #b2c8d4;
  font-weight: bold;
  font-size: 22px;
  line-height: 20px;
  cursor: pointer;
  transition: 0.3s;
  position: absolute;
  right: 20px;
  top: 15px;
}

.x--exit-modal:focus {
  color: #10304c;
}

.modal__btn-container {
  display: flex;
  justify-content: space-around;
}

.modal-header h3 {
  margin-top: 0;
  color: #42b983;
}

.modal-body {
  margin: 20px 0;
}

.text-right {
  text-align: right;
}

.form-label {
  display: block;
  margin-bottom: 1em;
}

.form-label > .form-control {
  margin-top: 0.5em;
}

.form-control {
  display: block;
  width: 100%;
  padding: 0.5em 1em;
  line-height: 1.5;
  border: 1px solid #ddd;
}

/*
 * The following styles are auto-applied to elements with
 * transition="modal" when their visibility is toggled
 * by Vue.js.
 *
 * You can easily play with the modal transition by editing
 * these styles.
 */

.modal-enter {
  opacity: 0;
}

.modal-leave-active {
  opacity: 0;
}

.modal-enter .modal-container,
.modal-leave-active .modal-container {
  -webkit-transform: scale(1.1);
  transform: scale(1.1);
}
</style>

<!-- 








<template>
  <div :class="screen == 'desktop' ? 'asideMediaDesktop' : 'asideMediaMobile'">
    <div>
      <button
        class="btn btn--primary custom-button--sticky"
        id="show-modal"
        @click="showModal = true"
      >
        Book Now
      </button>
    </div>
    <modal v-if="showModal == true">
      <div class="modal-mask">
        <div class="modal-container modal-container__width">
          <div class="x--exit-modal" @click="savePost()">&times;</div>

          <slot></slot>
        </div>
      </div>
    </modal>
  </div>
</template>

<script>
export default {
  props: ['screen'],
  data() {
    return {
      showModal: false,
    };
  },
  methods: {
    savePost: function() {
      // Some save logic goes here...
      this.showModal = false;
      //   this.$emit('close');
    },
  },

  mounted() {
    console.log('Component mounted.');
  },
};
</script>

<style scoped>
.modal-mask {
  position: fixed;
  z-index: 9998;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  transition: opacity 0.3s ease;
}

.modal-container {
  margin: 40px auto 0;
  padding: 20px 30px 30px 30px;
  background-color: #fff;
  border-radius: 2px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.33);
  animation-name: fadeInModal;
  animation-duration: 1s;
  position: relative;
  border-radius: 24px;
}

@keyframes fadeInModal {
  from {
    opacity: 0;
  }
  to {
    opacity: 1;
  }
}

.x--exit-modal {
  color: #b2c8d4;
  font-weight: bold;
  font-size: 22px;
  line-height: 20px;
  cursor: pointer;
  transition: 0.3s;
  position: absolute;
  right: 20px;
  top: 15px;
}

.x--exit-modal:focus {
  color: #10304c;
}

.modal__btn-container {
  display: flex;
  justify-content: space-around;
}

.modal-header h3 {
  margin-top: 0;
  color: #42b983;
}

.modal-body {
  margin: 20px 0;
}

.text-right {
  text-align: right;
}

.form-label {
  display: block;
  margin-bottom: 1em;
}

.form-label > .form-control {
  margin-top: 0.5em;
}

.form-control {
  display: block;
  width: 100%;
  padding: 0.5em 1em;
  line-height: 1.5;
  border: 1px solid #ddd;
}

/*
 * The following styles are auto-applied to elements with
 * transition="modal" when their visibility is toggled
 * by Vue.js.
 *
 * You can easily play with the modal transition by editing
 * these styles.
 */

.modal-enter {
  opacity: 0;
}

.modal-leave-active {
  opacity: 0;
}

.modal-enter .modal-container,
.modal-leave-active .modal-container {
  -webkit-transform: scale(1.1);
  transform: scale(1.1);
}
</style> -->
