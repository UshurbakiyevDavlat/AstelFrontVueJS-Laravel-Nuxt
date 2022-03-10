<template>
	<transition name="fade">
		<div v-if="$check('modals.vacSuccess')" class="vac-success">
			<div
				class="vac-success-backdrop"
				@click="$setFalse('modals.vacSuccess')"
			></div>
			<div class="vac-success-inner">
				<button
					class="vac-success-close"
					@click="$setFalse('modals.vacSuccess')"
				>
					<close />
				</button>
				<h1 class="vac-success-title">{{ $trans("Спасибо!") }}</h1>
				<p class="vac-success-text">
					{{
						$trans(
							"Ваше резюме получено, мы обязательно рассмотрим его и свяжемся с Вами в случае заинтересованности!"
						)
					}}
				</p>
				<button
					class="vac-success-btn"
					@click="$setFalse('modals.vacSuccess')"
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
.vac-success
	position: fixed
	z-index: 1000
	top: 0
	left: 0
	width: 100%
	height: 100vh
	display: flex
	align-items: center
	justify-content: center
	&-backdrop
		position: absolute
		top: 0
		left: 0
		width: 100%
		height: 100%
		background: rgba(#000, 0.5)
	&-inner
		position: relative
		z-index: 1
		background: #fff
		padding: 0 42px
		height: 700px
		display: flex
		flex-direction: column
		align-items: center
		padding-top: 13%
	&-close
		display: flex
		position: absolute
		z-index: 1
		right: 22px
		top: 22px
		background: transparent
		padding: 0
	&-title
		font-family: $font-base
		font-size: 24px
		font-weight: 500
		color: $color-text
		margin-bottom: 25px
	&-text
		text-align: center
		font-family: $font-base
		font-size: 18px
		font-weight: 400
		color: $color-text
		max-width: 427px
	&-btn
		background: $color-blue
		width: 220px
		height: 45px
		border-radius: 999px
		color: #fff
		font-family: $font-base
		font-size: 18px
		margin-top: 180px
@media (max-width: 450px)
	.vac-success
		&-inner
			height: 100%
			justify-content: center
		&-btn
			margin-top: 84px
			font-size: 14px
		&-close svg
			width: 16px
			height: 16px
		&-title
			font-size: 18px
		&-text
			font-size: 14px
</style>
