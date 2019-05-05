import http from './Http'

export default {
  async get () {
    try {
      const res = await http.get('/api/supplier')
      
      return res.data
    } catch (err) {
      throw new Error('Gagal mendapatkan data supplier!')
    }
  },

  async store (payload) {
    try {
      await http.post('/api/supplier', payload)
    } catch (err) {
      throw new Error('Gagal simpan supplier baru!')
    }
  },

  async find (id) {
    try {
      const res = await http.get(`/api/supplier/${id}`)
      console.log(res.data)
      return res.data[0]
    } catch (err) {
      throw new Error('Gagal mendapatkan data supplier!')
    }
  },

  async update (id, payload) {
    try {
      const res = await http.patch(`/api/supplier/${id}`, payload)

      return res.data
    } catch (err) {
      throw new Error('Gagal update data supplier!')
    }
  },

  async delete (id) {
    try {
      await http.delete(`/api/supplier/${id}`)
    } catch (err) {
      throw new Error('Gagal hapus data supplier')
    }
  }
}