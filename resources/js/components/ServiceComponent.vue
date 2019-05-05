<template>
  <div>
    <div class="text-xs-center">
        <h1 style="font-size:15pt; padding-top:30px">TABEL JASA SERVICE</h1>    
    </div>
    <!-- ini pop up tambah-->
      <v-dialog v-model="dialog" persistent max-width="600px">
       <template v-slot:activator="{ on }">
          <v-btn dark v-on="on" color="indigo" class="button">Tambah</v-btn>
        </template>
        <v-card>
          <v-card-title>
            <span class="headline">Tambah Jasa Service</span>
          </v-card-title>
          <VForm>
          <v-card-text>
            <v-layout>
              <v-flex>
                <v-text-field 
                  label="Nama*" 
                  class="pa-1"
                  v-model="form.service_name"
                  required 
                />
              </v-flex>
            </v-layout>
            <v-layout>
              <v-flex>
                <v-text-field 
                  label="Harga*" 
                  class="pa-1"
                  v-model="form.service_harga"
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
            <span class="headline">Edit Jasa Service</span>
          </v-card-title>
          <VForm>
          <v-card-text>
            <v-layout>
              <v-flex>
                <v-text-field 
                  label="Nama*" 
                  class="pa-1"
                  v-model="form.service_name"
                  required 
                />
              </v-flex>
            </v-layout>
            <v-layout>
              <v-flex>
                <v-text-field 
                  label="Harga*" 
                  class="pa-1"
                  v-model="form.service_harga"
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
        <td>{{ props.item.harga }}</td>
        <td>
          <v-icon
            small
            class="mr-2"
            @click="editJasa(props.item.id)"
          >
            edit
          </v-icon>
         <v-icon
            small
            @click="deleteJasa(props.item.id)"
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
            text: 'Harga',
            value: 'harga'
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
      loading: state => state.Service.loading,
      error: state => state.Service.error,
      items: state => state.Service.services
    }),
    ...mapGetters({
      form: 'Service/service',
    })
  },

    methods: {
      submitHandler () {
        console.log(this.form.service_name)
        this.$emit('submitted', this.form)
      },
      ...mapActions({
        fetch: 'Service/get',
        add: 'Service/store',
        edit: 'Service/update',
        find: 'Service/edit',
        delete: 'Service/delete'
      }),

      async submitHandler()
      {
          const payload = {
            nama: this.form.service_name,
            harga: this.form.service_harga,
          }
          await this.add(payload)
        
          if (!this.error) {
            this.dialog=false
            this.fetch()
          }
      },

      editJasa(id){
        this.dialog2=true
        this.id_jasa=id
        console.log(id)
        this.find(id)
      },

      deleteJasa(id){
        this.id_jasa=id
        this.dialog3=true
      },

      async deleteHandler () {
        console.log(this.id_jasa);
        await this.delete(this.id_jasa)
        this.fetch()
        this.dialog3=false
      },

      async editHandler(){
        const payload = {
          id: this.id_jasa,
          nama: this.form.service_name,
          harga: this.form.service_harga,
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