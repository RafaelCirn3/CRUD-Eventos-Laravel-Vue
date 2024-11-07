<template>
    <div class="my-events-container px-4 py-8">
        <h1 class="text-3xl font-bold mb-6 text-center">Meus Eventos Criados</h1>
        <div v-if="events.length === 0" class="text-center text-gray-500">
            <p>Você ainda não criou nenhum evento.</p>
        </div>
        <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div v-for="event in events" :key="event.id" class="event-card bg-white p-6 rounded-lg shadow-md mx-auto">
                <h2 class="text-xl font-semibold mb-2">{{ event.name }}</h2>
                <p class="text-gray-600 mb-4">{{ event.description }}</p>
                <p class="text-gray-500">Data: {{ formatDate(event.date) }}</p>

                <div class="mt-4 flex justify-between gap-2">
                    <button @click="editEvent(event.id)"
                        class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">
                        Editar
                    </button>
                    <button @click="deleteEvent(event.id)"
                        class="bg-red-500 text-white py-2 px-4 rounded-md hover:bg-red-600">
                        Deletar
                    </button>
                    <button @click="viewMore(event.id)"
                        class="mt-4 ml-4 bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300 transition-all duration-200">
                        Ver Mais
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            events: [],
        };
    },
    mounted() {
        this.fetchMyEvents();
    },
    methods: {
        async fetchMyEvents() {
            try {
                const response = await axios.get('/my-events'); // Rota para eventos criados pelo usuário
                this.events = response.data;
            } catch (error) {
                console.error('Erro ao buscar meus eventos', error);
            }
        },
        async deleteEvent(eventId) {
            if (confirm("Tem certeza que deseja deletar este evento?")) {
                try {
                    await axios.delete(`/event/${eventId}`);
                    alert('Evento deletado com sucesso!');
                    this.fetchMyEvents(); // Atualiza a lista de eventos
                } catch (error) {
                    console.error('Erro ao deletar evento', error);
                }
            }
        },
        editEvent(eventId) {
            // Redireciona para a página de edição, passando o id do evento
            this.$router.push({ name: 'EditEvent', params: { id: eventId } });
        },
        formatDate(date) {
            const options = { year: 'numeric', month: 'long', day: 'numeric' };
            return new Date(date).toLocaleDateString('pt-BR', options);
        },

        // Redireciona para a página de detalhes do evento
        viewMore(eventId) {
            this.$router.push(`/event/${eventId}`);
        }
    }
};
</script>

<style scoped>
.my-events-container {
    max-width: 1200px;
    margin: 0 auto;
}

.event-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.event-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

/* Ajustando o layout para centralizar */
.grid {
    display: grid;
    justify-items: center;
    /* Centraliza os itens dentro da grid */
}

/* Adicionando um pouco de espaçamento para telas menores */
@media (max-width: 768px) {
    .my-events-container {
        padding: 16px;
    }
}
</style>
