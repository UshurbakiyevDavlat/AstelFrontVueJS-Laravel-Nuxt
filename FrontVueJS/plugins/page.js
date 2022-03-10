export default function({ store, app }, inject) {

    inject('page', (t = null) => {
        return t ? store.getters['page/GET_PAGE_BY_TEMPLATE'](t) : store.getters['page/GET_PAGE']
    })

    inject('pageUrl', (t, s = '') => {
        return app.$url(store.getters['page/GET_URL'](t), s)
    })

    inject('paginate', async (field) => {
        await store.dispatch('page/paginate', field)
    })

}
