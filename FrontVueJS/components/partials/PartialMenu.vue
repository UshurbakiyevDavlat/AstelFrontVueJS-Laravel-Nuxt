<template>
	<transition name="fade">
		<div class="menu" v-if="$check('modals.menu')">
			<header class="menu-header">
				<!-- <div class="menu-langs-wrp">
					<div class="menu-lang-current">
						Ru
						<arrow />
					</div>
				</div> -->
				<div class="menu-search-wrp">
					<button class="menu-search-btn">
						<search-icon />
					</button>
					<input
						type="text"
						class="menu-input"
						placeholder="Введите текст"
					/>
				</div>
				<button class="menu-close" @click="close"><close /></button>
			</header>
			<template v-for="(item, index) in menuItems">
				<template v-if="item.childPages.length || item.id == 11">
					<div class="menu-item" @click="setDropdown(item.id)">
						<p class="menu-link">{{ item.name }}</p>
						<arrow />
					</div>
					<transition name="fade">
						<div
							class="menu-dropdown"
							v-if="currentDropdown == item.id"
						>
							<nuxt-link
								v-if="item.id !== 11"
								:to="$url(item.slug)"
								class="menu-dropdown-link"
								>{{ item.name }}</nuxt-link>
							<nuxt-link
								:to="$url(child.slug)"
								class="menu-dropdown-link"
								v-for="(child, index) in item.childPages"
								:key="index"
								>{{ child.name }}</nuxt-link>

							<div v-if="item.id == 11" v-for="(item2,index2) in menuServiceItems">
								<div class="menu-dropdown-link" 
									:key="index2" 
									data-header-item 
									v-if="item2.childServices.length">
									<nuxt-link 
										:to="$url(item.slug) + '/' + item2.slug" 
										class="menu-dropdown-link">{{ item2.name }}
									</nuxt-link>
									<nuxt-link 
										:to="$url(item.slug) + '/' + child2.slug" 
										class="menu-dropdown-link" 
										v-for="(child2, index2) in item2.childServices" 
										:key="index2">
										{{ child2.name }}
										<nuxt-link 
											:to="$url(item.slug) + '/' + item2.slug + '/' + child2.slug.split('/')[1] + '/' + grand['slug']" 
											class="menu-dropdown-link menu-dropdown__last" 
											v-for="(grand,index3) in item2.grandChildService" 
											:key="index3" 
											v-if="grand.parent_id === child2.id">{{ grand['name']['ru'] }}
										</nuxt-link>
									</nuxt-link>
								</div>
							</div>
						</div>
					</transition>
				</template>
				<nuxt-link :to="$url(item.slug)" class="menu-item" v-else>
					<p class="menu-link">{{ item.name }}</p>
				</nuxt-link>
			</template>
			<nuxt-link
				:to="$pageUrl('vacancies')"
				class="menu-text"
				v-if="$page('vacancies')"
				>{{ $page("vacancies").name }}</nuxt-link
			>
			<nuxt-link
				:to="$pageUrl('charity')"
				class="menu-text"
				v-if="$page('charity')"
				>{{ $page("charity").name }}</nuxt-link
			>
			<socials class="menu-socials"></socials>
			<div class="menu_lang">
			  <a class="lang_link-lang-current" href="#">{{ locales[locale] }}</a>
			  <a class="lang_link" :href="getLocaleUrl(null)" v-if="locale != 'ru'">{{ locales.ru }}</a>
			  <a class="lang_link" :href="getLocaleUrl('en')" v-if="locale != 'en'">{{ locales.en }}</a>
			  <a class="lang_link" :href="getLocaleUrl('kk')" v-if="locale != 'kk'">{{ locales.kk }}</a>
			</div>
		</div>
	</transition>
</template>

<script>
import arrow from "@/static/icons/arrow.svg";
import close from "@/static/icons/close.svg";
import searchIcon from "@/static/icons/search.svg";
import Socials from "~/components/partials/Socials";
import { mapGetters } from "vuex";

export default {
	components: {
		arrow,
		close,
		searchIcon,
		Socials
	},
	data: () => ({
		currentDropdown: null
	}),
	computed: {
		...mapGetters({
			menuItems: 'page/GET_MENU',
			menuServiceItems: 'page/GET_MENU_SERVICES',
			locale: 'translation/GET_LOCALE',
			locales: 'translation/GET_LOCALES'
		})
	},
	watch: {
		"$route.fullPath": function() {
			this.close();
		}
	},
	methods: {
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
		setDropdown(item_id) {
			this.currentDropdown =
				this.currentDropdown == item_id ? null : item_id;
		},
		close() {
			this.currentDropdown = null;
			document.body.classList.remove("--hidden");
			this.$setFalse("modals.menu");
		},
	}
};
</script>

<style lang="sass">
.menu
	background: #fff
	position: fixed
	top: 0
	left: 0
	z-index: 1000
	padding: 20px 10px 100px
	width: 100%
	height: 100vh
	overflow-y: auto
	&-header
		display: flex
		align-items: center
		justify-content: space-between
		margin-bottom: 30px
	&-lang-current
		font-size: 14px
		font-weight: 400
	&-search
		&-wrp
			display: flex
			align-items: center
		&-btn
			display: flex
			background: transparent
			padding: 0
			margin-right: 10px
	&-input
		width: 150px
		border: none
		border-bottom: 1px solid #c9c9c9
		font-size: 14px
	&-close
		padding: 0
		background: transparent
		svg
			width: 14px
			height: 14px
		path
			stroke: $color-text
	&-link
		font-size: 14px
		font-weight: 500
		color: $color-text
		text-transform: uppercase
	&-item
		display: flex
		align-items: center
		margin-top: 20px
		svg
			margin-left: 10px
	&-dropdown
		padding: 10px 15px 0
		&__last
			margin-left: 1rem
		&-link
			display: block
			font-size: 14px
			font-weight: 300
			color: $color-text
			margin-top: 10px
	&-text
		display: block
		margin-top: 20px
		color: $color-text
		font-size: 14px
		font-weight: 300
		&.--underline
			text-decoration: underline
		&.--blue
			color: $color-blue
	&-socials
		margin-top: 20px
		a
			margin-right: 20px
.menu_lang
	position: absolute
	margin-top: 40px
	margin-left: 10px
.lang_link
	margin-right: 30px
	margin-left: 10px
	font-weight: 400
	color: #8D8D8D
	&-lang-current
		font-weight: 600
		margin-right: 30px
		color: #303030

</style>
