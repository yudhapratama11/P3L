import pegawaiService from '../../service/Pegawai'

const state = {
  employees: [],
  employee: {
    employee_name: '',
    employee_address: '',
    employee_notelp: '',
    employee_gaji: '',
    id_user: '',
    id_roles: '',
    id_branch: '',
    username:'',
    password:'',
  },
  loading: true,
  error: null
}

const mutations = {
  setSource(state, payload) {
    state.employees = payload
    state.loading = false
    state.error = null
  },

  setFailedAction(state, payload) {
    state.loading = false
    state.error = payload.error
  },

  setEmployeeForm(state, payload) {
    state.employee.employee_name = payload.nama
    state.employee.employee_notelp = payload.nomor_telepon
    state.employee.employee_address = payload.alamat
    state.employee.employee_gaji = payload.gaji
    state.employee.id_branch = payload.id_branch
    state.employee.id_roles = payload.id_roles
    state.employee.id_user = payload.id_user
    state.employee.username = payload.username
    state.employee.password = payload.password

  }
}

const getters = {
  error: state => state.error,
  loading: state => state.loading,
  employee: state => state.employee
}

const actions = {
  async get(context) {
    try {
      context.commit('setSource', await pegawaiService.get())
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async store(context, payload) {
    try {
      await pegawaiService.store(payload)
    } catch (err) {
      context.commit('setFailedStore', err)
    }
  },

  async edit(context, id) {
    try {
      console.log(id)
      const res = await pegawaiService.find(id)
      context.commit('setEmployeeForm', res)
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async update(context, payload) {
    try {
      const data = {
        nama : payload.nama,
        alamat : payload.alamat,
        gaji : payload.gaji,
        nomor_telepon : payload.nomor_telepon,
        id_branch : payload.id_branch,
        id_user : payload.id_user,
        id_roles : payload.id_roles,
        password: payload.password
      }
      await pegawaiService.update(payload.id, data)
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  async delete (context, id) {
    try {
      await pegawaiService.delete(id)
    } catch (err) {
      context.commit('setFailedAction', err)
    }
  },

  resetForm(context) {
    context.commit('setEmployeeForm', {})
  }
}

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
}