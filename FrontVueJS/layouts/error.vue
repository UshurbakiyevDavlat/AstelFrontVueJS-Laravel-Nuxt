<template>
	<div class="error-page">
		<div class="error-page-inner" v-if="error.statusCode === 404">
			<h4 class="error-page-title"><span>404:</span> {{ $trans('Страница не найдена') }}</h4>

			<p class="error-page-text">Страницы, которую Вы запрашиваете, не существует.<br>
				Возможно, она была удалена, либо адрес страницы введен некорректно.<br>
				Пожалуйста, попробуйте найти нужную Вам информацию с главной страницы</p>
			<nuxt-link class="error-page-btn" :to="$url('/')">{{ $trans('Вернуться на главную') }}</nuxt-link>
		</div>
		<div class="error-page-inner" v-if="error.statusCode === 500">
			<h4 class="error-page-title"><span>500:</span> {{ $trans('Возникла ошибка') }}</h4>
			<p class="error-page-text">{{ $trans('Попробуйте повторить запрос позже.') }}</p>
			<nuxt-link class="error-page-btn" :to="$url('/')">{{ $trans('Вернуться на главную') }}</nuxt-link>
		</div>
	</div>
</template>

<script>
export default {
	props: ["error"],
}
</script>

<style lang="sass" scoped>
.error-page
	display: flex
	align-items: center
	justify-content: center
	height: calc(100vh - 180px)
	&-inner
		display: flex
		flex-direction: column
		align-items: center
	&-title
		font-size: 36px
		font-weight: 500
		margin-top: 40px
		span
			color: #c00d0d
	&-text
		font-size: 15px
		font-weight: 400
		text-align: center
		margin-top: 16px
		margin-bottom: 24px
	&-btn
		display: inline-block
		padding: 14px 24px
		border-radius: 999px
		border: none
		background-color: #c00d0d
		color: #fff
		font-size: 15px
		font-weight: 500
</style>
