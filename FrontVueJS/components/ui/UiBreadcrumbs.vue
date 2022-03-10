<template>
	<div class="breadcrumbs" :class="{ '--dark': dark }">
		<nuxt-link to="/">{{ $page("home").name }}</nuxt-link>
		<div v-for="(link, index) in links" :key="index">
			<arrow />
			<nuxt-link :to="link.url">{{ link.text }}</nuxt-link>
		</div>
	</div>
</template>

<script>
import arrow from "@/static/icons/arrow.svg";
export default {
	props: {
		dark: Boolean,
		links: {
			type: Array,
			default: function() {
				[];
			}
		}
	},
	components: {
		arrow
	}
};
</script>

<style lang="sass">
.breadcrumbs
	display: flex
	align-items: center
	flex-wrap: wrap
	&.--dark
		a
			color: $color-text
		path
			stroke: $color-text
	a
		font-size: 12px
		font-weight: 300
		color: #fff
	svg
		margin: 0 30px
		transform: rotate(-90deg)
		path
			stroke: #fff
@media (min-width: 320px)
	.breadcrumbs
		display: none
@media (min-width: 1280px)
	.breadcrumbs
		display: flex
</style>
