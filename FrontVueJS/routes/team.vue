<template>
	<div class="admins-page">
		<inner-hero
			:links="breadcrumbs"
			:image="$page().image"
			:title="$page().title"
			:text="$page().description"
		/>
		<div class="layout-container" data-scroll-section>
			<h2 class="admins-page-title" data-on-scroll-paginate>
				{{ $page().title }}
			</h2>
			<div class="admins-page-row">
				<div
					class="admins-page-item"
					data-on-scroll-paginate
					v-for="(item, index) in $page().managers"
					:key="index"
				>
					<img
						:data-src="item.image"
						v-lazy-load
						:alt="item.name"
						class="admins-page-img"
					/>
					<div class="admins-page-item-right">
						<component
							:is="item.link ? 'a' : 'p'"
							:href="item.link"
							class="admins-page-name"
							>{{ item.name }}</component
						>
						<div
							class="admins-page-position"
							v-html="item.description"
						></div>
					</div>
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
	computed: {
		breadcrumbs() {
			return [
				{
					url: this.$pageUrl("team"),
					text: this.$page("team").name
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
.admins-page
	.layout-container
		padding: 80px 0
	&-title
		margin-bottom: 80px
		font-size: 24px
		font-weight: 500
		color: $color-blue
	&-item
		display: flex
		align-items: flex-start
		margin-bottom: 40px
		&:last-child
			margin-bottom: 0
	&-img
		width: 270px
		height: 270px
		object-fit: cover
		margin-right: 48px
	&-name
		font-size: 18px
		font-weight: 500
		color: $color-text
		margin-bottom: 30px
	&-position
		font-size: 14px
		font-weight: 300
		color: $color-blue
		max-width: 340px
@media (min-width: 320px)
	.admins-page
		.layout-container
			padding: 30px 10px
		&-img
			width: 140px
			height: 140px
			margin-right: 14px
		&-title
			font-size: 18px
			margin-bottom: 30px
		&-name
			font-size: 14px
			margin-bottom: 12px
		&-position
			font-size: 12px
@media (min-width: 768px)
	.admins-page
		&-img
			width: 270px
			height: 270px
			margin-right: 40px
		&-name
			font-size: 18px
			margin-bottom: 30px
		&-position
			font-size: 14px
@media (min-width: 1280px)
	.admins-page
		.layout-container
			padding: 80px 0
		&-title
			font-size: 24px
			margin-bottom: 80px
</style>
