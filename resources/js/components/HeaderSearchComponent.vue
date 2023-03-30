<template>
    <div class="accommodation__header__search">
        <div class="search">
            <!--<div class="search__input-holder search__input-holder--place">
                      <input
                              v-model="params.location"
                              type="text"
                              id="place"
                              class="search__input search__input--place input input--text"
                              placeholder="Where to?"
                      />
                  </div> -->

            <div class="search__input-holder search__input-holder--date">
                <!-- ".search__input--date" should have ".entered" class when user enters vlaue for guests -->
                <div class="search__input--date entered">
                    <!-- 24. Jun — 18. Jun -->
                    <daterange
                            :displayClearButton="false"
                            format="DD.MM.YYYY"
                            @check-in-changed="setCheckIn"
                            @check-out-changed="setCheckOut"
                            :startingDateValue="startDate"
                            :endingDateValue="endDate"
                            :i18n="calendar"
                    />
                </div>
            </div>
            <div class="search__input-holder search__input-holder--guests">
                <!-- Guests select. On click should toggle class ".active" on itself and ".search__popover--guests". Also ".search__input--guests" should have ".entered" class when user enters vlaue for guests -->
                <div
                        class="search__input search__input--guests"
                        v-bind:class="[params.guest ? 'entered' : '']"
                        @click="toggleClass()"
                >
                    {{ params.guest }} {{ $tc('messages.home.guest', params.guest) }}
                </div>
                <div
                        class="search__popover--guests"
                        v-bind:class="[isActiveFilter ? 'active' : '']"
                >
                    <div class="search__popover__title t-theta t-upper o-80">
                        Filter
                    </div>
                    <div class="search__popover__close" @click="toggleClass"></div>
                    <div class="field field--flex">
                        <div class="field__text">
                            <p>{{ $tc('messages.home.guest', params.guest) }}</p>
                        </div>
                        <counter v-model="params.guest"></counter>
                    </div>
                    <!--
                              <div class="field field--flex">
                                  <div class="field__text">
                                      <p>Children</p>
                                      <p class="o-40">Children 2-12</p>
                                  </div>

                                  <div class="counter">
                                      <button type="button" class="counter__minus"></button>

                                      <input
                                              class="counter__value"
                                              type="number"
                                              name="quantity"
                                              min="0"
                                              defaultValue="0"
                                      />

                                      <button type="button" class="counter__plus"></button>
                                  </div>
                              </div>
                              <div class="field field--flex">
                                  <div class="field__text">
                                      <p>Infants</p>
                                      <p class="o-40">Under 2</p>
                                  </div>

                                  <div class="counter">
                                      <button type="button" class="counter__minus"></button>

                                      <input
                                              class="counter__value"
                                              type="number"
                                              name="quantity"
                                              min="0"
                                              defaultValue="0"
                                      />

                                      <button type="button" class="counter__plus"></button>
                                  </div>
                              </div>
                              -->
                    <div class="s-top--lrg">
                        <label class="toggle toggle--right toggle--full-width">
                            <span class="toggle-label t-theta">Pets</span>
                            <input
                                    class="toggle-checkbox"
                                    type="checkbox"
                                    v-model="params.pets"
                            />
                            <div class="toggle-switch"></div>
                        </label>
                    </div>
                    <p class="t-theta o-60 s-top--med">
                        {{ $t('messages.home.infants') }}
                    </p>
                    <div class="s-top--med s-bottom--sml">
                        <button class="btn btn--empty btn--med">
                            {{ $t('messages.payments.clear') }}
                            {{ $t('messages.search.filters') }}
                        </button>
                        <button class="btn btn--primary btn--med" @click="search">
                            {{ $t('messages.search.apply_filters') }}
                        </button>
                    </div>
                </div>
            </div>
            <button class="btn btn--primary search__button" @click="search">
                <img src="./assets/icon-magnifier.svg" alt="Magnifier"/>
                {{ $t('messages.home.search') }}
            </button>
        </div>
    </div>
</template>

<script>
    import moment from 'moment';

    export default {
        created() {
            this.lang = window.lang;
            this.$i18n.locale = window.lang;
            this.setLang();
            this.setUrlParams();

            Event.$on('check-in-changed', (data) => this.setCheckIn(data));
            Event.$on('check-out-changed', (data) => this.setCheckOut(data));
        },

        data() {
            return {

                lang: 'en',
                url_params: '',
                accommodations: '',
                data: [],
                isActiveFilter: false,
                period: {
                    amenities: [],
                    checkIn: '',
                    checkOut: '',
                    nights: 0,
                },
                params: {
                    location: '',
                    //  min_price: 10,
                    //  max_price: 750,
                    //  amenities: [],
                    //  property_type: [],
                    //  room_type: [],
                    pets: '',
                    //   beds: 0,
                    //   bathrooms: 0,
                    //   bedrooms: 0,
                    checkin: '',
                    checkout: '',
                    guest: 1,
                    //  map_details: "",
                    //  instant_book: "0",
                    //  page: "1",
                    php_date_format: 'd/m/Y',
                },
            };
        },

        computed: {
            startDate() {
                return this.url_params.checkin
                    ? moment(this.url_params.checkin, 'DD/MM/YYYY').toDate()
                    : null;
                //new Date(new Date().getFullYear(), new Date().getMonth(), 1),
            },
            endDate() {
                return this.url_params.checkout
                    ? moment(this.url_params.checkout, 'DD/MM/YYYY').toDate()
                    : null;
            },

            calendar() {
                if (this.$i18n.locale == 'hr') {
                    return {
                        'night': 'Noć',
                        'nights': 'Noći',
                        'day-names': ['Ned', 'Pon', 'Uto', 'Sri', 'Cet', 'Pet', 'Sub'],
                        'check-in': 'Prijava',
                        'check-out': 'Odjava',
                        'month-names': ['Siječanj', 'Veljača', 'Ožujak', 'Travanj', 'Svibanj', 'Lipanj', 'Srpanj', 'Kolovoz', 'Rujan', 'Listopad', 'Studeni', 'Prosinac'],
                    }
                } else if (this.$i18n.locale == 'de') {
                    return {
                        'night': 'Nacht',
                        'nights': 'Nächte',
                        'day-names': ['So', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa'],
                        'check-in': 'Check In',
                        'check-out': 'Check Out',
                        'month-names': [' Januar', 'Februar', 'März', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember'],
                    }
                } else {
                    return {
                        'night': 'Night',
                        'nights': 'Nights',
                        'day-names': ['Sun', 'Mon', 'Tue', 'Wed', 'Thur', 'Fri', 'Sat'],
                        'check-in': 'Check-in',
                        'check-out': 'Check-Out',
                        'month-names': ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                    }
                }
            }
        },

        methods: {
            setLang() {
            this.lang = window.default_locale;
            this.$i18n.locale = window.default_locale;
             },
            setUrlParams() {
                var urlParams;
                (window.onpopstate = function () {
                    var match,
                        pl = /\+/g, // Regex for replacing addition symbol with a space
                        search = /([^&=]+)=?([^&]*)/g,
                        decode = function (s) {
                            return decodeURIComponent(s.replace(pl, ' '));
                        },
                        query = window.location.search.substring(1);

                    urlParams = {};
                    while ((match = search.exec(query)))
                        urlParams[decode(match[1])] = decode(match[2]);
                })();

                this.url_params = urlParams;

                if (this.url_params.checkin) {
                    this.params.checkin = this.url_params.checkin;
                }

                if (this.url_params.checkout) {
                    this.params.checkout = this.url_params.checkout;
                }
                if (this.url_params.location) {
                    this.params.location = this.url_params.location;
                }

                if (this.url_params.guest) {
                    this.params.guest = this.url_params.guest;
                }
            },

            toggleClass() {
                this.isActiveFilter = !this.isActiveFilter;
            },

            setCheckIn(data) {
                this.params.checkin = moment(data).format('DD/MM/YYYY');
            },

            setCheckOut(data) {
                this.params.checkout = moment(data).format('DD/MM/YYYY');
            },

            serialize(obj) {
                var str = [];
                for (var p in obj)
                    if (obj.hasOwnProperty(p)) {
                        str.push(encodeURIComponent(p) + '=' + encodeURIComponent(obj[p]));
                    }
                return str.join('&');
            },

            search() {
                window.location = '/accommodation?' + this.serialize(this.params);
            },
        },
    };
</script>
