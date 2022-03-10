<template>
	<div class="home-contacts" data-scroll-section v-if="city">
		<div class="home-contacts-map">
			<img
				:src="$page().contacts_image"
				:alt="$page().contacts_title"
				data-on-scroll-paginate
				class="animate-home-contacts"
			/>
		</div>
		<div class="layout-container">
			<h2 class="home-page-title animate-home-contacts" data-on-scroll-paginate>
				{{ $page().contacts_title }}
			</h2>
			<div class="home-contacts-select-wrp animate-home-contacts" data-on-scroll-paginate>
				<ui-select
					v-model="currentCityIndex"
					:default="$trans('Выберите город')"
					:options="cityNames"
				/>
			</div>
			<div data-on-scroll-paginate class="animate-home-contacts" v-if="city.address" >
				<h5 class="home-contacts-heading">{{ $trans("Адрес") }}</h5>
				<p class="home-contacts-text --mb">{{ city.address }}</p>
			</div>
			<div data-on-scroll-paginate class="animate-home-contacts" v-if="city.phones && city.phones.length">
				<h5 class="home-contacts-heading">{{ $trans("Телефон:") }}</h5>
				<a
					:href="'tel:' + $tel(phone.phone)"
					v-for="(phone, index) in city.phones"
					:key="index"
					class="home-contacts-text --mb">
					{{ phone.phone }}
				</a>
			</div>
			<div data-on-scroll-paginate class="animate-home-contacts" v-if="city.support && city.support.length">
				<h5 class="home-contacts-heading">
					{{ $trans("Служба поддержки пользователей:") }}
				</h5>
				<p
					v-for="(item, index) in city.support"
					:key="index"
					class="home-contacts-text --mb"
				>
					{{ item.label }}
				</p>
			</div>
			<div data-on-scroll-paginate class="animate-home-contacts" v-if="city.emails && city.emails.length">
				<h5 class="home-contacts-heading">{{ $trans("E-mail:") }}</h5>
				<a
					:href="`mailto:${email.email}`"
					v-for="(email, index) in city.emails"
					:key="index"
					class="home-contacts-text --mb"
					>{{ email.email }}</a
				>
			</div>
			<div data-on-scroll-paginate class="animate-home-contacts" v-if="city.faxes && city.faxes.length">
				<h5 class="home-contacts-heading">{{ $trans("Факс:") }}</h5>
				<a
					:href="`fax:${fax.fax}`"
					v-for="(fax, index) in city.faxes"
					:key="index"
					class="home-contacts-text --mb"
					>{{ fax.fax }}</a
				>
			</div>
			<div data-on-scroll-paginate class="animate-home-contacts" v-if="city.description">
				<h5
					class="home-contacts-heading"
					v-html="city.description"
				></h5>
			</div>
			<div class="home-contacts-footer animate-home-contacts" data-on-scroll-paginate>
				<p class="home-contacts-footer-txt">
					{{ $trans("ASTEL | Все права защищены") }}
				</p>
				<a
					:href="$settings('privacy_policy')"
					target="_blank"
					v-if="$settings('privacy_policy')"
					class="home-contacts-footer-txt --margin"
				>
					{{ $trans("Политика конфеденциальности") }}
				</a>
				<a
					:href="$settings('offer_agreement')"
					target="_blank"
					v-if="$settings('offer_agreement')"
					class="home-contacts-footer-txt"
				>
					{{ $trans("Договор оферта") }}
				</a>
			</div>
		</div>
	</div>
</template>

<script>
import contacts from "@/mixins/contacts";
import UiSelect from "~/components/ui/UiSelect";
import {gsap} from "gsap";

export default {
	mixins: [contacts],
	components: {
		UiSelect
	},
	props: ['timeline'],
	mounted(){
		this.animateOnLoad();
	},
	methods: {
		animateOnLoad() {
			//let tl = this.timeline;
			//let tl = gsap.timeline();
			let tl = gsap;
			//let header = document.querySelector(".layout-content");
			let item = document.querySelectorAll(".animate-home-contacts");
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
.home-contacts
	position: relative
	padding-top: 50px
	padding-bottom: 30px
	background: $bg-base
	.layout-container
		position: relative
		z-index: 1
	.home-page-title
		margin-bottom: 34px
	&-text
		display: block
		font-size: 14px
		font-weight: 300
		color: #686877
		max-width: 206px
		&.--mb
			margin-bottom: 18px
	&-map
		position: absolute
		top: 50%
		right: 10vw
		transform: translateY(-50%)
	&-heading
		max-width: 340px
		font-size: 18px
		line-height: 25px
		font-weight: 500
		color: $color-blue
		margin-bottom: 7px
	&-footer
		border-top: 1px solid #E8E8E8
		margin-top: 68px
		padding-top: 34px
		display: flex
		align-items: center
		&-txt
			font-size: 12px
			font-weight: 300
			color: #686877
			&.--margin
				margin-left: auto
				margin-right: 30px
@media (min-width: 320px)
	.home-contacts
		padding: 40px 10px
		&-map,
		&-footer
			display: none
		&-heading
			font-size: 14px
		&-select-wrp
			position: relative
			z-index: 1
		.custom-select .items
			background: $bg-base
			border-color: $color-blue
			div
				color: $color-blue
		.custom-select .selected
			background: $bg-base
			border-color: $color-blue
			border-radius: 15px
			color: $color-blue
		.custom-select .arrow
			path
				stroke: $color-blue
@media (min-width: 1280px)
	.home-contacts
		padding: 100px 0px
		&-map
			display: block
			right: 10vw
			top: 40%
			max-width: 70vw
		&-footer
			display: flex
		&-heading
			font-size: 16px
		&-select-wrp
			display: none
</style>
