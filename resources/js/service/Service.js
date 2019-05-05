import http from './Http'

export default {
  async get () {
    try {
      const res = await http.get('/api/service')
      
      return res.data
    } catch (err) {
      throw new Error('Gagal mendapatkan data jasa service!')
    }
  },

  async store (payload) {
    try {
      await http.post('/api/service', payload)
    } catch (err) {
      throw new Error('Gagal simpan jasa service baru!')
    }
  },

  async find (id) {
    try {
      const res = await http.get(`/api/service/${id}`)
      console.log(res.data)
      return res.data[0]
    } catch (err) {
      throw new Error('Gagal mendapatkan data jasa service!')
    }
  },

  async update (id, payload) {
    try {
      const res = await http.patch(`/api/service/${id}`, payload)

      return res.data
    } catch (err) {
      throw new Error('Gagal update data jasa service!')
    }
  },

  async delete (id) {
    try {
      await http.delete(`/api/service/${id}`)
    } catch (err) {
      throw new Error('Gagal hapus data jasa service')
    }
  }
}