<template>
	<div class="home-news" data-scroll-section>
		<div class="layout-container">
			<div class="home-page-title-wrp .animate-home-news" data-on-scroll-paginate>
				<h2 class="home-page-title">{{ $page('blog').name }}</h2>
				<nuxt-link class="home-news-link" :to="$pageUrl('blog')">
					<span>{{ $trans('Все новости') }}</span>
					<link-arrow />
				</nuxt-link>
			</div>
			<div class="home-news-row">
				<div class="home-news-col .animate-home-news" data-on-scroll-paginate v-if="mainPost">
					<img :data-src="mainPost.image" v-lazy-load :alt="mainPost.name" class="home-news-img">
					<p class="home-news-date">{{ $format_date(mainPost.published_at, 'DD.MM.Y') }}</p>
					<h4 class="home-news-heading">{{ mainPost.name }}</h4>
					<p class="page-text">{{ mainPost.description }}</p>
					<nuxt-link :to="$pageUrl('blog', mainPost.slug)" class="button --red">{{ $trans('Узнать подробнее') }}</nuxt-link>
				</div>
				<div class="home-news-col" v-if="posts.length">
					<nuxt-link :to="$pageUrl('blog', post.slug)" class="home-news-item .animate-home-news" data-on-scroll-paginate v-for="(post, index) in posts" :key="index">
						<div class="home-news-icon"><arrow /></div>
						<p class="home-news-date">{{ $format_date(post.published_at, 'DD.MM.Y') }}</p>
						<h4 class="home-news-heading">{{ post.name }}</h4>
						<p class="page-text">{{ post.description }}</p>
					</nuxt-link>
				</div>
			</div>
			<div class="home-news-btn-wrp .animate-home-news" data-on-scroll-paginate>
				<button class="home-news-prev"><link-arrow /></button>
				<button class="home-news-next"><link-arrow /></button>
			</div>
			<div v-swiper="options">
				<div class="swiper-wrapper">
					<nuxt-link :to="$pageUrl('blog', post.slug)" data-on-scroll-paginate class="swiper-slide .animate-home-news" v-for="(post, index) in $page().posts" :key="index">
						<p class="home-news-date">{{ $format_date(post.published_at, 'DD.MM.Y') }}</p>
						<h4 class="home-news-heading">{{ post.name }}</h4>
						<p class="page-text">{{ post.description }}</p>
						<div class="home-news-icon"><arrow /></div>
					</nuxt-link>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
import linkArrow from "@/static/icons/link-arrow.svg";
import arrow from "@/static/icons/arrow.svg";
import {gsap} from "gsap";
export default {
	components: {
		linkArrow,
		arrow,
	},
	props: ['timeline'],
	data: () => ({
		options: {
			slidesPerView: 1,
			navigation: {
				prevEl: ".home-news-prev",
				nextEl: ".home-news-next",
			},
			breakpoints: {
				600: {
					slidesPerView: 2,
				},
			},
		},
	}),
	computed: {
		mainPost()  {
			return this.$page().posts.length > 0 ? this.$page().posts[0] : null
		},
		posts() {
			return this.$page().posts.slice(1)
		}
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
			let item = document.querySelectorAll(".animate-home-news");
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
.home-news
	padding: 100px 0
	.button
		margin-top: 20px
	&-icon
		width: 48px
		height: 48px
		display: flex
		align-items: center
		justify-content: center
		background: $color-blue
		border-radius: 999px
		position: absolute
		right: 0
		top: 50%
		transform: translateY(-50%)
		svg
			width: 18px
			height: 18px
			transform: rotate(-90deg)
		path
			stroke: #fff
	&-link
		margin-left: auto
		display: flex
		align-items: center
		span
			text-decoration: underline
			font-size: 12px
			font-weight: 400
			color: $color-text
			margin-right: 7px
		path
			fill: $color-text
	&-row
		display: flex
		margin-top: 52px
	&-col
		width: 50%
		&:first-child
			margin-right: 50px
			max-width: 500px
	&-img
		margin-bottom: 10px
	&-date
		font-size: 12px
		font-weight: 300
		color: $color-red
	&-heading
		font-size: 18px
		font-weight: 600
		color: $color-blue
		margin: 10px 0
	.page-text
		font-size: 14px
		line-height: 25px
	&-item
		display: block
		margin-bottom: 55px
		position: relative
		.page-text,
		.home-news-heading
			max-width: 410px
		&:last-child
			margin-bottom: 0
@media (min-width: 320px)
	.home-news
		padding: 40px 10px
		&-row
			margin-top: 25px
		&-col
			width: 100%
			&:first-child
				margin-right: 0
				max-width: 100%
			&:last-child
				display: none
		&-icon
			position: static
			transform: none
			width: 24px
			height: 24px
			margin-top: 25px
			svg
				width: 10px
				height: 10px
		&-prev,
		&-next
			background: transparent
			width: 20px
			height: 20px
			padding: 0
			display: flex
			svg
				width: 100%
				height: 100%
			path
				fill: #D0D0D8
		&-prev
			margin-right: 20px
			svg
				transform: rotate(180deg)
		&-btn-wrp
			display: flex
			justify-content: flex-end
			margin-top: 30px
			margin-bottom: 15px
		&-heading
			font-size: 16px
		&-img
			width: 100%
@media (min-width: 1280px)
	.home-news
		padding: 110px 0px
		&-row
			margin-top: 52px
		&-col
			width: 50%
			&:first-child
				margin-right: 50px
				max-width: 500px
			&:last-child
				display: block
		&-icon
			position: absolute
			transform: translateY(-50%)
			width: 40px
			height: 40px
			margin-top: 0
		&-btn-wrp,
		.swiper-container
			display: none
</style>
