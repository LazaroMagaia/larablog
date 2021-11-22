
require('./bootstrap');
import Vue from 'vue'
import VueRouter from 'vue-router'
Vue.use(VueRouter)

//TOASTER
/*import Toaster from 'v-toaster'

// You need a specific loader for CSS files like https://github.com/webpack/css-loader
import 'v-toaster/dist/v-toaster.css'
Vue.use(Toaster, {timeout: 5000})*/

//TAIWIND CSS
import Notifications from "vt-notifications";
Vue.use(Notifications);
//BOOTSTRAP
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'

// Import Bootstrap an BootstrapVue CSS files (order is important)
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

// Make BootstrapVue available throughout your project
Vue.use(BootstrapVue)
// Optionally install the BootstrapVue icon components plugin
Vue.use(IconsPlugin)

//SWEETALERT 2
import Swal from 'sweetalert2';
window.Swal = Swal
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer)
      toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
  })
  window.Toast = Toast

//VUE-PAGINATOR
Vue.component('pagination', require('laravel-vue-pagination'));

//USER IMPORTED
import User from './helpers/User';
window.User = User;

//ROUTE IMPORTED
import {routes} from './routes.js';
const router = new VueRouter({
    routes,
    mode: "history"
});


const app = new Vue({
    el: '#app',
    router,
});
