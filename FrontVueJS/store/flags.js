export const state = () => ({
    data: {}
})

export const getters = {
    CHECK: (state) => (payload) => {
        return Boolean(state.data[payload])
    }
}

export const mutations = {
    TOGGLE: (state, payload) => {
        state.data = Object.assign({}, state.data, {[payload]: !Boolean(state.data[payload])})
    },
    SET: (state, payload) => {
        state.data = Object.assign({}, state.data, payload)
    },
}

export const actions = {
    toggle: ({ commit }, payload) => {
        commit('TOGGLE', payload)
    },
    set: ({ commit }, payload) => {
        commit('SET', payload)
    }
}
