<template>
	<div class="news-inner" data-scroll-section>
		<ui-breadcrumbs :links="breadcrumbs" data-on-scroll-paginate :dark="true" />
		<div class="news-inner-container">
			<h1 class="news-inner-title" data-on-scroll-paginate>{{ post.name }}</h1>
			<p class="news-inner-date" data-on-scroll-paginate>{{ $format_date(post.published_at, 'DD.MM.Y') }}</p>
			<img :data-src="post.image" v-lazy-load :alt="post.name" data-on-scroll-paginate class="news-inner-img">
			<div class="news-inner-content" data-on-scroll-paginate v-html="post.content"></div>
			<button class="news-inner-back" data-on-scroll-paginate @click="$router.push($pageUrl('blog'))">
				<arrow />
				{{ $trans('Назад к новостям') }}
			</button>
		</div>
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
	computed: {
		post() {
			return this.$page().post
		},
		breadcrumbs() {
			return [
				{
					url: this.$pageUrl('blog'),
					text: this.$page('blog').name
				},
				{
					url: this.$pageUrl('blog', this.post.slug),
					text: this.post.name
				}
			]
		}
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
};
</script>

<style lang="sass">
.news-inner
	padding: 40px 50px 80px
	&-container
		max-width: 772px
		width: 100%
		margin: 0 auto
	&-img
		margin: 20px auto
	&-content *
		font-weight: 400
   		font-size: 15px
   		color: #303030
   		line-height: 24px
	&-back
		display: flex
		align-items: center
		font-size: 18px
		font-weight: 300
		color: $color-blue
		padding: 0
		background: transparent
		margin-top: 40px
		svg
			width: 12px
			height: 9px
			transform: rotate(90deg)
			margin-right: 15px
	&-title
		margin-top: 64px
		font-weight: 500
		color: $color-blue
		font-size: 36px
		margin-bottom: 16px
	&-date
		color: $color-red
		font-size: 14px
		font-weight: 300
@media (min-width: 320px)
	.news-inner
		padding: 30px 10px
		&-title
			font-size: 18px
			margin-top: 30px
		&-content
			*
				font-size: 14px
				line-height: 24px
		&-back
			margin-top: 30px
			font-size: 14px
@media (min-width: 1280px)
	.news-inner
		padding: 40px 50px 80px
		&-title
			font-size: 36px
			margin-top: 40px
		&-back
			margin-top: 40px
			font-size: 18px
</style>
