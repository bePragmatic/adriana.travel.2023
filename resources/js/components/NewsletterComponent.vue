<template>
  <div>
    <!-- WHITE BG NEWSLETTER ELEMENT  -->
    <transition name="fade">
      <section v-if="color == 'white' && success == false" class="newsletter">
        <h3 class="newsletter__title">
          {{ $t('messages.home.tips') }}
        </h3>

        <div :class="{ newsletter__error: isError }" class="newsletter__input ">
          <input
            v-model="email"
            type="text"
            id="input"
            v-bind:class="{ inputErrorState: isError }"
            class="input input--text input-on-focus inputError"
            placeholder="Enter your E-mail"
          />

          <transition name="fade">
            <span class="error-message" v-if="errors == error"
              >* {{ $t('messages.home.email_required') }}</span
            >
          </transition>
        </div>

        <button
          class="newsletter__button btn btn--primary btn--med"
          @click="subscribe"
        >
          {{ $t('messages.home.subscribe') }}
        </button>
      </section>
    </transition>

    <!-- GRAY BG SUBSCRIBE ELEMENT -->

    <transition name="fade">
      <section
        v-if="color == 'gray' && success == false"
        class="newsletter background__greyish"
      >
        <h3 class="newsletter__title">
          {{ $t('messages.home.tips') }}
        </h3>

        <div
          v-bind:class="{ newsletter__error: isError }"
          class="newsletter__input "
        >
          <input
            v-model="email"
            type="text"
            id="input"
            v-bind:class="{ inputErrorState: isError }"
            class="input input--text input-on-focus inputError"
            placeholder="Enter your E-mail"
          />
          <span
            v-bind:class="{ newsletter__errorHide: success }"
            class="error-message"
            v-if="errors == error"
            >*{{ $t('messages.home.email_required') }}</span
          >
        </div>

        <button
          class="newsletter__button btn btn--primary btn--med"
          @click="subscribe"
        >
          {{ $t('messages.home.subscribe') }}
        </button>
      </section>
    </transition>

    <!--SUCCESS ELEMENT -->
    <transition name="fade">
      <div v-if="success == true" class="newsletter-success__container">
        <div class="subscription-x">
          <img src="../../assets/images/Congrats.svg" />
          <h3 class="text__padding__10">
            {{ $t('messages.home.subscription') }}
          </h3>
        </div>
      </div>
    </transition>

    <!-- HOMEPAGE SUBSCRIPTION ELEMENT -->
    <transition name="fade">
      <div
        v-if="color == 'home' && success == false"
        class="wrapper newsletter  newsletter-homepage-container newsletter-additional-container-style constrain-max"
      >
        <div class="newsletter-homepage-element newsletter-flex">
          <img
            class="easier-exploration-icon--sml"
            src="../../assets/images/Drink.svg"
          />
          <h2 class="easier-exploration">
            {{ $t('messages.home.planing_a')
            }}<strong> {{ $t('messages.home.dalmatia') }}</strong>
            {{ $t('messages.home.getaway') }}
          </h2>
        </div>

        <div class="newsletter-homepage-element">
          <div class="text__box screen-to-sml--hide ">
            <p class="subscription__font">
              {{ $t('messages.home.tips') }}
            </p>
          </div>
          <p class="newsletter-txt-to-show">
            {{ $t('messages.contactus.email') }}
          </p>
          <div
            class="homepage__search__box hsb-color"
            :class="{ inputErrorState: isError, focused: focused }"
          >
            <input
              v-model="email"
              type="text"
              id="place"
              class="search__input input--text input__outline__none homepage__input-box"
              placeholder="E-mail?"
              @focus="focused = true"
              @blur="focused = false"
              :class="{ focused: focused, inputErrorState: isError }"
            />

            <button
              @click="subscribe"
              class="btn btn--primary search__button-a margin__3 homepage-subscribe__btn"
            >
              <!-- <img src="./assets/icon-magnifier.svg" alt="Magnifier" /> -->
              {{ $t('messages.home.subscribe') }}
            </button>
          </div>
          <span
            v-bind:class="{ newsletter__errorHide: success }"
            class="error-message"
            v-if="errors == error"
            >*{{ $t('messages.home.email_required') }}</span
          >
        </div>
      </div>
    </transition>
  </div>
</template>

<style>
.fade-enter-active {
  transition: opacity 1s;
}
.fade-leave-active {
  transition: opacity 0s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0;
}
</style>

<script>
export default {
  props: ['color'],
  data() {
    return {
      email: '',
      success: false,
      errors: '',
      isError: false,
      focused: false,
    };
  },

  methods: {
    subscribe() {
      axios
        .post('/newsletter/subscribe', { email: this.email })
        .then((response) => {
          this.success = true;

          window.dataLayer.push({'event': 'newsletter-signup'});

          this.email = '';
          console.log(response.data);
        })
        .catch((error) => {
          this.errors = error.email;

          console.log(error.response.data);
          this.isError = true;
        });
    },
  },

  mounted() {
    this.$i18n.locale = window.lang;
  },
};
</script>
