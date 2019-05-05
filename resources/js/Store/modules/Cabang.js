import cabangService from '../../service/Cabang'

const state = {
  cabangs: [],
  cabang: {
    cabang_name: '',
    cabang_address: '',
    cabang_phone_number: '',
  },
  loading: true,
  error: null
}

const mutations = {
  setSource(state, payload) {
    state.cabangs = payload
    state.loading = false
    state.error = null
  },

  setFailedAction(state, payload) {
    state.loading = false
    state.error = payload.error
  },

  setCabangForm(state, payload) {
    state.cabang.cabang_name = payload.nama
    state.cabang.cabang_address = payload.alamat
    state.cabang.cabang_phone_number = payload.nomor_telepon
  }
}

const getters = {
  error: state => state.error,
  loading: state => state.loading,
  cabang: state => state.cabang
}

const actions = {
  async get(context) {
    try {
      context.commit('setSource', await cabangService.get())
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async store(context, payload) {
    try {
      await cabangService.store(payload)
    } catch (err) {
      context.commit('setFailedStore', err)
    }
  },

  async edit(context, id) {
    try {
      console.log(id)
      const res = await cabangService.find(id)
      context.commit('setCabangForm', res)
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async update(context, payload) {
    try {
      const data = {
        nama : payload.nama,
        alamat: payload.alamat,
        nomor_telepon: payload.nomor_telepon
      }
      console.log(data)
      await cabangService.update(payload.id, data)
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async delete (context, id) {
    try {
      await cabangService.delete(id)
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  resetForm(context) {
    context.commit('setCabangForm', {})
  }
}

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
}