import userService from '../../service/User'

const state = {
  users: [],
  user: {
   username: '',
   password:'',
  },
  loading: true,
  error: null
}

const mutations = {
  setSource(state, payload) {
    state.users = payload
    state.loading = false
    state.error = null
  },

  setFailedAction(state, payload) {
    state.loading = false
    state.error = payload.error
  },

  setUserForm(state, payload) {
    state.user.username = payload.username
    state.user.password = payload.password
  }
}

const getters = {
  error: state => state.error,
  loading: state => state.loading,
  user: state => state.user
}

const actions = {
  async get(context) {
    try {
      context.commit('setSource', await userService.get())
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async store(context, payload) {
    try {
      await userService.store(payload)
    } catch (err) {
      context.commit('setFailedStore', err)
    }
  },

  async edit(context, id) {
    try {
      console.log(id)
      const res = await userService.find(id)
      context.commit('setServiceForm', res)
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async update(context, payload) {
    try {
      const data = {
        username: payload.username,
        password: payload.password,
      }
      console.log(data)
      await userService.update(payload.id, data)
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async delete (context, id) {
    try {
      await userService.delete(id)
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  resetForm(context) {
    context.commit('setUserForm', {})
  }
}

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
}