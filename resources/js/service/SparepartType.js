import http from './Http'

export default {
  async get () {
    try {
      const res = await http.get('/api/spareparttype')
      
      return res.data.data
    } catch (err) {
      throw new Error('Gagal mendapatkan data tipe sparepart!')
    }
  },

  async store (payload) {
    try {
      await http.post('/api/spareparttype', payload)
    } catch (err) {
      throw new Error('Gagal simpan tipe sparepart!')
    }
  },

  async find (id) {
    try {
      const res = await http.get(`/api/spareparttype/${id}`)
      console.log(res.data)
      return res.data[0]
    } catch (err) {
      throw new Error('Gagal mendapatkan data tipe sparepart')
    }
  },

  async update (id, payload) {
    try {
      const res = await http.patch(`/api/spareparttype/${id}`, payload)
      return res.data.data
    } catch (err) {
      throw new Error('Gagal update data tipe sparepart!')
    }
  },

  async delete (id) {
    try {
      await http.delete(`/api/spareparttype/${id}`)
    } catch (err) {
      throw new Error('Gagal hapus data tipe sparepart')
    }
  }
}