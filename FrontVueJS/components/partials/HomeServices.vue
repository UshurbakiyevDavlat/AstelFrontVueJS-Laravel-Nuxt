<template>
	<div class="home-services" data-scroll-section>
		<div class="layout-container">
			<div class="home-page-title-wrp">
				<h2 class="home-page-title animate-home-services" data-on-scroll-paginate>{{ $page().services_title }}</h2>
			</div>
			<div class="page-text animate-home-services" data-on-scroll-paginate v-html="$page().services_content"></div>
			<services-items :services="$page().services" />
		</div>
	</div>
</template>

<script>
import ServicesItems from "~/components/partials/ServicesItems";
import {gsap} from "gsap";

export default {
	components: {
		ServicesItems
	},
	props: ['timeline'],
	mounted(){
		this.animateOnLoad();
	},
	methods: {
		animateOnLoad() {
			//let tl = this.timeline;
			//let tl = gsap.timeline();
			let tl = gsap;
			//let header = document.querySelector(".layout-content");
			let item = document.querySelectorAll(".animate-home-services");
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
.home-services
	padding: 110px 0
.home-page-title
	margin-bottom: 2.5rem
	@media (max-width: 556px)
		margin-bottom: 1rem
@media (min-width: 320px)
	.home-services
		padding: 30px 0
		.page-text,
		.home-page-title-wrp
			padding: 0 10px
		.services-items
			padding: 0 10px
@media (min-width: 1280px)
	.home-services
		padding: 110px 0
		.page-text,
		.home-page-title-wrp
			padding: 0
		.services-items
			padding: 0
</style>
