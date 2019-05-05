import sparepartService from '../../service/Sparepart'

const state = {
  spareparts: [],
  sparepart: {
    sparepart_id: '',
    sparepart_name: '',
    sparepart_merk: '',
    sparepart_harga_beli: '',
    sparepart_harga_jual: '',
    sparepart_stok: '',
    sparepart_stok_minimal: '',
    sparepart_penempatan: '',
    sparepart_gambar: '',
    id_sparepart_type: '',
  },
  loading: true,
  error: null
}

const mutations = {
  setSource(state, payload) {
    state.spareparts = payload
    state.loading = false
    state.error = null
  },

  setFailedAction(state, payload) {
    state.loading = false
    state.error = payload.error
  },

  setSparepartForm(state, payload) {
    state.sparepart.sparepart_id = payload.id
    state.sparepart.sparepart_name = payload.nama
    state.sparepart.sparepart_merk = payload.merk
    state.sparepart.sparepart_harga_beli = payload.harga_beli
    state.sparepart.sparepart_harga_jual = payload.harga_jual
    state.sparepart.sparepart_stok = payload.stok 
    state.sparepart.sparepart_stok_minimal = payload.stok_minimal 
    state.sparepart.sparepart_penempatan = payload.penempatan
    state.sparepart.sparepart_gambar = payload.gambar 
    state.sparepart.id_sparepart_type = payload.id_sparepart_type
  }
}

const getters = {
  error: state => state.error,
  loading: state => state.loading,
  sparepart: state => state.sparepart
}

const actions = {
  async get(context) {
    try {
      context.commit('setSource', await sparepartService.get())
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async store(context, payload) {
    try {
      await sparepartService.store(payload)
    } catch (err) {
      context.commit('setFailedStore', err)
    }
  },

  async edit(context, id) {
    try {
      console.log(id)
      const res = await sparepartService.find(id)
      context.commit('setSparepartForm', res)
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async update(context, payload) {
    try {
      let data = new FormData();
      data.append('id',payload.id)
      data.append('nama',payload.nama)
      data.append('merk',payload.merk)
      data.append('harga_beli',payload.harga_beli)
      data.append('harga_jual',payload.harga_jual)
      data.append('stok',payload.stok)
      data.append('stok_minimal',payload.stok_minimal)
      data.append('gambar',payload.gambar)
      data.append('penempatan',payload.penempatan)
      data.append('id_sparepart_type',payload.id_sparepart_type)

      console.log(data.get('harga_beli'))

      await sparepartService.update(payload.id, data)


      } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async delete (context, id) {
    try {
      await sparepartService.delete(id)
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  resetForm(context) {
    context.commit('setSparepartForm', {})
  }
}

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
}