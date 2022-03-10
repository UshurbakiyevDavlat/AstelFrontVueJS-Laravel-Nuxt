<template>
	<transition name="fade">
		<div v-if="$check('modals.certModal')" class="cert-modal">
			<div class="cert-modal-overlay" @click="$setFalse('modals.certModal')"></div>
			<img :data-src="image" v-lazy-load alt="Astel image" class="cert-modal-img">
		</div>
	</transition>
</template>

<script>
export default {
	props: {
		image: String,
	},
};
</script>

<style lang="sass">
.cert-modal
	position: fixed
	z-index: 1000
	top: 0
	left: 0
	width: 100%
	height: 100vh
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
	&-img
		position: relative
		z-index: 1
		max-width: 100%
		max-height: 100%;
 </style>
