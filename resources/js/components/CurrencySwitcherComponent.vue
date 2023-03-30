<template>
    <div class="nav__lang-select">
        <div class="nav__lang">{{ defualt.toUpperCase() }}</div>
        <ul class="nav__lang-popover">
            <li>
                <a class="" href="#" @click.prevent="changeCurrency('EUR')" v-bind:class="[defualt =='EUR' ? 'active' : '']">
                    EUR
                </a>
            </li>
            <li>
                <a href="#" @click.prevent="changeCurrency('USD')" v-bind:class="[defualt =='USD' ? 'active' : '']">
                    USD
                </a>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {

        props:['defualt'],


        methods: {
            changeCurrency(lang){
                axios.post('/set_session',  {"currency": lang,"previous_currency": this.default } );
                location.reload()
            }
        }
    }
</script>

<style scoped>

</style>
