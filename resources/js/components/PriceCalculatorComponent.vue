<template>
  <aside
          class="accommodation__filters padding__top__1"
          :class="screen == 'desktop' ? 'asideMediaDesktop' : 'asideMediaMobile'"
  >
    <div sticky-offset="{top: 30, bottom: 20}">
      <!-- Filter open/close. On click ".filter--header" should toggle class ".active" on itself and ".filter__holder". Should be incorporated with smooth js open -->
      <div class="filter filterB">
        <div class="homepage__row__container">
          <div>
            <h3 class="filter__title--primary t-bold">
              {{ price.rooms_price | money }}
            </h3>
          </div>
          <div>
            <p class="t-zeta">
              &nbsp;
              <small>/&nbsp; {{ $t('messages.rooms.per_night') }}</small>
            </p>
          </div>
        </div>

        <div class="grade__group">
          <!--  TODO: rjesit rating

                    /** @if($result->overall_star_rating)
                            <a href="#reviews" class="review_link">
                                <div class="star-rating-wrapper d-flex align-items-center">
                                    {!! $result->overall_star_rating !!}
                                    <span class="ml-2">({{ $result->reviews->count() }})</span>
                                </div>
                            </a>
                        @endifv
                        -->
          <p v-if="result.reviews_count">
            <img src="/assets/icon-star.svg" style="padding-bottom: 5px" />
            {{ Number(result.overall_star_rating.rating_value).toFixed(1) }} ({{
            result.reviews_count
            }})
          </p>
        </div>
      </div>

      <div class="filter filter__holder">
        <h4 class="filter__title filter__title--secondary margin-bottom--7">
          {{ $tc('messages.home.guest', params.guest_count) }}
        </h4>

        <div class="field field--flex">
          <div class="field__text">
            {{ $tc('messages.home.guest', params.guest_count) }}
          </div>
          <div class="counter field__content">
            <div class="counter">
              <counter v-model="params.guest_count"></counter>
            </div>
          </div>
        </div>
      </div>

      <div class="filter">
        <h4 class="filter__title filter__title--secondary margin-bottom--7">
          {{ $t('messages.lys.select_dates') }}
        </h4>

        <div
                class="search__input-holder search__input-holder--date"
                style="border-right: none !important"
        >
          <!-- ".search__input--date" should have ".entered" class when user enters vlaue for guests -->
          <div class="search__input--date entered">
            <!-- 24. Jun — 18. Jun -->
            <daterange
                    :id="'test'"
                    :displayClearButton="false"
                    format="DD.MM.YYYY"
                    @check-in-changed="setCheckIn"
                    @check-out-changed="setCheckOut"
                    :disabledDates="calendar.not_avilable"
                    :startingDateValue="startDate"
                    :minNights="result.rooms_price.minimum_stay"
                    :maxNights="result.rooms_price.maximum_stay"
                    :endingDateValue="endDate"
                    defaultPrice="123"
                    v-if="calendar"
            />
          </div>
        </div>
      </div>

      <div class="" v-if="!loading && params.checkout && params.checkin">
        <transition name="fade">
          <form
                  ref="book_it_form"
                  accept-charset="UTF-8"
                  :action="'/payments/book/' + params.room_id"
                  id="book_it_form"
                  method="post"
          >
            <input type="hidden" name="_token" :value="token" />

            <input type="hidden" name="checkin" :value="params.checkin" />
            <input type="hidden" name="checkout" :value="params.checkout" />
            <input
                    type="hidden"
                    name="booking_type"
                    :value="result.booking_type"
            />
            <input
                    type="hidden"
                    name="cancellation"
                    :value="result.cancel_policy"
            />
            <input
                    type="hidden"
                    name="number_of_guests"
                    :value="params.guest_count"
            />
            <input
                    type="hidden"
                    name="instant_book"
                    :value="result.booking_type"
            />
            <input type="hidden" name="hosting_id" :value="params.room_id" />
            <input
                    type="hidden"
                    name="room_types"
                    :value="result.room_type_name"
            />
            <!-- HTML ZA INSTANT BOOK  -->
            <div class="filter">
              <ul class="list__props  color_000 o-80 padding__bottom__custom">
                <li>
                  <div class="homepage__row__container space__between">
                    <p class="t-theta">
                      {{ price.base_rooms_price | money }} x
                      {{ price.total_nights }} nights
                    </p>
                    <p class="t-theta t-bold">
                      {{ price.total_night_price | money }}
                    </p>
                  </div>
                </li>

                <!--early_bird booking_period-->
                <li v-if="price.booked_period_type == 'early_bird'">
                  <div class="homepage__row__container space__between">
                    <p class="t-theta  red__class">
                      {{ price.booked_period_discount }}%
                      {{ $t('messages.rooms.early_bird_price_discount') }}
                    </p>
                    <p class="t-theta t-bold  red__class">
                      - {{ price.booked_period_discount_price | money }}
                    </p>
                  </div>
                </li>

                <!-- last_min -->
                <li v-if="price.booked_period_type == 'last_min'">
                  <div class="homepage__row__container space__between">
                    <p class="t-theta red__class">
                      {{ price.booked_period_discount }}%
                      {{ $t('messages.rooms.last_min_price_discount') }}
                    </p>
                    <p class="t-theta t-bold red__class">
                      - {{ price.booked_period_discount_price | money }}
                    </p>
                  </div>
                </li>

                <!-- weekly_discount -->
                <li v-if="price.length_of_stay_type == 'weekly'">
                  <div class="homepage__row__container space__between">
                    <p class="t-theta">
                      {{ price.length_of_stay_discount }}%
                      {{ $t('messages.rooms.weekly_price_discount') }}
                    </p>
                    <p class="t-theta t-bold">
                      - {{ price.length_of_stay_discount_price | money }}
                    </p>
                  </div>
                </li>

                <!-- monthly_discount -->
                <li v-if="price.length_of_stay_type == 'monthly'">
                  <div class="homepage__row__container space__between">
                    <p class="t-theta">
                      {{ price.length_of_stay_discount }}%
                      {{ $t('messages.rooms.monthly_price_discount') }}
                    </p>
                    <p class="t-theta t-bold">
                      - {{ price.length_of_stay_discount_price | money }}
                    </p>
                  </div>
                </li>

                <!-- long_term -->
                <li v-if="price.length_of_stay_type == 'long_term'">
                  <div class="homepage__row__container space__between">
                    <p class="t-theta">
                      {{ price.length_of_stay_discount }}%
                      {{ $t('messages.rooms.long_term_price_discount') }}
                    </p>
                    <p class="t-theta t-bold">
                      - {{ price.length_of_stay_discount_price | money }}
                    </p>
                  </div>
                </li>

                <li v-if="price.service_fee">
                  <div class="homepage__row__container space__between">
                    <p class="t-theta">
                      {{ $t('messages.rooms.service_fee') }}
                    </p>
                    <p class="t-theta t-bold">
                      {{ price.service_fee | money }}
                    </p>
                  </div>
                </li>
                <li v-if="price.additional_guest">
                  <div class="homepage__row__container space__between">
                    <p class="t-theta">
                      {{ $t('messages.rooms.addtional_guest_fee') }}
                    </p>
                    <p class="t-theta t-bold">
                      {{ price.additional_guest | money }}
                    </p>
                  </div>
                </li>
                <li v-if="price.cleaning_fee">
                  <div class="homepage__row__container space__between">
                    <p class="t-theta">
                      {{ $t('messages.rooms.cleaning_fee') }}
                    </p>
                    <p class="t-theta t-bold">
                      {{ price.cleaning_fee | money }}
                    </p>
                  </div>
                </li>
              </ul>

              <div
                      class="t-zeta t-bold homepage__row__container space__between o-80 padding__top__xs"
              >
                <p>{{ $t('messages.rooms.total') }}</p>
                <p>{{ price.total | money }}</p>
              </div>
            </div>

            <div
                    class="homepage__row__container"
                    :class="
                screen == 'desktop' ? 'flex__end__img' : 'btn-justify-center'
              "
            >
              <button class="btn btn--primary btn--med" @click.prevent="submit()">
                {{ $t('messages.rooms.request_to_book') }}
              </button>

            </div>
          </form>
        </transition>
      </div>

      <div v-if="!loading && !params.checkout && !params.checkin">
        <h4 class="t-center t-epsilon">
          {{ $t('messages.search.enter_dates') }}
        </h4>
      </div>

      <div v-if="loading" sticky-offset="{top: 30, bottom: 20}">
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
      </div>
    </div>
  </aside>
</template>

<script>
  import moment from 'moment';

  export default {
    props: [
      'result',
      'formatted_checkin',
      'formatted_checkout',
      'checkin',
      'checkout',
      'guests',
      'token',
      'screen',
    ],

    created() {

      if (this.guests == 0)
        this.params.guest_count = 1


      this.$i18n.locale = window.lang;
      this.getPrice();
      this.getCalendar();
    },

    watch: {
      params: {
        handler: function() {
          this.getPrice();
          this.getCalendar();
          this.checkGuestNum();
        },
        deep: true,
      },
    },

    data() {
      return {
        calendar: '',
        price: '',
        loading: true,
        params: {
          room_id: this.result.id,
          guest_count: this.guests,
          checkin: this.formatted_checkin,
          checkout: this.formatted_checkout,
        },
      };
    },

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
      startDate() {
        return this.checkin ? moment(this.checkin).toDate() : null; //new Date(new Date().getFullYear(), new Date().getMonth(), 1),
      },
      endDate() {
        return this.checkout ? moment(this.checkout).toDate() : null; //ne
      },
    },

    methods: {

      submit(){


        window.dataLayer.push({
          'event': 'room-single',
          'room': this.result.id ,
          'guests': this.params.guest_count,
          'checkIn': this.params.checkin ,
          'checkOut': this.params.checkout ,
          'price': this.price.total,
        })
        this.$refs.book_it_form.submit()
      },

      getPrice() {
        this.loading = true;

        axios.post('/rooms/price_calculation', this.params).then((response) => {
          this.price = response.data;
          this.data = response.data;
        });
      },

      checkGuestNum(){
        // if (this.params.guest_count > this.result.accommodates) {
        //   this.params.guest_count =  this.params.guest_count - 1
        // }
      },

      getCalendar() {
        this.loading = true;
        axios
                .post('/rooms/rooms_calendar', { data: this.params.room_id })
                .then((response) => {
                  this.calendar = response.data;
                  this.loading = false;
                })
                .catch((error) => {
                  this.calendar = {};
                  this.loading = false;
                });
      },

      setCheckIn(data) {
        this.params.checkin = moment(data).format('DD-MM-YYYY');
      },

      setCheckOut(data) {
        this.params.checkout = moment(data).format('DD-MM-YYYY');
      },

      // {"checkin":"08-03-2020","checkout":"23-03-2020","guest_count":"1","room_id":10006}
    },
  };
</script>

<style>
  div#test .datepicker {
    position: absolute !important;
    left: 125px !important;
  }
  @media (max-width: 700px) {
    div#test .datepicker {
      position: fixed !important;
      left: 0 !important;
    }
  }

  .margin-bottom--7 {
    margin-bottom: 7px !important;
  }

  .filter__title--secondary {
    margin-bottom: 20px;
  }

  .loader__container {
    padding-top: 50px;
    padding-bottom: 50px;
    display: flex;
    justify-content: center;
    align-items: center;
  }

  /* @media (min-width: 48em) .search__input-holder--date {
    border: 1px solid rgba(16, 48, 76, 0.1) !important;
  } */
</style>
