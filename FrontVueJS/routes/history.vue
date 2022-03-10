<template>
	<div class="history-page">
		<inner-hero :links="breadcrumbs" :image="$page().image" :title="$page().title" :text="$page().description" />
		<div class="layout-container" data-scroll-section>
			<h1 class="history-page-title" data-on-scroll-paginate>{{ $page().title }}</h1>
			<ul class="history-page-list" data-on-scroll-paginate>
				<li class="history-page-list-item" v-for="(item, index) in $page().items" :key="index">
					<span class="history-page-year">{{ item.year }}</span>
					<div class="page-text" v-html="item.event"></div>
				</li>
			</ul>
		</div>
		<partial-form />
	</div>
</template>

<script>
import InnerHero from "~/components/partials/InnerHero";
import PartialForm from "~/components/partials/PartialForm";
import {gsap} from "gsap";

export default {
	components: {
		InnerHero,
		PartialForm
	},
	computed: {
		breadcrumbs() {
			return [
				{
					url: this.$pageUrl('history'),
					text: this.$page('history').name
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
.trage_mark
	position: relative
	top: -5px
.history-page
	.layout-container
		padding: 80px 0
	&-title
		font-size: 24px
		font-weight: 500
		color: $color-blue
		margin-bottom: 80px
	&-list
		position: relative
		&:before
			content: ''
			width: 1px
			height: calc(100% - 25px)
			background: #cdcdcd
			position: absolute
			left: 0
			top: 25px
		&-item
			padding-bottom: 64px
			display: flex
			align-items: flex-start
			position: relative
			&:nth-child(even)
				.history-page-year:after
					background: $color-red
			&:last-child
				&:before
					content: ''
					width: 4px
					height: calc(100% - 25px)
					background: #fff
					position: absolute
					left: 0
					top: 25px
			.page-text
				margin-top: 10px
				max-width: 960px
	&-year
		font-size: 36px
		font-weight: 500
		color: $color-text
		min-width: 145px
		padding-left: 27px
		flex-shrink: 0
		display: inline-block
		position: relative
		&:before
			content: ''
			width: 12px
			height: 12px
			border: 1px solid #cdcdcd
			border-radius: 999px
			position: absolute
			left: -6px
			top: 50%
			transform: translateY(-50%)
			background: #fff
		&:after
			content: ''
			width: 6px
			height: 6px
			border-radius: 999px
			background: $color-blue
			position: absolute
			left: -3px
			top: 50%
			transform: translateY(-50%)
			z-index: 1
@media (min-width: 320px)
	.history-page
		.layout-container
			padding: 30px 10px
		&-year
			font-size: 18px
			padding-left: 20px
		&-list
			&:before
				top: 15px
		&-title
			margin-bottom: 30px
			font-size: 18px
		&-list-item
			flex-direction: column
			padding-bottom: 30px
			&:last-child:before
				top: 15px
				left: -2px
			.page-text
				padding-left: 20px
@media (min-width: 1280px)
	.history-page
		.layout-container
			padding: 80px 0
		&-year
			font-size: 36px
			padding-left: 27px
		&-list
			&:before
				top: 25px
		&-title
			margin-bottom: 80px
			font-size: 24px
		&-list-item
			flex-direction: row
			padding-bottom: 64px
			&:last-child:before
				top: 25px
				left: -2px
			.page-text
				padding-left: 0
</style>
