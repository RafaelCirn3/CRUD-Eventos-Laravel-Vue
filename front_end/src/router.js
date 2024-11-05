import Vue from 'vue';
import Router from 'vue-router';
import LoginComponent from './components/LoginComponent.vue';
import RegisterComponent from './components/RegisterComponent.vue';
import EventListComponent from './components/EventListComponent.vue';
import EventFormComponent from './components/EventFormComponent.vue';
import EventDetailComponent from './components/EventDetailComponent.vue';

Vue.use(Router);

export default new Router({
    mode: 'history', // Habilita o modo history para URLs limpas
    routes: [
        {
            path: '/',
            redirect: '/login', // Redireciona a raiz para a página de login
        },
        {
            path: '/login',
            name: 'Login',
            component: LoginComponent,
        },
        {
            path: '/register',
            name: 'Register',
            component: RegisterComponent,
        },
        {
            path: '/events',
            name: 'Events',
            component: EventListComponent,
        },
        {
            path: '/events/create',
            name: 'CreateEvent',
            component: EventFormComponent,
        },
        {
            path: '/events/:id/edit',
            name: 'EditEvent',
            component: EventFormComponent,
        },
        {
            path: '/events/:id',
            name: 'EventDetail',  // Rota para exibir detalhes do evento
            component: EventDetailComponent,
            props: true  // Permite passar o id como prop para o componente
        }
    ]
});
