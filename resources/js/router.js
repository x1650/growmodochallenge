import { createWebHistory, createRouter } from "vue-router";
import login from './components/Login.vue';
import register from './components/register.vue';
import dashboard from './components/Portal/Dashboard.vue'
import records from './components/Portal/Records.vue'

import store from '../store/index.js';


const ifNotAuthenticated = () => {
    if(!store.state.token){
      router.push('/');
    }
  }
  const ifAuthenticated = () => {
    if(store.state.token){
      router.push('/portal/Dashboard');
    }
  }

  const ifNotAdmin = () => {
    if(store.state.userlevel == 2){
      router.push('/portal/Dashboard');
    }
  }


const routes = [
    {
        path : '/',
        name : 'Login',
        component : login,
        beforeEnter: ifAuthenticated,
    },
    {
        path : '/register',
        name : 'Register',
        component : register,
        beforeEnter: ifAuthenticated,
    },
    {
      path : '/portal/dashboard',
      name : 'Dashboard',
      component : dashboard,
      beforeEnter: ifNotAuthenticated,
    },
    {
      path : '/portal/records',
      name : 'Records',
      component : records,
      beforeEnter: [ifNotAuthenticated, ifNotAdmin],
    },
    
    
];

const router = createRouter({
    history: createWebHistory(),
    routes,
    linkActiveClass: "active",
});

export default router;