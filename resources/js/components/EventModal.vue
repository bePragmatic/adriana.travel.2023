<template>
        <div>
            <fieldset>
                <legend>Event details</legend>
                <b>Title:</b> {{ event.title }} <br />
                <b>Start:</b> {{ startStr }} <br />
                <b>End:</b> {{ endStr }} <br />
                <b>ID:</b> {{ event.id }} <br />
            </fieldset>

            <fieldset>
                <legend>Edit event</legend>
                <input type="text" v-model="title">
                <input type="date" v-model="start">
                <input type="date" v-model="end">

                <div class="mt-2">
                    <button type="button" class="btn btn-primary" @click="updateEvent">Save</button>
                    <button type="button" class="btn btn-danger" @click="deleteEvent">Delete</button>
                </div>
            </fieldset>
        </div>
</template>

<script>
    export default {
        mounted() {
            this.title = this.event.title;
            this.start = this.formatDate(this.event.start);
            this.end = this.formatDate(this.event.end);
            this.id = this.event.id;
            this.startStr = this.formatDateStr(this.event.start)
            this.endStr = this.formatDateStr(this.event.end)
        },

        data: () => ({
            title: "",
            start: {},
            startStr: "",
            end: {},
            endStr: "",
            id: ""
        }),

        props: {
            text: String,
            event: Object
        },
        methods: {
            formatDate(date) {
                let options = { year: "numeric", month: '2-digit', day: '2-digit' };
                let string = date.toLocaleDateString("sv-SE", options)

                return string;
            },

            formatDateStr(date){
                let options = { year: "numeric", month: '2-digit', day: '2-digit' };
                let string = date.toLocaleDateString("en-GB", options)

                return string;
            },

            updateEvent() {
                if(this.end > this.start){
                    axios.put('/accommodation/{accomodation}', { title: this.title, start: this.start, end: this.end, id: this.id })
                    .then(response => {
                        this.$emit('updated');
                        this.$emit('close');
                    })
                }
                else{
                    Vue.$toast.open({
                        message: 'Ending date can not be equal or less then starting date.',
                        type: 'warning',
                        position: 'top'
                        });
                }
            },

            deleteEvent() {
                axios.delete('/accommodation/{accomodation}', {params: { id: this.id }})
                    .then(response => {
                        this.$emit('updated');
                        this.$emit('close');
                    })
            }

        }
    }
</script>