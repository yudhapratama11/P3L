import roleService from '../../service/Role'

const state = {
  roles: [],
  role: {
    role_id: '',
    role_name: '',
  },
  loading: true,
  error: null
}

const mutations = {
  setSource(state, payload) {
    state.roles = payload
    state.loading = false
    state.error = null
  },

  setFailedAction(state, payload) {
    state.loading = false
    state.error = payload.error
  },

  setRoleForm(state, payload) {
    state.role.role_id = payload.id
    state.role.role_name = payload.nama
  }
}

const getters = {
  error: state => state.error,
  loading: state => state.loading,
  role: state => state.role
}

const actions = {
  async get(context) {
    try {
      context.commit('setSource', await roleService.get())
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async store(context, payload) {
    try {
      await roleService.store(payload)
    } catch (err) {
      context.commit('setFailedStore', err)
    }
  },

  async edit(context, id) {
    try {
      console.log(id)
      const res = await roleService.find(id)
      context.commit('setRoleForm', res)
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async update(context, payload) {
    try {
      const data = {
        nama : payload.nama,
        id : payload.id
      }
      console.log(data)
      await roleService.update(payload.id, data)
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async delete (context, id) {
    try {
      await roleService.delete(id)
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  resetForm(context) {
    context.commit('setRoleForm', {})
  }
}

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
}