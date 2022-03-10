export default {
	// Global page headers: https://go.nuxtjs.dev/config-head
	head: {
		title: "Astel",
		meta: [
			{ charset: "utf-8" },
			{
				name: "viewport",
				content: "width=device-width, initial-scale=1"
			},
			{ hid: "description", name: "description", content: "" }
		],
		link: [{ rel: "icon", type: "image/x-icon", href: "/favicon.ico" }]
	},

	// Global CSS: https://go.nuxtjs.dev/config-css
	css: ["@/assets/css/app.sass"],
	pageTransition: "fade",
	layoutTransition: "fade",
	// Plugins to run before rendering page: https://go.nuxtjs.dev/config-plugins
	plugins: [
		{ src: "@/plugins/swiper", mode: "client" },
		{ src: "@/plugins/mask", mode: "client" },
		{ src: "~/plugins/ymapPlugin.js", mode: "client" },
		{ src: "@/plugins/flags" },
		{ src: "@/plugins/api" },
		{ src: "@/plugins/helpers" },
		{ src: "@/plugins/page" },
		{ src: "@/plugins/lang" },
		{ src: "@/plugins/seo" },
		{ src: "@/plugins/owlCarousel", mode: "client" }
	],

	router: {
		middleware: ["localization", "page"],
		extendRoutes(routes) {
			routes.push({
				name: "page",
				path: "/:locale(en|kk)?/:page?/:slug?/:inner?/:inner2?/:inner3?",
				component: "pages/index.vue"
			});
		}
	},

	// Auto import components: https://go.nuxtjs.dev/config-components
	components: true,

	// Modules for dev and build (recommended): https://go.nuxtjs.dev/config-modules
	buildModules: ["@nuxtjs/style-resources"],

	gtm: {
		id: 'GTM-TBQVM6F'
	},

	// Modules: https://go.nuxtjs.dev/config-modules
	modules: [
		// https://go.nuxtjs.dev/axios
		//'@nuxtjs/component-cache',
		['@nuxtjs/component-cache', { maxAge: 1000 * 10 }],
		"@nuxtjs/axios",
		"nuxt-svg-loader",
		'nuxt-lazy-load',
		'@nuxtjs/gtm',
		[
			'@nuxtjs/gtm',
			{
				id: 'GTM-TBQVM6F'
			}
		]
	],
	optimization: {
		nodeEnv: 'production',
		minimize: true,
		runtimeChunk: true,
		splitChunks: {
			chunks: 'all'
		}
	},

	styleResources: {
		sass: ["./assets/css/variables.sass"]
	},

	// Axios module configuration: https://go.nuxtjs.dev/config-axios
	axios: {
		baseURL: `${
			process.env.NODE_ENV == "production"
				// ? "http://localhost:8001/api"
				// : "http://localhost:8001/api"
				? "https://demo-admin.astel.kz/api"
				: "https://demo-admin.astel.kz/api"
		}`
	},

	// Build Configuration: https://go.nuxtjs.dev/config-build
	build: {
		transpile: ["gsap"]
	},
	server: {
		port: 3001 // default: 3000
	}
};
