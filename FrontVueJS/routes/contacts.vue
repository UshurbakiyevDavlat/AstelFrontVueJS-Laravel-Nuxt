<template>
	<div class="contacts">
		<div class="contacts-top" data-scroll-section>
			<ui-breadcrumbs :links="breadcrumbs" data-on-scroll-paginate :dark="true" />
			<div class="contacts-container">
				<div class="contacts-row">
					<div class="contacts-select-wrp">
						<h1 class="contacts-title" data-on-scroll-paginate>
							{{ $page().name }}
						</h1>
						<ui-select
							v-model="currentCityIndex"
							:options="cityNames"
							data-on-scroll-paginate
						/>
					</div>
					<div class="contacts-info-wrp" v-if="city">
						<div class="contacts-col" data-on-scroll-paginate>
							<div class="contacts-block" v-if="city.address">
								<h6 class="contacts-heading">
									{{ $trans("Головной офис") }}
								</h6>
								<p class="contacts-text">{{ city.address }}</p>
							</div>
							<div class="contacts-block" v-if="city.phones && city.phones.length">
								<h6 class="contacts-heading">
									{{ $trans("Телефон:") }}
								</h6>
								<a
									:href="'tel:' + $tel(phone.phone)"
									v-for="(phone, index) in city.phones"
									:key="index"
									><p class="contacts-text">
										{{ phone.phone }}
									</p></a
								>
							</div>
							<div class="contacts-block" v-if="city.emails && city.emails.length">
								<h6 class="contacts-heading">
									{{ $trans("E-mail:") }}
								</h6>
								<a
									:href="`mailto:${email.email}`"
									v-for="(email, index) in city.emails"
									:key="index"
									><p class="contacts-text">{{ email.email }}</p></a
								>
							</div>
							<div class="contacts-block" v-if="city.faxes && city.faxes.length">
								<h6 class="contacts-heading">
									{{ $trans("Факс:") }}
								</h6>
								<a
									:href="`fax:${fax.fax}`"
									v-for="(fax, index) in city.faxes"
									:key="index"
									><p class="contacts-text">{{ fax.fax }}</p></a
								>
							</div>
						</div>
						<div class="contacts-col" data-on-scroll-paginate>
							<div class="contacts-block" v-if="city.support && city.support.length">
							<h6 class="contacts-heading">
								{{ $trans("Служба поддержки пользователей:") }}
							</h6>
							<p
								class="contacts-text"
								v-for="(item, index) in city.support"
								:key="index"
							>
								{{ item.label }}
							</p>
						</div>
						<div class="contacts-block" v-if="city.description">
							<h6
								class="contacts-heading"
								v-html="city.description"
							></h6>
						</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="contacts-map">
			<client-only>
				<yandex-map
					:coords="coords"
					style="width:100%;height: 100%;"
					:zoom="zoom"
				>
					<ymap-marker
						:coords="[marker.lat, marker.long]"
						:marker-id="index"
						v-for="(marker, index) in markers"
						:key="index"
					/>
				</yandex-map>
			</client-only>
		</div>
		<div
			class="contacts-bot"
			data-scroll-section
			v-if="$page().departments"
		>
			<div class="contacts-container">
				<div class="contacts-row">
					<h4 class="contacts-subtitle" v-if="$page().departments && $page().departments.length" data-on-scroll-paginate>
						{{ $trans("Отделы") }}
					</h4>
					<ul class="contacts-list">
						<li
							class="contacts-list-item"
							data-on-scroll-paginate
							v-for="(item, index) in $page().departments"
							:key="index"
						>
							<p class="page-text">{{ item.name }}</p>
							<a
								:href="$tel(item.phone)"
								class="contacts-phone"
								v-if="item.phone"
								><p class="contacts-list-text">
									{{ item.phone }}
								</p></a
							>
							<a
								:href="`mailto:${item.emial}`"
								class="contacts-email"
								v-if="item.email"
								><p class="contacts-list-text --underline">
									{{ item.email }}
								</p></a
							>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<partial-form />
	</div>
</template>

<script>
import contacts from "@/mixins/contacts";
import UiBreadcrumbs from "~/components/ui/UiBreadcrumbs";
import UiSelect from "~/components/ui/UiSelect";
import PartialForm from "~/components/partials/PartialForm";
import {gsap} from "gsap";

export default {
	mixins: [contacts],
	components: {
		UiSelect,
		UiBreadcrumbs,
		PartialForm
	},
	data() {
		return {
			zoom: 12
		};
	},
	computed: {
		breadcrumbs() {
			return [
				{
					url: this.$pageUrl("contacts"),
					text: this.$page("contacts").name
				}
			];
		},
		coords() {
			return this.markers.length == 0
				? [43.25886500000001, 76.89687350000001]
				: [
						this.markers
							.map(s => Number(s.lat))
							.reduce((a, b) => a + b, 0) / this.markers.length,
						this.markers
							.map(s => Number(s.long))
							.reduce((a, b) => a + b, 0) / this.markers.length
				  ];
		},
		markers() {
			return this.city && this.city.coords
				? this.city.coords.filter(m => m.lat && m.long)
				: [];
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
.contacts
	padding-bottom: 80px
	.breadcrumbs
		margin-bottom: 50px
	&-top
		padding: 40px 50px
	&-container
		max-width: 1115px
		width: 100%
		margin: 0 auto
		position: relative
		z-index: 1
	&-select-wrp
		margin-right: 260px
		position: relative
		z-index: 2
		.items
			background: #fff
	&-title
		font-size: 42px
		font-weight: 500
		color: $color-blue
		margin-bottom: 27px
	&-heading
		font-size: 18px
		font-weight: 500
		color: $color-text
		max-width: 300px
		margin-bottom: 7px
	&-text
		font-size: 14px
		font-weight: 300
		color: #686877
		max-width: 210px
	&-row
		display: flex
		&.--mt
			margin-top: 120px
	&-col
		width: 50%
	&-block
		margin-bottom: 18px
	&-info-wrp
		display: flex
		flex-wrap: wrap
	&-map
		height: 516px
		display: flex
		justify-content: center
		align-items: center
		background: $bg-base
		margin-bottom: 65px
	&-subtitle
		font-size: 24px
		font-weight: 500
		color: $color-blue
	&-list
		max-width: 773px
		margin-left: auto
		width: 100%
		&-item
			display: flex
			align-items: center
			padding: 22px 0
			border-bottom: 1px solid #D6D6D6
		&-text
			font-size: 14px
			font-weight: 300
			color: $color-text
			&.--underline
				text-decoration: underline
	&-phone
		margin-left: auto
	&-email
		width: 30%
		text-align: right
@media (min-width: 320px)
	.contacts
		padding-bottom: 0
		.breadcrumbs
			margin-bottom: 30px
		&-row
			flex-direction: column
			&.--mt
				display: none
		&-col
			width: 100%
		&-select-wrp
			margin-right: 0
			max-width: 400px
		&-top,
		&-bot
			padding: 30px 10px
		&-top
			padding-bottom: 10px
		&-title
			font-size: 18px
		&-subtitle
			font-size: 16px
		&-list
			margin-left: 0
		&-map
			height: 210px
			margin-bottom: 0
		&-heading
			font-size: 14px
		&-list
			max-width: 100%
			&-item
				flex-direction: column
				align-items: flex-start
		&-phone
			margin-left: 0
			margin-top: 10px
		&-email
			margin-top: 10px
			width: auto
@media (min-width: 768px)
	.contacts
		&-map
			height: 350px
@media (min-width: 1024px)
	.contacts
		&-col
			width: 50%
@media (min-width: 1280px)
	.contacts
		padding-bottom: 80px
		.breadcrumbs
			margin-bottom: 50px
		&-row
			flex-direction: row
		&-select-wrp
			margin-right: 260px
			max-width: 400px
		&-top
			padding: 40px 50px
		&-bot
			padding: 0
		&-title
			font-size: 36px
		&-subtitle
			font-size: 18px
		&-list
			margin-left: auto
		&-map
			height: 516px
			margin-bottom: 65px
		&-heading
			font-size: 18px
		&-list
			max-width: 770px
			&-item
				flex-direction: row
				align-items: center
		&-phone
			margin-left: auto
			margin-top: 0
		&-email
			margin-top: 0
			width: 30%
@media (min-width: 1440px)
	.contacts
		&-subtitle
			font-size: 24px
</style>
