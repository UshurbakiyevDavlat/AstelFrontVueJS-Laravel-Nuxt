<template>
	<div class="projects-page"  >
		<div class="projects-page-title-wrp">
			<ui-breadcrumbs
				:dark="true"
				data-on-scroll-paginate
				:links="breadcrumbs"
			></ui-breadcrumbs>
		</div>
		<div class="layout-container">
			<h1 class="projects-page-title" data-on-scroll-paginate>
				{{ $page().title }}
			</h1>
			<nuxt-link
				:to="$pageUrl('projects', item.slug)"
				class="projects-page-row"
				data-on-scroll-paginate
				v-for="(item, index) in $page().projects.data"
				:key="index"
			>
				<div class="projects-page-left">
					<h4 class="projects-page-heading">{{ item.name }}</h4>
					<p class="projects-page-text">{{ item.description }}</p>
					<div class="projects-page-link">
						{{ $trans("Подробнее") }}
						<arrow />
					</div>
				</div>
				<img
					:data-src="item.image"
					v-lazy-load
					:alt="item.name"
					class="projects-page-img"
				/>
			</nuxt-link>
			<ui-pagination :paginator="$page().projects" />
		</div>
	</div>
</template>

<script>
import arrow from "@/static/icons/arrow.svg";
import UiBreadcrumbs from "~/components/ui/UiBreadcrumbs";
import UiPagination from "~/components/ui/UiPagination";

import { gsap } from "gsap";

export default {
	components: {
		arrow,
		UiBreadcrumbs,
		UiPagination
	},
	computed: {
		breadcrumbs() {
			return [
				{
					url: this.$pageUrl("projects"),
					text: this.$page("projects").title
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
.projects-page
	padding-bottom: 80px
	&-title-wrp
		padding: 40px 50px 0
	&-title
		font-size: 42px
		font-weight: 500
		color: $color-blue
	&-row
		display: flex
		align-items: center
		justify-content: space-between
		padding: 40px 0
		border-top: 1px solid #E8E8E8
		color: $color-text
	&-heading
		font-size: 24px
		font-weight: 500
		margin-bottom: 36px
	&-text
		font-size: 18px
		font-weight: 300
	&-left
		max-width: 550px
	&-img
		width: 40vw
		height: 50vh
		object-fit: cover
	&-link
		display: flex
		align-items: center
		margin-top: 36px
		font-size: 14px
		font-weight: 300
		color: $color-text
		svg
			margin-left: 10px
			transform: rotate(-90deg)
@media (min-width: 320px)
	.projects-page
		padding-bottom: 30px
		&-title-wrp
			padding: 20px 10px 30px
		&-title
			font-size: 18px
			padding: 0 10px 20px
		&-row
			flex-wrap: wrap
			padding: 50px 10px
		&-img
			width: 100%
			height: 35vh
			min-height: 200px
			margin-top: 25px
		&-heading
			font-size: 16px
			margin-bottom: 25px
		&-text
			font-size: 14px
			margin-top: 25px
		&-link
			margin-top: 25px
@media (min-width: 1280px)
	.projects-page
		padding-bottom: 80px
		&-title-wrp
			padding: 40px 50px 0
		&-title
			font-size: 36px
			margin-top: 50px
			margin-bottom: 30px
			padding: 0
		&-row
			flex-wrap: nowrap
			padding: 40px 0
		&-img
			width: 50%
			height: 360px
			margin-top: 0
		&-heading
			font-size: 24px
			margin-bottom: 36px
		&-text
			font-size: 18px
			margin-top: 0
		&-link
			margin-top: 36px
</style>
