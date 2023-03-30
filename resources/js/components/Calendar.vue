<template>
  <div class="demo-app">
    <div class="demo-app-top">
      <button @click="toggleWeekends">
        {{ $t('messages.home.toggle_weekends') }}
      </button>
      <button @click="gotoPast">{{ $t('messages.home.past_date') }}</button>
      {{ $t('messages.home.add_event') }}
    </div>
    <FullCalendar
      class="demo-app-calendar"
      ref="fullCalendar"
      defaultView="dayGridMonth"
      :header="{
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek',
      }"
      :plugins="calendarPlugins"
      :weekends="calendarWeekends"
      :events="calendarEvents"
      :selectable="true"
      @select="handleSelect"
      @eventClick="handleClick"
    />
    <modals-container
      @updated="
        getBookedDates();
        toastMessage();
      "
    />
  </div>
</template>

<script>
import FullCalendar from '@fullcalendar/vue';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import interactionPlugin from '@fullcalendar/interaction';
import EventModal from './EventModal';
import EventCreateModal from './EventCreateModal';

export default {
  components: {
    FullCalendar, // make the <FullCalendar> tag available
  },
  props: ['bookable_id'],
  mounted() {
    this.getBookedDates();
  },
  data: function() {
    return {
      calendarPlugins: [
        // plugins must be defined in the JS
        dayGridPlugin,
        timeGridPlugin,
        interactionPlugin, // needed for dateClick
      ],
      calendarWeekends: true,
      calendarEvents: [], //initial event data
      test: null,
    };
  },
  methods: {
    toggleWeekends() {
      this.calendarWeekends = !this.calendarWeekends; // update a property
    },

    gotoPast() {
      let calendarApi = this.$refs.fullCalendar.getApi(); // from the ref="..."
      calendarApi.gotoDate('2000-01-01'); // call a method on the Calendar object
    },

    handleSelect(arg) {
      console.log(arg);
      this.$modal.show(EventCreateModal, {
        text: 'This is from the component creation',
        event: arg,
        id: this.bookable_id,
      });
    },

    handleClick(arg) {
      console.log(arg);

      this.$modal.show(EventModal, {
        text: 'This is from the component edit',
        event: arg.event,
      });
    },

    getBookedDates() {
      this.calendarEvents = [];
      axios.post('/dates', { id: this.bookable_id }).then((response) => {
        response.data.forEach((element) =>
          this.calendarEvents.push({
            id: element.id,
            title: 'OCCUPIED',
            start: new Date(element.from),
            end: new Date(element.to),
          })
        );
      });
    },

    toastMessage() {
      Vue.$toast.open({
        message: 'CHANGES SAVED!',
        type: 'success',
        position: 'top',
      });
    },
  },
};
</script>

<style lang="scss">
/* you must include each plugins' css */
/* paths prefixed with ~ signify node_modules */
@import '~@fullcalendar/core/main.css';
@import '~@fullcalendar/daygrid/main.css';
@import '~@fullcalendar/timegrid/main.css';

.demo-app {
  font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
  font-size: 14px;
}

.demo-app-top {
  margin: 0 0 3em;
}

.demo-app-calendar {
  margin: 0 auto;
  max-width: 900px;
}

fieldset {
  display: block;
  margin-left: 2px;
  margin-right: 2px;
  padding-top: 0.35em;
  padding-bottom: 0.625em;
  padding-left: 0.75em;
  padding-right: 0.75em;
  border: 2px groove;
}

legend {
  width: 30%;
}
</style>
