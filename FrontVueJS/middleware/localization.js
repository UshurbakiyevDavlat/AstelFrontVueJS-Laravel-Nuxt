export default function({ store, route, redirect, error }) {
    if (store.getters['translation/GET_LOCALE'] !== route.params.locale) {
        store.commit('translation/SET_LOCALE', (route.params.locale ? route.params.locale : 'ru'))
    }
}
