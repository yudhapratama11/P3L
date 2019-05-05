import middleware, { auth } from './middleware'
import App from './components/App'
import Login from './components/LoginComponent'
import Home from './components/Home'
import Sparepart from './components/SparepartComponent'
import SparepartType from './components/SparepartTypeComponent'
import Jasa from './components/ServiceComponent'
import Cabang from './components/CabangComponent'
import Supplier from './components/SupplierComponent'
import Beranda from './components/BerandaComponent'
import Transaksi from './components/TransaksiComponent'
import Pegawai from './components/PegawaiComponent'
import { homedir } from 'os';
import VueRouter from 'vue-router';

export const routes = [
  {
    path: '/',
    name: 'login',
    component: Login,
  },
  {
    path: '/home',
    name: 'home',
    component: Home,
    children:[
      {
        path: 'transaksi',
        name: 'transaksi',
        component: Transaksi,
        meta: { role: [
          'Administrator',
        ]},
        beforeEnter: middleware([
            auth
        ]) 
      },
      {
        path: 'pegawai',
        name: 'pegawai',
        component: Pegawai,
        meta: { role: [
          'Administrator',
        ]},
        beforeEnter: middleware([
            auth
        ]) 
      },
      {
        path: 'beranda',
        name: 'beranda',
        component: Beranda,
        meta: { role: [
          'Administrator',
        ]},
        beforeEnter: middleware([
            auth
        ]) 
      },
      {
        path: 'supplier',
        name: 'supplier',
        component: Supplier,
        meta: { role: [
          'Administrator',
        ]},
        beforeEnter: middleware([
            auth
        ]) 
      },
      {
        path: 'cabang',
        name: 'cabang',
        component: Cabang,
        meta: { role: [
          'Administrator',
        ]},
        beforeEnter: middleware([
            auth
        ]) 
      },
      {
        path: 'jasa',
        name: 'jasa',
        component: Jasa,
        meta: { role: [
          'Administrator',
        ]},
        beforeEnter: middleware([
            auth
        ]) 
      },
      {
        path: 'sparepart',
        name: 'sparepart',
        component: Sparepart,
        meta: { role: [
          'Administrator',
        ]},
        beforeEnter: middleware([
            auth
        ]) 
      },
      {
        path: 'spareparttype',
        name: 'spareparttype',
        component: SparepartType,
        meta: { role: [
          'Administrator',
        ]},
        beforeEnter: middleware([
            auth
        ]) 
      },
    ],
    // meta: { role: [
    //     'Administrator',
    // ]},
    // beforeEnter: middleware([
    //     auth
    // ]) 
  },
];

