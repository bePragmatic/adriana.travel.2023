<template>
    <div class="counter">
        <button type="button" class="counter__minus" @click='sub'></button>

        <input class="counter__value"
               type="text"
               name="number"
               min="0"
               defaultValue="0"
               :value="result"
        />

        <button type="button" class="counter__plus" @click='add'></button>
    </div>
</template>

<script>
    export default {

        data() {
            return {
                result: 0
            }
        },

        props: {
            value: {
                type: Number,
            },
            max: {
                type: Number,
            },
        },

        created(){
            if (this.value) {
                this.result = parseInt(this.value)
            }
        },
        computed: {
            formatedResult: function () {
                return this.result + ' +'
            }
        },

        methods: {

            emitResult() {
                this.$emit('input', this.result)
            },

            add() {
                this.result =  this.result + 1
                this.emitResult()
            },

            sub() {
                if (this.result > 1) {
                    this.result -= 1
                    this.emitResult()
                }
            }

        }
    }

</script>

<style scoped>

</style>
