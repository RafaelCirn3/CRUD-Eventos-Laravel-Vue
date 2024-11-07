<template>
    <div class="max-w-3xl mx-auto p-6 bg-white shadow-md rounded-lg">
        <h1 class="text-3xl font-bold mb-4">{{ event.name }}</h1>
        <p class="text-lg mb-4">{{ event.description }}</p>
        <p class="text-lg mb-4"><strong>Data:</strong> {{ event.date }}</p>
        <p class="text-lg mb-4"><strong>Local:</strong> {{ event.location }}</p>

        <button @click="registerForEvent" v-if="!isRegistered" class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
            Inscrever-se
        </button>
        <p v-else class="text-green-600 mt-4">Você já está inscrito neste evento!</p>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    props: ['id'],  // O id é passado como prop
    data() {
        return {
            event: {},
            isRegistered: false,  // Inicializa o estado de inscrição
        };
    },
    created() {
        this.fetchEventDetails();
    },
    methods: {
        async fetchEventDetails() {
            const eventId = this.$route.params.id;  // Obtém o id do evento a partir da URL
            try {
                const response = await axios.get(`http://localhost:8000/api/events/${eventId}`);
                this.event = response.data;  // Atribui os dados do evento à variável
                this.checkRegistrationStatus(eventId);  // Verifica se o usuário já está inscrito
            } catch (error) {
                console.error('Erro ao obter detalhes do evento:', error);
            }
        },
        async checkRegistrationStatus(eventId) {
            try {
                // Verifica se o usuário já está inscrito no evento
                const response = await axios.get(`http://localhost:8000/api/events/${eventId}/is-registered`, {
                    headers: {
                        'Authorization': `Bearer ${localStorage.getItem('token')}`
                    }
                });
                this.isRegistered = response.data.isRegistered;  // Atualiza o status de inscrição
            } catch (error) {
                console.error('Erro ao verificar inscrição:', error);
            }
        },
        async registerForEvent() {
            const eventId = this.$route.params.id;
            try {
                await axios.post(`http://localhost:8000/api/events/${eventId}/register`, {}, {
                    headers: {
                        'Authorization': `Bearer ${localStorage.getItem('token')}`
                    }
                });
                this.isRegistered = true;  // Marca como inscrito após o sucesso
                alert('Inscrição realizada com sucesso!');
            } catch (error) {
                console.error('Erro ao se inscrever no evento:', error);
                alert('Ocorreu um erro ao se inscrever no evento.');
            }
        }
    }
};
</script>

<style scoped>
/* Personalize o estilo conforme necessário */
</style>
