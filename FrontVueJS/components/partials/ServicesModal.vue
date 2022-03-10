<template>
	<transition name="fade">
		<form
			@submit.prevent="send"
			v-if="$check('modals.servicesModal')"
			class="services-modal"
		>
			<div
				class="services-modal-overlay"
				@click="$setFalse('modals.servicesModal')"
			></div>
			<div class="services-modal-inner">
				<button
					type="button"
					class="services-modal-close"
					@click="$setFalse('modals.servicesModal')"
				>
					<close />
				</button>
				<h4 class="services-modal-title">
					{{ $trans("Обратная связь") }}
				</h4>
				<div class="services-modal-container">
					<p class="services-modal-text">
						{{
							$trans(
								"Вы можете оставить в специальной форме обратной связи свои контактные данные и мы перезвоним вам в ближайшее время для консультаций!"
							)
						}}
					</p>
					<div class="services-modal-row">
						<div class="services-modal-col">
							<p class="services-modal-label">
								{{ $trans("Введите город") }} <span>*</span>
							</p>
							<input
								type="text"
								name="city"
								:placeholder="$trans('Город')"
								class="services-modal-input"
								v-model="info.city"
								required
							/>
						</div>
						<div class="services-modal-col">
							<p class="services-modal-label">
								{{ $trans("Введите имя") }} <span>*</span>
							</p>
							<input
								type="text"
								name="name"
								:placeholder="$trans('Имя')"
								class="services-modal-input"
								v-model="info.name"
								required
							/>
						</div>
						<div class="services-modal-col">
							<p class="services-modal-label">
								{{ $trans("Введите телефон") }} <span>*</span>
							</p>
							<input
								type="text"
								name="phone2"
								style="width:1px; height:1px; padding: 0; border:none; position: absolute;"
								required
								v-model="info.phone"
							/>
							<client-only>
								<the-mask
									:mask="['+# (###) ###-##-##']"
									class="services-modal-input"
									:placeholder="$trans('Телефон')"
									type="tel"
									name="phone"
									v-model="info.phone"
									required
								/>
							</client-only>
						</div>
						<div class="services-modal-col">
							<p class="services-modal-label">
								{{ $trans("Введите e-mail") }}
							</p>
							<input
								type="email"
								:placeholder="$trans('E-mail')"
								name="email"
								class="services-modal-input"
								v-model="info.email"
							/>
						</div>
					</div>
					<p class="services-modal-label">
						{{ $trans("Сообщение") }}
					</p>
					<textarea
						class="services-modal-input"
						:placeholder="$trans('Текст сообщения')"
						name="message"
						v-model="info.message"
					></textarea>
				</div>
				<div class="services-modal-btn-wrp">
					<button type="submit" class="services-modal-send">
						{{ $trans("Отправить") }}
						<arrow />
					</button>
				</div>
			</div>
		</form>
	</transition>
</template>

<script>
import close from "@/static/icons/close.svg";
import arrow from "@/static/icons/link-arrow.svg";
export default {
	components: {
		close,
		arrow
	},
	data() {
		return {
			info: {
				phone: null,
				email: null,
				name: null,
				city: null,
				message: null
			}
		};
	},
	methods: {
		async send() {
			this.$setFalse("modals.servicesModal");
			this.$setTrue("modals.callback");
			await this.$api.post(
				"callback",
				Object.assign(
					{ ...this.info },
					{ service_id: this.$page().service.id }
				)
			);
			this.info = {};
		}
	}
};
</script>

<style lang="sass">
.services-modal
	position: fixed
	top: 0
	left: 0
	width: 100%
	height: 100vh
	display: flex
	align-items: center
	justify-content: center
	z-index: 1000
	&-btn-wrp
		display: flex
		justify-content: center
		margin-top: 33px
	&-send
		background: $color-blue
		display: flex
		align-items: center
		justify-content: center
		color: #fff
		font-size: 14px
		font-weight: 400
		height: 65px
		width: 205px
		svg
			margin-left: 10px
		path
			fill: #fff
	&-container
		padding: 0 40px
	&-close
		display: flex
		padding: 0
		background: transparent
		margin-left: auto
	&-title,
	&-text
		text-align: center
	&-title
		font-size: 24px
		font-weight: 500
		color: $color-blue
		margin-bottom: 24px
	&-text
		font-size: 16px
		font-weight: 300
		line-height: 1.2
		color: $color-text
		margin-bottom: 32px
	&-input
		border: none
		background: #fff
		padding: 11px 23px
		width: 100%
		resize: none
		font-size: 14px
		font-weight: 400
		color: $color-text
	&-row
		display: flex
		flex-wrap: wrap
	&-col
		width: calc(50% - 10px)
		margin-right: 20px
		margin-bottom: 24px
		&:nth-child(even)
			margin-right: 0
	&-label
		font-size: 14px
		font-weight: 300
		color: $color-text
		line-height: 30px
		span
			color: $color-red
	&-overlay
		position: absolute
		top: 0
		left: 0
		width: 100%
		height: 100%
		background: rgba(0, 0, 0, .5)
	&-inner
		background: #FAFAFA
		position: relative
		z-index: 1
		padding: 20px
		max-width: 770px
@media (min-width: 320px)
	.services-modal
		&-col
			width: 100%
			margin-right: 0
		&-container
			padding: 0
		&-inner
			overflow-y: auto
			height: 100vh
			padding: 16px 10px
			padding-bottom: 80px
		&-title
			text-align: left
			font-size: 18px
		&-text
			font-size: 14px
			text-align: left
		&-btn-wrp
			justify-content: flex-start
		&-send
			height: 47px
			width: 170px
		&-close
			svg
				width: 20px
				height: 20px
		&-inner,
		&-input
			max-width: 100%
@media (min-width: 768px)
	.services-modal
		&-col
			width: calc(50% - 10px)
			margin-right: 20px
		&-inner
			height: auto
			padding-bottom: 20px
			max-width: 770px
@media (min-width: 1280px)
	.services-modal
		&-container
			padding: 0 40px
		&-inner
			padding: 20px
			padding-bottom: 40px
		&-title
			text-align: center
			font-size: 24px
		&-text
			font-size: 16px
			text-align: center
		&-btn-wrp
			justify-content: center
		&-send
			height: 65px
			width: 205px
</style>
