<template>

    <div>
        <div class="pagination__btns">
            <button
                    type="button"
                    class="pagination__btn pagination__btn--left"
                    v-if="pagination.current_page > 1"
                    @click.prevent="changePage(pagination.current_page - 1)"
            />

            <div class="pagination__pages">

                <span v-for="page in pagesNumber" class="pagination__page"
                      :class="{'pagination__page--active': page == pagination.current_page}">
                    <a href="javascript:void(0)" @click.prevent="changePage(page)">{{ page }}</a>
                </span>

               <!-- <span class="pagination__dots">...</span>-->

            </div>

            <button
                    type="button"
                    class="pagination__btn pagination__btn--right"
                    v-if="pagination.current_page < pagination.last_page"
                    @click.prevent="changePage(pagination.current_page + 1)"

            />
        </div>


        <p class="pagination__results">
            showing {{ pagination.from }} - {{ pagination.to }} of {{ pagination.total }} results
        </p>


    </div>


</template>
<script>
    export default {
        props: {
            pagination: {
                type: Array,
                required: true
            },
            offset: {
                type: Number,
                default: 4
            }
        },
        computed: {
            pagesNumber() {
                if (!this.pagination.to) {
                    return [];
                }
                let from = this.pagination.current_page - this.offset;
                if (from < 1) {
                    from = 1;
                }
                let to = from + (this.offset * 2);
                if (to >= this.pagination.last_page) {
                    to = this.pagination.last_page;
                }
                let pagesArray = [];
                for (let page = from; page <= to; page++) {
                    pagesArray.push(page);
                }
                return pagesArray;
            }
        },
        methods: {
            changePage(page) {
                this.pagination.current_page = page;
                Event.$emit('paginate', page);
            }
        }
    }
</script>