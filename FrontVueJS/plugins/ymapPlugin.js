import Vue from 'vue'
import YmapPlugin from 'vue-yandex-maps'

const settings = {
    apiKey: 'a357989c-af31-45c6-8be9-d477e253495d',
    lang: 'ru_RU',
    coordorder: 'latlong',
    version: '2.1',
    region: 'KZ'
}

Vue.use(YmapPlugin, settings)
