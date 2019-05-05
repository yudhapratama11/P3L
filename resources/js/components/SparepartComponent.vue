<template>
  <div>
    <div class="text-xs-center">
        <h1 style="font-size:15pt; padding-top:30px">TABEL SPAREPART</h1>    
    </div>
    <!-- ini pop up tambah-->
      <v-dialog v-model="dialog" persistent max-width="600px">
        <template v-slot:activator="{ on }">
          <v-btn dark v-on="on" color="indigo" class="button">Tambah</v-btn>
        </template>
        <v-card>
          <v-card-title>
            <span class="headline">Tambah Sparepart</span>
          </v-card-title>
          <VForm>
          <v-card-text>
           <v-layout>
              <v-flex>
                <v-text-field 
                  label="Kode Sparepart*" 
                  class="pa-1"
                  v-model="form.sparepart_id"
                  required 
                />
              </v-flex>
            </v-layout>
            <v-layout>
              <v-flex>
                <v-text-field 
                  label="Nama*" 
                  class="pa-1"
                  v-model="form.sparepart_name"
                  required 
                />
              </v-flex>
            </v-layout>
            <v-layout>
              <v-flex>
                <v-text-field 
                  label="Merk*" 
                  class="pa-1"
                  v-model="form.sparepart_merk"
                  required 
                />
              </v-flex>
            </v-layout>
            <v-layout>
              <v-flex>
                <v-select
                  label="Tipe*" 
                  class="pa-1"
                  v-model="form.id_sparepart_type"
                  item-text="nama"
                  item-value="id"
                  :items="items2"
                  :return-object="false"
                  required 
                ></v-select>
              </v-flex>
            </v-layout>
            <v-layout>
              <v-flex>
                <v-text-field 
                  label="Harga Jual*" 
                  class="pa-1"
                  v-model="form.sparepart_harga_jual"
                  required 
                />
              </v-flex>
            </v-layout>
             <v-layout>
              <v-flex>
                <v-text-field 
                  label="Harga Beli*" 
                  class="pa-1"
                  v-model="form.sparepart_harga_beli"
                  required 
                />
              </v-flex>
            </v-layout>
             <v-layout>
              <v-flex>
                <v-text-field 
                  label="Stok*" 
                  class="pa-1"
                  v-model="form.sparepart_stok"
                  required 
                />
              </v-flex>
            </v-layout>
             <v-layout>
              <v-flex>
                <v-text-field 
                  label="Stok Minimal*" 
                  class="pa-1"
                  v-model="form.sparepart_stok_minimal"
                  required 
                />
              </v-flex>
            </v-layout>
             <v-layout>
              <v-flex>
                <v-text-field 
                  label="Penempatan*" 
                  class="pa-1"
                  v-model="form.sparepart_penempatan"
                  required 
                />
              </v-flex>
            </v-layout>
            <v-layout>
              <v-flex>
                <img :src="imageUrl" height="200" v-if="imageUrl"/>
                <img :src="'/itemImages/'+form.sparepart_gambar" height="200" :alt="form.sparepart_gambar" v-else-if="form.sparepart_gambar"/>
                <img :src="defaultImg" height="200" v-else/>
                <v-text-field 
                  label="Gambar*" 
                  class="pa-1"
                  v-model="imageName"
                  @click='pickFile'
                />
                <input  
                  type="file"
                  style="display: none"
                  ref="image"
                  accept="image/*"
                  @change="onFilePicked"
                >
              </v-flex>
            </v-layout>
            <small>*indicates required field</small>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
              <VBtn
              depressed
              color="info"
              @click="submitHandler"
            >
              Simpan
            </VBtn>
            <v-btn color="success" @click="dialog = false">Close</v-btn>
          </v-card-actions>
          </VForm>
        </v-card>
      </v-dialog>

      <!-- ini pop up edit-->
      <v-dialog v-model="dialog2" persistent max-width="600px">
        <v-card>
          <v-card-title>
            <span class="headline">Edit Sparepart</span>
          </v-card-title>
          <VForm>
          <v-card-text>
           <v-layout>
              <v-flex>
                <v-text-field 
                  label="Kode Sparepart*" 
                  class="pa-1"
                  v-model="form.sparepart_id"
                  disabled
                />
              </v-flex>
            </v-layout>
            <v-layout>
              <v-flex>
                <v-text-field 
                  label="Nama*" 
                  class="pa-1"
                  v-model="form.sparepart_name"
                  required 
                />
              </v-flex>
            </v-layout>
            <v-layout>
              <v-flex>
                <v-text-field 
                  label="Merk*" 
                  class="pa-1"
                  v-model="form.sparepart_merk"
                  required 
                />
              </v-flex>
            </v-layout>
            <v-layout>
              <v-flex>
                <v-select
                  label="Tipe*" 
                  class="pa-1"
                  v-model="form.id_sparepart_type"
                  item-text="nama"
                  item-value="id"
                  :items="items2"
                  :return-object="false"
                  disabled 
                ></v-select>
              </v-flex>
            </v-layout>
            <v-layout>
              <v-flex>
                <v-text-field 
                  label="Harga Jual*" 
                  class="pa-1"
                  v-model="form.sparepart_harga_jual"
                  required 
                />
              </v-flex>
            </v-layout>
             <v-layout>
              <v-flex>
                <v-text-field 
                  label="Harga Beli*" 
                  class="pa-1"
                  v-model="form.sparepart_harga_beli"
                  required 
                />
              </v-flex>
            </v-layout>
             <v-layout>
              <v-flex>
                <v-text-field 
                  label="Stok*" 
                  class="pa-1"
                  v-model="form.sparepart_stok"
                  required 
                />
              </v-flex>
            </v-layout>
             <v-layout>
              <v-flex>
                <v-text-field 
                  label="Stok Minimal*" 
                  class="pa-1"
                  v-model="form.sparepart_stok_minimal"
                  required 
                />
              </v-flex>
            </v-layout>
             <v-layout>
              <v-flex>
                <v-text-field 
                  label="Penempatan*" 
                  class="pa-1"
                  v-model="form.sparepart_penempatan"
                  required 
                />
              </v-flex>
            </v-layout>
            <v-layout>
              <v-flex>
                <img :src="imageUrl" height="200" v-if="imageUrl"/>
                <img :src="'/itemImages/'+form.sparepart_gambar" height="200" :alt="form.sparepart_gambar" v-else-if="form.sparepart_gambar"/>
                <img :src="defaultImg" height="200" v-else/>
                <v-text-field 
                  label="Gambar*" 
                  class="pa-1"
                  v-model="imageName"
                  @click='pickFile'
                />
                <input  
                  type="file"
                  style="display: none"
                  ref="image"
                  accept="image/*"
                  @change="onFilePicked"
                >
              </v-flex>
            </v-layout>
            <small>*indicates required field</small>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
              <VBtn
              depressed
              color="info"
              @click="editHandler"
            >
              Edit
            </VBtn>
            <v-btn color="success" @click="dialog2 = false">Close</v-btn>
          </v-card-actions>
          </VForm>
        </v-card>
      </v-dialog>
      <!-- ini pop up buat delete-->
      <v-dialog v-model="dialog3" persistent max-width="500">
        <v-card>
          <v-card-text class="text-md-center" style="font-size:15px">Anda yakin ingin menghapus data ini?</v-card-text>
          <v-card-actions>
            <v-spacer/>
            <VBtn class="mb-4" depressed dark color="blue darken-1" @click="deleteHandler()">Yes</VBtn>
            <VBtn class="mb-4" depressed dark color="blue darken-1"  @click="dialog3 = false">No</VBtn>
            <v-spacer/>
          </v-card-actions>
        </v-card>
      </v-dialog>
   <div class="search-input">
    <v-text-field
      v-model="search"
      class="search-input"
      append-icon="search"
      label="Search..."
      color="black"
      />
    </div>
    <v-data-table 
      :headers="headers"
      :items="items"
      :search="search"
      class="my-data-table"
    > 
    <template
        slot="headerCell"
        slot-scope="{ header }"
      >
      <span
        class="subheading font-weight-light text-success text--darken-3"
        v-text="header.text"
      />
    </template>
      <template
        slot="items"
        slot-scope="props"
      >
        <td>{{ props.item.id }}</td>
        <td>{{ props.item.nama }}</td>
        <td>{{ props.item.merk }}</td>
        <td>{{ props.item.tipe_sparepart }}</td>
        <td>{{ props.item.harga_beli }}</td>
        <td>{{ props.item.harga_jual }}</td>
        <td>{{ props.item.stok }}</td>
        <td>{{ props.item.stok_minimal }}</td>
        <td>{{ props.item.penempatan }}</td>
        <!-- <td>{{ props.item.gambar }}</td>-->
        <td>
          <v-icon
            small
            class="mr-2"
            @click="editSparepart(props.item.id)"
          >
            edit
          </v-icon>
         <v-icon
            small
            @click="deleteSparepart(props.item.id)"
          >
            delete
          </v-icon>
        </td>
      </template>
      <v-alert v-slot:no-results :value="true" color="error" icon="warning">
        Your search for "{{ search }}" found no results.
      </v-alert>
    </v-data-table>
  </div>
</template>

<script>
import { mapGetters, mapState, mapActions } from 'vuex'
import sparepartType from '.././service/SparepartType'

//:error-messages="nameErrors"
  export default {
    props: {
      value: {
        type: Boolean,
        default: false
      }
    },
    data () {
      return {
        dialog: false,
        dialog2: false,
        dialog3: false,
        search: '',
        id_sparepart_type: '',
        imageName: '',
        defaultImg: 'http://localhost:8000/aset/default.png',
        imageUrl: '',
         headers: [
          {
            sortable: false,
            text: 'Kode Sparepart',
            value: 'id'
          },
          {
            sortable: false,
            text: 'Nama',
            value: 'nama'
          },
          {
            sortable: false,
            text: 'Merk',
            value: 'merk'
          },
          {
            sortable: false,
            text: 'Type',
            value: 'tipe_sparepart'
          },
          {
            sortable: false,
            text: 'Harga Beli',
            value: 'harga_beli'
          },
          {
            sortable: false,
            text: 'Harga Jual',
            value: 'harga_jual'
          },
          {
            sortable: false,
            text: 'Stok',
            value: 'stok'
          },
          {
            sortable: false,
            text: 'Stok Minimal',
            value: 'stok_minimal'
          },
          {
            sortable: false,
            text: 'Penempatan',
            value: 'penempatan'
          },
          {
            sortable: false,
            text: 'Action',
            value: 'action'
          },
        ],
         dialog: false
      }
    },

    computed: {
    ...mapState({
      loading: state => state.Sparepart.loading,
      error: state => state.Sparepart.error,
      items: state => state.Sparepart.spareparts,
      items2: state => state.Spareparttype.spareparttypes
    }),
    ...mapGetters({
      form: 'Sparepart/sparepart',
    })
  },

    methods: {
      
      ...mapActions({
        fetch: 'Sparepart/get',
        fetch2: 'Spareparttype/get',
        add: 'Sparepart/store',
        edit: 'Sparepart/update',
        find: 'Sparepart/edit',
        delete: 'Sparepart/delete'
      }),

      pickFile () {
        this.$refs.image.click ()
      },
		
      onFilePicked (e) {
        const files = e.target.files
        if(files[0] !== undefined) {
          this.imageName = files[0].name
          if(this.imageName.lastIndexOf('.') <= 0) {
            return
          }
          const fr = new FileReader ()
          fr.readAsDataURL(files[0])
          fr.addEventListener('load', () => {
            this.imageUrl = fr.result
            this.form.sparepart_gambar = files[0] // this is an image file that can be sent to server...
          })
        } else {
          this.imageName = ''
          this.imageUrl = 'http://localhost:8000/aset/default.png'
        }
      },

      async submitHandler()
      {
          console.log(this.form.sparepart_harga_beli)

          let payload = new FormData();
          payload.append('id',this.form.sparepart_id)
          payload.append('nama', this.form.sparepart_name)
          payload.append('merk', this.form.sparepart_merk)
          payload.append('harga_beli', this.form.sparepart_harga_beli)
          payload.append('harga_jual', this.form.sparepart_harga_jual)
          payload.append('stok', this.form.sparepart_stok)
          payload.append('stok_minimal', this.form.sparepart_stok_minimal)
          payload.append('gambar', this.form.sparepart_gambar)
          payload.append('penempatan', this.form.sparepart_penempatan)
          payload.append('id_sparepart_type', this.form.id_sparepart_type)

          await this.add(payload)
        
          if (!this.error) {
            this.dialog=false
            this.fetch()
          }
      },

      editSparepart(id){
        this.dialog2=true
        this.sparepart_id=id
        console.log(id)
        this.find(id)
      },

      deleteSparepart(id){
        this.sparepart_id=id
        this.dialog3=true
      },

      async deleteHandler () {
        console.log(this.sparepart_id);
        await this.delete(this.sparepart_id)
        this.fetch()
        this.dialog3=false
      },

      async editHandler(){
        const payload = {
          id: this.form.sparepart_id,
          nama: this.form.sparepart_name,
          merk: this.form.sparepart_merk,
          harga_beli: this.form.sparepart_harga_beli,
          harga_jual: this.form.sparepart_harga_jual,
          stok: this.form.sparepart_stok,
          stok_minimal: this.form.sparepart_stok_minimal,
          gambar: this.form.sparepart_gambar,
          penempatan: this.form.sparepart_penempatan,
          id_sparepart_type: this.form.id_sparepart_type,
        }
        console.log(payload.harga_beli)
        await this.edit(payload)
      
        if (!this.Error) {
          this.dialog2=false
          this.fetch()
        }
      }
      
    },

    mounted () {
      this.fetch()
      this.fetch2()
    }
  }
</script>	

<style scoped>
.button{
  left:250px;
  top:50px;
}
.search-input {
      margin-bottom: 30px !important;
      padding: 5px;
      width: 150px;
    }
.my-data-table {
 margin-top: 70px;
}
</style>