<template>
  <div>
    <div class="text-xs-center">
        <h1 style="font-size:15pt; padding-top:30px">TABEL PEGAWAI</h1>    
    </div>
    <!-- ini pop up tambah-->
      <v-dialog v-model="dialog" persistent max-width="600px">
        <template v-slot:activator="{ on }">
          <v-btn dark v-on="on" color="indigo" class="button">Tambah</v-btn>
        </template>
        <v-card>
          <v-card-title>
            <span class="headline">Tambah Pegawai</span>
          </v-card-title>
          <VForm>
          <v-card-text>
            <v-layout>
              <v-flex>
                <v-text-field 
                  label="Nama*" 
                  class="pa-1"
                  v-model="form.employee_name"
                  required 
                />
              </v-flex>
            </v-layout>
            <v-layout>
              <v-flex>
                <v-text-field 
                  label="Nomor Telepon*" 
                  class="pa-1"
                  v-model="form.employee_notelp"
                  required 
                />
              </v-flex>
            </v-layout>
             <v-layout>
              <v-flex>
                <v-text-field 
                  label="Alamat*" 
                  class="pa-1"
                  v-model="form.employee_address"
                  required 
                />
              </v-flex>
            </v-layout>
             <v-layout>
              <v-flex>
                <v-text-field 
                  label="Gaji*" 
                  class="pa-1"
                  v-model="form.employee_gaji"
                  required 
                />
              </v-flex>
            </v-layout>
             <v-layout>
              <v-flex>
                <v-select
                  label="Peran*" 
                  class="pa-1"
                  v-model="form.id_roles"
                  item-text="nama"
                  item-value="id"
                  :items="items1"
                  :return-object="false"
                  required 
                ></v-select>
              </v-flex>
            </v-layout>
            <v-layout v-if="form.id_roles != 0">
            <v-layout v-if="form.id_roles != 3">
              <v-flex>
                <v-text-field 
                  label="Username*" 
                  class="pa-1"
                  v-model="form.username"
                  required 
                />
              </v-flex>
            </v-layout>
            </v-layout>
            </v-layout>
            <v-layout v-if="form.id_roles != 0">
            <v-layout v-if="form.id_roles != 3">
              <v-flex>
                <v-text-field 
                  label="Password*" 
                  class="pa-1"
                  v-model="form.password"
                  :append-icon="show1 ? 'visibility' : 'visibility_off'"
                  :type="show1 ? 'text' : 'password'"
                   @click:append="show1 = !show1"
                  required 
                />
              </v-flex>
            </v-layout>
            </v-layout>
             <v-layout>
              <v-flex>
                <v-select 
                  label="Cabang*" 
                  class="pa-1"
                  v-model="form.id_branch"
                  item-text="nama"
                  item-value="id"
                  :items="items2"
                  :return-object="false"
                  required 
                ></v-select>
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
            <span class="headline">Edit Pegawai</span>
          </v-card-title>
          <VForm>
          <v-card-text>
            <v-layout>
              <v-flex>
                <v-text-field 
                  label="Nama*" 
                  class="pa-1"
                  v-model="form.employee_name"
                  required 
                />
              </v-flex>
            </v-layout>
            <v-layout>
              <v-flex>
                <v-text-field 
                  label="Nomor Telepon*" 
                  class="pa-1"
                  v-model="form.employee_notelp"
                  required 
                />
              </v-flex>
            </v-layout>
             <v-layout>
              <v-flex>
                <v-text-field 
                  label="Alamat*" 
                  class="pa-1"
                  v-model="form.employee_address"
                  required 
                />
              </v-flex>
            </v-layout>
             <v-layout>
              <v-flex>
                <v-text-field 
                  label="Gaji*" 
                  class="pa-1"
                  v-model="form.employee_gaji"
                  required 
                />
              </v-flex>
            </v-layout>
              <v-layout>
              <v-flex>
                <v-select
                  label="Peran*" 
                  class="pa-1"
                  v-model="form.id_roles"
                  item-text="nama"
                  item-value="id"
                  :items="items1"
                  :return-object="false"
                  required 
                ></v-select>
              </v-flex>
            </v-layout>
            </v-layout>
            <v-layout v-if="form.id_roles != 0">
            <v-layout v-if="form.id_roles != 3">
              <v-flex>
                <v-text-field 
                  label="Password*" 
                  class="pa-1"
                  v-model="form.password"
                  :append-icon="show1 ? 'visibility' : 'visibility_off'"
                  :type="show1 ? 'text' : 'password'"
                   @click:append="show1 = !show1"
                  required 
                />
              </v-flex>
            </v-layout>
            </v-layout>
             <v-layout>
              <v-flex>
                <v-select 
                  label="Cabang*" 
                  class="pa-1"
                  v-model="form.id_branch"
                  item-text="nama"
                  item-value="id"
                  :items="items2"
                  :return-object="false"
                  required 
                ></v-select>
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
        <td>{{ props.item.gaji }}</td>
        <td>{{ props.item.role }}</td>
        <td>{{ props.item.branch }}</td>
        <td>
          <v-icon
            small
            class="mr-2"
            @click="editPegawai(props.item.id)"
          >
            edit
          </v-icon>
         <v-icon
            small
            @click="deletePegawai(props.item.id)"
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
import cabangService from '.././service/Cabang'
import roleService from '.././service/Role'

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
       show1: false,
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
            text: 'Gaji',
            value: 'gaji'
          },
           {
            sortable: false,
            text: 'Peran',
            value: 'role'
          },
           {
            sortable: false,
            text: 'Cabang',
            value: 'branch'
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
      loading: state => state.Employee.loading,
      error: state => state.Employee.error,
      items: state => state.Employee.employees,
      items1: state => state.Role.roles,
      items2: state => state.Cabang.cabangs,
    }),
    ...mapGetters({
      form: 'Employee/employee',
    })
  },

    methods: {
    
      ...mapActions({
        fetch: 'Employee/get',
        fetch1: 'Role/get',
        fetch2: 'Cabang/get',
        add: 'Employee/store',
        edit: 'Employee/update',
        find: 'Employee/edit',
        delete: 'Employee/delete'
      }),

    
      async submitHandler()
      {
        console.log(this.form.id_roles)
        if(this.form.id_roles != 3){
          console.log("bukan montir")
          const payload = {
            nama: this.form.employee_name,
            alamat: this.form.employee_address,
            nomor_telepon: this.form.employee_notelp,
            gaji: this.form.employee_gaji,
            id_branch: this.form.id_branch,
            id_roles: this.form.id_roles,
            id_user: this.form.id_user,
            username: this.form.username,
            password: this.form.password,
          }
          await this.add(payload)
          console.log(this.error)
          if (!this.error) {
            this.dialog=false
            this.fetch()
          }
        }else{
          console.log("montir")
          const payload = {
            nama: this.form.employee_name,
            alamat: this.form.employee_address,
            nomor_telepon: this.form.employee_notelp,
            gaji: this.form.employee_gaji,
            id_branch: this.form.id_branch,
            id_roles: this.form.id_roles,
          }
          await this.add(payload)
          console.log(this.error)
          console.log(payload)
          if (!this.error) {
            this.dialog=false
            this.fetch()
          }
        }
      },

      editPegawai(id){
        this.dialog2=true
        this.id_employee=id
        this.find(id)
      },

      deletePegawai(id){
        this.id_employee=id
        this.dialog3=true
      },

      async deleteHandler () {
        console.log(this.id_employee);
        await this.delete(this.id_employee)
        this.fetch()
        this.dialog3=false
      },

      async editHandler(){
        console.log(this.id_employee)
        console.log(this.form.employee_name)
        if(this.form.id_roles != 3){
          console.log("Edit no M")
          console.log(this.id)
          const payload = {
            id: this.id_employee,
            nama: this.form.employee_name,
            alamat: this.form.employee_address,
            nomor_telepon: this.form.employee_notelp,
            gaji: this.form.employee_gaji,
            id_branch: this.form.id_branch,
            id_roles: this.form.id_roles,
            id_user: this.form.id_user,
            password: this.form.password,
          }
          console.log(payload.id)
          await this.edit(payload)
          if (!this.error) {
            this.dialog2=false
            this.fetch()
          }
        }else{
          console.log("Edit M")
          const payload = {
            id: this.id_employee,
            nama: this.form.employee_name,
            alamat: this.form.employee_address,
            nomor_telepon: this.form.employee_notelp,
            gaji: this.form.employee_gaji,
            id_branch: this.form.id_branch,
            id_roles: this.form.id_roles,
          }
          console.log(payload.id)
          await this.edit(payload)
          console.log("cek")
          console.log(this.error)
          if (!this.error) {
            this.dialog2=false
            this.fetch()
          }
        }
      }
      
    },

    mounted () {
      this.fetch()
      this.fetch1()
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