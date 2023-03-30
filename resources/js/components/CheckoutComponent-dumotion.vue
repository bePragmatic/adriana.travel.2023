<template>
    <div class="col-12 mt-100" v-show="checkout_component" v-cloak>
        <div class="brk-cart" data-brk-library="component__cart">
            <div class="col-12 text-right pt-10 pr-20">
                {{$t('payment.currency')}}:
                <button
                        class="btn btn-sm btn-outline-primary"
                        value="hrk"
                        @click="changeCurrency('hrk')"
                >
                    KN
                </button
                >&nbsp;&nbsp;
                <button
                        class="btn btn-sm btn-outline-primary"
                        value="usd"
                        @click="changeCurrency('usd')"
                >
                    USD
                </button
                >&nbsp;&nbsp;
                <button
                        class="btn btn-sm btn-outline-primary"
                        value="eur"
                        @click="changeCurrency('eur')"
                >
                    EUR
                </button>
            </div>
            <hr class="pb--10 mb-0"/>
            <table>
                <thead>
                <tr>
                    <th colspan="2">{{$t('payment.product')}}</th>
                    <th>{{$t('payment.price')}}</th>
                    <th>{{$t('payment.quantity')}}</th>
                    <th>{{$t('payment.total')}}</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="item in order.items">
                    <td>
                        <div
                                class="d-flex flex-row justify-content-lg-center justify-content-between align-items-center"
                        >
                            <img
                                    :data-src="'/storage/' + item.product.image"
                                    :src="'/storage/' + item.product.image"
                                    alt="item-alt"
                                    class="lazyload brk-cart__img"
                            />
                        </div>
                    </td>
                    <td aria-label="Product">
                        <a
                                href="#"
                                class="font__size-16 line-height-1-375 brk-cart__title"
                        >{{ item.name }}</a
                        >
                    </td>
                    <td aria-label="Price">
                            <span
                                    class="font__size-16 line__height-20 font__family-montserrat font__weight-bold"
                                    v-if="currency == 'hrk'"
                            >
                                {{ parseFloat(item.unit_price_hrk).toFixed(2) }}
                                Kn
                            </span>
                        <span
                                class="font__size-16 line__height-20 font__family-montserrat font__weight-bold"
                                v-else-if="currency == 'usd'"
                        >
                                ${{
                                    parseFloat(item.unit_price_usd).toFixed(2)
                                }}
                            </span>
                        <span
                                class="font__size-16 line__height-20 font__family-montserrat font__weight-bold"
                                v-else
                        >
                                {{ parseFloat(item.unit_price_eur).toFixed(2) }}
                                &euro;
                            </span>
                    </td>
                    <td aria-label="Qty">
                        <div class="brk-cart__count brk-cart__count_input">
                            <input type="number" :value="item.qty"/>
                        </div>
                    </td>
                    <td aria-label="Total">
                            <span
                                    class="font__size-16 line__height-20 font__family-montserrat font__weight-bold"
                                    v-if="currency == 'hrk'"
                            >
                                {{
                                    parseFloat(item.total_price_hrk).toFixed(2)
                                }}
                                Kn
                            </span>
                        <span
                                class="font__size-16 line__height-20 font__family-montserrat font__weight-bold"
                                v-else-if="currency == 'usd'"
                        >
                                ${{
                                    parseFloat(item.total_price_usd).toFixed(2)
                                }}
                            </span>
                        <span
                                class="font__size-16 line__height-20 font__family-montserrat font__weight-bold"
                                v-else
                        >
                                {{
                                    parseFloat(item.total_price_eur).toFixed(2)
                                }}
                                &euro;
                            </span>
                    </td>
                </tr>
                </tbody>
            </table>
            <div class="brk-cart__footer">
                <div class="brk-cart__footer-coupon">
                    <form class="brk-form-round brk-form-round-btn-inside-full w-100" v-if="order.status != 3">
                        <input type="text" :placeholder="$t('coupon.code')" v-model="couponCode">
                        <button class="btn btn-inside-out btn-lg border-radius-30 btn-shadow mx-0 my-0"
                                data-brk-library="component__button" @click.prevent="checkCoupon">
                            <span class="before">{{$t('payment.apply')}}</span><span class="text">{{$t('payment.apply')}}</span><span
                                class="after">{{$t('payment.apply')}}</span>
                        </button>
                    </form>
                </div>
                <div class="brk-cart__footer-total">
                    <div
                            class="brk-cart__footer-total-item font__family-montserrat"
                    >
                        <div
                                class="font__size-sm-14 font__size-13 line-height-1-5"
                        >
                            {{$t('payment.subtotal')}}
                        </div>
                        <div
                                class="font__size-14 line-height-1-5 font__weight-bold"
                        >
                            <span v-if="currency == 'usd'"
                            >${{
                                    parseFloat(total.total_usd).toFixed(2)
                                }}</span
                            >
                            <span v-else-if="currency == 'eur'"
                            >{{
                                    parseFloat(total.total_eur).toFixed(2)
                                }}
                                &euro;</span
                            >
                            <span v-else
                            >{{
                                    parseFloat(total.total_hrk).toFixed(2)
                                }}
                                Kn</span
                            >
                        </div>
                    </div>

                    <div
                            class="brk-cart__footer-total-item font__family-montserrat"
                            v-if="coupon"
                    >
                        <div
                                class="font__size-sm-14 font__size-13 line-height-1-5"
                        >
                            {{$t('payment.discount')}}
                        </div>
                        <div
                                class="font__size-14 line-height-1-5 font__weight-bold"
                        >
                            {{ coupon.discount }} %
                        </div>
                    </div>

                    <div
                            class="brk-cart__footer-total-item font__family-montserrat"
                            v-if="coupon"
                    >
                        <div
                                class="font__size-sm-14 font__size-13 line-height-1-5"
                        >
                            {{$t('payment.discount_amount')}}
                        </div>
                        <div
                                class="font__size-14 line-height-1-5 font__weight-bold"
                        >
                            - {{ discountAmmount }}
                            <span
                                    class="font__size-16 line__height-20 font__family-montserrat font__weight-bold"
                                    v-if="currency == 'hrk'"
                            >Kn</span>
                            <span
                                    class="font__size-16 line__height-20 font__family-montserrat font__weight-bold"
                                    v-else-if="currency == 'usd'"
                            >$</span>
                            <span
                                    class="font__size-16 line__height-20 font__family-montserrat font__weight-bold"
                                    v-else
                            >&euro;</span>
                        </div>
                    </div>

                    <div
                            class="brk-cart__footer-total-item font__family-montserrat"
                    >
                        <div
                                class="font__size-sm-14 font__size-13 line-height-1-5"
                        >
                            {{$t('payment.total')}}
                        </div>
                        <div
                                class="font__size-16 line-height-1-25 font__weight-bold brk-base-font-color"
                        >
                            <span v-if="orderTotal"
                            >{{ parseFloat(orderTotal).toFixed(2) }}
                            <span
                                    class="font__size-16 line__height-20 font__family-montserrat font__weight-bold"
                                    v-if="currency == 'hrk'"
                            >Kn</span>
                        <span
                                class="font__size-16 line__height-20 font__family-montserrat font__weight-bold"
                                v-else-if="currency == 'usd'"
                        >$</span>
                        <span
                                class="font__size-16 line__height-20 font__family-montserrat font__weight-bold"
                                v-else
                        >&euro;</span></span>
                            <span v-else>
                            <span
                                    class="font__size-16 line__height-20 font__family-montserrat font__weight-bold"
                                    v-if="currency == 'hrk'"
                            > {{ parseFloat(total.total_hrk).toFixed(2) }} Kn</span>
                        <span
                                class="font__size-16 line__height-20 font__family-montserrat font__weight-bold"
                                v-else-if="currency == 'usd'"
                        >${{ parseFloat(total.total_usd).toFixed(2) }}</span>
                        <span
                                class="font__size-16 line__height-20 font__family-montserrat font__weight-bold"
                                v-else
                        >{{ parseFloat(total.total_eur).toFixed(2) }} &euro;</span></span
                            >
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <form
                    name="pay"
                    ref="form"
                    :action="wspay_uri"
                    method="POST"
            >
                    <input type="hidden" name="ShopID" :value="shop_id">
                <input type="hidden" name="ShoppingCartID" :value="order_id">
                <input type="hidden" name="TotalAmount" :value="formatPrice">
                <input type="hidden" name="Signature" :value="signature">
                <input type="hidden" name="Lang" :value="lang">
                <input type="hidden" name="CustomerFirstName" :value="racer.first_name">
                <input type="hidden" name="CustomerLastName" :value="racer.last_name">
                <input type="hidden" name="CustomerAddress" :value="racer.address">
                <input type="hidden" name="CustomerCity" :value="racer.city">
                <input type="hidden" name="CustomerZIP" :value="racer.postal">
                <input type="hidden" name="CustomerCountry" :value="country">
                <input type="hidden" name="CustomerPhone" :value="racer.phone">
                <input type="hidden" name="CustomerEmail" :value="racer.email">

                <input
                        type="hidden"
                        name="ReturnURL"
                        :value="payment_success_url"
                />
                <input
                        type="hidden"
                        name="CancelURL"
                        :value="payment_cancel_url"
                />
                <input
                        type="hidden"
                        name="ReturnErrorURL"
                        :value="payment_error_url"
                />

            </form>
        </div>
        <div class="text-center translate-top-50">
            <a
                    class="btn btn-inside-out btn-lg border-radius-25 btn-shadow pl-50 pr-50"
                    data-brk-library="component__button"
                    @click="submit()"
            >
                <span class="before">{{$t('payment.pay')}}</span
                ><span class="text">{{$t('payment.pay')}}</span
            ><span class="after">{{$t('payment.pay')}}</span>
            </a>

        </div>


    </div>
</template>

<script>
    export default {
        mounted() {
            this.getData();
            this.getProducts();
            this.setLang();


            this.wspay_uri = normalizeUrl(window.wspay_uri, {forceHttps: true});

            //    Event.$on("coupon-apply", coupon => this.applyCoupon(coupon));
        },

        data() {
            return {
                payment_success_url: normalizeUrl(route('payment.success').url()),
                payment_error_url: normalizeUrl(route('payment.error').url()),
                payment_cancel_url: normalizeUrl(route('payment.cancel').url()),
                lang: '',
                checkout_component: false,
                errors: {},
                order: {},
                products: "",
                shop_id: "",
                wspay_uri: "",
                signature: "",
                currency: "hrk",
                count: {},
                coupon: "",
                couponCode: "",
                total: {
                    total_hrk: 0,
                    total_usd: 0,
                    total_eur: 0
                },
                racer: {},
                country: ""
            };
        },

        props: ["order_id"],

        computed: {
            orderTotal() {

                if (this.coupon.discount == 100) {
                    return parseFloat(0).toFixed(2);
                } else {
                    if (this.currency == "eur") {
                        return (
                            this.total.total_eur -
                            this.total.total_eur *
                            parseFloat((this.coupon.discount / 100).toFixed(2))
                        );
                    } else if (this.currency == "usd") {
                        return (
                            this.total.total_usd -
                            this.total.total_usd *
                            parseFloat((this.coupon.discount / 100).toFixed(2))
                        );
                    } else {
                        return (
                            this.total.total_hrk -
                            this.total.total_hrk *
                            parseFloat((this.coupon.discount / 100).toFixed(2))
                        );
                    }
                }
            },

            discountAmmount() {
                if (this.currency == "eur") {
                    return (this.total.total_eur - this.orderTotal).toFixed(2);
                } else if (this.currency == "usd") {
                    return (this.total.total_usd - this.orderTotal).toFixed(2);
                } else {
                    return (this.total.total_hrk - this.orderTotal).toFixed(2);
                }
            },

            formatPrice() {
                let options = {
                    decimal: ",",
                    thousand: "",
                    precision: 2,
                };

                if (this.coupon == "") {
                    return this.$accounting.formatNumber(this.total.total_hrk, options);
                } else {
                    return this.$accounting.formatNumber((this.total.total_hrk - this.total.total_hrk *
                        parseFloat((this.coupon.discount / 100).toFixed(2))), options);
                }
            },

        },

        methods: {
            setLang() {
                this.lang = window.default_locale
                this.$i18n.locale = window.default_locale
            },


            setSignature() {

                // this.wspay_uri = normalize(window.wspay_uri);

                axios.post('/api/v1/signature', {
                    order_id: String(this.order_id),
                    price: String(this.formatPrice.replace(",", ""))
                }).then(response => {
                    this.signature = response.data.signature
                    this.shop_id = response.data.shop_id
                }).catch(error => {
                    console.log(error.response)
                });
            },


            submit() {

                this.setSignature()

                let loader = this.$loading.show();

                axios.put("/api/v1/order/update", {
                    order: this.order,
                    signature: this.signature,
                    coupon: this.coupon.coupon
                }).then(response => {


                        console.log(response.data)


                        if (response.data.free) {
//alert(route('payment.free',{ id: this.order.id}).url())
                            window.location.href = route('payment.free', {order: this.order.id}).url()
                        } else {

                            this.$refs.form.submit();
                        }

                    },
                    error => {
                        this.errors = error.response.data.errors;
                        alertMessage('error')
                    }
                );
            },


            changeCurrency(value) {
                this.currency = value;
            },

            applyCoupon(coupon) {
                if (coupon.isValid) {
                    this.$toastr.s(this.$t('coupon.valid'))
                    this.coupon = coupon;
                } else {
                    this.$toastr.e(this.$t('coupon.expired'))
                }

                this.setSignature()
            },


            checkCoupon(){
                axios.post('/api/v1/service/coupon', { coupon: this.couponCode })
                    .then(response => {

                        this.applyCoupon(response.data)

                        this.coupon.code = ''

                    }, (error) => {
                        this.errors = error.response.data.errors
                        this.coupon = ''
                        this.$toastr.e(this.$t('coupon.not_valid'))

                    });
            },

            getData() {


                axios.get("/api/v1/order/" + this.order_id).then(response => {
                    this.order = response.data.order;
                    //  this.products = response.data.products
                    this.racer = response.data.racer;
                    this.country = response.data.racer.country.name
                    this.items = response.data.order.items;
                    this.count = response.data.count;
                    this.total = response.data.total;
                    this.checkout_component = true;

                    if (this.order.coupon) {
                        this.couponCode = this.order.coupon
                        this.checkCoupon();
                    }
                    this.setSignature()

                });


            },

            getProducts() {
                axios
                    .get("/api/v1/service/products/crosssale")
                    .then(response => {
                        this.products = response.data.products;
                    });
            },

            addToOrder(product) {
                axios
                    .post("/order/add", {
                        product: product,
                        order: this.order.id
                    })
                    .then(
                        response => {
                            this.getData();
                        },
                        error => {
                            this.errors = error.response.data.errors;
                        }
                    );
            }
        }
    };
</script>
<style>
    td {
        padding: 15px !important;
    }

    .brk-cart__img {
        width: 120px !important;
        height: auto !important;
    }
</style>
