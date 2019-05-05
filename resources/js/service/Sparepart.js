import http from './Http'

export default {
  async get () {
    try {
      const res = await http.get('/api/sparepart')
      
      return res.data.data
    } catch (err) {
      throw new Error('Gagal mendapatkan data sparepart!')
    }
  },

  async store (payload) {
    try {
      await http.post('/api/sparepart', payload)
    } catch (err) {
      throw new Error('Gagal simpan sparepart baru!')
    }
  },

  async find (id) {
    try {
      const res = await http.get(`/api/sparepart/${id}`)
      console.log("tes")
      console.log(res.data)
      return res.data
    } catch (err) {
      throw new Error('Gagal mendapatkan data sparepart!')
    }
  },

  async update (id, payload) {
    try {
      const res = await http.post(`/api/sparepart/${id}`, payload)

      return res.data.data
    } catch (err) {
      throw new Error('Gagal update data sparepart!')
    }
  },

  async delete (id) {
    try {
      await http.delete(`/api/sparepart/${id}`)
    } catch (err) {
      throw new Error('Gagal hapus data sparepart')
    }
  }
}