<template>
	<div class="layout">
		<partial-menu />
		<partial-header />
		<callback-modal />
		<vacancy-success-modal />
		<div class="layout-content">
			<Nuxt />
		</div>
		<partial-footer />
	</div>
</template>

<script>
import PartialMenu from "~/components/partials/PartialMenu";
import PartialHeader from "~/components/partials/PartialHeader";
import CallbackModal from "~/components/partials/CallbackModal";
import VacancySuccessModal from "~/components/partials/VacancySuccessModal";
import PartialFooter from "~/components/partials/PartialFooter";

export default {
	components: {
		PartialFooter,
		PartialHeader,
		PartialMenu,
		CallbackModal,
		VacancySuccessModal
	}
};
</script>
