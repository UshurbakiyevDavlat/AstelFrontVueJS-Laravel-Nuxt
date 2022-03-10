<template>
	<div class="services-category">
		<services-modal />
		<button @click="$router.back()" class="services-category-back">
			<arrow-back />
			{{ $trans('Назад') }}
		</button>
		<ui-breadcrumbs :links="breadcrumbs" :dark="true" />
		<div class="layout-container">
			<div class="services-category-title-wrp" :class="{'--show-mob': $page().categories.filter(c => c.id == $page().service.parent_id).length == 0}">
				<h1 class="services-category-title">
					{{ $page().label ? $page().label : $page().name }}
				</h1>

				<button v-if="$page().categories.length > 5" class="services-category-prev"><arrow /></button>
				<button v-if="$page().categories.length > 5" class="services-category-next"><arrow /></button>
 			</div>
			<div class="services-category-slider-wrp">
				<div v-swiper="options" :cleanup-styles-on-destroy="false">
					<div class="swiper-wrapper">
						<div
							class="swiper-slide"
							v-for="(category, index) in $page().categories"
							:key="index"
						>
							<nuxt-link
								:to="$pageUrl('services', category.slug)"
								:class="[
									'services-category-link',
									{
										'nuxt-link-active':
											category.id ==
											$page().service.parent_id
									}
								]"
								>{{ category.name }}</nuxt-link
							>
						</div>
					</div>
				</div>
			</div>
			<div class="services-category-row">
				<h1 class="services-category-title --mobile" v-if="$page().categories.filter(c => c.id == $page().service.parent_id).length > 0">
					{{ $page().categories.filter(c => c.id == $page().service.parent_id)[0].name }}
				</h1>
				<div class="services-category-select-wrp" v-if="$page().service.parent_id">
					<select v-model="selectedSubcategory" @change="changeRoute" >
						<option value="" disabled>{{$page().service.name}}</option>
						<option
							:value="subcategory.slug"
							v-for="(subcategory, index) in $page()
								.aside_subcategories"
							:key="index"
							>{{ subcategory.name }}</option
						>
					</select>
				</div>
				<aside
					class="services-category-aside"
					v-if="
						$page().aside_subcategories &&
							$page().aside_subcategories.length > 0
					"
				>
					<nuxt-link
						v-for="(subcategory, index) in $page()
							.aside_subcategories"
						:key="index"
						:to="$pageUrl('services', subcategory.slug)"
						>{{ subcategory.name }}</nuxt-link
					>
				</aside>
				<div class="services-category-inner" data-scroll-section>
					<h2 class="services-category-heading">
						{{ $page().service.name }}
					</h2>

					<div class="services-items">
						<div class="services-items-item animate-inner-services" data-on-scroll-paginate
							v-for="(item, index) in $page().subcategories" :key="index">
							<div class="services-item-wrap">
								<h2 style="margin: 0px 40px 20px 0px;position: absolute; color: white;font-size:14px;" class="services-items-title">{{ item.name }}</h2>
								<component style="z-index: 999;position: relative;"
										:is="isSameHost($pageUrl('services', item.slug)) ? 'nuxt-link' : 'a'"
										:href="isSameHost($pageUrl('services', item.slug)) ? ($pageUrl('services', item.slug)) : $pageUrl('services', item.slug)"
										:to="($pageUrl('services', item.slug))" class="buttonMain --transparent animate-home-hero buttonMain-hover"
										data-on-scroll-paginate>
									{{ 'Подробнее' }}
								</component>
							</div>
						</div>
					</div>

					<services-items
						v-if="
							$page().subcategories &&
								$page().subcategories.length > 0
						"
					/>
					<template v-else>
						<div
							class="services-category-content"
							v-html="$page().service.content"
						></div>
						<button
							@click="$setTrue('modals.servicesModal')"
							class="button --red"
						>
							{{ $trans("Получить консультацию") }}
						</button>
						<div
							class="services-category-divider"
							v-if="
								$page().service.advantages_title ||
									($page().service.advantages &&
										$page().service.advantages.length)
							"
						></div>
						<h4
							class="services-category-subtitle"
							v-if="$page().service.advantages_title"
						>
							{{ $page().service.advantages_title }}
						</h4>
						<div
							class="services-category-row --icons"
							v-if="
								$page().service.advantages &&
									$page().service.advantages.length
							"
						>
							<div
								class="services-category-col"
								v-for="(item, index) in $page().service
									.advantages"
								:key="index"
							>
								<img
									:data-src="item.image"
									v-lazy-load
									:alt="item.name"
									class="services-category-icon"
								/>
								<p class="services-category-text">
									{{ item.name }}
								</p>
							</div>
						</div>
						<div
							class="services-category-divider"
							v-if="
								$page().service.connection_title ||
									$page().service.connection_content ||
									($page().service.connection_items &&
										$page().service.connection_items.length)
							"
						></div>
						<h4 class="services-category-subtitle">
							{{ $page().service.connection_title }}
						</h4>
						<div
							class="services-category-content"
							v-html="$page().service.connection_content"
						></div>
						<div class="services-category-row --list">
							<div
								class="services-category-col"
								v-for="(item, index) in $page().service
									.connection_items"
								:key="index"
							>
								<div class="services-category-txt-wrp">
									<check />
									<p class="services-category-text">
										{{ item.name }}
									</p>
								</div>
							</div>
						</div>
						<button
							@click="$setTrue('modals.servicesModal')"
							class="button --red"
							v-if="
								$page().service.connection_title ||
									$page().service.connection_content ||
									($page().service.connection_items &&
										$page().service.connection_items.length)
							"
						>
							{{ $trans("Получить консультацию") }}
						</button>
						<div
							class="services-category-docs"
							v-if="
								$page().service.documents &&
									$page().service.documents.length
							"
						>
							<h3 class="services-category-subtitle" data-on-scroll-paginate>
								{{ $trans("Документы") }}
							</h3>
							<div class="services-category-docs-row">
								<a
									v-for="(item, index) in $page().service.documents"
									:key="index"
 									:href="item.file"
								    target= '_blank'
									class="services-category-docs-item"
									data-on-scroll-paginate
								>
									<img
										data-src="/icons/pdf.svg"
										v-lazy-load
										alt="Astel icon"
									/>
									<p class="page-text">{{ item.name }}</p>
								</a>
							</div>
						</div>
					</template>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
import arrow from "@/static/icons/link-arrow.svg";
import arrowBack from "@/static/icons/arrow.svg";
import check from "@/static/icons/check.svg";
import ServicesModal from "~/components/partials/ServicesModal";
import UiBreadcrumbs from "~/components/ui/UiBreadcrumbs";
import ServicesItems from "~/components/partials/ServicesItems";
import {gsap} from "gsap";

export default {
	components: {
		arrow,
		arrowBack,
		check,
		ServicesModal,
		UiBreadcrumbs,
		ServicesItems
	},
	data() {
		return {
			selectedSubcategory: "",
			options: {
				navigation: {
					prevEl: ".services-category-prev",
					nextEl: ".services-category-next"
				},
				breakpoints: {
					1280: {
						slidesPerView: "auto"
					},
					1024: {
						slidesPerView: 3
					},
					600: {
						slidesPerView: 3
					},
					320: {
						slidesPerView: "auto",
						spaceBetween: 20
					}
				}
			}
		};
	},
	computed: {
		breadcrumbs() {
			let breadcrumbs = [];
			let service = this.$page().service.breadcrumbs;

			do {
				breadcrumbs.push({
					url: this.$pageUrl("services", service.slug),
					text: service.name
				});
				service = service.breadcrumbs;
			} while (service);

			breadcrumbs.push({
				url: this.$pageUrl("services"),
				text: this.$page("services").name
			});
			return breadcrumbs.reverse();
		}
	},
	mounted(){
		this.animateOnLoad();
	},
	methods: {
		getSrcServiceImage (item) {
			this.fullUrlImg =  this.urlForImg.concat(item)
			if (item === null) return ""
			return this.fullUrlImg;
		},

		getMime(url) {
			let chunks = url.split('.')
			return `video/${chunks[chunks.length - 1]}`
		},

		isSameHost(url) {
			return !url.startsWith('http')
		},

		changeRoute() {
			this.$router.push(
				this.$pageUrl("services", this.selectedSubcategory)
			);
		},
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

.services-items-item.animate-inner-services
	height: 14em
	background: linear-gradient(50deg, #00236d, #003bb7)
	
.services-category
	padding: 40px 50px
	.button
		margin: 30px 0
	&-divider
		width: 100%
		height: 1px
		background: #E8E8E8
		margin-bottom: 30px
	&-price
		max-width: 340px
		font-size: 14px
		font-weight: 300
		color: $color-blue
		text-decoration: underline
		display: block
	&-file-wrp
		display: flex
		max-width: 340px
		border-bottom: 1px solid #E8E8E8
		padding-bottom: 20px
		margin-bottom: 22px
		align-items: center
		font-size: 14px
		font-weight: 300
		color: $color-blue
		svg
			margin-right: 26px
			width: 30px
			height: 30px
			flex-shrink: 0
	&-row
		display: flex
		&.--icons
			flex-wrap: wrap
			.services-category-col
				width: 33.3%
				margin-bottom: 58px
				text-align: center
				padding: 0 20px
		&.--list
			flex-wrap: wrap
			.services-category-col
				width: 50%
				margin-top: 36px
				p
					max-width: 360px
	&-txt-wrp
		display: flex
		align-items: flex-start
		svg
			width: 14px
			height: 14px
			flex-shrink: 0
			margin-right: 20px
			margin-top: 5px
	&-icon
		margin-bottom: 26px
	&-text
		font-size: 14px
		font-weight: 400
		line-height: 1.6
		color: $color-text
	&-subtitle
		font-size: 18px
		font-weight: 500
		color: $color-blue
		margin-bottom: 30px
	&-inner
		border-top: 1px solid #E8E8E8
		padding-top: 30px
		width: 100%
	&-heading
		font-size: 24px
		font-weight: 500
		color: $color-blue
		margin-bottom: 30px
	&-content
		ul
			list-style: disc
			padding-left: 20px
			li
				color: $color-black
		p
			font-size: 16px
			font-weight: 400
			color: $color-text
			line-height: 24px
	&-aside
		width: 270px
		flex-shrink: 0
		padding-right: 60px
		a
			display: block
			font-size: 14px
			font-weight: 300
			color: $color-text
			margin-bottom: 50px
			position: relative
			&:before
				content: ''
				width: 8px
				height: 8px
				background: url('/icons/arrow.svg') center no-repeat
				background-size: contain
				position: absolute
				left: 0
				top: 50%
				transform: translateY(-50%) rotate(-90deg)
				opacity: 0
			&.nuxt-link-active
				color: $color-blue
				font-weight: 500
				padding-left: 15px
				&:before
					opacity: 1
	&-slider-wrp
		margin-bottom: 60px
	.swiper-slide
		width: auto
	&-link
		display: inline-block
		padding: 11px 27px
		border-radius: 999px
		background: $bg-base
		font-size: 16px
		font-weight: 400
		color: $color-text
		transition: .3s ease
		&:hover,
		&.nuxt-link-active
			color: #fff
			background: $color-blue
	&-title-wrp
		display: flex
		align-items: center
		margin-top: 60px
		margin-bottom: 40px
	&-title
		font-size: 42px
		font-weight: 500
		color: $color-blue
	&-prev,
	&-next
		display: flex
		align-items: center
		justify-content: center
		padding: 0
		background: transparent
		width: 46px
		height: 46px
		border-radius: 999px
		background: #f8f8f8
		svg
			width: 18px
		path
			fill: $color-text
	&-prev
		margin-left: auto
		margin-right: 23px
		svg
			transform: rotate(180deg)
@media (min-width: 320px)
	.services-category
		padding: 30px 10px
		&-back
			display: flex
			align-items: center
			font-size: 10px
			font-weight: 400
			color: #000
			background: #f5f5f5
			border-radius: 15px
			padding: 8px 22px
			svg
				margin-right: 10px
				transform: rotate(90deg)
		.button
			line-height: initial
			height: 42px
			margin-top: 30px
			width: 100%
		&-content
			p
				font-size: 14px
		&-select-wrp
			margin-bottom: 12px
			select
				max-width: 100%
				border: none
				font-size: 14px
				font-weight: 300
				color: $color-text
				width: 100%
				option
					font-size: 14px
					font-weight: 300
					color: $color-text
		&-heading
			font-size: 18px
			margin-bottom: 20px
		&-link
			font-size: 14px
			padding: 8px 10px
		&-text
			line-height: 1.4
		&-title
			font-size: 18px
			margin: 20px 0
			&-wrp
				margin: 20px 0
				margin-top: 18px
		&-row
			flex-direction: column
			&.--icons
				flex-direction: row
				.services-category-col
					width: 50%
					padding: 0
					margin-bottom: 26px
			&.--list
				.services-category-col
					width: 100%
		&-icon
			max-width: 48px
		&-aside,
		&-slider-wrp,
		&-prev,
		&-next,
		&-heading,
		&-title-wrp
			display: none
		&-title-wrp
			&.--show-mob
				display: flex
		&-docs
			&-row
				display: flex
				flex-wrap: wrap
			&-item
				display: flex
				width: 100%
				margin-bottom: 30px
				img
					flex-shrink: 0
					width: 40px
					height: 40px
					object-fit: contain
				.page-text
					margin-left: 22px
@media (min-width: 1024px)
	.services-category
		&-docs
			&-item
				width: 50%
@media (min-width: 1280px)
	.services-category
		padding: 40px 50px
		.button
			width: auto
		&-content
			p
				font-size: 16px
		&-select-wrp,
		&-back
			display: none
		&-heading
			font-size: 24px
			margin-bottom: 30px
			display: block
		&-text
			line-height: 1.6
		&-title
			font-size: 42px
			&.--mobile
				display: none
			&-wrp
				margin: 60px 0 40px
		&-row
			flex-direction: row
			&.--icons
				.services-category-col
					width: 33.3%
					padding: 0 20px
					margin-bottom: 58px
			&.--list
				.services-category-col
					width: 50%
		&-icon
			max-width: 44px
		&-aside
			display: block
		&-title-wrp
			display: flex
		&-prev,
		&-next
			display: flex
		&-slider-wrp
			margin-bottom: 60px
			display: block
			.swiper-slide
				margin-right: 16px
		&-link
			padding: 10px 20px
</style>
