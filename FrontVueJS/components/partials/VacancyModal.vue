<template>
	<transition name="fade">
		<div v-if="$check('modals.vacancy') && vacancy" class="vacancy-modal">
			<div class="vacancy-modal-overlay" @click="close"></div>
			<div class="vacancy-modal-inner">
				<button class="vacancy-modal-close" @click="close">
					<close />
				</button>
				<h3 class="vacancy-modal-title">{{ vacancy.name }}</h3>
				<div class="page-text" v-html="vacancy.content"></div>
				<form @submit.prevent="send">
					<input
						type="text"
						name="name"
						class="vacancy-modal-input"
						:placeholder="$trans('Ваше ФИО')"
						v-model="info.full_name"
						required
					/>
					<client-only>
						<the-mask
							name="phone"
							:mask="['+# (###) ###-##-##']"
							class="vacancy-modal-input"
							type="tel"
							:placeholder="$trans('Ваш телефон')"
							v-model="info.phone"
						/>
					</client-only>
					<input
						type="email"
						name="email"
						class="vacancy-modal-input"
						:placeholder="$trans('Ваш e-mail')"
						v-model="info.email"
					/>
					<label class="vacancy-modal-file">
						<input
							name="cv"
							type="file"
							style="width: 0; height: 0;"
							@change="setFile"
							required
						/>
						<p class="vacancy-modal-file-text">
							{{ $trans("Ваше резюме") }}
						</p>
						<button class="vacancy-modal-file-btn">
							{{
								info.cv
									? info.cv.name
									: $trans("Выбрать файл...")
							}}
						</button>
					</label>
					<textarea
						name="message"
						class="vacancy-modal-input --message"
						:placeholder="$trans('Сопроводительное письмо')"
						v-model="info.message"
					></textarea>
					<label class="vacancy-modal-checkbox">
						<input
							type="checkbox"
							name="agreement"
							v-model="agreement"
							style="width: 0; height: 0;"
							required
							accept="application/msword, application/vnd.ms-powerpoint, text/plain, application/pdf, image/*"
						/>
						<div class="vacancy-modal-checkmark">
							<check />
						</div>
						<p class="vacancy-modal-checkbox-text">
							Я ознакомлен и согласен с условиями сбора и
							<nuxt-link to
								>обработки персональных данных</nuxt-link
							>
						</p>
					</label>
					<div class="vacancy-modal-btn-wrp">
						<button
							type="submit"
							class="button --blue"
							:disabled="waiting"
						>
							{{ $trans("Отправить") }}
						</button>
					</div>
				</form>
			</div>
		</div>
	</transition>
</template>

<script>
import close from "@/static/icons/close.svg";
import check from "@/static/icons/check.svg";
export default {
	components: {
		close,
		check
	},
	props: ["vacancy"],
	data() {
		return {
			waiting: false,
			agreement: false,
			info: {
				full_name: null,
				phone: null,
				email: null,
				cv: null,
				message: null
			}
		};
	},
	methods: {
		close() {
			document.body.classList.remove("--hidden");
			this.$setFalse("modals.vacancy");
			this.$setTrue("modals.vacSuccess");
		},
		async send() {
			this.waiting = true;
			let formData = this.$objToFormData(this.info);
			let resp = await this.$api.post(
				`vacancy/${this.vacancy.id}`,
				formData
			);
			this.close();

			this.waiting = false;
		},
		setFile(e) {
			if (e.target.files && e.target.files.length > 0) {
				this.info.cv = e.target.files[0];
			}
		}
	}
};
</script>

<style lang="sass">
.vacancy-modal
	position: fixed
	z-index: 1000
	top: 0
	left: 0
	width: 100%
	height: 100%
	display: flex
	align-items: center
	justify-content: center
	&-overlay
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
		padding: 46px 55px
		max-width: 560px
		max-height: 100vh
		overflow-y: auto
	&-close
		padding: 0
		display: flex
		background: transparent
		position: absolute
		right: 30px
		top: 30px
		z-index: 1
		svg
			width: 15px
			height: 15px
	&-title
		font-size: 24px
		font-weight: 500
		color: $color-blue
		margin-bottom: 35px
	.page-text
		line-height: initial
		margin-bottom: 35px
		font-size: 16px
	&-input
		border: none
		border-bottom: 1px solid #cbcbcb
		padding-bottom: 10px
		font-size: 14px
		font-weight: 300
		color: $color-text
		margin-bottom: 20px
		display: block
		width: 100%
		&.--message
			resize: vertical
		&::placeholder
			color: #cbcbcb
	&-file
		border-bottom: 1px solid #cbcbcb
		padding-bottom: 10px
		display: flex
		align-items: center
		justify-content: space-between
		margin-bottom: 20px
		&-text
			font-size: 14px
			font-weight: 300
			color: #cbcbcb
		&-btn
			border-radius: 30px
			color: #fff
			line-height: 34px
			font-size: 12px
			font-weight: 300
			padding: 0 20px
			background: #B6B6B6
	&-checkbox
		display: flex
		align-items: flex-start
		input:checked
			& ~ .vacancy-modal-checkmark
				background: $color-blue
		&-text
			font-size: 14px
			font-weight: 300
			color: #cbcbcb
			a
				color: $color-text
				text-decoration: underline
	&-checkmark
		flex-shrink: 0
		width: 20px
		height: 20px
		border: 1px solid #CBCBCB
		border-radius: 5px
		margin-right: 15px
		display: flex
		align-items: center
		justify-content: center
		path
			fill: #fff
	&-btn-wrp
		display: flex
		justify-content: center
		margin-top: 47px
		.button
			width: 200px
@media (min-width: 320px)
	.vacancy-modal
		&-inner
			padding: 50px 10px 100px
			max-width: 100%
		&-close
			right: 15px
			top: 15px
		&-title
			font-size: 18px
			margin-bottom: 20px
		.page-text
			font-size: 14px
			line-height: 24px
@media (min-width: 768px)
	.vacancy-modal
		&-title
			font-size: 24px
		&-inner
			max-width: 560px
			padding: 46px 55px
		&-close
			top: 30px
			right: 30px
</style>
