import Vue from 'vue';
import Router from 'vue-router';
import LoginComponent from './components/LoginComponent.vue';
import RegisterComponent from './components/RegisterComponent.vue';
import EventFormComponent from './components/EventFormComponent.vue';
import MyEventsComponent from './components/MyEventsComponent.vue';  // Rota para eventos criados pelo usuário
import SubscribedEventsComponent from './components/SubscribedEventsComponent.vue';  // Rota para eventos aos quais o usuário está inscrito
import AvailableEventsComponent from './components/AvailableEventsComponent.vue'; // Rota para eventos disponíveis para inscrição

Vue.use(Router); // função de gerenciamento de Rotas

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
            path: '/events/create',
            name: 'CreateEvent',
            component: EventFormComponent,
        },
        {
            path: '/event/:id/edit',
            name: 'EditEvent',
            component: EventFormComponent,
        },
        {
            path: '/my-events',
            name: 'MyEvents',
            component: MyEventsComponent, 
        },
        {
            path: '/events/subscribed',
            name: 'SubscribedEvents',
            component: SubscribedEventsComponent,  
        },
        {
            path: '/events/available',
            name: 'AvailableEvents',
            component: AvailableEventsComponent, 
        }
    ]
});
