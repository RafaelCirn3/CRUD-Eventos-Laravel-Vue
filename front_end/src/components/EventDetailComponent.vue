<template>
    <div class="event-detail p-4 max-w-7xl mx-auto">
        <!-- Card do Evento -->
        <div class="bg-white shadow-lg rounded-lg p-6 mb-6">
            <div class="flex flex-wrap items-center gap-6">
                <!-- Coluna de Detalhes do Evento -->
                <div class="flex-1">
                    <h1 class="text-2xl font-bold mb-4 text-gray-800">{{ event.name }}</h1>
                    <p class="text-lg text-gray-600 mb-4">{{ event.description }}</p>

                    <!-- Data do Evento -->
                    <div v-if="event.date" class="mb-6">
                        <strong class="text-lg">Data:</strong>
                        <p>{{ new Date(event.date).toLocaleDateString() }}</p>
                    </div>

                    <!-- Dono do Evento -->
                    <div v-if="event.event_owner" class="mb-6">
                        <strong class="text-lg">Dono do Evento:</strong>
                        <p>{{ event.event_owner }}</p>
                    </div>
                </div>

                <!-- Coluna de Imagens -->
                <div class="flex gap-6 w-full sm:w-auto">
                    <!-- Mapa -->
                    <div v-if="event.map" class="flex-1">
                        <strong class="text-lg">Mapa:</strong>
                        <img :src="`/storage/${event.map}`" alt="Mapa do evento"
                            class="w-full h-32 object-cover rounded-lg shadow-md" />
                    </div>
                    <div v-else class="flex-1">
                        <strong class="text-lg">Mapa:</strong>
                        <p class="text-gray-500">Não possui imagem</p>
                    </div>

                    <!-- Capa -->
                    <div v-if="event.cover" class="flex-1">
                        <strong class="text-lg">Capa:</strong>
                        <img :src="`/storage/${event.cover}`" alt="Capa do evento"
                            class="w-full h-32 object-cover rounded-lg shadow-md" />
                    </div>
                    <div v-else class="flex-1">
                        <strong class="text-lg">Capa:</strong>
                        <p class="text-gray-500">Não possui imagem</p>
                    </div>

                    <!-- Banner -->
                    <div v-if="event.banner" class="flex-1">
                        <strong class="text-lg">Banner:</strong>
                        <img :src="`/storage/${event.banner}`" alt="Banner do evento"
                            class="w-full h-32 object-cover rounded-lg shadow-md" />
                    </div>
                    <div v-else class="flex-1">
                        <strong class="text-lg">Banner:</strong>
                        <p class="text-gray-500">Não possui imagem</p>
                    </div>
                </div>
            </div>

            <!-- Usuários Inscritos (Somente para o Dono do Evento) -->
            <div v-if="isEventOwner" class="mt-6">
                <h2 class="text-xl font-semibold mb-4 text-gray-800">Usuários Inscritos</h2>
                <div v-if="subscribedUsers.length > 0">
                    <ul class="space-y-2">
                        <li v-for="user in subscribedUsers" :key="user.id" class="bg-gray-100 p-4 rounded-lg shadow-md">
                            <p class="font-semibold text-gray-800">{{ user.name }}</p>
                            <p class="text-sm text-gray-500">{{ user.email }}</p>
                        </li>
                    </ul>
                </div>
                <div v-else>
                    <p class="text-gray-500">Nenhum usuário inscrito até o momento.</p>
                </div>
            </div>

            <!-- Botão Voltar -->
            <div class="mt-6 text-center">
                <button @click="goBack"
                    class="bg-gray-500 text-white py-2 px-6 rounded-lg hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300 transition-all duration-200">
                    Voltar
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            event: null, // Armazena os detalhes do evento
            subscribedUsers: [], // Armazena os usuários inscritos no evento
            isEventOwner: false, // Verifica se o usuário é o dono do evento
            loggedUserEmail: '', // Email do usuário logado
        };
    },
    mounted() {
        this.fetchEventDetails();
        this.getLoggedUserEmail();
    },
    methods: {
        async fetchEventDetails() {
            const eventId = this.$route.params.id; // Assume que o ID do evento está na URL
            try {
                // Fazendo requisição para detalhes do evento
                const response = await axios.get(`http://localhost:8000/api/event/${eventId}`);
                this.event = response.data;

                // Verificando se o evento foi encontrado e possui os dados necessários
                if (!this.event) {
                    console.error("Evento não encontrado.");
                    return;
                }

                // Fazendo requisição para obter os usuários inscritos no evento
                const usersResponse = await axios.get(`http://localhost:8000/api/event/${eventId}/subscribed-users`);
                this.subscribedUsers = usersResponse.data;

                // Verificando se o usuário logado é o dono do evento com base no campo `event_owner`
                if (this.event.event_owner === this.loggedUserEmail) {
                    this.isEventOwner = true; // O usuário é o dono do evento
                }
            } catch (error) {
                console.error('Erro ao buscar detalhes do evento:', error);
            }
        },
        async getLoggedUserEmail() {
            try {
                // Aqui você deve obter o email do usuário logado via autenticação (Exemplo: via token)
                const response = await axios.get('http://localhost:8000/api/user'); // Ajuste conforme sua rota
                this.loggedUserEmail = response.data.email; // Supondo que o API retorne o email do usuário
            } catch (error) {
                console.error('Erro ao buscar o email do usuário logado:', error);
            }
        },
        goBack() {
            this.$router.go(-1); // Volta para a página anterior
        }
    },
};
</script>

<style scoped>
.event-detail {
    padding: 16px;
}

/* Ajustes adicionais de layout */
@media (max-width: 768px) {
    .event-detail .flex {
        flex-direction: column;
    }
    .event-detail .flex-1 {
        width: 100%;
    }
}
</style>
