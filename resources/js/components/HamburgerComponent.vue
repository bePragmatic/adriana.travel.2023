<template>
    <header class="header">
        <a href="/" class="header__branding"></a>
        <button class="hamburger " type="button" @click="menuOpen()"  v-bind:class="{ active: menu }"></button>
        <nav class="nav" v-bind:class="{ active: menu }">
            <div class="nav__close" @click="menuClose()"></div>

            <slot></slot>

        </nav>
    </header>

</template>

<script>
    export default {


        data() {
            return {
                menu: false,
                lang: 'en',
            }
        },

        methods: {
            menuOpen(){
                this.menu = true
            },

            menuClose() {
                this.menu = false
            }
        }

    }

</script>
