<template>
  <div style="width: 100%">
    <div class="row filter">
      <div class="col-md-8">
        <!--  <div class="select">
                                <select
                                        class="focus"
                                        v-model="payment_type"
                                        placeholder="Select payment type"
                                        @change="setSignature"
                                >
                                    <option value="100">Full Amount</option>
                                    <option value="30">Deposit 30%</option>
                                </select>
                            </div>-->

        <div class="mt-4 pb-3 border-bottom">
          <!--   <div class="d-flex my-2 row">
                                            <div class="col-8 text-left">
                                                <span>€500 </span>
                                                <span>x 6 nights</span>
                                            </div>
                                            <div class="col-4 text-right">
                                                <span>{{ total.toFixed(2) }} {{currency_symbol }}</span>
                                            </div>
                                        </div>-->

          <div
            class="d-flex  mt-3 row  padding-top--1"
            style="display: flex; justify-content: space-between;"
            v-if="orderTotal != this.total"
          >
            <div class="text-left">
              <strong>
                {{ $t('messages.home.deposit') }} ({{ payment_type }}%)</strong
              >
            </div>
            <div class="text-right">
              <strong
                ><span class="font-style__oops" style="font-size: 23px"
                  >{{ orderTotal.toFixed(2) }} {{ currency_symbol }}</span
                ></strong
              >
            </div>
          </div>

          <div
            class="d-flex mt-3 row padding-top--1"
            style="display: flex; justify-content: space-between;"
            v-else
          >
            <div class="text-left">
              <span
                class="font-weight-bold d-item__name t-bold font-style__oops"
              >
                {{ $t('messages.home.total') }} (EUR)
              </span>
            </div>

            <div class="text-right">
              <strong>
                <span class="o-80 font-style__oops" style="font-size: 23px;">
                  {{ orderTotal.toFixed(2) }} {{ currency_symbol }}
                </span>
              </strong>
            </div>
          </div>

          <!-- <div class="d-flex my-2 row">
                                             <div class="col-8 text-left">
                                                 <span>Remaining</span>
                                             </div>
                                             <div class="col-4 text-right">
                                                 <span>- {{parseFloat(this.total - orderTotal).toFixed(2) }}  {{currency_symbol }}</span>
                                             </div>
                                         </div>-->
        </div>

        <div class="d-flex  mt-3 row" v-if="orderTotal != this.total">
          <div class="col-12 text-left">
            {{ $t('messages.home.remaining') }}
            <strong>{{ orderTotal.toFixed(2) }} {{ currency_symbol }}</strong>
            {{ $t('messages.home.needs') }}
          </div>
        </div>
      </div>
    </div>

    <ws-pay></ws-pay>

    <!-- PRIVOLA -->
    <div
      class="accommodation__filters__padding__top padding__top__1 padding-bottom--2"
      style="display: flex; justify-content: flex-end;"
    >
      <div
        class="homepage__row__container checkbox-container"
        style=" max-width: 350px"
      >
        <input
          v-bind:class="{ inputErrorState: isError }"
          class="initial-checkbox"
          style="margin-top: 2px; cursor: pointer;"
          type="checkbox"
          @change="!isError"
          v-model="consent"
          id="consent"
        />
        <label
          for="consent"
          class="text__footnote o-80 padding__left__10xs"
          v-bind:class="{ inputErrorState: isError }"
        >
          {{ $t('messages.home.by_clicking') }}
          <a href="/terms_of_service" target="_blank">
            {{ $t('messages.home.terms') }}</a
          >
          {{ $t('messages.home.and') }}
          <a href="/privacy_policy" target="_blank">
            {{ $t('messages.home.privacy') }}</a
          >
        </label>
      </div>
    </div>
    <!-- PRIVOLA KRAJ -->
    <form ref="form" :action="wspay_uri" method="post">
      <input type="hidden" name="ShopID" :value="shop_id" />
      <input type="hidden" name="ShoppingCartID" :value="order_id" />
      <input type="hidden" name="TotalAmount" :value="formatPrice" />
      <input type="hidden" name="Signature" :value="signature" />
      <input type="hidden" name="Lang" :value="lang" />
      <input type="hidden" name="CustomerFirstName" :value="user.first_name" />
      <input type="hidden" name="CustomerLastName" :value="user.last_name" />
      <input type="hidden" name="CustomerAddress" :value="user.address" />
      <input type="hidden" name="CustomerCity" :value="user.city" />
      <input type="hidden" name="CustomerZIP" :value="user.zip" />
      <input
        type="hidden"
        name="CustomerCountry"
        :value="user.country.long_name"
      />
      <input type="hidden" name="CustomerPhone" :value="user.phone" />
      <input type="hidden" name="CustomerEmail" :value="user.email" />
      <input type="hidden" name="ReturnURL" :value="payment_success_url" />
      <input type="hidden" name="CancelURL" :value="payment_cancel_url" />
      <input type="hidden" name="ReturnErrorURL" :value="payment_error_url" />

      <div style=" display: flex; justify-content: flex-end">
        <button
          id="pay"
          type="button"
          class="btn btn--primary guest-special-padding mt-4"
          @click="submit"
          v-if="!loading"
          style="min-width: 150px"
        >
          <span>{{ $t('messages.disputes.pay') }}</span>
        </button>

        <scale-loader
          class="loader"
          v-else
          :loading="loading"
          :height="30"
          :width="10"
          :radius="10"
          :color="'#009FDA'"
        >
        </scale-loader>
      </div>
    </form>
  </div>
</template>

<script>
import { BarLoader } from '@saeris/vue-spinners';

export default {
  mounted() {
    this.setSignature();
    this.convertToHrk();
  },

  components: {
    BarLoader,
  },

  data() {
    return {
      isError: false,
      consent: false,
      loading: false,
      payment_success_url: '',
      payment_error_url: '',
      payment_cancel_url: '',
      payment_user: this.messages.user_details,
      payment_type: 100,
      lang: 'en',
      transaction_id: '',
      shop_id: '',
      price_hrk: 0,
      wspay_uri: 'https://form.wspay.biz/Authorization.aspx',
      signature: '',
      currency_code: this.currency.code,
      currency_symbol: this.currency.symbol,
      total: this.messages.reservation.total,
    };
  },

  props: ['messages', 'currency', 'encrypted_id', 'user'],

  computed: {
    orderTotal() {
      return (this.total / 100) * this.payment_type;
    },

    formatPrice() {
      let options = { decimal: ',', thousand: '', precision: 2 };
      return this.$accounting.formatNumber(this.orderTotal, options);
    },

    order_id() {
      return this.messages.reservation_id + '-' + this.transaction_id;
    },
  },

  methods: {
    setLang() {
      this.lang = window.default_locale;
      this.$i18n.locale = window.default_locale;
    },

    setSignature() {
      axios
        .post('/payments/signature', {
          order_id: String(this.order_id),
          price: String(this.formatPrice.replace(',', '')),
        })
        .then((response) => {
          this.signature = response.data.signature;
          this.shop_id = response.data.shop_id;
        })
        .catch((error) => {
          console.log(error.response);
        });
    },

    convertToHrk() {
      // this.wspay_uri = normalize(window.wspay_uri);


      axios
        .post('/payments/currency-convert', { price: this.orderTotal })
        .then((response) => {
          this.price_hrk = response.data;
        })
        .catch((error) => {
          console.log(error.response);
        });
    },

    submit() {
      if (!this.consent) {
        this.isError = true;
        return false;
      }
      this.loading = true;

      axios
        .post('/transaction', {
          reservation: this.messages.reservation_id,
          price: this.orderTotal,
          currency: this.currency.code,
        })
        .then(
          (response) => {
            this.transaction_id = response.data.id;
            this.setSignature();
            this.payment_success_url =
              Ziggy.baseUrl +
              'payments/' +
              this.encrypted_id +
              '/' +
              this.transaction_id +
              '/success';
            this.payment_error_url =
              Ziggy.baseUrl +
              'payments/' +
              this.encrypted_id +
              '/' +
              this.transaction_id +
              '/error';
            this.payment_cancel_url =
              Ziggy.baseUrl +
              'payments/' +
              this.encrypted_id +
              '/' +
              this.transaction_id +
              '/cancel';
          },
          (error) => {
            this.errors = error.response.data.errors;
            this.loading = false;
          }
        )
        .finally(() => {
          setTimeout((resolve) => {
            this.$refs.form.submit();
          }, 1000);
        });
    },
  },
};
</script>
<style scoped>
.inputErrorState {
  color: red;
}
</style>
