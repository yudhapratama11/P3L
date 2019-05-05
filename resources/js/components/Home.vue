<template>
  <v-app id="inspire">
    <v-navigation-drawer
      fixed
      v-model="drawer"
      class="blue grey darken-3"
      app
      dark
    >
      <v-list>
      <v-list-tile
        @click="beranda"
      >
        <v-list-tile-action>
          <v-icon>home</v-icon>
        </v-list-tile-action>

        <v-list-tile-content>
          <v-list-tile-title>Home</v-list-tile-title>
        </v-list-tile-content>
      </v-list-tile>
      <v-list-tile
        @click="transaksi"
      >
        <v-list-tile-action>
          <v-icon>payment</v-icon>
        </v-list-tile-action>

        <v-list-tile-content>
          <v-list-tile-title>Transaction</v-list-tile-title>
        </v-list-tile-content>
      </v-list-tile>
      <v-list-tile
        @click="pegawai"
      >
        <v-list-tile-action>
          <v-icon>group</v-icon>
        </v-list-tile-action>

        <v-list-tile-content>
          <v-list-tile-title>Employee</v-list-tile-title>
        </v-list-tile-content>
      </v-list-tile>
      <v-list-tile
        @click="cabang"
      >
        <v-list-tile-action>
          <v-icon>call_split</v-icon>
        </v-list-tile-action>

        <v-list-tile-content>
          <v-list-tile-title>Branch</v-list-tile-title>
        </v-list-tile-content>
      </v-list-tile>
      <v-list-tile
        @click="supplier"
      >
        <v-list-tile-action>
          <v-icon>domain</v-icon>
        </v-list-tile-action>

        <v-list-tile-content>
          <v-list-tile-title>Supplier</v-list-tile-title>
        </v-list-tile-content>
      </v-list-tile>
      <v-list-tile
        @click="sales"
      >
        <v-list-tile-action>
          <v-icon>person</v-icon>
        </v-list-tile-action>

        <v-list-tile-content>
          <v-list-tile-title>Sales</v-list-tile-title>
        </v-list-tile-content>
      </v-list-tile>
      <v-list-tile
        @click="tipesparepart"
      >
        <v-list-tile-action>
          <v-icon>rv_hookup</v-icon>
        </v-list-tile-action>

        <v-list-tile-content>
          <v-list-tile-title>Sparepart Type</v-list-tile-title>
        </v-list-tile-content>
      </v-list-tile>
      <v-list-tile
        @click="sparepart"
      >
        <v-list-tile-action>
          <v-icon>rv_hookup</v-icon>
        </v-list-tile-action>

        <v-list-tile-content>
          <v-list-tile-title>Sparepart</v-list-tile-title>
        </v-list-tile-content>
      </v-list-tile>
      <v-list-tile
        @click="service"
      >
        <v-list-tile-action>
          <v-icon>pan_tool</v-icon>
        </v-list-tile-action>

        <v-list-tile-content>
          <v-list-tile-title>Sevice</v-list-tile-title>
        </v-list-tile-content>
      </v-list-tile>
      <v-list-tile
        @click="pelanggan"
      >
        <v-list-tile-action>
          <v-icon>mood</v-icon>
        </v-list-tile-action>

        <v-list-tile-content>
          <v-list-tile-title>Customer</v-list-tile-title>
        </v-list-tile-content>
      </v-list-tile>
      <v-list-tile
        @click="motor"
      >
        <v-list-tile-action>
          <v-icon>motorcycle</v-icon>
        </v-list-tile-action>

        <v-list-tile-content>
          <v-list-tile-title>Customer Motorcycle</v-list-tile-title>
        </v-list-tile-content>
      </v-list-tile>
      <v-list-tile
        @click="pemesanan"
      >
        <v-list-tile-action>
          <v-icon>note</v-icon>
        </v-list-tile-action>

        <v-list-tile-content>
          <v-list-tile-title>Sparepart Procurement</v-list-tile-title>
        </v-list-tile-content>
      </v-list-tile>
      <v-list-tile
        @click="laporan"
      >
        <v-list-tile-action>
          <v-icon>timeline</v-icon>
        </v-list-tile-action>

        <v-list-tile-content>
          <v-list-tile-title>Report</v-list-tile-title>
        </v-list-tile-content>
      </v-list-tile>
    </v-list>
    </v-navigation-drawer>
    <v-toolbar color="blue" dark fixed app>
      <v-toolbar-side-icon @click.stop="drawer = !drawer"></v-toolbar-side-icon>
        <!--<img class="logo" src="./aset/logo.png">-->
         <v-toolbar-title>Admin Panel</v-toolbar-title>
         <div class="logout">
          <v-btn flat color="dark"  @click="logoutHandler">
            <v-icon>logout</v-icon>
          </v-btn>
         </div>
    </v-toolbar>
    <v-content>
      <router-view></router-view>
    </v-content>
    <v-footer color="blue" app>
      <span class="white--text" sty>&copy; Atma Auto 2019</span>
    </v-footer>
  </v-app>
</template>

<script>
import auth from '../service/Auth'

  export default {
    data: () => ({
      drawer: null
    }),

    props: {
      source: String
    },

    methods: {
      logoutHandler() {
        auth.logout()
        this.$router.push({ name: 'login' })
      },
      beranda(){
        this.$router.push({ name: 'beranda' })
      },
      transaksi(){
        this.$router.push({ name: 'transaksi' })
      },
      pegawai(){
        this.$router.push({ name: 'pegawai' })
      },
      cabang(){
        this.$router.push({ name: 'cabang' })
      },
      supplier(){
        this.$router.push({ name: 'supplier' })
      },
      sales(){
        this.$router.push({ name: 'transaksi' })
      },
      tipesparepart(){
        this.$router.push({ name: 'spareparttype' })
      },
      sparepart(){
        this.$router.push({ name: 'sparepart' })
      },
      service(){
        this.$router.push({ name: 'jasa' })
      },
      pelanggan(){
        this.$router.push({ name: 'transaksi' })
      },
      motor(){
        this.$router.push({ name: 'transaksi' })
      },
      pemesanan(){
        this.$router.push({ name: 'transaksi' })
      },
      laporan(){
        this.$router.push({ name: 'transaksi' })
      },
    } 
  }
</script>

<style>
/*Untuk logo*/
.logo{
  width:100px;
  length:100px;
	float:right;
	padding-top:3px;
	padding-right: 0px;
}

.judul{
  font-family:"Times New Roman", Times, serif;
  font-size:150%;
  color:white;  
}

div.logout{
  position: relative;
  left: 1200px;
}
.menu{
  font-size:120%;
  font-weight: bold;
  color:black;
}

</style>