<template>

    <div class="col-sm-6">
        <input type="text" v-model="subname" class="form-control" id="sub_name" placeholder="Sub Name">
        <button class="btn btn-success" @click.prevent="change">Update</button>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        },

        props: ['data'],

        data() {
            return {
                subname: this.data.sub_name,
                success: ''
            };
        },

        methods: {

            change() {

                axios.put('/admin/room/' + this.data.id + '/subname', {subname: this.subname})
                    .then(function (response) {

                        alert('Sub name sucessfully changed!')
                    })
                    .catch(function (error) {
                    });
            }
        }
    }
</script>
