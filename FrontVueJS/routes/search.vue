<template>
	<div class="search-page">
		<ui-breadcrumbs link-text="Поиск" :dark="true" />
		<div class="layout-container">
			<h1 class="search-page-title">{{ $page().name }}</h1>
			<form @submit.prevent="startSearch" class="search-page-input-wrp">
				<button class="search-page-btn"><search-icon /></button>
				<input type="text" :placeholder="$trans('Введите текст')" class="search-page-input" v-model="q" @change="startSearch">
			</form>
			<p class="page-text">
				<template v-if="total">
					{{ $trans('По Вашему запросу найдено {cnt} ответов', total) }} <template v-if="total > 0">{{ $trans('(Результаты запроса {range})', `${results.from + 1} - ${results.to}`) }} </template>:
				</template>
				<template v-else-if="$route.params.slug">
					{{ $trans('По Вашему запросу ничего не найдено') }}
				</template>
			</p>
			<div class="search-page-item" v-for="(result, index) in results.data" :key="index">
				<h4 class="search-page-heading">{{ result.title }}</h4>
				<p class="page-text" v-if="result.description">{{ result.description }}</p>
				<nuxt-link :to="$pageUrl(result.template, result.slug)" class="search-page-link">
					{{ $trans('Подробнее') }}
					<arrow />
				</nuxt-link>
			</div>
			<ui-pagination :paginator="results" />
		</div>
	</div>
</template>

<script>
import arrow from "@/static/icons/arrow.svg";
import searchIcon from "@/static/icons/search.svg";
import UiBreadcrumbs from "~/components/ui/UiBreadcrumbs";
import UiPagination from "~/components/ui/UiPagination";

export default {
	components: {
		arrow,
		searchIcon,
		UiBreadcrumbs,
		UiPagination
	},
	data() {
		return {
			q: this.$route.params.slug
		}
	},
	computed: {
		results() {
			return this.$page().results
		},
		total() {
			return this.results.total ? this.results.total : 0
		}
	},
	methods: {
		startSearch() {
			this.$router.push(this.$pageUrl('search', this.q))
		}
	}
};
</script>

<style lang="sass">
.search-page
	padding: 40px 50px 80px
	.pagination
		margin-top: 40px
	&-heading
		font-size: 24px
		font-weight: 400
		color: $color-blue
		margin-bottom: 10px
	&-item
		margin-top: 40px
	&-link
		display: flex
		align-items: center
		font-size: 14px
		font-weight: 300
		color: $color-red
		margin-top: 16px
		svg
			margin-left: 10px
			transform: rotate(-90deg)
		path
			stroke: $color-red
	&-title
		margin-top: 50px
		font-size: 36px
		color: $color-blue
		font-weight: 500
	&-input-wrp
		display: flex
		align-items: center
		margin: 27px 0
	&-btn
		background: transparent
		display: flex
		padding: 0
		flex-shrink: 0
		margin-right: 12px
	&-input
		flex-grow: 1
		border: none
		border-bottom: 1px solid #c9c9c9
		font-size: 14px
		font-weight: 300
		color: $color-text
@media (min-width: 320px)
	.search-page
		padding: 30px 10px
		&-title
			font-size: 18px
			margin: 30px 0
		&-heading
			font-size: 18px
@media (min-width: 1280px)
	.search-page
		padding: 40px 50px 80px
		&-title
			font-size: 36px
			margin-top: 50px
			margin-bottom: 0
		&-heading
			font-size: 24px
</style>
