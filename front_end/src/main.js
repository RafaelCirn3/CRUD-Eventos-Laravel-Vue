import Vue from 'vue';
import App from './App.vue';
import axios from 'axios';
import router from './router'; 
import './assets/css/tailwind.css';


// URL base do backend
axios.defaults.baseURL = 'http://localhost:8000/api';
axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('token');
Vue.prototype.$axios = axios;   // facilitador do uso do Axios
new Vue({
    router,
    render: h => h(App),
}).$mount('#app');
