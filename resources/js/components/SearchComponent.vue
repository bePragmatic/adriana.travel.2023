<template>
  <div class="wrapper wrapper--sml-rounded">
    <div class="accommodation">
      <aside class="accommodation__filters">
        <div>
          <div class="accommodation__tags">
            <button
              class="btn btn--filter"
              v-for="amenity in default_data.amenities"
              v-if="default_data.amenities.includes(amenity.id)"
            >
              {{ amenit.name }}
            </button>
          </div>
          <!-- Filter open/close. On click ".filter--header" should toggle class ".active" on itself and ".filter__holder". Should be incorporated with smooth js open -->
          <div
            class="filter filter--header"
            v-bind:class="[isActiveFilter ? 'active' : '']"
          >
            <h3 class="filter__title--primary" @click="toggleClass()">
              <img src="./assets/icon-filter.svg" alt="Filters" />
              {{ $t('messages.search.filters') }}
            </h3>
            <div class="filter__clear">
              <button
                class="btn btn--empty btn--med btn--no-padd"
                @click="clearFilters"
              >
                {{ $t('messages.payments.clear') }}
                {{ $t('messages.search.filters') }}
              </button>
            </div>
          </div>
          <div
            class="filter__holder "
            v-bind:class="[isActiveFilter ? 'active' : '']"
          >
            <div class="filter__clear--mobile">
              <button
                class="btn btn--empty btn--med btn--no-padd"
                @click="clearFilters"
              >
                {{ $t('messages.payments.clear') }}
                {{ $t('messages.search.filters') }}
              </button>
            </div>

            <div class="filter ">
              <h4 class="filter__title filter__title--secondary">
                <img src="./assets/icon-home.svg" alt="Accommodation type" />
                {{ $t('messages.your_trips.accommodation_type') }}
              </h4>
              <ul class="filter__list">
                <li
                  class="filter__list__item"
                  v-for="type in default_data.property_type_dropdown"
                >
                  <input
                    :id="'amenity-' + type.id"
                    type="checkbox"
                    :value="type.id"
                    class="input--check"
                    v-model.lazy="params.property_type"
                  />
                  <label :for="'amenity-' + type.id">{{
                    type.description
                  }}</label>
                </li>
              </ul>
            </div>

            <div class="filter">
              <h4 class="filter__title filter__title--secondary">
                <img src="./assets/icon-bed.svg" alt="Beds" />
                {{ $t('messages.lys.rooms_beds') }}
              </h4>

              <div class="field field--flex">
                <div class="field__text">
                  {{ $tc('messages.lys.bed', params.beds) }}
                </div>
                <counter v-model="params.beds"></counter>
              </div>

              <div class="field field--flex">
                <div class="field__text">
                  {{ $tc('messages.rooms.bedroom', params.bedrooms) }}
                </div>
                <counter v-model="params.bedrooms"></counter>
              </div>
            </div>

            <div class="filter">
              <h4 class="filter__title filter__title--secondary">
                <img src="./assets/icon-coins.svg" alt="Price range" />
                {{ $t('messages.search.price_range') }}
              </h4>
              <vue-slider
                ref="slider"
                :height="8"
                :minRange="0"
                v-model.lazy="price"
                :max="1000"
                :value="[params.min_price, params.max_price]"
                :tooltip="false"
                maxRange="1000"
                :enableCross="false"
                @change="changePrice"
              />

              <div class="filter__input-flex">
                <div class="filter__input">
                  <label for="from" class="field__lbl">
                    {{ $t('messages.profile.from') }}
                  </label>
                  <input
                    type="text"
                    defaultValue="0"
                    id="from"
                    class="input input--text"
                    placeholder="Min. price €"
                    v-model.lazy="params.min_price"
                  />
                </div>
                <div class="filter__input">
                  <label for="to" class="field__lbl">
                    {{ $t('messages.payments.to') }}
                  </label>

                  <input
                    type="text"
                    defaultValue=""
                    id="to"
                    class="input input--text"
                    placeholder="Max. price €"
                    v-model.lazy="params.max_price"
                  />
                </div>
              </div>
            </div>

            <div class="filter">
              <h4 class="filter__title filter__title--secondary">
                <img src="./assets/icon-wand.svg" alt="Amenities" />
                {{ $t('messages.lys.amenities') }}
              </h4>
              <ul class="filter__list">
                <li
                  class="filter__list__item"
                  v-for="amenity in default_data.amenities"
                  v-if="amenity.type_id == 1"
                >
                  <input
                    v-model.lazy="params.amenities"
                    :id="'amenity-' + amenity.id + 100"
                    :value="amenity.id"
                    type="checkbox"
                    class="input--check"
                  />
                  <label :for="'amenity-' + amenity.id + 100">{{
                    amenity.name
                  }}</label>
                </li>
              </ul>
            </div>

            <button
              class="btn btn--primary btn--med"
              @click="getAccommodations"
            >
              {{ $t('messages.search.apply_filters') }}
            </button>
          </div>
        </div>
      </aside>

      <section class="accommodation__list__wrapper">
        <div class="accommodation__list">
          <div class="split-view s-bottom--xlrg">
            <div class="split-view__primary t-theta t-secondary">
              {{ $t('messages.search.results') }}: {{ accommodations.length }}
            </div>

            <div
              class="split-view__secondary t-theta t-secondary accommodation__pages"
              style="padding-right: 10px;"
            >
              <span class="accommodation__pages__label s-right--sml">
                {{ $t('messages.inbox.price') }}
              </span>
              <select
                name="order"
                defaultValue="10"
                class="input input--select input--select--gray accommodation__pages__select"
                @change="changeOrder($event)"
              >
                <option value="asc">
                  {{ $t('messages.payments.lowest') }}</option
                >
                <option value="desc">{{
                  $t('messages.payments.highest')
                }}</option>
              </select>
            </div>

            <div
              class="split-view__secondary t-theta t-secondary accommodation__pages"
            >
              <span class="accommodation__pages__label s-right--sml">
                {{ $t('messages.payments.per_page') }}
              </span>
              <select
                name="per_page"
                defaultValue="20"
                class="input input--select input--select--gray accommodation__pages__select"
                @change="changePerPage($event)"
              >
                <option value="20">20</option>
                <option value="40">50</option>
                <option value="100">100</option>
              </select>
            </div>
          </div>
          <transition name="fade">
            <ul class="d-item__wrapper" v-show="accommodations">
              <div class="loader__container" v-show="loading">
                <scale-loader
                  class="loader"
                  :loading="loading"
                  :height="80"
                  :width="10"
                  :radius="10"
                  :color="'#009FDA'"
                >
                </scale-loader>
              </div>

              <li
                class="d-item"
                v-for="accommodation in orderedAccommodations"
                v-show="!loading"
              >
                <div class="d-item__image">
                  <a :href="accommodation.link" target="_blank">
                    <img
                      :src="accommodation.original_image"
                      :alt="accommodation.name"
                    />
                  </a>
                </div>
                <div class="d-item__content">
                  <div class="split-view">
                    <h2 class="d-item__name split-view__primary">
                      <a
                        :href="
                          accommodation.link +
                            '?checkin=' +
                            params.checkin +
                            '&checkout=' +
                            params.checkout +
                            ' &guests=' +
                            params.guest
                        "
                        class="d-item__link"
                        target="_blank"
                      >
                        {{ accommodation.name }} | {{ accommodation.sub_name }}
                      </a>
                    </h2>
                    <div
                      v-if="accommodation.reviews_count"
                      class="d-item__rating split-view__secondary"
                    >
                      <img src="./assets/icon-star.svg" alt="Rating" />
                      {{
                        Number(
                          accommodation.overall_star_rating.rating_value
                        ).toFixed(1)
                      }}
                      ({{ accommodation.reviews_count }})
                    </div>

                    <div class="d-item__rating split-view__secondary" v-else>
                      0 (0)
                      <!--                                            {{ $t('messages.rooms.no_reviews_yet')}}-->
                    </div>
                  </div>
                  <p class="d-item__description">
                    {{ accommodation.summary }}
                  </p>

                  <p class="d-item__info">
                    <span class="d-item__price"> </span>

                    <span
                      v-if="params.guest > 1 && params.guest"
                      class="d-item__price"
                    >
                      {{
                        (accommodation.rooms_price.night +
                          accommodation.rooms_price.additional_guest *
                            (params.guest - accommodation.rooms_price.guests))
                          | money
                      }}
                    </span>

                    <span
                      v-if="
                        params.guest == 1 ||
                          params.guest <= accommodation.rooms_price.guests
                      "
                      class="d-item__price"
                    >
                      {{ accommodation.rooms_price.night | money }}
                    </span>
                    / {{ $t('messages.rooms.per_night') }}

                    <span v-if="accommodation.booking_type == 'instant_book'">
                      <!--                                         {{ accommodation.rooms_price.currency.symbol }}-->
                    </span>
                    &middot;
                    <span class="d-item__beds"
                      >{{ accommodation.beds }}
                      {{ $tc('messages.lys.bed', accommodation.beds) }}</span
                    >
                  </p>
                  <p
                    class="d-item__info font-size--14"
                    v-show="accommodation.rooms_price.total"
                  >
                    {{ accommodation.rooms_price.total | money }}
                    {{ $tc('messages.rooms.total') }}
                    {{ $tc('messages.inbox.price') }}
                    <!--                 {{ $tc('messages.email.for')}}
                                                                             {{ accommodation.normal_nights + accommodation.normal_weekends }}
                                                                             {{ $tc('messages.reviews.day', accommodation.normal_nights + accommodation.normal_weekends )}}-->
                  </p>
                </div>
              </li>
            </ul>
          </transition>

          <transition name="fade">
            <div
              class="d-item__wrapper emptystate-message-container"
              v-if="accommodations == '' && !loading"
            >
              <div><img src="./assets/diving.svg" /></div>
              <div class="emptysate-message-element">
                <h2>{{ $t('messages.search.no_results_found') }}</h2>
              </div>
              <div class="emptysate-message-sub-element">
                <p>Let’s remove some filters so we can dive in deeper!</p>
              </div>
            </div>
          </transition>
        </div>
        <div class="pagination accommodation__pagination">
          <pagination :pagination="data"></pagination>
        </div>
      </section>
    </div>
  </div>
</template>

<script>
// var moment = require('moment');
// import 'vue-range-component/dist/vue-range-slider.css'
// import VueRangeSlider from 'vue-range-component'

import VueSlider from 'vue-slider-component';
import 'vue-slider-component/theme/default.css';
import { BarLoader } from '@saeris/vue-spinners';

var _ = require('lodash');
export default {
  created() {
    this.params.checkin = this.default_data.checkin;
    this.params.checkout = this.default_data.checkout;
    this.params.location = this.default_data.location;

    // Event.$on('change', data => this.changePrice(data))
    Event.$on('paginate', (data) => this.changePage(data));
    Event.$on('per-page', (data) => this.changePerPage(data));

    this.getAccommodations();

    this.lang = window.lang;
    this.$i18n.locale = window.lang;
  },

  props: ['default_data', 'guest'],

  components: {
    BarLoader,
    VueSlider,
  },

  data() {
    return {
      lang: 'en',
      order: 'asc',
      loading: false,
      isActiveFilter: false,
      accommodations: '',
      data: [],
      price: [10, 1000],
      params: {
        location: '',
        min_price: '',
        max_price: '',
        amenities: [],
        property_type: [],
        room_type: [],
        beds: 0,
        bathrooms: '',
        bedrooms: '',
        checkin: '',
        checkout: '',
        guest: this.guest,
        map_details: '',
        instant_book: '',
        page: '1',
        per_page: '20',
        php_date_format: 'd/m/Y',
      },
    };
  },

  /*  watch: {
            params: {
                handler: function () {
                    this.getAccommodations();
                },
                deep: true,
            },
        },*/

  filters: {
    money: function(value) {
      if (!value) return '';
      return new Intl.NumberFormat('de-DE', {
        style: 'currency',
        currency: 'EUR',
      }).format(value);
    },
  },

  computed: {
    highestBid() {
      if (this.accommodations.length == 0) return;
      return this.accommodations.reduce((a, b) =>
        Number(a.avg_price) > Number(b.avg_price) ? a : b
      );
    },

    orderedAccommodations() {
      return _.orderBy(this.accommodations, 'popup_price', this.order);
    },
  },

  methods: {
    getAccommodations() {
      if (!this.loading) {
        this.accommodations = false;
        this.loading = true;

        axios.get('/searchResult', { params: this.params }).then((response) => {
          this.data = response.data;
          this.accommodations = response.data.data;
          this.loading = false;
        });
      }
    },

    changePage(data) {
      this.params.page = data;
      this.getAccommodations();

    },

    changePerPage(event) {
      this.params.page = 1;
      this.params.per_page = event.target.value;
      this.getAccommodations();
    },

    changeOrder(event) {
      this.order = event.target.value;
    },

    toggleClass() {
      this.isActiveFilter = !this.isActiveFilter;
    },

    changePrice() {
      this.params.min_price = this.price[0];
      this.params.max_price = this.price[1];
    },

    setPrice(event) {
      this.params.min_price = event.currentValue[0];
      this.params.max_price = event.currentValue[1];
    },

    clearFilters() {
      location.reload();
    },
  },
};
</script>

<style>
.vue-slider-dot-handle {
  position: absolute;
  width: 16px;
  height: 16px;
  background-color: #009fda !important;
  border-radius: 20px;
  cursor: pointer;
  transition: all 0.15s ease-in-out;
}

.loader__container {
  padding-top: 150px;
  padding-bottom: 150px;
  display: flex;
  justify-content: center;
  align-items: center;
}

.vue-slider-process {
  background-color: #384f66;
}

.fade-enter-active,
.fade-leave-active {
  transition: opacity 1.5s;
}

.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */
 {
  opacity: 0;
}

.font-size--14 {
  font-size: 14px;
}
</style>
