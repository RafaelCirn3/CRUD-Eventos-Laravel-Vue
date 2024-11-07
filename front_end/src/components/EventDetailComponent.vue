<template>
    <div class="event-detail">
        <h1>{{ event.name }}</h1>
        <p>{{ event.description || 'Sem descrição disponível' }}</p>
        <p><strong>Data:</strong> {{ new Date(event.date).toLocaleDateString() }}</p>
        <p v-if="event.map"><strong>Mapa:</strong> {{ event.map }}</p>
        <p v-if="event.cover"><strong>Capa:</strong> <img :src="event.cover" alt="Capa do evento"
                class="w-full h-auto mb-4" /></p>
        <p v-if="event.banner"><strong>Banner:</strong> <img :src="event.banner" alt="Banner do evento"
                class="w-full h-auto mb-4" /></p>

        <!-- Botão Voltar -->
        <button @click="goBack"
            class="mt-4 bg-gray-500 text-white py-2 px-4 rounded-lg hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300 transition-all duration-200">
            Voltar
        </button>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    props: ['id'],  // O id é passado como prop
    data() {
        return {
            event: {},  // Dados do evento
        };
    },
    created() {
        this.fetchEventDetails();
    },
    methods: {
        async fetchEventDetails() {
            const eventId = this.$route.params.id;  // Obtém o id do evento a partir da URL
            try {
                const response = await axios.get(`http://localhost:8000/api/event/${eventId}`);
                this.event = response.data;  // Atribui os dados do evento à variável
            } catch (error) {
                console.error('Erro ao obter detalhes do evento:', error);
            }
        },
        goBack() {
            this.$router.go(-1);  // Volta para a página anterior
        }
    }
};
</script>

<style scoped>
.event-detail {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
}

h1 {
    font-size: 2em;
    margin-bottom: 10px;
}

p {
    font-size: 1.2em;
    margin-bottom: 10px;
}
</style>
