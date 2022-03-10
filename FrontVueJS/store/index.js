export const actions = {
    async nuxtServerInit({ dispatch, commit }, { req, route }) {

        commit('translation/SET_LOCALE', (route.params.locale ? route.params.locale : 'ru'))

        let queue = [
            dispatch('page/fetchPages')
        ]

        return Promise.all(queue)
    }
}
