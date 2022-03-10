export default function({ app, req, store }, inject) {
    inject('get_seo_tags', (item) => {
        const locales = store.getters['translation/GET_LOCALES']
        const currentLocale = app.$locale()

        let seo = {
            title: item ? item.seo_title : null,
            htmlAttrs: {
                lang: currentLocale
            },
            meta: [
                {
                    hid: 'og_type',
                    name: 'og:type',
                    content: 'website'
                }
            ],
            link: []
        }

        for(let locale in locales) {
            if (locale != currentLocale) {
                let path = app.router.currentRoute.fullPath
                let chunks = path.split('/').filter(c => c && c.length)
                if (chunks.length && chunks[0] == currentLocale) {
                    chunks.shift()
                }

                if (locale != 'ru') {
                    chunks.unshift(locale)
                }

                path = chunks.join('/')

                seo.link.push({
                    rel: 'alternate',
                    href: `${app.$host()}/${path}`,
                    hreflang: locale
                })
            }
        }

        if (!item) {
            return seo
        }

        if (item.pagination) {
            let query = {...app.router.currentRoute.query}
            delete query.page
            let query_string = "?"
            for(const key in query) {
                query_string+=`${key}=${query[key]}&`
            }

            seo.link.push({
                rel: 'canonical',
                href: `${app.$host()}${app.router.currentRoute.fullPath}`
            })

            if (item[item.pagination].next_page_url) {
                seo.link.push({
                    rel: 'next',
                    href: `${app.$host()}${app.router.currentRoute.path}${query_string}page=${item[item.pagination].current_page + 1}`
                })
            }
            if (item[item.pagination].prev_page_url) {
                seo.link.push({
                    rel: 'prev',
                    href: `${app.$host()}${app.router.currentRoute.path}${query_string}page=${item[item.pagination].current_page - 1}`
                })
            }
        }

        if (item.seo_title) {
            seo.meta.push({
                hid: 'og_title',
                name: 'og:title',
                content: item.seo_title
            })
        }

        if (item.seo_description) {
            seo.meta.push({
                hid: 'description',
                name: 'description',
                content: item.seo_description
            })
            seo.meta.push({
                hid: 'og_description',
                name: 'og:description',
                content: item.seo_description
            })
        }

        if (item.seo_keywords) {
            seo.meta.push({
                hid: 'keywords',
                name: 'keywords',
                content: item.seo_keywords
            })
        }

        if (item.seo_image) {
            seo.meta.push({
                hid: 'og_image',
                name: 'og:image',
                content: item.seo_image
            })
        }

        return seo
    })

}
