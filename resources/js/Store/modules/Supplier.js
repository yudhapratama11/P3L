import supplierService from '../../service/Supplier'

const state = {
  suppliers: [],
  supplier: {
    supplier_name: '',
    supplier_address: '',
    supplier_phone_number: '',
  },
  loading: true,
  error: null
}

const mutations = {
  setSource(state, payload) {
    state.suppliers = payload
    state.loading = false
    state.error = null
  },

  setFailedAction(state, payload) {
    state.loading = false
    state.error = payload.error
  },

  setSupplierForm(state, payload) {
    state.supplier.supplier_name = payload.nama
    state.supplier.supplier_address = payload.alamat
    state.supplier.supplier_phone_number = payload.nomor_telepon
  }
}

const getters = {
  error: state => state.error,
  loading: state => state.loading,
  supplier: state => state.supplier
}

const actions = {
  async get(context) {
    try {
      context.commit('setSource', await supplierService.get())
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async store(context, payload) {
    try {
      await supplierService.store(payload)
    } catch (err) {
      context.commit('setFailedStore', err)
    }
  },

  async edit(context, id) {
    try {
      console.log(id)
      const res = await supplierService.find(id)
      context.commit('setSupplierForm', res)
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
      await supplierService.update(payload.id, data)
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async delete (context, id) {
    try {
      await supplierService.delete(id)
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  resetForm(context) {
    context.commit('setSupplierForm', {})
  }
}

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
}