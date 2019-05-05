<template>
  <div>
    <div class="text-xs-center">
        <h1 style="font-size:15pt; padding-top:30px">TABEL CABANG</h1>    
    </div>
    <!-- ini pop up tambah-->
      <v-dialog v-model="dialog" persistent max-width="600px">
        <template v-slot:activator="{ on }">
          <v-btn dark v-on="on" color="indigo" class="button">Tambah</v-btn>
        </template>
        <v-card>
          <v-card-title>
            <span class="headline">Tambah Cabang</span>
          </v-card-title>
          <VForm>
          <v-card-text>
            <v-layout>
              <v-flex>
                <v-text-field 
                  label="Nama*" 
                  class="pa-1"
                  v-model="form.cabang_name"
                  required 
                />
              </v-flex>
            </v-layout>
            <v-layout>
              <v-flex>
                <v-text-field 
                  label="Alamat*" 
                  class="pa-1"
                  v-model="form.cabang_address"
                  required 
                />
              </v-flex>
            </v-layout>
            <v-layout>
              <v-flex>
                <v-text-field 
                  label="Nomor Telepon*" 
                  class="pa-1"
                  v-model="form.cabang_phone_number"
                  required 
                />
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
            <span class="headline">Edit Cabang</span>
          </v-card-title>
          <VForm>
          <v-card-text>
            <v-layout>
              <v-flex>
                <v-text-field 
                  label="Nama*" 
                  class="pa-1"
                  v-model="form.cabang_name"
                  required 
                />
              </v-flex>
            </v-layout>
            <v-layout>
              <v-flex>
                <v-text-field 
                  label="Alamat*" 
                  class="pa-1"
                  v-model="form.cabang_address"
                  required 
                />
              </v-flex>
            </v-layout>
            <v-layout>
              <v-flex>
                <v-text-field 
                  label="Nomor Telepon*" 
                  class="pa-1"
                  v-model="form.cabang_phone_number"
                  required 
                />
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
        <td>{{ props.item.nama }}</td>
        <td>{{ props.item.alamat }}</td>
        <td>{{ props.item.nomor_telepon }}</td>
        <td>
          <v-icon
            small
            class="mr-2"
            @click="editCabang(props.item.id)"
          >
            edit
          </v-icon>
         <v-icon
            small
            @click="deleteCabang(props.item.id)"
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
         headers: [
          {
            sortable: false,
            text: 'Nama',
            value: 'nama'
          },
          {
            sortable: false,
            text: 'Alamat',
            value: 'alamat'
          },
          {
            sortable: false,
            text: 'No Telp',
            value: 'nomor_telepon'
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
      loading: state => state.Cabang.loading,
      error: state => state.Cabang.error,
      items: state => state.Cabang.cabangs
    }),
    ...mapGetters({
      form: 'Cabang/cabang',
    })
  },

    methods: {
        submitHandler () {
        console.log(this.form.first_name)
        this.$emit('submitted', this.form)
      },
      ...mapActions({
        fetch: 'Cabang/get',
        add: 'Cabang/store',
        edit: 'Cabang/update',
        find: 'Cabang/edit',
        delete: 'Cabang/delete'
      }),

      async submitHandler()
      {
          const payload = {
            nama: this.form.cabang_name,
            alamat: this.form.cabang_address,
            nomor_telepon: this.form.cabang_phone_number,
          }

          await this.add(payload)
        
          if (!this.error) {
            this.dialog=false
            this.fetch()
          }
      },

      editCabang(id){
        this.dialog2=true
        this.id_cabang=id
        console.log(id)
        this.find(id)
      },

      deleteCabang(id){
        this.id_cabang=id
        this.dialog3=true
      },

      async deleteHandler () {
        console.log(this.id_cabang);
        await this.delete(this.id_cabang)
        this.fetch()
        this.dialog3=false
      },

      async editHandler(){
        const payload = {
          id: this.id_cabang,
          nama: this.form.cabang_name,
          alamat: this.form.cabang_address,
          nomor_telepon: this.form.cabang_phone_number,
        }

        await this.edit(payload)
      
        if (!this.Error) {
          this.dialog2=false
          this.fetch()
        }
      }
      
    },

    mounted () {
      this.fetch()
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