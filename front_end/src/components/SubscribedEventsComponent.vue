<template>
    <div class="subscribed-events-container px-4 py-8">
        <h1 class="text-3xl font-bold mb-6 text-center">Eventos Inscritos</h1>

        <!-- Componente de Filtro -->
        <EventFilter :currentFilters="filters" @update-filters="updateFilters" />

        <!-- Lista de Eventos Inscritos -->
        <div v-if="filteredEvents.length === 0" class="text-center text-gray-500">
            <p>Nenhum evento encontrado.</p>
        </div>
        <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div v-for="event in filteredEvents" :key="event.id"
                class="event-card bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                <h2 class="text-xl font-semibold mb-2">{{ event.name }}</h2>
                <p class="text-gray-600 mb-4">{{ event.description }}</p>
                <p class="text-gray-500">Data: {{ formatDate(event.date) }}</p>
                <!-- Botão Ver Mais -->
                <button @click="viewMore(event.id)"
                    class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300 transition-all duration-200 mb-2">
                    Ver Mais
                </button>

                <!-- Botão Cancelar-->
                <button @click="unsubscribe(event.id)"
                    class="bg-red-500 text-white py-2 px-4 rounded-lg hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-300 transition-all duration-200">
                    Cancelar
                </button>
            </div>
        </div>
    </div>
</template>

<script>
// Importa o SweetAlert2
import Swal from 'sweetalert2';
import axios from 'axios';
import EventFilter from './EventFilter.vue';

export default {
    components: {
        EventFilter
    },
    data() {
        return {
            events: [],
            filters: {
                name: '',
                date: '',
                status: ''
            },
        };
    },
    computed: {
        filteredEvents() {
            return this.events.filter(event => {
                const matchesName = event.name.toLowerCase().includes(this.filters.name.toLowerCase());
                const matchesDate = this.filters.date ? event.date === this.filters.date : true;
                const matchesStatus = this.filters.status ? event.status === this.filters.status : true;
                return matchesName && matchesDate && matchesStatus;
            });
        }
    },
    mounted() {
        this.fetchEvents();
    },
    methods: {
        async fetchEvents() {
            try {
                const response = await axios.get('http://localhost:8000/api/subscribed-event', {
                    headers: { Authorization: `Bearer ${localStorage.getItem('token')}` }
                });
                this.events = response.data;
            } catch (error) {
                console.error('Erro ao buscar eventos inscritos', error);
            }
        },
        async unsubscribe(eventId) {
            // Exibe o SweetAlert para confirmar a desinscrição
            const result = await Swal.fire({
                title: 'Tem certeza?',
                text: 'Você deseja se desinscrever deste evento?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, desinscrever!'
            });

            if (result.isConfirmed) {
                try {
                    await axios.post(`http://localhost:8000/api/event/${eventId}/unsubscribe`, {}, {
                        headers: { Authorization: `Bearer ${localStorage.getItem('token')}` }
                    });
                    // Exibe um alerta de sucesso após desinscrição
                    Swal.fire(
                        'Desinscrito!',
                        'Você foi desinscrito com sucesso do evento.',
                        'success'
                    );
                    this.fetchEvents(); // Atualiza a lista de eventos inscritos
                } catch (error) {
                    console.error('Erro ao desinscrever-se do evento', error);
                    // Exibe um alerta de erro caso algo dê errado
                    Swal.fire(
                        'Erro!',
                        'Não foi possível desinscrever-se deste evento.',
                        'error'
                    );
                }
            }
        },
        // Redireciona para a página de detalhes do evento
        viewMore(eventId) {
            this.$router.push(`/event/${eventId}`);
        },
        updateFilters(newFilters) {
            this.filters = newFilters; // Atualiza os filtros
        },
        formatDate(date) {
            const options = { year: 'numeric', month: 'long', day: 'numeric' };
            return new Date(date).toLocaleDateString('pt-BR', options);
        }
    }
};
</script>

<style scoped>
.event-card {
    transition: transform 0.3s ease;
}

.event-card:hover {
    transform: scale(1.05);
}

button {
    transition: background-color 0.3s ease;
}

button:hover {
    background-color: #4b79ff;
}
</style>
