import jasaService from '../../service/Service'

const state = {
  services: [],
  service: {
    service_name: '',
    service_harga: '',
  },
  loading: true,
  error: null
}

const mutations = {
  setSource(state, payload) {
    state.services = payload
    state.loading = false
    state.error = null
  },

  setFailedAction(state, payload) {
    state.loading = false
    state.error = payload.error
  },

  setServiceForm(state, payload) {
    state.service.service_name = payload.nama
    state.service.service_harga = payload.harga
  }
}

const getters = {
  error: state => state.error,
  loading: state => state.loading,
  service: state => state.service
}

const actions = {
  async get(context) {
    try {
      context.commit('setSource', await jasaService.get())
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async store(context, payload) {
    try {
      await jasaService.store(payload)
    } catch (err) {
      context.commit('setFailedStore', err)
    }
  },

  async edit(context, id) {
    try {
      console.log(id)
      const res = await jasaService.find(id)
      context.commit('setServiceForm', res)
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async update(context, payload) {
    try {
      const data = {
        nama : payload.nama,
        harga: payload.harga,
      }
      console.log(data)
      await jasaService.update(payload.id, data)
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async delete (context, id) {
    try {
      await jasaService.delete(id)
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  resetForm(context) {
    context.commit('setServiceForm', {})
  }
}

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
}