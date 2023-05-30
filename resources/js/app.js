 require('./bootstrap');
 window.Vue = require('vue');
 import App from './App.vue';
 import VueAxios from 'vue-axios';
 import { createRouter, createWebHistory } from 'vue-router';
 
 import axios from 'axios';
 import { routes } from './routes';
 
 Vue.use(VueRouter);
 Vue.use(VueAxios, axios);

 const router = createRouter({
    history: createWebHistory(),
    routes: routes
});
  
 const app = new Vue({
     el: '#app',
     router: router,
     render: h => h(App),
 });