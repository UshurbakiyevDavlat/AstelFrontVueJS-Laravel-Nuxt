export const state = () => ({
    locale: 'ru',
    locales: {
        kk: 'Kz',
        ru: 'Ru',
        en: 'En'
    },
})

export const getters = {
    GET_LOCALE: s => s.locale,
    GET_LOCALE_URL: s => s.locale == 'ru' ? '' : s.locale,
    GET_LOCALES: s => s.locales
}

export const mutations = {
    SET_LOCALE: (s, l) => s.locale = l,
}
