<template>
  <v-app id="inspire">
    <v-navigation-drawer
      fixed
      v-model="drawer"
      app
      dark
    >
     <v-list dense>
         <router-link :to="{name:'beranda'}"> <v-btn flat block class="menu" color="blue-grey lighten-4"><v-icon>home</v-icon>Beranda</v-btn></router-link>
      </v-list>
      <v-list dense>
         <router-link :to="{name:'transaksi'}"> <v-btn flat block class="menu" color="blue-grey lighten-4">Transaksi</v-btn></router-link>
      </v-list>
       <v-list dense>
         <router-link :to="{name:'pegawai'}"> <v-btn flat block class="menu" color="blue-grey lighten-4">Pegawai</v-btn></router-link>
      </v-list>
       <v-list dense>
         <router-link :to="{name:'cabang'}"> <v-btn flat block class="menu" color="blue-grey lighten-4">Cabang</v-btn></router-link>
      </v-list>
       <v-list dense>
         <router-link :to="{name:'supplier'}"> <v-btn flat block class="menu" color="blue-grey lighten-4">Supplier</v-btn></router-link>
      </v-list>
       <v-list dense>
         <router-link :to="{name:'transaksi'}"> <v-btn flat block class="menu" color="blue-grey lighten-4">Sales</v-btn></router-link>
      </v-list>
       <v-list dense>
         <router-link :to="{name:'spareparttype'}"> <v-btn flat block class="menu" color="blue-grey lighten-4">Sparepart Type</v-btn></router-link>
      </v-list>
       <v-list dense>
         <router-link :to="{name:'sparepart'}"> <v-btn flat block class="menu" color="blue-grey lighten-4">Sparepart</v-btn></router-link>
      </v-list>
       <v-list dense>
         <router-link :to="{name:'jasa'}"> <v-btn flat block class="menu" color="blue-grey lighten-4">Jasa Service</v-btn></router-link>
      </v-list>
       <v-list dense>
         <router-link :to="{name:'transaksi'}"> <v-btn flat block class="menu" color="blue-grey lighten-4">Konsumen</v-btn></router-link>
      </v-list>
       <v-list dense>
         <router-link :to="{name:'transaksi'}"> <v-btn flat block class="menu" color="blue-grey lighten-4">Data Motor</v-btn></router-link>
      </v-list>
       <v-list dense>
         <router-link :to="{name:'transaksi'}"> <v-btn flat block class="menu" color="blue-grey lighten-4">Pengadaan Sparepart</v-btn></router-link>
      </v-list>
       <v-list dense>
         <router-link :to="{name:'transaksi'}"> <v-btn flat block class="menu" color="blue-grey lighten-4">Laporan</v-btn></router-link>
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