export default function({ store, route, error }) {
    let arr = [route.params.page, route.params.slug, route.params.inner, route.params.inner2, route.params.inner3]
    return store.dispatch('page/fetchPage', {
        page: [...arr].filter(p => p).join('/'),
        query: {...route.query}
    }).catch(e => {
		error({ statusCode: 404, message: '404 ERROR FOUND!' })
	})
}
