<template>
	<div class="pagination" v-if="lastPage != 1">
		<nuxt-link :to="getQuery(page - 1 <= 1 ? {} : { page: page - 1 })" class="pagination-prev" v-if="page != 1"><arrow /></nuxt-link>
		<div v-for="i in lastPage" :key="i">
			<nuxt-link @click.native="scrollToTop()" :to="getQuery(i <= 1 ? {} : { page: i })" :class="['pagination-page', {'--active': page == i}]" v-if="Math.abs(i - page) < range || i == 1 || i == lastPage">{{ i }}</nuxt-link>
			<span v-else-if="i != 1 && i != lastPage && Math.abs(i - page) == range">...</span>
		</div>
		<nuxt-link :to="getQuery({ page: page + 1 })" class="pagination-next" v-if="page < lastPage"><arrow /></nuxt-link>
	</div>
</template>

<script>
import arrow from "@/static/icons/arrow.svg"
import { gsap } from "gsap";

export default {
	components: {
		arrow
	},
	props: ['paginator'],
	data() {
		return {
			range: 2
		}
	},
	computed: {
		page: function() {
			return this.$route.query.page ? Math.min(this.lastPage, Math.max(1, this.$route.query.page)) : 1
		},
		lastPage: function() {
			return this.paginator ? this.paginator.last_page : 4
		}
	},
	methods: {
		animateOnLoad() {
			let tl = gsap.timeline();
			let header = document.querySelector(".layout-content");
			let item = header.querySelectorAll("[data-on-scroll-paginate]");
			tl.fromTo(
				item,
				{ opacity: 0, y: 30 },
				{
					opacity: 1,
					y: 0,
					stagger: 0.25,
					delay: 0.5,
					duration: 1.6,
					ease: "elastic",
				}
			);
		},
		getQuery(query) {
            let q = {...this.$route.query}
            delete q.page
            return { query: Object.assign({}, q, query) }
        },
		scrollToTop() {
                window.scrollTo(0,0);
				this.animateOnLoad();
           }
	}
}
</script>

<style lang="sass">
.pagination
	display: flex
	justify-content: center
	align-items: center
	&-prev,
	&-next
		display: flex
		padding: 0
		background: transparent
	&-prev
		margin-right: 10px
		svg
			transform: rotate(90deg)
	&-next
		margin-left: 10px
		svg
			transform: rotate(-90deg)
	&-page
		display: block
		padding: 0 7px
		line-height: 22px
		font-size: 14px
		font-weight: 400
		color: $color-text
		transition: .3s ease
		margin: 0 5px
		&.--active
			color: #fff
			background: $color-blue
</style>
