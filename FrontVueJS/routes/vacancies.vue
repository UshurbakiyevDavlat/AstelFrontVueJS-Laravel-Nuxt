<template>
	<div class="vacancies-page">
		<vacancy-modal :vacancy="currentVacancy" />
		<inner-hero
			:links="breadcrumbs"
			:image="$page().image"
			:title="$page().name"
			:text="$page().description"
		/>
		<div class="layout-container" data-scroll-section>
			<h2 class="vacancies-page-title" data-on-scroll-paginate>
				{{ $page().title }}
			</h2>
			<div
				class="page-text"
				data-on-scroll-paginate
				v-html="$page().content"
			></div>
			<div class="vacancies-page-select-wrp" data-on-scroll-paginate>
				<ui-select
					v-model="currentTab"
					default="Выберите вакансию"
					:options="$page().vacancies.map(v => v.name)"
				/>
			</div>
			<div class="vacancies-page-row" data-on-scroll-paginate>
				<nav class="vacancies-page-btn-wrp">
					<button
						class="button --gray"
						:class="{ '--blue': currentTab == index }"
						v-for="(vacancy, index) in $page().vacancies"
						@click="currentTab = index"
						:key="index"
					>
						{{ vacancy.name }}
					</button>
				</nav>
				<div class="vacancies-page-right">
					<transition-group name="fade" mode="out-in">
						<div
							v-for="(vacancy, index) in $page().vacancies"
							:key="`vac-${vacancy.id}`"
						>
							<div
								class="vacancies-page-tab"
								v-if="currentTab == index"
							>
								<div class="vacancies-page-heading-wrp">
									<p class="page-text">{{ vacancy.name }}</p>
									<p class="page-text">
										{{ vacancy.salary || "" }}
									</p>
								</div>
								<div
									class="vacancies-page-content"
									v-html="vacancy.content"
								></div>
								<button
									class="vacancies-page-reply-btn"
									@click="openModal"
								>
									{{ $trans("Откликнуться") }}
								</button>
							</div>
						</div>
					</transition-group>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
import VacancyModal from "~/components/partials/VacancyModal";
import InnerHero from "~/components/partials/InnerHero";
import UiSelect from "~/components/ui/UiSelect";
import {gsap} from "gsap";

export default {
	components: {
		VacancyModal,
		InnerHero,
		UiSelect
	},
	data: () => ({
		currentTab: 0
	}),
	computed: {
		breadcrumbs() {
			return [
				{
					url: this.$pageUrl("vacancies"),
					text: this.$page("vacancies").name
				}
			];
		},
		currentVacancy() {
			return this.$page().vacancies && this.$page().vacancies.length > 0
				? this.$page().vacancies[this.currentTab]
				: null;
		}
	},
	mounted(){
		this.animateOnLoad();
	},
	methods: {
		openModal() {
			document.body.classList.add("--hidden");
			this.$setTrue("modals.vacancy");
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
.vacancies-page
	&-select-wrp
		margin-top: 30px
		z-index: 1
		position: relative
		.custom-select
			display: flex
			align-items: flex-start
			width: 100%
			max-width: 370px
		.custom-select .items
			border-color: $color-blue
			div
				color: $color-blue
		.custom-select .arrow
			top: 17px
			path
				stroke: $color-blue
		.custom-select .selected
			padding: 10px 15px
			padding-right: 50px
			border-radius: 15px
			border-color: $color-blue
			color: $color-blue
			width: 100%
	&-reply-btn
		width: 170px
		line-height: 50px
		border: 1px solid $color-blue
		border-radius: 999px
		text-align: center
		font-size: 14px
		font-weight: 300
		color: $color-blue
		background: transparent
		margin: 0 auto
		margin-top: 30px
		display: block
	.layout-container
		padding: 80px 0
	&-title
		font-size: 24px
		font-weight: 500
		color: $color-blue
		margin-bottom: 10px
	&-row
		display: flex
		align-items: flex-start
		margin-top: 80px
	&-btn-wrp
		width: 283px
		flex-shrink: 0
		margin-right: 56px
	&-right
		flex-grow: 1
		position: relative
	.button
		width: 100%
		margin-bottom: 20px
		&:hover
			color: #fff
			background: $color-blue
	&-heading-wrp
		display: flex
		align-items: center
		justify-content: space-between
		padding-bottom: 20px
		margin-bottom: 20px
		border-bottom: 1px solid #ededed
@media (min-width: 320px)
	.vacancies-page
		&-btn-wrp
			display: none
		&-reply-btn
			line-height: 42px
			margin-left: 0
		&-content *
			color: $color-text
			font-size: 14px
			font-weight: 300
			line-height: 24px
		.layout-container
			padding: 30px 10px
		&-title
			font-size: 18px
		&-row
			margin-top: 30px
		&-heading-wrp
			.page-text:first-child
				width: 60%
			.page-text:last-child
				width: 40%
				text-align: right
@media (min-width: 1280px)
	.vacancies-page
		&-select-wrp,
			display: none
		&-btn-wrp
			display: block
		&-reply-btn
			line-height: 50px
			margin-left: auto
		.layout-container
			padding: 80px 0
		&-title
			font-size: 24px
		&-row
			margin-top: 80px
</style>
