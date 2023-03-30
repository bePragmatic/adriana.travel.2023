<template>

    <div class="card-body">
        <div v-if="success != ''" class="alert alert-success" role="alert">
            {{success}}
        </div>
        <form @submit="formSubmit" enctype="multipart/form-data">

            <img :src="data.src" alt="">

            <input type="file" class="form-control" v-on:change="onImageChange">

            <button class="btn btn-success">Submit</button>

        </form>
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
                image: '',
                success: ''
            };
        },

        methods: {
            onImageChange(e) {
                console.log(e.target.files[0]);
                this.image = e.target.files[0];
            },
            formSubmit(e) {
                e.preventDefault();
                let currentObj = this;

                const config = {
                    headers: {'content-type': 'multipart/form-data'}
                }

                let formData = new FormData();
                formData.append('image', this.image);

                axios.post('/admin/posts/' + this.data.id + '/image', formData, config)
                    .then(function (response) {
                        currentObj.success = response.data.success;
                    })
                    .catch(function (error) {
                        currentObj.output = error;
                    });
            }
        }
    }
</script>
