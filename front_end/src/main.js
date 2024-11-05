import Vue from 'vue';
import App from './App.vue';
import axios from 'axios';
import router from './router'; // Ajuste para './router/router' se o arquivo estiver em uma pasta 'router'
import './assets/css/tailwind.css';

// URL base do backend
axios.defaults.baseURL = 'http://localhost:8000/api';
axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('token');

new Vue({
    router,
    render: h => h(App),
}).$mount('#app');
