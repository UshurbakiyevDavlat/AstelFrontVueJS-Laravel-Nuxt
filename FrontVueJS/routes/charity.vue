<template>
	<div class="charity-page">
		<cert-modal :image="modalImg" />
		<inner-hero
			:liks="breadcrumbs"
			:image="$page().image"
			:title="$page().title"
			:text="$page().description"
		/>
		<div class="layout-container" data-scroll-section>
			<h2 class="charity-page-title" data-on-scroll-paginate>
				{{ $page().title }}
			</h2>
			<div
				class="charity-page-content"
				data-on-scroll-paginate
				v-html="$page().content"
			></div>
			<div class="charity-page-slider-wrp">
				<button class="charity-page-prev" data-on-scroll-paginate>
					<arrow class="charity-page-arrow --desktop" />
					<link-arrow class="charity-page-arrow --mobile" />
				</button>
				<button class="charity-page-next" data-on-scroll-paginate>
					<arrow class="charity-page-arrow --desktop" />
					<link-arrow class="charity-page-arrow --mobile" />
				</button>
				<div v-swiper="options">
					<div class="swiper-wrapper">
						<div
							class="swiper-slide"
							data-on-scroll-paginate
							v-for="(item, index) in $page().images"
							:key="index"
						>
							<img
								:data-src="item"
								v-lazy-load
								alt="Astel image"
								@click="openModal"
							/>
						</div>
					</div>
				</div>
			</div>
		</div>
		<partial-form />
	</div>
</template>

<script>
import arrow from "@/static/icons/arrow.svg";
import linkArrow from "@/static/icons/link-arrow.svg";
import CertModal from "~/components/partials/CertModal";
import InnerHero from "~/components/partials/InnerHero";
import PartialForm from "~/components/partials/PartialForm";
import {gsap} from "gsap";

export default {
	components: {
		arrow,
		linkArrow,
		CertModal,
		InnerHero,
		PartialForm
	},
	data: () => ({
		modalImg: "",
		options: {
			slidesPerView: 4,
			spaceBetween: 50,
			navigation: {
				prevEl: ".charity-page-prev",
				nextEl: ".charity-page-next"
			},
			breakpoints: {
				1024: {
					slidesPerView: 4
				},
				600: {
					slidesPerView: 3
				},
				320: {
					slidesPerView: 2,
					spaceBetween: 30
				}
			}
		}
	}),
	computed: {
		breadcrumbs() {
			return [
				{
					url: this.$pageUrl("charity"),
					text: this.$page("charity").name
				}
			];
		}
	},
	mounted(){
		this.animateOnLoad();
	},
	methods: {
		openModal(e) {
			this.modalImg = e.target.src;
			this.$setTrue("modals.certModal");
		},
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
};
</script>

<style lang="sass">
.charity-page
	.layout-container
		padding-top: 40px
	&-title
		font-size: 24px
		font-weight: 500
		color: $color-blue
		margin-bottom: 40px
	&-content
		*
			font-size: 18px
			font-weight: 300
			color: $color-text
		ul
			list-style-type: disc
			padding-left: 20px
		li
			color: $color-red
	&-slider-wrp
		padding: 0 50px
		position: relative
		margin-top: 40px
		img
			width: 100%
	&-prev,
	&-next
		display: flex
		padding: 0
		background: transparent
		position: absolute
		top: 50%
		transform: translateY(-50%)
		svg
			width: 32px
			height: 32px
		path
			stroke: #B9B9B9
	&-prev
		left: 0px
		.--desktop
			transform: rotate(90deg)
	&-next
		right: 0px
		.--desktop
			transform: rotate(-90deg)
@media (min-width: 320px)
	.charity-page
		.layout-container
			padding: 30px 10px
			padding-bottom: 10px
		&-title
			font-size: 18px
			margin-bottom: 10px
		&-content *
			font-size: 14px
			line-height: 24px
		&-prev,
		&-next
			position: static
			transform: none
			display: flex
			width: 20px
			height: 20px
			svg
				width: 100%
				height: 100%
			path
				stroke: none
				fill: $color-text
		&-prev
			margin-left: auto
			margin-right: 20px
			.--mobile
				transform: rotate(180deg)
		&-arrow
			&.--desktop
				display: none
		&-slider-wrp
			padding: 0
			display: flex
			flex-wrap: wrap
			margin-top: 0
			.swiper-container
				margin-top: 15px
				width: 100%
@media (min-width: 1280px)
	.charity-page
		.layout-container
			padding: 80px 0 0
		&-title
			font-size: 24px
			margin-bottom: 40px
		&-prev,
		&-next
			position: absolute
			transform: translateY(-50%)
			display: flex
			width: auto
			height: auto
			svg
				width: 32px
				height: 32px
			path
				stroke: #B9B9B9
				fill: none
		&-prev
			margin-left: 0
			margin-right: 0
		&-arrow
			&.--desktop
				display: block
			&.--mobile
				display: none
		&-slider-wrp
			padding: 0 50px
			.swiper-container
				margin-top: 0
</style>
