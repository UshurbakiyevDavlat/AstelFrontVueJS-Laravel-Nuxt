<template>
	<transition name="fade">
		<div v-if="$check('modals.callback')" class="callback-modal">
			<div
				class="callback-modal-backdrop"
				@click="$setFalse('modals.callback')"
			></div>
			<div class="callback-modal-inner">
				<button
					class="callback-modal-close"
					@click="$setFalse('modals.callback')"
				>
					<close />
				</button>
				<h1 class="callback-modal-title">
					{{ $trans("Обратная связь") }}
				</h1>
				<h2 class="callback-modal-heading">{{ $trans("Спасибо!") }}</h2>
				<p class="callback-modal-text">
					{{
						$trans(
							"Ваша заявка получена, мы свяжемся с Вами в ближайшее время!"
						)
					}}
				</p>
				<p class="callback-modal-text">
					{{
						$trans("Мы гарантируем сохранность Ваших личных данных")
					}}
				</p>
				<button
					class="callback-modal-btn"
					@click="$setFalse('modals.callback')"
				>
					{{ $trans("Закрыть") }}
				</button>
			</div>
		</div>
	</transition>
</template>

<script>
import close from "@/static/icons/close.svg";
export default {
	components: {
		close
	}
};
</script>

<style lang="sass">
.callback-modal
	position: fixed
	z-index: 1000
	top: 0
	left: 0
	width: 100%
	height: 100vh
	display: flex
	align-items: center
	justify-content: center
	&-heading
		font-family: $font-base
		font-size: 24px
		font-weight: 500
		color: $color-text
		margin-top: 124px
		margin-bottom: 42px
	&-text
		font-family: $font-base
		color: $color-text
		font-weight: 400
		font-size: 18px
		max-width: 367px
		text-align: center
		margin-bottom: 14px
	&-btn
		margin-top: 100px
		background: $color-blue
		color: #fff
		width: 206px
		height: 76px
		font-size: 14px
		font-family: $font-base
		font-weight: 400
	&-backdrop
		background: rgba(#000, 0.5)
		position: absolute
		top: 0
		left: 0
		width: 100%
		height: 100%
	&-inner
		background: #fff
		position: relative
		z-index: 1
		max-width: 770px
		padding-top: 40px
		padding-bottom: 70px
		width: 100%
		display: flex
		flex-direction: column
		align-items: center
	&-close
		padding: 0
		display: flex
		background: transparent
		position: absolute
		right: 22px
		top: 22px
		width: 20px
		height: 20px
		z-index: 1
	&-title
		font-size: 24px
		font-weight: 500
		color: $color-blue
		font-family: $font-base
@media (min-width: 320px)
	.callback-modal
		&-inner
			padding: 0 10px
			padding-top: 35px
			height: 100%
			align-items: flex-start
		&-text
			text-align: left
			font-size: 14px
			max-width: 100%
		&-heading
			margin-top: 54px
			font-size: 18px
		&-title
			font-size: 18px
		&-btn
			width: 170px
			height: 47px
			margin-top: 54px
@media (min-width: 768px)
	.callback-modal
		&-inner
			padding: 40px 0 70px
			height: auto
			align-items: center
		&-text
			text-align: center
			font-size: 18px
			max-width: 367
		&-heading
			margin-top: 124px
			font-size: 24px
		&-title
			font-size: 24px
		&-btn
			width: 206px
			height: 76px
			margin-top: 100px
</style>
