<template>
	<div class="home-partners" data-scroll-section>
		<div class="layout-container">
			<div class="home-page-title-wrp">
				<h2 class="home-page-title animate-home-partners" data-on-scroll-paginate>
					{{ $page().partners_title }}
				</h2>
			</div>
			<div
				class="page-text animate-home-partners"
				data-on-scroll-paginate
				v-html="$page().partners_content"
			></div>
			<div class="home-partners-slider-wrp">
				<div class="home-partners-nav-wrp animate-home-partners" data-on-scroll-paginate>
					<button class="home-partners-prev"><arrow /></button>
					<button class="home-partners-next"><arrow /></button>
				</div>
				<div v-swiper="options">
					<div class="swiper-wrapper">
						<component
							:is="partner.link ? 'a' : 'div'"
							:href="partner.link"
							class="swiper-slide animate-home-partners"
							data-on-scroll-paginate
							v-for="(partner, index) in $page().partners"
							:key="index"
						>
							<img :data-src="partner.image" v-lazy-load :alt="partner.name" />
						</component>
					</div>
				</div>
			</div>
			<div class="home-partners-row">
				<component
					:is="item.link ? 'a' : 'div'"
					:href="item.link"
					class="home-partners-col animate-home-partners"
					data-on-scroll-paginate
					v-for="(item, index) in $page().partners"
					:key="index"
				>
					<img :data-src="item.image" v-lazy-load :alt="item.name" />
				</component>
			</div>
		</div>
	</div>
</template>

<script>
import arrow from "@/static/icons/link-arrow.svg";
import {gsap} from "gsap";
export default {
	components: {
		arrow
	},
	props: ['timeline'],
	data() {
		return {
			options: {
				slidesPerView: 4,
				spaceBetween: 20,
				watchSlidesVisibility: true,
				navigation: {
					prevEl: ".home-partners-prev",
					nextEl: ".home-partners-next"
				}
			}
		};
	},
	mounted(){
		this.animateOnLoad();
	},
	methods: {
		animateOnLoad() {
			//let tl = this.timeline;
			//let tl = gsap.timeline();
			let tl = gsap;
			//let header = document.querySelector(".layout-content");
			let item = document.querySelectorAll(".animate-home-partners");
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
.home-partners
	background: $bg-base
	padding: 134px 0 90px
	.swiper-container
		width: calc( 100% + 40px )
		padding: 0 20px
		margin-left: -20px
	.swiper-slide
		height: 207px
		box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.05)
		background: #fff
		display: flex
		align-items: center
		justify-content: center
		opacity: 0
		margin-bottom: 20px
		transition: opacity .3s ease
		img
			max-width: 110px
			max-height: 110px
		&-visible
			opacity: 1
	&-prev,
	&-next
		padding: 0
		background: transparent
		width: 46px
		height: 46px
		background: #fff
		border-radius: 999px
		display: flex
		align-items: center
		justify-content: center
		svg
			width: 20px
			height: 20px
		path
			fill: $color-text
	&-prev
		margin-right: 20px
		svg
			transform: rotate(180deg)
	&-nav-wrp
		display: flex
		align-items: center
		justify-content: flex-end
		margin-bottom: 14px
		margin-top: 77px
@media (min-width: 320px)
	.home-partners
		padding: 40px 10px
		&-slider-wrp
			display: none
		&-row
			display: flex
			flex-wrap: wrap
		&-col
			width: calc(50% - 10px)
			margin-right: 20px
			margin-top: 20px
			background: #fff
			box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.05)
			height: 140px
			display: flex
			align-items: center
			justify-content: center
			&:nth-child(even)
				margin-right: 0
			img
				max-width: 80px
				max-height: 80px
@media (min-width: 1024px)
	.home-partners
		&-col
			width: calc(33.3% - 13px)
			&:nth-child(even)
				margin-right: 20px
			&:nth-child(3n)
				margin-right: 0
@media (min-width: 1280px)
	.home-partners
		padding: 110px 0 90px
		&-row
			display: none
		&-slider-wrp
			display: block
</style>
