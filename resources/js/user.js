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

window.normalizeUrl = require('normalize-url');

window.Vue = require('vue');

window.Event = new Vue();

import VueI18n from 'vue-i18n'

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
import { DateTime } from "luxon";

//import modal from 'vue-js-modal';
//Vue.use(modal, {dialog: true, dynamic: true});



import moment from "moment";


// import {carousel} from 'vue-owl-carousel'
// Vue.use(carousel)

Vue.component('ws-pay', require('./components/WSPay.vue').default);
//Vue.component('event-modal', require('./components/EventModal.vue').default);
Vue.component('checkout', require('./components/CheckoutComponent.vue').default);
//Vue.component('calendar', require('./components/Calendar.vue').default);



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
    messages: Locale
})


const app = new Vue({
    i18n
}).$mount('#app')

//i18n.locale  = 'en'

