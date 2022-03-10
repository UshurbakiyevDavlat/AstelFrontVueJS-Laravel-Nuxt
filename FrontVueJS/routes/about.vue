<template>
	<div class="about-page">
		<inner-hero :links="breadcrumbs" :image="$page().image" :title="$page().title" :text="$page().description" />
		<div class="layout-container" data-scroll-section>
			<div class="about-page-row" v-if="$page().about">
				<div class="about-page-col" data-on-scroll-paginate>
					<h3 class="about-page-heading">{{ $trans('О нас') }}</h3>
				</div>
				<div class="about-page-col" data-on-scroll-paginate>
					<div class="page-text" v-html="$page().about"></div>
				</div>
			</div>
			<div class="about-page-row" v-if="$page().mission">
				<div class="about-page-col" data-on-scroll-paginate>
					<h3 class="about-page-heading">{{ $trans('Миссия компании') }}</h3>
				</div>
				<div class="about-page-col" data-on-scroll-paginate>
					<div class="page-text" v-html="$page().mission"></div>
				</div>
			</div>
		</div>
		<div class="about-page-row" data-scroll-section v-if="$page().partner_items && $page().partner_items.length">
			<img :data-src="$page().partner_image" v-lazy-load alt="Astel image" class="about-page-img">
			<div class="about-page-list-wrp">
				<h3 class="about-page-heading" data-on-scroll-paginate>{{ $page().partner_title }}</h3>
				<ul class="about-page-list" data-on-scroll-paginate>
					<li class="about-page-list-item" v-for="(item, index) in $page().partner_items" :key="index">
						<p class="page-text">{{ item.description }}</p>
					</li>
				</ul>
			</div>
		</div>
		<div class="layout-container --last" data-scroll-section v-if="$page().content">
			<h3 class="about-page-heading" data-on-scroll-paginate>{{ $page().company_title }}</h3>
			<div class="about-page-divider"></div>
			<div class="about-page-content" data-on-scroll-paginate v-html="$page().content"></div>
		</div>
		<div class="about-page-docs" data-scroll-section v-if="$page().documents && $page().documents.length">
			<div class="about-page-row">
				<h3 class="about-page-heading" data-on-scroll-paginate>{{ $trans('Документы') }}</h3>
				<div class="about-page-docs-inner" v-for="(item, index) in $page().documents" :key="index">
					<a :href="item.file" class="about-page-docs-item" data-on-scroll-paginate>
						<img data-src="/icons/pdf.svg" v-lazy-load alt="Astel icon">
						<p class="page-text">{{ item.name }}</p>
					</a>
				</div>
			</div>
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
	},
	computed: {
		breadcrumbs() {
			return [
				{
					url: this.$pageUrl('about'),
					text: this.$page('about').name
				}
			]
		}
	}
};
</script>

<style lang="sass">
.about-page
	&-docs
		padding: 110px 50px 45px
		background: $bg-base
		.about-page-heading
			width: 25%
		.about-page-row
			max-width: 1200px
			margin: 0 auto
			align-items: flex-start
		.page-text
			max-width: 300px
			line-height: 22px
		&-inner
			width: 75%
			display: flex
			flex-wrap: wrap
		&-item
			width: 50%
			display: flex
			margin-bottom: 65px
			align-items: center
			img
				width: 40px
				height: 40px
				margin-right: 20px
				flex-shrink: 0
	&-divider
		height: 1px
		margin: 30px 0
		background: #CECECE
	.layout-container
		padding: 80px 50px 0
		max-width: 1300px
		&.--last
			padding-bottom: 80px
			padding-top: 0
	&-row
		display: flex
		margin-bottom: 80px
		align-items: center
	&-heading
		font-size: 24px
		font-weight: 500
		color: $color-text
	&-content *
		font-size: 18px
		font-weight: 300
		color: $color-text
		line-height: 30px
	&-content a
		font-size: 18px
		font-style: italic
		font-weight: 500
		color: $color-red
	&-col
		width: 80%
		padding-left: 50px
		&:first-child
			width: 20%
			padding-left: 0
	&-list
		padding-left: 15px
		margin-top: 10px
		list-style-type: initial
		&-wrp
			display: flex
			padding-left: 40px
			justify-content: space-between
			flex-direction: column
		&-item
			max-width: 700px
			padding-right: 50px
			margin-bottom: 43px
			color: $color-red
			&:last-child
				margin-bottom: 0
	&-img
		max-width: 40vw
		min-height: 700px
		object-fit: cover
@media (min-width: 320px)
	.about-page
		.layout-container
			padding: 0
			&.--last
				padding-bottom: 30px
				.about-page-heading
					padding: 0 10px
		&-content
			padding: 0 10px
			*
				font-size: 14px
				line-height: 20px
			a
				font-size: 14px
		&-row
			margin-bottom: 0
			flex-direction: column
			align-items: flex-start
		&-col
			width: 100%
			padding-left: 0
			padding: 30px 10px 0
			&:first-child
				width: 100%
				padding-left: 10px
		&-heading
			font-size: 18px
		&-img
			max-width: 100%
			min-height: initial
			width: 100%
			height: 237px
			margin: 30px 0
		&-list-wrp
			padding: 0 10px
		&-list
			padding-left: 18px
			margin: 30px 0
			&-item
				padding-right: 0
				margin-bottom: 25px
		&-docs
			padding: 30px 10px
			.about-page-heading
				width: 100%
				margin-bottom: 30px
			&-inner
				width: 100%
			&-item
				width: 100%
				margin-bottom: 25px
				img
					width: 20px
					height: 20px
					margin-right: 15px
@media (min-width: 1024px)
	.about-page
		&-docs
			.about-page-row
				flex-direction: row
			.about-page-heading
				width: 25%
				margin-bottom: 0
			&-inner
				width: 75%
			&-item
				width: 50%
				margin-bottom: 65px
				align-items: flex-start
				&:nth-child(3),
				&:nth-child(4)
					margin-bottom: 0
				img
					width: 40px
					height: 40px
					margin-right: 20px
@media (min-width: 1280px)
	.about-page
		.layout-container
			padding: 80px 50px 0
			&.--last
				padding-bottom: 80px
				.about-page-heading
					padding: 0
		&-content
			padding: 0
			*
				font-size: 16px
				line-height: 26px
			a
				font-size: 16px
		&-row
			margin-bottom: 80px
			flex-direction: row
			align-items: center
		&-col
			width: 80%
			padding: 0
			padding-left: 50px
			&:first-child
				width: 20%
				padding-left: 0
		&-heading
			font-size: 20px
		&-img
			max-width: 40vw
			min-height: 700px
			height: 100%
			margin: 0
		&-list-wrp
			padding: 0
			padding-left: 40px
		&-list
			padding-left: 18px
			margin: 30px 0
			padding-right: 20px
			&-item
				padding-right: 0
				margin-bottom: 25px
		&-docs
			padding: 110px 50px 45px
			&-item:nth-child(3),
			&-item:nth-child(4)
				margin-bottom: 65px
@media (min-width: 1440px)
	.about-page
		&-heading
			font-size: 24px
</style>
