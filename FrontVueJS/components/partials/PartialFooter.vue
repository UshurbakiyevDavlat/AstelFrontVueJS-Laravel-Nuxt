<template>
	<footer class="footer">
		<p class="footer-text --copyright">{{ $trans('(с) 1993-{year} АО «ASTEL» (АСТЕЛ)', year) }}</p>
		<nav class="footer-nav">
			<nuxt-link :to="$url(item.slug)" class="footer-text" v-for="(item, index) in menuItems" :key="index">{{ item.name }}</nuxt-link>
		</nav>
		<socials class="footer-socials"></socials>
		<div class="footer-mobile">
			<p class="footer-text --thin">{{ $trans('ASTEL | Все права защищены') }}</p>
			<a :href="$settings('privacy_policy')" target="_blank" v-if="$settings('privacy_policy')"><p class="footer-text --thin">{{ $trans('Политика конфеденциальности') }}</p></a>
			<a :href="$settings('offer_agreement')" target="_blank" v-if="$settings('offer_agreement')"><p class="footer-text --thin">{{ $trans('Договор оферта') }}</p></a>
			<p class="footer-text">{{ $trans('(с) 1993-{year} АО «ASTEL» (АСТЕЛ)', year) }}</p>
		</div>
	</footer>
</template>

<script>
import Socials from "~/components/partials/Socials";

import { mapGetters } from 'vuex'

export default {
	components: {
		Socials
	},
	computed: {
		...mapGetters({
			menuItems: 'page/GET_MENU'
		}),
		year() {
			return new Date().getFullYear()
		}
	}
};
</script>

<style lang="sass">
.footer
	display: flex
	align-items: center
	position: relative
	padding: 22px 50px
	background: $color-blue
	&-text
		font-size: 12px
		font-weight: 600
		color: #fff
	&-nav
		position: absolute
		left: 50%
		top: 50%
		transform: translate(-50%, -50%)
		z-index: 1
		a
			margin-right: 55px
			&:last-child
				margin-right: 0
	&-socials
		margin-left: auto
		margin-right: 56px
		a
			display: inline-block
			margin-right: 22px
			&:last-child
				margin-right: 0
		path
			fill: #fff
			fill-opacity: 1
@media (min-width: 320px)
	.footer
		padding: 40px 10px
		flex-direction: column
		align-items: flex-start
		.--copyright
			display: none
		&-nav
			position: static
			transform: none
			display: flex
			flex-direction: column
			a
				margin-right: 0
				margin-bottom: 12px
		&-socials
			margin: 13px 0 25px
		&-text
			&.--thin
				font-weight: 300
				margin-bottom: 18px
		&-mobile
			margin-bottom: 25px
@media (min-width: 1024px)
	.footer
		flex-direction: row
		align-items: center
		.--copyright
			display: block
		&-socials
			margin: 0
			display: flex
			margin-left: auto
			margin-right: 35px
			a
				display: flex
		&-bs
			display: flex
		&-nav
			position: absolute
			transform: translate(-50%, -50%)
			flex-direction: row
			a
				white-space: nowrap
				margin-bottom: 0
				margin-right: 35px
		&-mobile
			display: none
@media (min-width: 1280px)
	.footer
		padding: 22px 50px
</style>
