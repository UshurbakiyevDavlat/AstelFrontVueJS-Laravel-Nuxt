import moment from 'moment'

export default function ({ app, store, req, route }, inject) {

    inject('format_date', function (value, format = 'D MMMM YYYY') {
        moment.locale(store.getters['translation/GET_LOCALE'])
        return moment(value).format(format)
    })

    inject('format_number', (number) => {
        return number ? number.toLocaleString().split(',').join(' ') : number
    })

    inject('format_phone', (phone) => {
        if (!phone) return

        let cleaned = (phone).replace(/\D/g, '')
        let match = cleaned.match(/^(\d{1})(\d{3})(\d{3})(\d{2})(\d{2})$/)

        if (match) {
            return `+${match[1]} (${match[2]}) ${match[3]}-${match[4]}-${match[5]}`
        }
    })

    inject('tel', (p = '') => {
        let pref = ''
        if (p.charAt(0) == '+') {
            pref = '+'
        }

        return pref + p.replace(/\D/g, '')
    })

    inject('str_limit', (str, cnt = 50) => {
        return str ? str.substring(0, cnt) : str
    })

    inject('pad', (str, size = 2, ch = '0') => {
        let s = str + ""
        while (s.length < size) s = ch + s
        return s
    })

    inject('chunk', function (array, chunkSize) {
        let arr = [], i = 0
        for (; i < array.length; i += chunkSize) {
            arr.push(array.slice(i, i + chunkSize))
        }
        return arr
    })

    inject('settings', (k) => {
        return store.getters['page/GET_SETTINGS_BY_KEY'](k)
    })

    inject('host', () => {
        let domain

        // // SERVER NPM RUN BUILD, NPM RUN START

        if (process.client) {
            domain = window.location.host
        } else {
            domain = req.headers.host
        }

        // LOCAL NPM RUN DEV
        
        // if (process.client) {
        //     domain = req.headers.host
        // } else {
        //     domain = req?.headers?.host
        // }

        return 'http' + (process.env.NODE_ENV == 'production' ? 's': '') + `://${domain}`
    })

    inject('objToFormData', (obj) => {
        let form = new FormData()

        let rec = (obj, field = null) => {
            if (obj == null) {
                obj = ''
            }
            if ((typeof obj == 'object' && (obj instanceof File || obj instanceof Date)) || !['array', 'object'].includes(typeof obj)) {
                if (obj instanceof Date) {
                    form.append(field, app.$formatDate(obj, 'DD.MM.YYYY'))
                } else {
                    form.append(field, obj)
                }
            } else if (typeof obj == 'object') {
                for(const key in obj) {
                    rec(obj[key], field ? field + `[${key}]` : key)
                }
            } else if (typeof obj == 'array') {
                for(let i=0;i<obj.length; ++i) {
                    rec(obj[i], field ? field + `[]` : i)
                }
            }
        }

        rec(obj)

        return form
    })

}
