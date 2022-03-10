<template>
	<div class="custom-select" :tabindex="tabindex" @blur="open = false">
		<arrow class="arrow" @click="open = !open" style="cursor: pointer;" />
		<div class="selected" :class="{ open: open }" @click="open = !open">
			{{ val }}
		</div>
		<div class="items" :class="{ selectHide: !open }">
			<div v-for="(option, i) of options"
				:key="i"
				@click="selected = i; open = false; $emit('input', i); ">
				{{ option }}
			</div>
		</div>
	</div>
</template>

<script>
import arrow from "@/static/icons/arrow.svg";
 export default {
	props: {
		options: {
			type: Array,
			required: true,
		},
		default: {
			type: String,
			required: false,
			default: null,
		},
		value: {
			default: 0
		},
		tabindex: {
			type: Number,
			required: false,
			default: 0,
		},
	},
	data() {
		return {
			selected: this.value
				? this.value
				: this.options.length > 0
				? 0
				: null,
			open: false,
		};
	},
	computed: {
		val() {
			return typeof this.selected == 'number' ? this.options[this.selected] : this.default
		}
	},
	mounted() {
		this.$emit("input", this.selected);
	},
	components: {
		arrow,
	},
};
</script>

<style>
.custom-select {
	position: relative;
	width: 100%;
	text-align: left;
	outline: none;
	max-width: 416px;
	border-radius: 12px;
	margin-bottom: 22px;
}

.custom-select .arrow {
	position: absolute;
	right: 20px;
	top: 23px;
	z-index: 3;
	width: 12px;
	height: 12px;
}

.arrow path {
	stroke: #c9c9c9;
}

.custom-select .selected {
	border-radius: 30px;
	padding: 15px;
	padding-right: 40px;
	cursor: pointer;
	user-select: none;
	position: relative;
	z-index: 2;
	border: 1px solid #c9c9c9;
	background: #fff;
	font-size: 14px;
	font-weight: 400;
	color: $color-text;
}

.custom-select .items {
	border: 1px solid #c9c9c9;
	border-radius: 0 0 12px 12px;
	overflow: hidden;
	position: absolute;
	background-color: #fff;
	left: 0;
	right: 0;
	top: calc(100% - 30px);
	padding: 40px 0 15px;
	z-index: 1;
}

.custom-select .items div {
	padding: 5px 15px;
	cursor: pointer;
	user-select: none;
	font-size: 14px;
	font-weight: 400;
	color: #370932;
}

.selectHide {
	display: none;
}
@media (min-width: 320px) {
	.custom-select {
		max-width: 100%;
	}
}
@media (min-width: 1280px) {
	.custom-select {
		max-width: 416px;
	}
}
</style>
