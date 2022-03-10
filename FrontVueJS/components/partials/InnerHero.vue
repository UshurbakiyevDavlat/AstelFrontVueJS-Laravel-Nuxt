<template>
	<div class="inner-hero">
		<div class="inner-hero-left">
			<ui-breadcrumbs data-on-scroll-paginate :links="links" />
			<button
				class="inner-hero-back-btn"
				@click="$router.back()"
				data-on-scroll-paginate
			>
				<arrow />
				{{ $trans("Назад") }}
			</button>
			<h1 class="inner-hero-title" data-on-scroll-paginate>{{ title }}</h1>
			<p class="inner-hero-text" data-on-scroll-paginate>{{ text }}</p>
		</div>
		<img :data-src="image" v-lazy-load v-if="image" :alt="title" class="inner-hero-img" />
	</div>
</template>

<script>
import arrow from "@/static/icons/arrow.svg";
import UiBreadcrumbs from "~/components/ui/UiBreadcrumbs";
import {gsap} from "gsap";

export default {
	components: {
		arrow,
		UiBreadcrumbs
	},
	props: ["links", "image", "title", "text", "timeline"],
	mounted(){
		this.animateOnLoad();
	},
	methods: {
		animateOnLoad() {
			//let tl = this.timeline;
			let tl = gsap;
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
};
</script>

<style lang="sass">
.inner-hero
	position: relative
	background: $color-red
	height: 60vh
	&-left
		background: $color-blue
		height: 100%
		width: 55%
		padding-top: 40px
		padding-left: 50px
	&-img
		position: absolute
		right: 0
		top: 0
		width: 50%
		height: 90%
		object-fit: cover
	&-title
		color: #fff
		font-size: 42px
		font-weight: 600
		margin-top: 150px
		margin-bottom: 23px
	&-text
		font-size: 18px
		font-weight: 300
		max-width: 546px
		color: #fff
@media (min-width: 320px)
	.inner-hero
		height: auto
		padding-bottom: 15px
		&-back-btn
			border-radius: 20px
			background: #F1F1F1
			display: flex
			align-items: center
			justify-content: center
			line-height: 36px
			width: 120px
			font-size: 14px
			font-weight: 500
			color: $color-text
			svg
				transform: rotate(90deg)
				margin-right: 10px
		&:after
			content: ''
			width: 25%
			height: 30px
			background: $color-blue
			position: absolute
			left: 0
			bottom: 0
		&-left
			padding: 20px 10px
			width: 100%
			height: auto
		&-title
			margin-top: 30px
			font-size: 18px
		&-text
			font-size: 14px
		&-img
			position: relative
			z-index: 1
			width: 100%
			height: 35vh
@media (min-width: 1280px)
	.inner-hero
		min-height: 60vh
		padding-bottom: 0
		display: flex
		&:after,
		&-back-btn
			display: none
		&-left
			padding: 40px 0 0 50px
			width: 55%
			height: auto
		&-title
			margin-top: 150px
			font-size: 36px
		&-text
			font-size: 16px
		&-img
			position: absolute
			z-index: 1
			width: 50%
			height: 90%
</style>
