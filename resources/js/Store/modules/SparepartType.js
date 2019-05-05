import sparepartType from '../../service/SparepartType'

const state = {
  spareparttypes: [],
  spareparttype: {
    type_name: '',
  },
  loading: true,
  error: null
}

const mutations = {
  setSource(state, payload) {
    state.spareparttypes = payload
    state.loading = false
    state.error = null
  },

  setFailedAction(state, payload) {
    state.loading = false
    state.error = payload.error
  },

  setTypeForm(state, payload) {
    state.spareparttype.type_name = payload.nama
  }
}

const getters = {
  error: state => state.error,
  loading: state => state.loading,
  spareparttype: state => state.spareparttype
}

const actions = {
  async get(context) {
    try {
      context.commit('setSource', await sparepartType.get())
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async store(context, payload) {
    try {
      await sparepartType.store(payload)
    } catch (err) {
      context.commit('setFailedStore', err)
    }
  },

  async edit(context, id) {
    try {
      console.log(id)
      const res = await sparepartType.find(id)
      context.commit('setTypeForm', res)
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async update(context, payload) {
    try {
      const data = {
        nama : payload.nama,
      }
      console.log(data)
      await sparepartType.update(payload.id, data)
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async delete (context, id) {
    try {
      await sparepartType.delete(id)
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  resetForm(context) {
    context.commit('setTypeForm', {})
  }
}

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
}