<template>
	<div class="callback-form" data-scroll-section>
		<div class="callback-form-inner">
			<h2 class="callback-form-title" data-on-scroll-paginate>{{ $trans(partners ? 'По вопросам партнерства' : 'Напишите нам') }}</h2>
			<form ref="form" @submit.prevent="send" class="callback-form-form">
				<div class="callback-form-col" data-on-scroll-paginate>
					<p class="callback-form-label">{{ $trans('Введите город') }}<span>*</span></p>
					<input type="text" v-model="data.city" class="callback-form-input" :placeholder="$trans('Город')" required>
				</div>
				<div class="callback-form-col" data-on-scroll-paginate>
					<p class="callback-form-label">{{ $trans('Введите имя') }}<span>*</span></p>
					<input type="text" v-model="data.name" class="callback-form-input" :placeholder="$trans('Имя')" required>
				</div>
				<div class="callback-form-col" data-on-scroll-paginate>
					<p class="callback-form-label">{{ $trans('Введите телефон') }}<span>*</span></p>
					<client-only>
						<the-mask :mask="['+# (###) ###-##-##']" type="tel" required v-model="data.phone" class="callback-form-input" :placeholder="$trans('Телефон')" />
					</client-only>
				</div>
				<div class="callback-form-col" data-on-scroll-paginate>
					<p class="callback-form-label">{{ $trans('Введите e-mail') }}<span>*</span></p>
					<input type="email" v-model="data.email" class="callback-form-input" :placeholder="$trans('E-mail')" required>
				</div>
				<div class="callback-form-message" data-on-scroll-paginate>
					<p class="callback-form-label">{{ $trans('Сообщение') }}</p>
					<div class="callback-form-textarea-wrp">
						<textarea v-model="data.message" :placeholder="$trans('Текст сообщения')"></textarea>
						<button type="submit" class="callback-form-button">
							{{ $trans('Отправить') }}
							<arrow />
						</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</template>

<script>
import arrow from "@/static/icons/link-arrow.svg";
import {gsap} from "gsap";

export default {
	components: {
		arrow,
	},
	props: {
		partners: Boolean,
	},
	data() {
		return {
			data: {
				city: null,
				name: null,
				phone: null,
				email: null,
				message: null,
			}
		}
	},
	mounted(){
		this.animateOnLoad();
	},
	methods: {
		async send() {
			let resp = await this.$api.post('callback', Object.assign({}, this.data, { partners: this.partners }))

			if (resp) {
				this.$setTrue("modals.callback");
			}

			this.data = {}
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
.callback-form
	padding: 80px 0
	&-button
		margin-left: 23px
		width: 206px
		display: flex
		align-items: center
		justify-content: center
		font-size: 14px
		font-weight: 400
		color: #fff
		background: $color-blue
		svg
			margin-left: 10px
	&-textarea-wrp
		display: flex
	&-inner
		background: $bg-base
		max-width: 1116px
		width: 100%
		margin: 0 auto
		display: flex
		align-items: flex-start
		padding: 40px 90px
	&-title
		flex-shrink: 0
		font-size: 24px
		font-weight: 500
		color: $color-blue
		margin-right: 57px
	&-form
		display: flex
		flex-wrap: wrap
	&-col
		width: 100%
		max-width: 320px
		margin-bottom: 15px
		&:nth-of-type(odd)
			margin-right: 20px
	&-input,
	textarea
		border: none
		background: #fff
		max-width: 320px
		width: 100%
		font-size: 14px
		font-weight: 300
		color: $color-text
		padding: 0 23px
		line-height: 52px
	textarea
		resize: none
		max-width: 430px
		height: 75px
		line-height: initial
		padding: 10px 23px
	&-label
		line-height: 30px
		font-size: 14px
		font-weight: 300
		color: $color-text
		span
			color: $color-red
	&-message
		width: 100%
@media (min-width: 320px)
	.callback-form
		padding: 20px 0 0
		&-inner
			padding: 25px 10px
			flex-direction: column
		&-title
			margin-right: 0
			font-size: 18px
		&-col
			max-width: 100%
			margin-bottom: 0
			margin-top: 25px
			&:nth-child(odd)
				margin-right: 0
		&-input,
		textarea
			max-width: 100%
		textarea
			padding: 18px 23px
			height: 100px
			margin-bottom: 25px
		&-message
			margin-top: 25px
		&-textarea-wrp
			flex-direction: column
			align-items: flex-start
		&-button
			margin-left: 0
			line-height: 47px
@media (min-width: 1024px)
	.callback-form
		&-col
			max-width: 320px
			margin-top: 0
			margin-bottom: 15px
			&:nth-last-of-type(odd)
				margin-right: 20px
		&-inner
			flex-direction: row
		&-title
			width: 25%
		&-message
			margin-top: 0
		&-textarea-wrp
			flex-direction: row
			align-items: stretch
		textarea
			max-width: 430px
			height: 75px
			margin-bottom: 0
		&-button
			margin-left: 23px
		&-form
			width: 75%
@media (min-width: 1280px)
	.callback-form
		padding: 80px 0
		&-inner
			padding: 40px 90px
@media (min-width: 1440px)
	.callback-form
		&-title
			font-size: 24px
</style>
