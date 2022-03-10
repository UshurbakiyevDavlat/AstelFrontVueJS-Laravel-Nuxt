<template>
	<div class="certificates-page">
		<cert-modal :image="modalImg" />
		<inner-hero :links="breadcrumbs" :image="$page().image" :title="$page().title" :text="$page().description" />
		<div class="layout-container">
			<div data-scroll-section>
				<h2 class="certificates-page-title" data-on-scroll-paginate>{{ $trans('Лицензии') }}</h2>
				<div class="certificates-page-dropdown --mb">
					<div class="page-text" data-on-scroll-paginate v-html="$page().license_content"></div>
					<div class="certificates-page-btn-wrp" data-on-scroll-paginate>
						<button class="certificates-page-prev license-prev"><arrow /></button>
						<button class="certificates-page-next license-next"><arrow /></button>
					</div>
					<div v-swiper:licenseSlider="licenseOptions" data-on-scroll-paginate>
						<div class="swiper-wrapper">
							<div class="swiper-slide" v-for="(item, index) in $page().licenses" :key="index">
								<img :data-src="item.image" v-lazy-load :alt="item.name" class="certificates-page-img" @click="openModal">
								<p class="certificates-page-text">{{ item.name }}</p>
							</div>
						</div>
					</div>
					<div class="certificates-page-row">
						<div class="certificates-page-col" data-on-scroll-paginate v-for="(item, index) in $page().licenses" :key="index">
							<img :data-src="item.image" v-lazy-load :alt="item.name" class="certificates-page-img" @click="openModal">
							<p class="certificates-page-text">{{ item.name }}</p>
						</div>
					</div>
				</div>
			</div>
			<div data-scroll-section>
				<h2 class="certificates-page-title" data-on-scroll-paginate>{{ $trans('Сертификаты') }}</h2>
				<div class="certificates-page-dropdown">
					<div class="page-text" v-html="$page().certificate_content" data-on-scroll-paginate></div>
					<div class="certificates-page-btn-wrp" data-on-scroll-paginate>
						<button class="certificates-page-prev certs-prev"><arrow /></button>
						<button class="certificates-page-next certs-next"><arrow /></button>
					</div>
					<div v-swiper:certsSlider="certsOptions" data-on-scroll-paginate>
						<div class="swiper-wrapper">
							<div class="swiper-slide" v-for="(item, index) in $page().certificates" :key="index">
								<img :data-src="item.image" v-lazy-load :alt="item.name" class="certificates-page-img" @click="openModal">
								<p class="certificates-page-text">{{ item.name }}</p>
							</div>
						</div>
					</div>
					<div class="certificates-page-row">
						<div class="certificates-page-col" data-on-scroll-paginate v-for="(item, index) in $page().certificates" :key="index">
							<img :data-src="item.image" v-lazy-load :alt="item.name" class="certificates-page-img" @click="openModal">
							<p class="certificates-page-text">{{ item.name }}</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
import arrow from "@/static/icons/link-arrow.svg";
import CertModal from "~/components/partials/CertModal";
import InnerHero from "~/components/partials/InnerHero";
import {gsap} from "gsap";

export default {
	components: {
		arrow,
		CertModal,
		InnerHero
	},
	data: () => ({
		modalImg: "",
		licenseOptions: {
			slidesPerView: 2,
			spaceBetween: 30,
			autoHeight: true,
			navigation: {
				prevEl: ".license-prev",
				nextEl: ".license-next",
			},
			breakpoints: {
				700: {
					slidesPerView: 3,
				},
			},
		},
		certsOptions: {
			slidesPerView: 2,
			autoHeight: true,
			spaceBetween: 30,
			navigation: {
				prevEl: ".certs-prev",
				nextEl: ".certs-next",
			},
			breakpoints: {
				700: {
					slidesPerView: 3,
				},
			},
		},
	}),
	computed: {
		breadcrumbs() {
			return [
				{
					url: this.$pageUrl('certificates'),
					text: this.$page('certificates').name
				}
			]
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
.certificates-page
	.layout-container
		padding: 80px 0
	&-title
		font-size: 24px
		font-weight: 500
		color: $color-blue
		margin-right: 10px
	&-dropdown
		margin-top: 40px
		&.--mb
			margin-bottom: 68px
	&-row
		display: flex
		flex-wrap: wrap
	&-col
		width: 207px
		margin-right: 95px
		margin-top: 48px
		cursor: pointer
		&:nth-child(4n)
			margin-right: 0
	&-img
		width: 100%
		height: 292px
		object-fit: cover
		margin-bottom: 20px
	&-text
		font-size: 14px
		font-weight: 300
		color: $color-text
@media (min-width: 320px)
	.certificates-page
		&-row
			display: none
		.layout-container
			padding: 30px 10px
		&-title
			font-size: 18px
			margin-right: 0
		&-dropdown
			margin-top: 30px
			&.--mb
				margin-bottom: 30px
		&-img
			height: auto
		&-btn-wrp
			margin: 10px 0 20px
			display: flex
			justify-content: flex-end
		&-prev
			margin-right: 20px
			svg
				transform: rotate(180deg)
		&-prev,
		&-next
			display: flex
			padding: 0
			width: 20px
			height: 20px
			background: transparent
			path
				fill: $color-text
			svg
				width: 100%
				height: 100%
@media (min-width: 1280px)
	.certificates-page
		&-row
			display: flex
		.swiper-container,
		&-btn-wrp
			display: none
		&-col
			margin-right: 89px
		.layout-container
			padding: 80px 0
		&-title
			font-size: 24px
		.--mb
			margin-bottom: 68px
		&-dropdown
			margin-top: 40px
</style>
