<template>
    <div class="event-list">
        <h1>Lista de Eventos</h1>
        <p v-if="loading">Carregando eventos...</p>
        <p v-else-if="events.length === 0">Nenhum evento encontrado.</p>
        <ul v-else>
            <li v-for="event in events" :key="event.id">
                <router-link :to="`/events/${event.id}`">{{ event.name }}</router-link>
            </li>
        </ul>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            events: [],
            loading: true, // Estado para carregar eventos
        };
    },
    created() {
        this.fetchEvents();
    },
    methods: {
        async fetchEvents() {
            try {
                const response = await axios.get('http://localhost:8000/api/events'); // URL da sua API
                console.log('Eventos recebidos:', response.data); // Adicione este log
                this.events = response.data; // Armazena os eventos recebidos
            } catch (error) {
                console.error('Erro ao buscar eventos:', error);
                this.events = []; // Garante que a lista fique vazia em caso de erro
            } finally {
                this.loading = false; // Define como carregado após a tentativa de buscar eventos
            }
        }
    }
};
</script>

<style scoped>
.event-list {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
}

h1 {
    font-size: 2em;
    margin-bottom: 10px;
}

ul {
    list-style: none;
    padding: 0;
}

li {
    margin-bottom: 10px;
}
</style>
