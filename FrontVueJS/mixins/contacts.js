export default {
    data() {
		return {
			currentCityIndex: 0
		}
	},
	computed: {
		cityNames() {
			return this.$page().cities.map(c => c.name)
		},
		city() {
			return this.$page().cities[this.currentCityIndex]
		}
	}
}
