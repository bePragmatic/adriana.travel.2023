/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

//require('./bootstrap');
/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';


window.Vue = require('vue');

window.Event = new Vue();

import VueI18n from 'vue-i18n'


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
import { DateTime } from "luxon";

//import modal from 'vue-js-modal';
//Vue.use(modal, {dialog: true, dynamic: true});


import { VueSpinners } from '@saeris/vue-spinners'
Vue.use(VueSpinners)

import Sticky from 'vue-sticky-directive'
Vue.use(Sticky)

import moment from "moment";


import * as VueGoogleMaps from 'vue2-google-maps'

Vue.use(VueGoogleMaps, {
    load: {
        key: 'AIzaSyD6jss73ZXqaDZHX4j8YtqtQq--7ERdIiA',
        libraries: 'places' // This is required if you use the Autocomplete plugin
        // OR: libraries: 'places,drawing'
        // OR: libraries: 'places,drawing,visualization'
        // (as you require)

        //// If you want to set the version, you can do so:
        // v: '3.26',
    },

    //// If you intend to programmatically custom event listener code
    //// (e.g. `this.$refs.gmap.$on('zoom_changed', someFunc)`)
    //// instead of going through Vue templates (e.g. `<GmapMap @zoom_changed="someFunc">`)
    //// you might need to turn this on.
    // autobindAllEvents: false,

    //// If you want to manually install components, e.g.
    //// import {GmapMarker} from 'vue2-google-maps/src/components/marker'
    //// Vue.component('GmapMarker', GmapMarker)
    //// then set installComponents to 'false'.
    //// If you want to automatically install all the components this property must be set to 'true':
    installComponents: true
})

import VueCarousel from 'vue-carousel';

Vue.use(VueCarousel);
import 'vue-foldable/dist/vue-foldable.css'

import accounting from 'accounting-js';

accounting.settings = {
    thousand: '',
    decimal: ',', // decimal point separator
}
Object.defineProperty(Vue.prototype, '$accounting', { value: accounting });


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

//import modal from 'vue-js-modal';
//Vue.use(modal, {dialog: true, dynamic: true});




// import {carousel} from 'vue-owl-carousel'
// Vue.use(carousel)


Vue.component('star-rating', require('vue-star-rating').default);

Vue.component('daterange', require('vue-hotel-datepicker').default);
Vue.component('cookie-law', require('vue-cookie-law').default);


//Vue.component('event-modal', require('./components/EventModal.vue').default);
//Vue.component('calendar', require('./components/Calendar.vue').default);

Vue.component('counter', require('./components/CounterComponent.vue').default);
Vue.component('header-search', require('./components/HeaderSearchComponent.vue').default);
Vue.component('search', require('./components/SearchComponent.vue').default);
Vue.component('pagination', require('./components/PaginationComponnent.vue').default);
Vue.component('hamburger', require('./components/HamburgerComponent.vue').default);
Vue.component('gallery', require('./components/GalleryComponent.vue').default);
Vue.component('price-calculator', require('./components/PriceCalculatorComponent.vue').default);
Vue.component('boat-calculator', require('./components/BoatCalculatorComponent.vue').default);
Vue.component('language-switcher', require('./components/LanguageSwitcherComponent.vue').default);
Vue.component('language-switcher-mobile', require('./components/LanguageSwitcherComponentMobile.vue').default);

Vue.component('currency-switcher', require('./components/CurrencySwitcherComponent.vue').default);
Vue.component('accommodation-map', require('./components/AccomodationMapComponent.vue').default);

Vue.component('newsletter', require('./components/NewsletterComponent.vue').default);

Vue.component('pts-carousel', require('./components/PlacesToStayCarousel.vue').default);
Vue.component('wts-desktop', require('./components/WhereToStayDesktop.vue').default);
Vue.component('wts-carousel', require('./components/WhereToStayCarousel.vue').default);
Vue.component('blog-carousel', require('./components/BlogCarousel.vue').default);
Vue.component('sac-carousel', require('./components/SingleAccommodationCarousel.vue').default);
Vue.component('book-now-modal', require('./components/BookNowButton.vue').default);
Vue.component('edit-post', require('./components/admin/EditPostComponent.vue').default);
Vue.component('image-upload', require('./components/admin/ImageUpload.vue').default);
Vue.component('room-subname-edit', require('./components/admin/RoomSubnameEdit.vue').default);
Vue.component('ws-pay', require('./components/WSPay.vue').default);

Vue.component('checkout', require('./components/CheckoutComponent.vue').default);
Vue.component('foldable', require('vue-foldable').default);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import Locale from './vue-i18n-locales.generated';


// Ready translated locale messages
//import messages from './lang/messages'

// Create VueI18n instance with options

const i18n = new VueI18n({
    locale: 'en', // set locale
    messages: Locale,
})


const app = new Vue({
    i18n
}).$mount('#app')

//i18n.locale  = 'de'

