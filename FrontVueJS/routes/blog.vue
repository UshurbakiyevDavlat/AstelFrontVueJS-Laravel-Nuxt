<template>
	<div class="news-page">
		<ui-breadcrumbs :links="breadcrumbs" data-on-scroll-paginate :dark="true" />
		<div class="layout-container">
			<h1 class="news-page-title" data-on-scroll-paginate>{{ $page().name }}</h1>
			<div class="news-page-row">
				<nuxt-link :to="$pageUrl('blog', item.slug)" class="news-page-item" data-on-scroll-paginate v-for="(item, index) in $page().posts.data" :key="index">
					<img :data-src="item.image" v-lazy-load :alt="item.name" class="news-page-img">
					<p class="news-page-date">{{ $format_date(item.published_at, 'DD.MM.Y') }}</p>
					<h4 class="news-page-heading">{{ item.name }}</h4>
					<p class="page-text">{{ item.description }}</p>
					<button class="button --red">{{ $trans('Узнать подробнее') }}</button>
				</nuxt-link>
			</div>
			<ui-pagination :paginator="$page().posts"/>
		</div>
	</div>
</template>

<script>
import UiBreadcrumbs from "~/components/ui/UiBreadcrumbs";
import UiPagination from "~/components/ui/UiPagination";

import { gsap } from "gsap";

export default {
	components: {
		UiPagination,
		UiBreadcrumbs
	},
	computed: {
		breadcrumbs() {
			return [
				{
					url: this.$pageUrl('blog'),
					text: this.$page('blog').name
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
}
</script>

<style lang="sass">
.news-page
	padding: 40px 50px 80px
	.layout-container
		margin-top: 56px
	&-title
		font-size: 42px
		font-weight: 500
		color: $color-blue
		margin-bottom: 40px
	&-row
		display: flex
		flex-wrap: wrap
	&-item
		width: calc(33.3% - 13px)
		margin-right: 20px
		display: flex
		flex-direction: column
		align-items: flex-start
		margin-bottom: 65px
		&:nth-child(3n)
			margin-right: 0
	&-img
		width: 93%
		height: 184px
		object-fit: cover
	&-date
		font-size: 14px
		font-weight: 300
		color: $color-red
		margin: 10px 0
	&-heading
		font-size: 18px
		font-weight: 500
		color: $color-blue
		margin-bottom: 22px
	.page-text
		margin-bottom: 22px
		padding-right: 10%
	.button
		line-height: 47px
		padding: 0 20px
		margin-top: auto
@media (min-width: 320px)
	.news-page
		padding: 30px 10px
		&-title
			font-size: 18px
			margin-bottom: 30px
		.layout-container
			margin-top: 30px
		&-item
			width: 100%
			margin-right: 0
		&-img
			height: 184px
		&-heading
			font-size: 16px
@media (min-width: 768px)
	.news-page
		&-item
			width: calc(50% - 10px)
			margin-right: 20px
			&:nth-child(even)
				margin-right: 0
			&:nth-child(3n)
				margin-right: 20px
@media (min-width: 1280px)
	.news-page
		padding: 40px 50px 80px
		&-title
			font-size: 36px
			margin-bottom: 40px
		.layout-container
			margin-top: 56px
		&-item
			width: calc(33.3% - 20px)
			&:nth-child(even)
				margin-right: 20px
			&:nth-child(3n)
				margin-right: 0
		&-img
			height: 184px
</style>
