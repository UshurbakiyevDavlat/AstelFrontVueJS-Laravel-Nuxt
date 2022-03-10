<template>
	<header class="header">
		<nuxt-link class="header-logo" :to="'/' + (locale === 'ru' ? '' : locale)">
			<img width="150" height="39" data-src="/icons/logo.svg" alt="Astel" data-header-item v-lazy-load>
		</nuxt-link>
		<div class="header-inner">
			<div class="header-top">
				<div class="header-lang-wrp">
					<div class="header-lang-current" data-header-item>
						{{ locales[locale] }}
						<arrow />
					</div>
					<div class="header-dropdown">
						<a 
							class="header-dropdown-link header-dropdown-link__social" 
							:href="getLocaleUrl(null)" 
							v-if="locale != 'ru'">
							{{ locales.ru }}
						</a>
						<a 
							class="header-dropdown-link header-dropdown-link__social" 
							:href="getLocaleUrl('en')" 
							v-if="locale != 'en'">
							{{ locales.en }}
						</a>
						<a 
							class="header-dropdown-link header-dropdown-link__social" 
							:href="getLocaleUrl('kk')" 
							v-if="locale != 'kk'">
							{{ locales.kk }}
						</a>
					</div>
				</div>
				<client-only>
					<socials class="header-socials" data-header-item></socials>
				</client-only>
			</div>
			<nav class="header-nav">
				<template v-for="(item, index) in menuItems">
					<div 
                        @click="closeDesctopMenu"
                        class="header-nav-link" 
                        :key="index" 
                        data-header-item 
                        v-if="item.childPages.length">
						{{ item.name }}
						<div class="header-dropdown">
							<nuxt-link 
								:to="$url(item.slug)" 
								class="header-dropdown-link">
								{{ item.name }}
							</nuxt-link>
							<nuxt-link 
								:to="$url(child.slug)"
								class="header-dropdown-link"
								v-for="(child, index) in item.childPages" 
								:key="index">
								{{ child.name }}
							</nuxt-link>
						</div>
					</div>
					<nuxt-link :to="$url(item.slug)" :key="index"
						data-header-item class="header-nav-link"
						v-else-if="index === 1"
						>{{ item.name }}
						<div class=".--menuOpen" v-bind:class="getLocaleMenu()">
							<div class="header-serviceContent">
								<div 
									v-for="(item2,index2) in menuServiceItems" 
									class="header-serviceDrop__item-wrap">
									<div
										@click="closeDesctopMenu"
										class="header-drop-link"
										:key="index2"
										data-header-item
										v-if="item2.childServices.length">
										<nuxt-link
											:to="$url(item.slug)+'/'+item2.slug"
											class="header-serviceDrop-title">
											{{ item2.name }}
										</nuxt-link>
										<nuxt-link 
											:to="$url(item.slug)+'/'+child2.slug" 
											class="header-serviceDrop-link" 
											v-for="(child2, index2) in item2.childServices" 
											:key="index2">
											{{ child2.name }}
											<nuxt-link 
												:to="$url(item.slug)+'/'+item2.slug + '/' + child2.slug.split('/')[1] +'/'+ grand['slug']"
												class="header-serviceDrop-link header-serviceDrop-underLink" 
												v-for="(grand,index3) in item2.grandChildService" 
												:key="index3" 
												v-if="grand.parent_id === child2.id">
												{{ grand['name']['ru'] }}
											</nuxt-link>
										</nuxt-link>
									</div>
								</div>
							</div>
						</div>
					</nuxt-link>
					<nuxt-link 
						:to="$url(item.slug)" 
						:key="index" data-header-item class="header-nav-link"
						v-else
						>
						{{ item.name }}
					</nuxt-link>
				</template>

				<div data-header-item class="header-search-wrp" :class="{'--active': searchActive}">
					<button class="header-search-btn" @click="searchActive = !searchActive"><search /></button>
					<form @submit.prevent="startSearch">
						<input type="text" class="header-search-input" placeholder="Введите текст" v-model="q">
					</form>
				</div>
			</nav>
		</div>
		<button data-header-item class="header-burger" @click="openMenu">
			<burger />
		</button>
		<a 
			:class="{scrollShow: scrollPosition > 400, scrollHide: scrollPosition < 400}"
			class="arrowUp" 
			href="#">
			<svg xmlns="http://www.w3.org/2000/svg" fill="#00236A" width="24" height="24" viewBox="0 0 24 24"><path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm0 7.58l5.995 5.988-1.416 1.414-4.579-4.574-4.59 4.574-1.416-1.414 6.006-5.988z"/></svg>
		</a>
	</header>
</template>

<script>
import search from "@/static/icons/search.svg";
import arrow from "@/static/icons/arrow.svg";
import Socials from "~/components/partials/Socials";
import burger from "@/static/icons/burger.svg";

import { gsap } from "gsap";
import { mapGetters } from 'vuex'

export default {
	components: {
		burger,
		search,
		arrow,
		Socials
	},
	data() {
		return {
			q: null,
			searchActive: false,
			scrollPosition: null,
		};
	},
	computed: {
		...mapGetters({
			menuItems: 'page/GET_MENU',
			menuServiceItems: 'page/GET_MENU_SERVICES',
			locale: 'translation/GET_LOCALE',
			locales: 'translation/GET_LOCALES'
		}),
	},
	watch: {
		'$route.fullPath': function() {
			this.searchActive = false
			this.q = null
		}
	},
	mounted() {
		this.animateOnLoad();
		window.addEventListener('scroll', this.updateScroll);
	},
	methods: {
		updateScroll() {
			this.scrollPosition = window.scrollY
		},
		getLocaleUrl(locale) {
			let items = this.$route.fullPath.split('/').filter(c => c)

			if (this.locale != 'ru') {
				items = items.slice(1)
			}

			if (locale) {
				items.unshift(locale)
			}

			let url = items.join('/')

			return `/${url}`
		},
		startSearch() {
			this.$router.push(this.$pageUrl('search', this.q))
		},
		animateOnLoad() {
			let tl = gsap.timeline();
			let header = document.querySelector(".header");
			let item = header.querySelectorAll("[data-header-item]");
			tl.fromTo(
				item,
				{ opacity: 0, y: 30 },
				{
					opacity: 1,
					y: 0,
					stagger: 0.06,
					duration: 0.6,
					ease: "power2.inOut",
				}
			);
		},
		openMenu() {
			document.body.classList.add("--hidden");
			this.$setTrue("modals.menu");
		},
		closeDesctopMenu() {
			document.body.classList.add("--menuClose");
			setTimeout(function(){
				document.body.classList.remove("--menuClose");
			}, 1000);
		},
		getLocaleMenu() {
			let locale;
			let menuLoc;
			locale = this.locale
			if (locale === 'ru') menuLoc = 'header-serviceDrop' 
			else if (locale === 'en') menuLoc = 'header-serviceDrop-eng'
			else if (locale === 'kk') menuLoc = 'header-serviceDrop-kz'
			return menuLoc
		}
	},
};
</script>

<style lang="sass">
@keyframes moveFromTop
	0%
		transform: translateY(-25px)
	100%
		transform: translateY(0)

.scrollShow
	opacity: 1
  	visibility: visible
	animation: moveFromTop .5s ease-in-out
    animation-delay: 200ms

.scrollHide
	opacity: 0
  	visibility: hidden

.arrowUp
	position: fixed
	right: 5%
	bottom: 7.5%
	display: flex
	justify-content: center
	align-content: center
	border-radius: 50%
	border: 1px solid #fff
	background: #fff
	-webkit-transition: all .5s ease
    -moz-transition: all .5s ease
    transition: all .5s ease
	@media (max-width: 556px)
		bottom: 5%
	
	&:hover
		transform: translateY(-8px)
		box-shadow: rgb(204, 219, 232) 3px 3px 6px 0px inset, 
		rgba(255, 255, 255, 0.5) -3px -3px 6px 1px inset
	svg
		width: 50px
		height: 50px
		-webkit-transition: all .5s ease
		-moz-transition: all .5s ease
		transition: all .5s ease
		&:hover
			transform: rotate(360deg)

.header
	display: flex
	box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1)
	position: relative
	z-index: 10
	&-drop-link
		padding: 1.2rem 0.5rem
	&-logo
		display: flex
		align-items: center
		justify-content: flex-end
		padding-right: 45px
		width: 277px
		flex-shrink: 0
		border-right: 1px solid #F8F8F8
	&-inner
		flex-grow: 1
	&-top
		background: #F8F8F8
		display: flex
		align-items: center
		padding: 12px 43px
	&-lang
		&-wrp
			position: relative
			display: block
			.header-dropdown
				top: 30px
				padding: 10px 20px
				&-link
					margin-bottom: 5px
			.header-serviceDrop
				top: 30px
				padding: 10px 20px
				&-link
					margin-bottom: 5px
			&:hover
				.header-dropdown
					opacity: 1
					visibility: visible
		&-current
			display: flex
			align-items: center
			font-size: 12px
			font-weight: 600
			cursor: pointer
			svg
				margin-left: 5px
				margin-top: 2px
	&-link
		font-size: 12px
		font-weight: 300
		color: #828282
		display: inline-block
		margin-left: 33px
		&.--blue
			color: $color-blue
		&.--underline
			text-decoration: underline
	&-dropdown
		position: absolute
		top: 100%
		left: 50%
		background: #fff
		z-index: 1
		transform: translateX(-50%)
		border-top: 3px solid $color-blue
		border-bottom: 3px solid $color-red
		transition: all .3s ease
		opacity: 0
		visibility: hidden
		box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1)
		&-link
			position: relative
			display: block
			padding: 1rem 1.5rem
			font-size: 14px
			font-weight: 300
			color: $color-text
			text-transform: initial
			&__social
				padding: 0
			&:last-child
				margin-bottom: 0
			&:hover
				color: $color-blue
	&-serviceContent
		display: grid
		grid-template-columns: repeat(5, 360px)
		grid-template-rows: 360px
		padding: 0.5rem 1.5rem
		@media (max-width: 1875px)
			grid-template-columns: repeat(5, 325px)
		@media (max-width: 1700px)
			grid-template-columns: repeat(4, 320px)
			grid-template-rows: 1fr
		@media (max-width: 1340px)
			grid-template-columns: repeat(4, 310px)
		@media (max-width: 1280px)
			grid-template-columns: repeat(4, 300px)

	&-serviceDrop
		position: absolute
		top: 100%
		left: -610%
		display: block
		margin: 0 auto
		z-index: 99999
		background: #fff
		border-top: 3px solid $color-blue
		border-bottom: 3px solid $color-red
		box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1)
		visibility: hidden
		opacity: 0
		transition: all .3s ease
		@media (max-width: 1700px)
			left: -550%
		@media (max-width: 1536px)
			left: -480%
		@media (max-width: 1440px)
			left: -550%
		@media (max-width: 1380px)
			left: -535%
		@media (max-width: 1280px)
			left: -645%

		// KZZZZ

		&-kz
			position: absolute
			top: 100%
			left: -440%
			display: block
			margin: 0 auto
			z-index: 99999
			background: #fff
			border-top: 3px solid $color-blue
			border-bottom: 3px solid $color-red
			box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1)
			visibility: hidden
			opacity: 0
			transition: all .3s ease
			@media (max-width: 1700px)
				left: -550%
			@media (max-width: 1536px)
				left: -360%
			@media (max-width: 1380px)
				left: -340%
			@media (max-width: 1280px)
				left: -445%	

		// ENGGGGG

		&-eng
			position: absolute
			top: 100%
			left: -500%
			display: block
			margin: 0 auto
			z-index: 99999
			background: #fff
			border-top: 3px solid $color-blue
			border-bottom: 3px solid $color-red
			box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1)
			visibility: hidden
			opacity: 0
			transition: all .3s ease
			@media (max-width: 1750px)
				left: -510%
			@media (max-width: 1536px)
				left: -380%
			@media (max-width: 1280px)
				left: -535%	
		
		&__item-wrap
			width: 100%
			max-width: 290px
			&:nth-child(1)
				order: 1
			&:nth-child(2)
				order: 2
			&:nth-child(3)
				order: 3
			&:nth-child(4)
				order: 4
			&:nth-child(5)
				order: 5
			&:nth-child(6)
				order: 6
			&:nth-child(7)
				order: 7
			&:nth-child(8)
				order: 4
			&:nth-child(5),
			&:nth-child(6),
			&:nth-child(7),
				position: relative
				top: -80%
				left: 100%
				@media (max-width: 1700px)
					top: -75%
					left: 0
				@media (max-width: 1536px)
					top: -55%
					left: 0
		&-title
			padding-bottom: 0.5rem
			font-size: 16px
			color: #303030
			text-transform: uppercase
			opacity: .6
			&:last-child
				margin-bottom: 0
		&-link
			display: grid
			padding-top: 7px
			font-size: 14px
			color: $color-black
			font-weight: 500
			text-decoration: underline black
			text-transform: initial
			&:last-child
				margin-bottom: 0
			&:hover
				color: $color-blue
		&-underLink
			display: list-item
			margin-left: 1rem
			ist-style-type: revert
			font-size: 12px
			@media (max-width: 1547px)
				font-size: 11px

	&-socials
		margin-left: auto
		display: flex
		align-items: center
		a
			margin-left: 22px
			display: flex
			&:first-child
				margin-left: 0
	&-nav
		display: flex
		padding: 0 43px
		&-link
			cursor: pointer
			user-select: none
			padding: 35px 0
			font-size: 14px
			font-weight: 600
			color: $color-text
			text-transform: uppercase
			margin-right: 95px
			position: relative
			&:hover
				.header-dropdown
					opacity: 1
					visibility: visible
				.header-serviceDrop
					opacity: 1
					visibility: visible
				.header-serviceDrop-kz
					opacity: 1
					visibility: visible
				.header-serviceDrop-eng
					opacity: 1
					visibility: visible
	&-search
		&-wrp
			padding: 35px 0
			margin-left: auto
			display: flex
			overflow: hidden
			&.--active
				.header-search-btn
					transform: translateX(0)
				.header-search-input
					transform: translateX(0)
		&-input
			border: none
			border-bottom: 1px solid #C9C9C9
			font-size: 12px
			font-weight: 400
			color: $color-text
			width: 150px
			transform: translateX(150px)
			transition: transform .6s ease
			margin-left: 12px
		&-btn
			padding: 0
			background: transparent
			display: flex
			transform: translateX(162px)
			transition: transform .6s ease
@media (min-width: 320px)
	.header
		padding: 10px
		align-items: center
		&-top,
		&-nav
			display: none
		&-logo
			padding: 0
			width: auto
			img
				width: 100%
				max-width: 100px
		&-burger
			background: transparent
@media (min-width: 1280px)
	.header
		padding: 0
		align-items: initial
		&-top,
		&-nav
			display: flex
		&-logo
			padding-right: 30px
			width: 200px
			img
				max-width: 150px
		&-burger
			display: none
		&-nav
			padding: 0 25px
		&-top
			padding: 12px 25px
		&-nav-link
			margin-right: 65px
		&-nav-link,
		&-search-wrp
			padding: 25px 0
</style>
