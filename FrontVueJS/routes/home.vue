<template>
	<div class="home-page">
		<home-hero v-bind:timeline="timeline" />
		<home-services v-bind:timeline="timeline" />
		<home-partners :timeline="timeline" />
		<home-news v-if="$page('blog') && $page().posts && $page().template == 'home'" v-bind:timeline="timeline" />
		<home-contacts v-bind:timeline="timeline" />
	</div>
</template>

<script>
import HomeHero from "~/components/partials/HomeHero";
import HomeServices from "~/components/partials/HomeServices";
import HomePartners from "~/components/partials/HomePartners";
import HomeNews from "~/components/partials/HomeNews";
import HomeContacts from "~/components/partials/HomeContacts";
import {gsap} from "gsap";

let tl = gsap.timeline();

export default {
	components: {
		HomeContacts,
		HomeNews,
		HomePartners,
		HomeServices,
		HomeHero
	},

	data: () => ({ timeline: null }),

	created(){
		this.timeline = gsap.timeline();
	}
};

</script>

<style lang="sass">
.home-page
	&-title
		font-size: 36px
		font-weight: 300
		color: $color-blue
		max-width: 313px
		line-height: 44px
		&-wrp
			margin-bottom: 15px
			display: flex
			align-items: center
@media (min-width: 320px)
	.home-page
		&-title
			font-size: 18px
			line-height: initial
@media (min-width: 1280px)
	.home-page
		&-title
			font-size: 24px
</style>
