<template>
    <div>
        <fieldset>
            <legend>Create event</legend>
            <b>Title:</b> <input type="text" v-model="title"> <br />
            <b>Start:</b> <input type="date" v-model="start"> <br />
            <b>End:</b> <input type="date" v-model="end"> <br />

            <div class="mt-2">
            <button type="button" class="btn btn-primary" @click="createEvent">Save</button>
            </div>
        </fieldset>
    </div>
</template>

<script>
    export default {
        mounted() {
            this.start = this.formatDate(this.event.start);
            this.end = this.formatDate(this.event.end);
        },

        data: () => ({
            title: "",
            start: {},
            end: {},
        }),

        props: {
            text: String,
            event: Object,
            id: Number
        },
        methods: {
            formatDate(date) {
                let options = { year: "numeric", month: '2-digit', day: '2-digit' };
                let string = date.toLocaleDateString("sv-SE", options)

                return string;
            },

            createEvent(){
                const newEvent = {
                        title: this.title,
                        start: this.start,
                        end: this.end,
                        allDay: true,
                        id: this.id
                    }
                if(this.end > this.start){
                    axios.post('/accommodation', newEvent)
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
        }
    }
}
</script>