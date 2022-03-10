import md5 from 'js-md5'

export const state = () => ({
    current_url: 'home',
    page: {},
    pages: {},
    menu: [],
	menuServices: [],
    settings: {}
})

export const getters = {
    GET_SETTINGS_BY_KEY: s => k => s.settings[k],
    GET_PAGE: s => s.page,
    GET_PAGE_BY_TEMPLATE: s => t => s.pages[t],
    GET_URL: s => t => t == 'home' ? '' : s.pages[t].slug,
    GET_MENU: s => s.menu,
	GET_MENU_SERVICES: s=> s.menuServices,
    GET_TRANSLATION: s => (p) => {
        let hash = md5(p)
        return (Object.keys(s.page).length > 0 && s.page.translations[hash]) ? s.page.translations[hash] : null
    },
}

export const mutations = {
    SET_CURRENT_URL: (s, p) => s.current_url = p,
    SET_SETTINGS: (s, p) => s.settings = p,
    SET_PAGE: (s, p) => {
        s.page = Object.assign({...s.page}, { translations: {}, pagination: null }, p)
    },
    SET_DATA: (s, p) => {
        s.settings = p.settings
        s.pages = p.pages
        s.menu = p.menu
		s.menuServices = p.menuServices
    },
    SET_TRANSLATION: (s, p) => {
        let hash = md5(p)
        Object.assign(s.page.translations, { [hash]: p })
    },
    PAGINATE: (s, { field, data }) => {
        s.page[field].data.push(...data.data)
        s.page[field].next_page_url = data.next_page_url
        s.page[field].prev_page_url = data.prev_page_url
        s.page[field].last_page_url = data.last_page_url
        s.page[field].from = data.from
        s.page[field].to = data.to
        s.page[field].total = data.total
    }
}

export const actions = {
    async fetchPage({ commit }, { page, query }) {
        let url = `page/${page.length ? page : 'home'}`
        commit('SET_CURRENT_URL', url)
        commit('SET_PAGE', await this.$api.get(url, query))
    },
    async fetchPages({commit}, p) {
        commit('SET_DATA', await this.$api.get('page'))
    },
    async addTranslation({ commit, state }, p) {
        commit('SET_TRANSLATION', p)
        await this.$api.post(state.current_url, {
            'text': p
        }, {}, true, false)
    },
    async paginate({ commit, state }, field) {
        if (state.page[field].next_page_url) {
            commit('PAGINATE', {
                field: field,
                data: (await this.$axios({ url: state.page[field].next_page_url, baseURL: '', progress: false })).data
            })
            return true
        }
        return false
    }
}
