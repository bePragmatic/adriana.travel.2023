<template>
  <div>
    <div class="guest--row">
      <h4>{{ $t('messages.rooms.head') }}</h4>
      <div class="guest_select">
        <div class="guest-title">{{ $t('messages.rooms.title') }}</div>
        <div class="guest_increment">
          <button
            class="btn btn--primary btn--med quantity"
            @click="decreaseGuests()"
          >
            -
          </button>
          <span> {{ guests }} </span>
          <button
            class="btn btn--primary btn--med quantity"
            @click="increaseGuests()"
          >
            +
          </button>
        </div>
      </div>
    </div>
    <div>
      <h4>{{ $t('messages.rooms.select_date') }}</h4>
      
      <button class="
    btn " @click="showCheckin()">
      <svg style="  vertical-align: baseline; margin-right:15px;"width='17' height='16' viewBox='0 0 17 16' fill='none' xmlns='http://www.w3.org/2000/svg'><path d='M14.7029 2.5H1.51449C0.954493 2.5 0.5 2.948 0.5 3.5V14.5C0.5 15.052 0.954493 15.5 1.51449 15.5H14.7029C15.2629 15.5 15.7174 15.052 15.7174 14.5V3.5C15.7174 2.948 15.2629 2.5 14.7029 2.5Z' stroke='#009FDA' stroke-miterlimit='10' stroke-linecap='round' stroke-linejoin='round'/><path d='M0.5 5.5H15.7174' stroke='#009FDA' stroke-miterlimit='10' stroke-linecap='round' stroke-linejoin='round'/><path d='M4.55798 0.5V2.5' stroke='#009FDA' stroke-miterlimit='10' stroke-linecap='round' stroke-linejoin='round'/><path d='M11.6594 0.5V2.5' stroke='#009FDA' stroke-miterlimit='10' stroke-linecap='round' stroke-linejoin='round'/><path d='M5.57251 7.5V13.5' stroke='#009FDA' stroke-miterlimit='10' stroke-linecap='round' stroke-linejoin='round'/><path d='M10.6449 7.5V13.5' stroke='#009FDA' stroke-miterlimit='10' stroke-linecap='round' stroke-linejoin='round'/><path d='M2.52905 10.5H13.6885' stroke='#009FDA' stroke-miterlimit='10' stroke-linecap='round' stroke-linejoin='round'/></svg>
      
        {{


          checkinDate ? moment(checkinDate).format("DD-MM-YYYY") : "check-in"
        }}
      </button>
      <datepicker
      :highlighted="highlighted"
        @closed="check()"
        :disabled-dates="this.disabledDates"
        input-class="hide-input"
        ref="datepickin"
        v-model="checkinDate"
        name="checkin"
        >Checkin</datepicker
      >
      <p class="already_book" v-if="error">
       {{ $t('messages.rooms.error_msg') }}
      </p>
    </div>
    <div v-if="show" class="price">
      <div class="full_day">
        <input
          type="radio"
          id="full"
          @change="calculatecost(full_day_price)"
          value="full_day_price"
          v-model="day"
        />
        <label for="full"
          >{{ $t('messages.rooms.full_day_price') }}
          <span> : € {{
            full_day_price
          }}</span></label
        >
      </div>
      <div class="full_day">
        <input
          type="radio"
          @change="calculatecost(half_day_price)"
          id="no"
          value="half_day_price"
          v-model="day"
        />
        <label for="half"
          >{{ $t('messages.rooms.Half_day_price') }}
          <span> : € {{
          half_day_price 
          }}</span></label
        >
      </div>
      <p v-if="day=='full_day_price' "> Total Price    : € {{ full_day_price  }}</p>
      <p v-if="day=='half_day_price' "> Total Price    : € {{ half_day_price  }}</p>

      <form
        ref="book_it_form"
        accept-charset="UTF-8"
        :action="'/payments/boat/' + boat_id"
        id="book_it_form"
        method="post"
      >
        <input type="hidden" name="_token" :value="token" />
        <input type="hidden" name="checkin" :value="formatted" />
        <input type="hidden" name="checkout" :value="formatted" />
        <input type="hidden" name="number_of_guests" :value="guests" />
        <input
          type="hidden"
          name="half_day_price"
          :value="day == 'half_day_price' ? half_day_price : '-'"
        />
        <input
          type="hidden"
          name="full_day_price"
          :value="day == 'full_day_price' ? full_day_price : '-'"
        />
        <input type="hidden" name="total" :value="cost" />
        <input type="hidden" name="boat_id" :value="boat_id" />
        <input type="hidden" name="boat_type" :value="boat_type" />
        <input type="hidden" name="hosting_id" value="2" />
      </form>
      <button
        v-if="day"
        class="btn btn--primary btn--med"
        @click.prevent="submit()"
      >
        book
      </button>
    </div>
    <div v-if="!checkinDate ">
        <h4 class="t-center t-epsilon padding-top--2">
          {{ $t('messages.search.enter_dates') }}
        </h4>
      </div>
  </div>
</template>
<script>
import DatePicker from "vue2-datepicker";
import VueSessionStorage from 'vue-sessionstorage'
Vue.use(VueSessionStorage)
import "vue2-datepicker/index.css";
import Datepicker from "vuejs-datepicker";
import moment from "moment";
//var current = new Date(Date.now());
 // var current= new Date(moment(Date.now()).subtract(1, "days"));

var date = moment(new Date(Date.now())).add(7, "months").format("DD");

var month = moment(new Date(Date.now())).add(7, "months").format("MM");
var year = moment(new Date(Date.now())).add(7, "months").format("yyyy");
var futuredate = new Date(year, month, date);
export default {
  components: {
    Datepicker,
    DatePicker,
  },
computed:{
formatted()
{
return moment(this.checkinDate).format("YYYY-MM-DD");
}
},
  props: [
      'token',
      'boat_type',
    ],
  data() {
    return {
      guests: 1,
      checkinDate: "",
      moment,
      day: "",
      cost: 0,
      show:false,
      error:false,
      full_day_price:'',
      half_day_price:'',
      boat_id:'',
      price: 100,
    highlighted: {
    to: new Date(2022, 11, 26), // Highlight all dates up to specific date
    from: new Date(2022, 11, 31), // Highlight all dates after specific date
  },
      disabledDates: {
   
   
      },
    };
  },
  created() {

      this.$i18n.locale = window.lang;
      
    },
  watch: {
    checkinDate(val) {
      this.calculatecost();
    },
  },
  watch:{
    checkinDate(val,old){
      this.checkinDate
    }
  },
  mounted() {
  console.log(this.boat_type);
    var data=[];
      axios.get('/disabledate').then((response) => {
       data=response.data;
       console.log(response);
       
       var arr=[];
         //  var temp=new Date(Date.now());
           var temp= new Date(moment(new Date(Date.now())).subtract(1, "days").format("YYYY MM DD"));

console.log(data);
console.log(response);

data.map((item)=>{
if(item.boat_type==this.boat_type){

        arr.push({
          from:temp,
          to:new Date(item.from_date),
        })
        temp=new Date(moment(new Date(item.to_date)).add(1, "days").format("YYYY MM DD"))
}
    })
    
      arr.push({
          from:temp,
          to:new Date(moment(temp).add(365, "days").format("YYYY MM DD"))
        })
    console.log("Arr",arr);
    this.disabledDates={
      to:new Date(moment(new Date(Date.now())).subtract(1, "days").format("YYYY MM DD")),
      from:futuredate,
      ranges:arr
    }

});

  

   

  },
  methods: {
  calculatecost(rate) {
  console.log(rate);
      this.cost= rate;
     // console.log(this.cost)
    },
    check(){
      console.log("checkinDate", this.checkinDate);
        var url = location.href;
        var array = url.split('/');
        var lastsegment = array[array.length-1];
        //var segment_val = lastsegment;
        const params={
          date:moment(this.checkinDate).format("YYYY-MM-DD"),
          guests:this.guests,
          boat_type:lastsegment
          
        }
        this.day="";
         axios.post('/rent-a-boat-form', params).then((response) => {
         console.log("response179", response);
            if(response.data!=""){
                     console.log("response181", response);

                    
                  if(response.data.message)

                      {
                      console.log("response187", response);
                        this.error=true;
                        this.show=false;
                        return;
                      }
                      else{
                                            console.log("response193", response);

                        this.half_day_price=response.data[0].half_day_price;
                        this.full_day_price=response.data[0].full_day_price;
                        this.boat_id=response.data[0].id;
                        this.show=true;
                        this.error=false;
                      }
            }
             else{
                  this.error=false;
                  this.show=false;
                  return;
         }
        });
    },
      submit(){
       window.dataLayer.push({
       
          'guests': this.guests,
          'checkIn': this.formatted ,
          'checkOut': this.formatted ,
          'price': this.price
        })
      const obj={
      checkin_date:this.formatted,
       guest:this.guests,
       half_day_price:this.day == 'half_day_price' ? this.half_day_price : '-',
      full_day_price:this.day == 'full_day_price' ? this.full_day_price : '-',
       total:this.price

      };
   //   this.$session.set('booking_storage', obj)
 //  sessionStorage.setItem("booking", JSON.parse(JSON.stringfy(obj)));
   sessionStorage.setItem("booking", JSON.stringify(obj));

        this.$refs.book_it_form.submit()
      },
    showCheckin() {
      this.$refs.datepickin.showCalendar();
      this.calculatecost();
    },
    increaseGuests() {
      if (this.guests < 7) {
        this.guests++;
      }
    },
    decreaseGuests() {
      if (this.guests > 0) {
        this.guests--;
      }
    },
  },
};
</script>
<style>
.hide-input {
  display: none !important;
}
</style>