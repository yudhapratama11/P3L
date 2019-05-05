import http from './Http'

export default {
  async get () {
    try {
      const res = await http.get('/api/employee')
      
      return res.data.data
    } catch (err) {
      throw new Error('Gagal mendapatkan data karyawan!')
    }
  },

  async store (payload) {
    try {
      await http.post('/api/user', payload)
    } catch (err) {
      throw new Error('Gagal simpan karyawan baru!')
    }
  },

  async find (id) {
    try {
      const res = await http.get(`/api/employee/${id}`)
      console.log(res.data.data)
      return res.data[0]
    } catch (err) {
      throw new Error('Gagal mendapatkan data karyawan!')
    }
  },

  async update (id, payload) {
    try {
      const res = await http.patch(`/api/employee/${id}`, payload)
      console.log(res.data.data)
      return res.data.data
    } catch (err) {
      throw new Error('Gagal update data karyawan!')
    }
  },

  async delete (id) {
    try {
      await http.delete(`/api/employee/${id}`)
    } catch (err) {
      throw new Error('Gagal hapus data karyawan')
    }
  }
}