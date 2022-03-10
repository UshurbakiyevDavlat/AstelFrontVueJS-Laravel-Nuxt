<template>

	<div class="start-hero">
		<div v-show="notificationIsShow" class="preloader"></div>
		<carousel :responsive="responsive">
			<div v-for="n of 5" :key="n" v-if="$page()['image'+`${n}`] && locales[locale] === 'Ru'">
				<div v-if="small">
					<img width="456" height="520" :src="$page()['imageMobile'+`${n}`]">
				</div>
				<div v-else>
					<img width="1366" height="100%" class="hero_main_img" :src="$page()['image'+`${n}`]">
				</div>
				<div class="hero_main_wrap">
					<h1 class="hero_main_title">{{ $page()['title'+`${n}`] }}</h1>
					<!-- <h2 class="hero_main_subtitle">{{ $page()['subtitle'+`${n}`] }}</h2> -->
					<div class="hero_main_text">
						<p>{{ $page()['description'+`${n}`] }}</p>
					</div>
					<component
						:is="isSameHost($page()['link'+`${n}`]) ? 'nuxt-link' : 'a'"
						:href="isSameHost($page()['link'+`${n}`]) ? $url($page()['link'+`${n}`]) : $page()['link'+`${n}`]"
						:to="$url($page()['link'+`${n}`])" class="hero_main_btn buttonHome --blue animate-home-hero buttonHome-hover"
						data-on-scroll-paginate
						v-if="$page()['link'+`${n}`]">{{ $trans('Подробнее') }}
					</component>
				</div>
			</div>

			<div v-for="n of 5" :key="n" v-if="$page()['image'+`${n}`] != null && $page()['image'+`${n}`][0] != 'h' && locales[locale] !== 'Ru'">
				<div v-if="small">
					<img width="456" height="520" :src="$page()['imageMobile'+`${n}`]">
				</div>
				<div v-else>
					<img width="1366" height="100%" class="hero_main_img" :src="$page()['image'+`${n}`]">
				</div>
				<div class="hero_main_wrap">
					<h1 class="hero_main_title">{{ $page()['title'+`${n}`] }}</h1>
					<!-- <h2 class="hero_main_subtitle">{{ $page()['subtitle'+`${n}`] }}</h2> -->
					<div class="hero_main_text">
						<p>{{ $page()['description'+`${n}`] }}</p>
					</div>
					<component
						:is="isSameHost($page()['link'+`${n}`]) ? 'nuxt-link' : 'a'"
						:href="isSameHost($page()['link'+`${n}`]) ? $url($page()['link'+`${n}`]) : $page()['link'+`${n}`]"
						:to="$url($page()['link'+`${n}`])" class="hero_main_btn buttonHome --blue animate-home-hero buttonHome-hover"
						data-on-scroll-paginate
						v-if="$page()['link'+`${n}`]">{{ $trans('Подробнее') }}
					</component>
				</div>
			</div>
		</carousel>
	</div>

</template>


<script>
import {gsap} from "gsap";
import {mapGetters} from "vuex";

export default {
	props: ['timeline'],
	computed: {
		...mapGetters({
			locale: 'translation/GET_LOCALE',
			locales: 'translation/GET_LOCALES'
		}),
	},
	created() {
		if (process.browser){
			window.addEventListener('resize', this.onResize);
    		this.onResize();
		}
	},

	destroyed() {
   		window.removeEventListener('resize', this.onResize)
  	},

	mounted() {
		this.hideNotification();
	},

	data() {
		return {
			responsive: {
				568: {
					items: 1,
					nav: true,
					navText: ["&#10094;", "&#10095;"],
					loop: true,
					interval: false,
					autoplay: true,
					autoplayHoverPause: true,
					autoplaySpeed: 3200,
					autoplayTimeout: 3200,
					smartSpeed: 1200,
					lazyLoad: true,
				},
				0: {
					items: 1,
					nav: true,
					navText: ["&#10094;", "&#10095;"],
					loop: true,
					interval: false,
					autoplay: false,
					autoplayHoverPause: false,
					smartSpeed: 500,
					lazyLoad: true,
				},
			},
			notificationIsShow: true,
			small: false,
		}
	},

	methods: {
		onResize() {
        	this.small = window.innerWidth <= 600;
    	},

		hideNotification () {
        	setTimeout(() => {
				this.notificationIsShow = false
			}, 1000);
		},

		getMime(url) {
			let chunks = url.split('.')
			return `video/${chunks[chunks.length - 1]}`
		},

		isSameHost(url) {
			return !url.startsWith('http')
		},

		animateOnLoad() {
			let tl = gsap;
			let header = document.querySelector(".layout-content");
			let item = document.querySelectorAll(".animate-home-hero");
			tl.fromTo(
				item,
				{opacity: 0, y: 30},
				{
					opacity: 1,
					y: 0,
					stagger: 0.25,
					delay: 0.1,
					duration: 2.6,
					ease: "elastic",
				},
				'hero'
			);
		}
	}
};
</script>

<style lang="sass">
.start-hero
	position: relative
	min-height: 50vh

.owl-theme .owl-nav [class*='owl-']
	display: flex!important
	justify-content: center!important
	align-items: center!important
	border-radius: 50%!important
	border: 1px solid #2c2c2c!important
	color: #2c2c2c!important
	background: none!important
	@media (max-width: 556px)
		display: none!important

.owl-prev,
.owl-next
	position: absolute
	width: 70px
	height: 70px
	top: calc(50% - 35px)

.owl-next
	right: 2rem
.owl-prev
	left: 2rem

.preloader
	position: absolute
	overflow-x: hidden
	width: 100%
	height: calc(150vh - 9rem)
	top: -1.6rem
	left: 0
	background: #fff
	z-index: 1000
	@media (max-width: 556px)
		top: 0
		height: 100vh

.hero_main_wrap
	position: absolute
	top: 10rem
	left: 13rem
	@media (max-width: 556px)
		top: 3.3rem
		left: 1rem
		height: 50vh
		object-fit: cover

.hero_main_img
	@media (max-width: 556px)
		height: 50vh
		object-fit: cover

.hero_main_title
	width: 450px
	margin-bottom: 1rem
	color:#bf0d0d
	@media (max-width: 556px)
		width: 320px
		font-size: 20px

.hero_main_subtitle
	width: 450px
	margin-bottom: 1rem
	color: #fff
	@media (max-width: 556px)
		width: 320px
		margin-bottom: 0
		font-size: 20px

.hero_main_text
	p
		width: 420px
		font-size: 21px
		@media (max-width: 556px)
			width: 80%
			font-size: 16px

.hero_main_btn
	@media (max-width: 556px)
		margin: 0
		margin-top: 2rem
		line-height: 30px


.home-hero
	position: relative

	&-bg-video
		position: absolute
		top: 0
		left: 0
		width: 100%
		height: 100%
		object-fit: cover

	&-inner
		position: relative
		z-index: 1
		background: rgba(#000, 0.3)
		min-height: calc(100vh - 140px)
		display: flex
		align-items: center
		justify-content: center

	&-subtitle
		color: #fff
		font-size: 14px
		font-weight: 700
		margin-bottom: 20px

	&-title
		color: #fff
		font-size: 48px
		font-weight: 700
		max-width: 706px
		margin-bottom: 20px
		line-height: 59px

	&-text
		max-width: 609px
		font-size: 18px
		font-weight: 300
		color: #fff
		margin-bottom: 20px


@media (min-width: 320px)
	.home-hero
		&-inner
			padding: 40px 10px
			min-height: 50vh

		&-title
			font-size: 20px
			line-height: initial
			margin-bottom: 15px

		&-text
			font-size: 14px

		&-subtitle,
		&-text
			margin-bottom: 15px

@media (min-width: 1280px)
	.home-hero
		&-inner
			padding: 0
			min-height: calc(100vh - 120px)

		&-title
			font-size: 36px
			margin-bottom: 15px

		&-text
			font-size: 16px

		&-subtitle,
		&-text
			margin-bottom: 15px
</style>
