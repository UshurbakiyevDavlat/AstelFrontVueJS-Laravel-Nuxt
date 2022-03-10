<template>
	<div class="services-items">
		<div class="services-items-item animate-home-services" data-on-scroll-paginate
			v-for="(item, index) in services" :key="index">
			<div class="services-item-wrap">
				<h4 class="services-items-title">{{ item.name }}</h4>
				<component style="z-index: 999;position: relative;"
						:is="isSameHost($pageUrl('services', item.slug)) ? 'nuxt-link' : 'a'"
						:href="isSameHost($pageUrl('services', item.slug)) ? ($pageUrl('services', item.slug)) : $pageUrl('services', item.slug)"
						:to="($pageUrl('services', item.slug))" class="buttonMain --transparent animate-home-hero buttonMain-hover"
						data-on-scroll-paginate
						v-if="item.serviceImages !== null" >
						{{ $trans('Подробнее') }}
					<!-- <svg width="9" height="6" viewBox="0 0 9 6" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1 1l3.5 3.5L8 1" stroke="#fff" stroke-linecap="round"></path></svg> -->
				</component>
				<img class="service__item-img" :src="getSrcServiceImage(item.serviceImages)" alt="item.serviceImages">
			</div>
		</div>
	</div>
</template>

<script>
import { gsap } from "gsap";
import arrow from "@/static/icons/link-arrow.svg"

export default {
	components: {
		arrow,
	},
	props: {
		services: {
			type: Array,
			default: () => []
		},
		timeline: {
			default: null
		}
	},
	data() {
		return {
			urlForImg: 'https://demo-admin.astel.kz/storage/',
			fullUrlImg: '',
			options: {
				slidesPerView: 1,
				spaceBetween: 10,
				watchSlidesVisibility: true,
				navigation: {
					prevEl: ".services-items-prev",
					nextEl: ".services-items-next",
				},
				breakpoints: {
					1024: {
						slidesPerView: 3,
					},
					600: {
						slidesPerView: 2,
					},
				},
			}
		}
	},
	mounted(){
		// this.animateOnLoad();
	},
	methods: {
		getSrcServiceImage (item) {
			let fullUrlImg;
			fullUrlImg =  this.urlForImg.concat(item)
			if (item === null) return ""
			return fullUrlImg;
		},
		getMime(url) {
			let chunks = url.split('.')
			return `video/${chunks[chunks.length - 1]}`
		},
		isSameHost(url) {
			return !url.startsWith('http')
		},
		animateOnLoad() {
			//let tl = gsap.timeline();
			let tl = gsap;
			let header = document.querySelector(".layout-content");
			let item = header.querySelectorAll(".animate-home-services");
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
.services-items
	display: flex
	@media (max-width: 456px)
		justify-content: center
	&-item
		width: 100%
		max-width: calc(25% - 16px)
		margin-right: 16px
		margin-bottom: 17px
		box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.07)
		background: #fff
		padding: 23px 27px
		transition: background .4s ease
		&:hover
			.services-items-title,
			.services-items-go-to span
				color: #fff
			.services-items-go-to path
				fill: #fff
			.services-items-icon
				background: #10398D
			.services-items-icon-red
				opacity: 0
			.services-items-icon-arrow
				opacity: 1
	&-go-to
		display: flex
		align-items: center
		span
			transition: color .4s ease
			font-size: 12px
			font-weight: 300
			text-decoration: underline
			color: $color-red
		svg
			margin-left: 5px
		path
			transition: fill .4s ease
			fill: $color-red
	&-icon
		width: 48px
		height: 48px
		border-radius: 999px
		background: $color-red
		position: relative
		display: flex
		align-items: center
		justify-content: center
		margin-top: 32px
		transition: background .4s ease
		&-red
			transition: opacity .4s ease
			width: 26px
			height: 26px
		&-arrow
			position: absolute
			top: 50%
			left: 50%
			transform: translate(-50%, -50%)
			z-index: 1
			transition: opacity .4s ease
			opacity: 0
@media (min-width: 320px)
	.services-items
		flex-wrap: wrap
		&-item
			max-width: 100%
			margin-right: 0
@media (min-width: 700px)
	.services-items
		&-item
			max-width: 49%
			&:nth-child(odd)
				margin-right: 2%
@media (min-width: 1280px)
	.services-items
		&-item
			max-width: calc(33.3% - 16px)
			margin-right: 16px
			
		&-title
			min-height: 50px
.services-items-item.animate-home-services
	width: 16em
	padding: 25px 25px
	color: #fff
	height: 21em
	margin: 0em 1.8em 1.8em 0
	border-radius: 20px
	position: relative
	box-shadow: 5px 5px 5px #8e8a8a
	background: linear-gradient(50deg, #00236d, #003bb7)
	@media (max-width: 456px)
		margin: 1em 0
	
.services-item-wrap
	position: absolute
	top: 0
	left: 0
	right: 0
	padding: 25px 24px 25px 25px
	bottom: 0
	background: url(https://demo-admin.astel.kz/elfinder/connector?cmd=file&target=fls1_0YPRgdC70YPQs9C4L2NlbGxfYmdfYi5wbmc&_t=1642614210&_token=)
	background-position: 0 0
	background-size: 100%
	background-repeat: no-repeat

.services-items-item.animate-home-services:nth-child(4n),
.services-items-item.animate-inner-services:nth-child(4n)
	margin-right: 0
	@media (max-width: 1280px)
		margin-right: 1.8em
	@media (max-width: 456px)
		margin-right: 0
.services-items-item.animate-inner-services
	width: 15em
	padding: 25px 25px
	color: #fff
	height: 12.4444em
	margin: 0em 1.8em 1.8em 0
	border-radius: 20px
	position: relative
	box-shadow: 5px 5px 5px #8e8a8a
	background-size: 100%
	background: #01286b

.services-items-title
	position: relative
	max-width: 75%
	min-height: auto
	display: block
	margin: 0 0 1em
	font-size: 16px
	line-height: 1.5
	color: #fff
	font-weight: 400
	transition: color .4s ease

.services-items-item.animate-home-services:last-child h4
	max-width: 100%

.services-items-item a
	display: block
	width: fit-content
	position: relative
.services-items-item.animate-inner-services a
	position: absolute !important
    bottom: 25px
.services-items-item .service__item-img
	position: absolute
	height: 60%
	border-radius: 20px
	bottom: 0
	right: 0
	z-index: 0
.services-category .services-items-title
	position: relative !important
</style>
