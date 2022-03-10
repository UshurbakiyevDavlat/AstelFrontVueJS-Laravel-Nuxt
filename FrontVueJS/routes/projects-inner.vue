<template>
	<div class="project-inner">
		<div class="project-inner-top" data-scroll-section>
			<ui-breadcrumbs :links="breadcrumbs" data-on-scroll-paginate :dark="true" />
			<div class="project-inner-header">
				<div class="project-inner-left">
					<button
						class="project-inner-back-btn"
						@click="$router.back()"
						data-on-scroll-paginate
					>
						<arrow />
						{{ $trans("Назад") }}
					</button>
					<h1 data-on-scroll-paginate class="project-inner-title">
						{{ project.name }}
					</h1>
					<p
						data-on-scroll-paginate
						class="project-inner-subtitle"
						v-for="(label, index) in project.labels"
						:key="index"
					>
						{{ label.name }}
					</p>
				</div>
				<img
					:data-src="project.image"
					v-lazy-load
					:alt="project.name"
					class="project-inner-img"
				/>
			</div>
		</div>
		<div class="layout-container" data-scroll-section>
			<h2 class="project-inner-heading" data-on-scroll-paginate>
				{{ $trans("О проекте") }}
			</h2>
			<div
				class="page-text"
				data-on-scroll-paginate
				v-html="project.content"
			></div>

			<div
				class="project-inner-slider-wrp"
				v-if="project.images && project.images.length > 0"
			>
				<button class="project-inner-prev" data-on-scroll-paginate>
					<arrow class="project-inner-arrow --desktop" />
					<link-arrow class="project-inner-arrow --mobile" />
				</button>
				<button class="project-inner-next" data-on-scroll-paginate>
					<arrow class="project-inner-arrow --desktop" />
					<link-arrow class="project-inner-arrow --mobile" />
				</button>
				<div v-swiper="options">
					<div class="swiper-wrapper">
						<div
							class="swiper-slide"
							data-on-scroll-paginate
							v-for="(image, index) in project.images"
							:key="index"
						>
							<img :data-src="image" v-lazy-load :alt="project.name" />
						</div>
					</div>
				</div>
			</div>
			<div
				class="project-inner-annotation"
				data-on-scroll-paginate
				v-if="project.consultation"
			>
				<p class="page-text">{{ project.consultation }}</p>
			</div>
		</div>
		<partial-form />
	</div>
</template>

<script>
import arrow from "@/static/icons/arrow.svg";
import linkArrow from "@/static/icons/link-arrow.svg";
import UiBreadcrumbs from "~/components/ui/UiBreadcrumbs";
import PartialForm from "~/components/partials/PartialForm";
import {gsap} from "gsap";

export default {
	components: {
		arrow,
		linkArrow,
		UiBreadcrumbs,
		PartialForm
	},
	data: () => ({
		options: {
			slidesPerView: 3,
			spaceBetween: 40,
			navigation: {
				prevEl: ".project-inner-prev",
				nextEl: ".project-inner-next"
			},
			breakpoints: {
				1280: {
					slidesPerView: 3
				},
				1024: {
					slidesPerView: 2,
					spaceBetween: 20
				},
				320: {
					slidesPerView: 1,
					spaceBetween: 10
				}
			}
		}
	}),
	computed: {
		project() {
			return this.$page().project;
		},
		breadcrumbs() {
			return [
				{
					url: this.$pageUrl("projects"),
					text: this.$page("projects").title
				},
				{
					url: this.$pageUrl("projects", this.project.slug),
					text: this.project.name
				}
			];
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
.project-inner
	&-top
		padding: 40px 50px 0
	&-header
		display: flex
		margin-top: 25px
		height: 430px
		margin-bottom: 80px
	&-left
		background: $color-blue
		padding: 24px 30px
		width: 50%
	&-img
		width: 50%
		height: 100%
		object-fit: cover
	&-back-btn
		border-radius: 20px
		background: #F1F1F1
		display: flex
		align-items: center
		justify-content: center
		line-height: 36px
		width: 120px
		font-size: 14px
		font-weight: 500
		color: $color-text
		svg
			transform: rotate(90deg)
			margin-right: 10px
	&-title
		color: #fff
		font-size: 30px
		font-weight: 500
		margin-top: 84px
		margin-bottom: 30px
	&-subtitle
		color: #fff
		font-size: 18px
		font-weight: 500
	&-heading
		font-size: 24px
		font-weight: 500
		color: $color-blue
		margin-bottom: 40px
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
		svg
			transform: rotate(90deg)
	&-next
		right: 0px
		svg
			transform: rotate(-90deg)
	&-slider-wrp
		position: relative
		padding: 0 50px
		margin: 80px 0
		.swiper-slide img
			width: 100%
	&-annotation
		border: 1px solid $color-red
		padding: 30px 20px
		max-width: 1115px
		margin: 0 auto
		text-align: center
		.page-text
			font-size: 14px !important
			font-weight: 400 !important
    		color: #303030 !important
			line-height: initial !important
@media (min-width: 320px)
	.project-inner
		&-top
			padding: 30px 0
			.breadcrumbs
				padding: 0 10px
		&-header
			margin-bottom: 0
			height: auto
			flex-direction: column
		&-left
			width: 100%
			padding: 10px 10px 25px
		&-title
			font-size: 18px
			margin-top: 30px
		&-subtitle
			font-size: 14px
			font-weight: 300
		&-img
			width: 100%
		&-back-btn
			line-height: 32px
			width: 100px
		.layout-container
			padding: 0 10px
		&-heading
			font-size: 18px
			margin-bottom: 30px
		&-annotation
			padding: 10px
		&-arrow.--desktop
			display: none
		&-prev,
		&-next
			position: static
			transform: none
			svg
				width: 20px
				height: 20px
			path
				stroke: none
				fill: $color-text
		&-prev
			margin-left: auto
			margin-right: 20px
			svg
				transform: rotate(-180deg)
		&-next
			svg
				transform: none
		&-slider-wrp
			padding: 0
			display: flex
			flex-wrap: wrap
			margin: 30px 0
			.swiper-container
				width: 100%
				margin-top: 20px
@media (min-width: 1280px)
	.project-inner
		&-top
			padding: 40px 50px 0
			.breadcrumbs
				padding: 0
		&-header
			margin-bottom: 80px
			height: 430px
			flex-direction: row
		&-left
			width: 50%
			padding: 24px 30px
		&-title
			font-size: 24px
			margin-top: 80px
		&-subtitle
			font-size: 18px
			font-weight: 500
		&-img
			width: 50%
		&-back-btn
			line-height: 36px
			width: 120px
		.layout-container
			padding: 0
		&-heading
			font-size: 24px
			margin-bottom: 40px
		&-annotation
			padding: 30px 20px
		&-arrow.--mobile
			display: none
		&-arrow.--desktop
			display: block
		&-prev,
		&-next
			position: absolute
			transform: translateY(-50%)
			svg
				width: 32px
				height: 32px
			path
				stroke: #B9B9B9
				fill: none
		&-prev
			margin-left: 0
			margin-right: 0
			svg
				transform: rotate(90deg)
		&-next
			svg
				transform: rotate(-90deg)
		&-slider-wrp
			padding: 0 50px
			margin: 80px 0
			.swiper-container
				margin-top: 0
</style>
