export default function ({ $axios, store }, inject) {
    inject('api', {
        post(url, data = {}, headers = {}, recaptcha = true, progress = true) {
            if (recaptcha) {
                // Recaptcha
            }

            console.log(`Sending ${data['_method'] ? data['_method'] : 'POST'} request to /${store.getters['translation/GET_LOCALE']}/api/${url}`)

            return $axios.$post(`/${store.getters['translation/GET_LOCALE']}/${url}`, data, { headers: headers, progress: progress })
        },
        get(url, data = {}, headers = {}) {
            data['_method'] = 'GET'
            return this.post(url, data, headers, false)
        },
        delete(url, data = {}, headers = {}, recaptcha = false) {
            data['_method'] = 'DELETE'
            return this.post(url, data, headers, false)
        },
        put(url, data = {}, headers = {}, recaptcha = false) {
            data['_method'] = 'PUT'
            return this.post(url, data, headers, false)
        },
    })
}
