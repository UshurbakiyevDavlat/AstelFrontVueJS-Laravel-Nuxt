<template>
	<div class="partners-page">
		<inner-hero
			:links="breadcrumbs"
			:image="$page().image"
			:title="$page().title"
			:text="$page().description"
		/>
		<div class="layout-container" data-scroll-section>
			<h2 class="partners-page-title" data-on-scroll-paginate>
				{{ $page().title }}
			</h2>
			<div
				class="page-text"
				data-on-scroll-paginate
				v-html="$page().content"
			></div>
			<div class="partners-page-row">
				<component
					:is="item.link ? 'a' : 'div'"
					:href="item.link"
					class="partners-page-col"
					data-on-scroll-paginate
					v-for="(item, index) in $page().partners"
					:key="index"
				>
					<img
						:data-src="item.image"
						v-lazy-load
						:alt="item.name"
						class="partners-page-logo"
					/>
				</component>
			</div>
		</div>
		<partial-form :partners="true" />
	</div>
</template>

<script>
import InnerHero from "~/components/partials/InnerHero";
import PartialForm from "~/components/partials/PartialForm";
import {gsap} from "gsap";

export default {
	components: {
		PartialForm,
		InnerHero
	},
	computed: {
		breadcrumbs() {
			return [
				{
					url: this.$pageUrl("partners"),
					text: this.$page("partners").name
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
.partners-page
	.layout-container
		padding-top: 40px
	&-title
		font-size: 24px
		font-weight: 500
		color: $color-blue
		margin-bottom: 40px
	&-row
		display: flex
		flex-wrap: wrap
	&-col
		width: 207px
		height: 207px
		display: flex
		align-items: center
		justify-content: center
		box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.05)
		margin-right: 20px
		margin-top: 37px
		&:nth-child(5n)
			margin-right: 0
	&-log
		max-width: 110px
		max-height: 110px
@media (min-width: 320px)
	.partners-page
		.layout-container
			padding: 30px 10px
		&-title
			font-size: 18px
			margin-bottom: 30px
		&-col
			width: calc(50% - 10px)
			height: 140px
			margin-top: 25px
			&:nth-child(5n)
				margin-right: 0
			&:nth-child(odd)
				margin-right: 20px
			&:nth-child(even)
				margin-right: 0
@media (min-width: 600px)
	.partners-page
		&-col
			width: calc(33.3% - 14px)
			&:nth-child(even)
				margin-right: 20px
			&:nth-child(3n)
				margin-right: 0
@media (min-width: 1024px)
	.partners-page
		&-col
			height: 300px
@media (min-width: 1280px)
	.partners-page
		.layout-container
			padding: 80px 0 0
		&-title
			font-size: 24px
			margin-bottom: 40px
		&-col
			height: 203px
			width: 203px
			&:nth-child(5n)
				margin-right: 0
			&:nth-child(3n)
				margin-right: 20px
</style>
