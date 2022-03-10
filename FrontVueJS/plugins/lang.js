export default function ({ store }, inject) {

    inject('trans', (text, replace = null) => {
        let translation = store.getters['page/GET_TRANSLATION'](text)

        if (translation === null) {
            if (store.getters['page/GET_PAGE']) {
                store.dispatch('page/addTranslation', text)
            }
            translation = text
        }

        return (replace !== null && typeof replace != 'undefined' && translation) ? translation.replace(/\{.*\}/g, replace) : translation
    })

    inject('locale', () => store.getters['translation/GET_LOCALE'])

    inject('url', (p, s = '') => {
        return '/' + [store.getters['translation/GET_LOCALE_URL'], p, s].join('/').split('/').filter(c => c.length).join('/')
    })

}
