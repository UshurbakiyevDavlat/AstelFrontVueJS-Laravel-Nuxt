<template>
	<div class="services-page" data-scroll-section>
		<ui-breadcrumbs :links="breadcrumbs" data-on-scroll-paginate :dark="true" />
		<div class="layout-container">
			<h1 class="services-page-title" data-on-scroll-paginate>{{ $page().title }}</h1>
			<div class="services-page-tab">
				<div class="page-text" data-on-scroll-paginate v-html="$page().content"></div>
				<services-items :services="$page().services" />
			</div>
		</div>
	</div>
</template>

<script>
import UiBreadcrumbs from "~/components/ui/UiBreadcrumbs";
import ServicesItems from "~/components/partials/ServicesItems";
import {gsap} from "gsap";

export default {
	components: {
		UiBreadcrumbs,
		ServicesItems
	},
	computed: {
		breadcrumbs() {
			return [
				{
					url: this.$pageUrl("services"),
					text: this.$page("services").title,
				},
			]
		},
	},
	mounted(){
		this.animateOnLoad();
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
					duration: 2.6,
					ease: "elastic",
				}
			);
		}
	}
}
</script>

<style lang="sass">
.services-page
	padding: 40px 50px
	.page-text
		max-width: 1000px
		margin-bottom: 3rem
	&-title
		font-size: 36px
		font-weight: 500
		color: $color-blue
		margin-top: 50px
		margin-bottom: 30px
	.button
		transition: .4s ease
		margin-right: 17px
		margin-bottom: 17px
		&:hover
			color: #fff
			background: $color-blue
@media (min-width: 320px)
	.services-page
		padding: 30px 10px 13px
		&-title
			font-size: 18px
			margin: 30px 0
		.button
			padding: 0 15px
@media (min-width: 1280px)
	.services-page
		padding: 40px 50px
		&-title
			font-size: 36px
			margin-bottom: 40px
			margin-top: 50px
</style>
