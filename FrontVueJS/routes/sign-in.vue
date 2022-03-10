<template>
	<div class="sign-in-page" data-scroll-section>
		<ui-breadcrumbs link-text="Вход для клиентов" data-on-scroll-paginate :dark="true" />
		<div class="layout-container">
			<h1 class="sign-in-page-title" data-on-scroll-paginate>Вход для клиентов</h1>
			<form class="sign-in-page-form">
				<p class="sign-in-page-label">E-mail</p>
				<input type="email" class="sign-in-page-input">
				<p class="sign-in-page-label">Пароль</p>
				<input type="password" class="sign-in-page-input">
				<button class="sign-in-page-btn">Войти</button>
			</form>
		</div>
	</div>
</template>

<script>
import UiBreadcrumbs from "~/components/ui/UiBreadcrumbs";
import {gsap} from "gsap";

export default {
	components: {
		UiBreadcrumbs
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
.sign-in-page
	padding: 40px 50px
	&-title
		font-size: 42px
		font-weight: 500
		color: $color-blue
		margin: 50px 0
		text-align: center
	&-form
		width: 320px
		margin: 0 auto
	&-label
		font-size: 14px
		font-weight: 300
		color: $color-text
		margin-left: 16px
	&-input
		width: 100%
		display: block
		border: none
		background: $bg-base
		margin-bottom: 20px
		font-size: 14px
		font-weight: 300
		color: $color-text
		padding: 10px 16px
	&-btn
		width: 100%
		display: block
		font-size: 14px
		font-weight: 400
		color: #fff
		background: $color-blue
		text-align: center
		height: 52px
@media (min-width: 320px)
	.sign-in-page
		padding: 30px 10px
		&-title
			font-size: 18px
			margin: 30px 0
		&-form
			width: 100%
@media (min-width: 768px)
	.sign-in-page
		&-form
			width: 320px
@media (min-width: 1280px)
	.sign-in-page
		padding: 40px 50px
		&-title
			font-size: 36px
			margin: 50px 0
</style>
