<template>
    <div class="p-4 max-w-4xl mx-auto">
        <h2 class="text-3xl font-semibold mb-6 text-center">Eventos Disponíveis</h2>

        <!-- Componente de Filtro -->
        <EventFilter :currentFilters="filters" @update-filters="updateFilters" />

        <!-- Caso não haja eventos disponíveis -->
        <div v-if="filteredEvents.length === 0" class="text-center">
            <p class="text-lg text-gray-600">Não há eventos disponíveis para inscrição.</p>
        </div>

        <!-- Lista de eventos disponíveis -->
        <div v-else>
            <ul class="space-y-4">
                <li v-for="event in filteredEvents" :key="event.id"
                    class="bg-white p-4 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                    <h3 class="text-xl font-bold text-gray-800">{{ event.name }}</h3>
                    <p class="text-gray-600 mt-2">{{ event.description }}</p>
                    <p class="text-gray-500 mt-2">{{ new Date(event.date).toLocaleDateString('pt-BR') }}</p>

                    <button @click="subscribe(event.id)"
                        class="mt-4 bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300 transition-all duration-200">
                        Inscrever-se
                    </button>

                    <button @click="viewMore(event.id)"
                        class="mt-4 ml-4 bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300 transition-all duration-200">
                        Ver Mais
                    </button>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
// Importa o EventFilter
import EventFilter from './EventFilter.vue';
import axios from 'axios';

export default {
    components: {
        EventFilter
    },
    data() {
        return {
            events: [],
            filters: {
                name: '',
                date: ''
            },
            subscribedEvents: [] // IDs dos eventos aos quais o usuário está inscrito
        };
    },
    computed: {
        // Filtra os eventos disponíveis com base nos filtros e na inscrição
        filteredEvents() {
        return this.events.filter(event => {
            // Filtra os eventos com base nos filtros
            const matchesName = this.filters.name
                ? event.name.toLowerCase().includes(this.filters.name.toLowerCase())
                : true;

            // Converte a data para o formato 'yyyy-mm-dd' para comparação
            const eventDate = new Date(event.date).toISOString().split('T')[0];
            const filterDate = this.filters.date;

            const matchesDate = filterDate ? eventDate === filterDate : true;
            const isNotSubscribed = !this.isSubscribed(event.id);

            return matchesName && matchesDate && isNotSubscribed;
        });
    }
    },
    mounted() {
        this.fetchAvailableEvents();
        this.fetchSubscribedEvents();
    },
    methods: {
        // Busca todos os eventos disponíveis
        async fetchAvailableEvents() {
            try {
                const response = await axios.get('/available-event', {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`
                    }
                });
                this.events = response.data;
            } catch (error) {
                console.error('Erro ao buscar eventos disponíveis', error);
            }
        },

        // Busca os eventos aos quais o usuário está inscrito
        async fetchSubscribedEvents() {
            try {
                const response = await axios.get('/subscribed-event', {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`
                    }
                });
                this.subscribedEvents = response.data.map(event => event.id);
            } catch (error) {
                console.error('Erro ao buscar eventos inscritos', error);
            }
        },

        // Função para inscrever o usuário no evento
        async subscribe(eventId) {
            try {
                await axios.post(`/event/${eventId}/subscribe`, {}, {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`
                    }
                });
                alert('Inscrição realizada com sucesso!');
                this.fetchAvailableEvents();
                this.fetchSubscribedEvents();
            } catch (error) {
                console.error('Erro ao inscrever-se no evento', error);
                alert('Não foi possível se inscrever neste evento.');
            }
        },

        // Verifica se o usuário já está inscrito no evento
        isSubscribed(eventId) {
            return this.subscribedEvents.includes(eventId);
        },

        // Atualiza os filtros conforme mudanças no componente de filtro
        updateFilters(newFilters) {
            this.filters = newFilters;
            this.fetchAvailableEvents();
        },

        // Redireciona para a página de detalhes do evento
        viewMore(eventId) {
            this.$router.push(`/event/${eventId}`);
        }
    }
};
</script>

<style scoped>
/* Estilos adicionais */
</style>
