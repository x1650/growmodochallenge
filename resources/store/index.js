import { createStore } from 'vuex'

export default createStore({
  state: {
    token: localStorage.getItem('token'),
    username: localStorage.getItem('username'),
    email: localStorage.getItem('email'),
    userlevel: localStorage.getItem('userlevel'),
  },
  getters: {
    isAuthenticated: state => localStorage.getItem('token')
  },
  mutations: {
    login (state,userData) {
      state.token = userData.token;
      state.username = userData.username;
      state.email = userData.email;
      state.userlevel = userData.userlevel;
      
      localStorage.setItem('token', userData.token);
      localStorage.setItem('username', userData.username);
      localStorage.setItem('email', userData.email);
      localStorage.setItem('userlevel', userData.userlevel);
      
    },
    logout(state){
      state.token = "";
      state.username = "";
      state.email = "";
      state.userlevel = "";
      window.localStorage.clear();
    },
    initialiseStore(state) {
      const token = localStorage.getItem('token')
      const username = localStorage.getItem('username')
      const email = localStorage.getItem('email')
      const userlevel = localStorage.getItem('userlevel')
      if(token){ state.token = token; }
      if(username){ state.username = username; }
      if(email){ state.email = email; }
      if(userlevel){ state.email = userlevel; }
    }
  },
  actions: {
  },
  modules: {
  }
})