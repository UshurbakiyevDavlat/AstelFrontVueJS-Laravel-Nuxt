<template>
    <component :is="component" />
</template>

<script>
import { mapGetters } from 'vuex'

export default {
    middleware: [],
    computed: {
        ...mapGetters({
            page: 'page/GET_PAGE',
        })
    },
    head() {
        if (this.page) {
            let seo = this.$get_seo_tags(this.page)
            for(let key in seo) {
                if (!seo[key]) {
                    delete seo[key]
                }
            }

            return seo
        }
    },
    beforeCreate() {
        this.component = () => import(`@/routes/${this.page.component}`)
    }
}

</script>
