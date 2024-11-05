<template>
    <div class="event-detail">
        <h1>{{ event.name }}</h1>
        <p>{{ event.description }}</p>
        <p><strong>Data:</strong> {{ event.date }}</p>
        <p><strong>Local:</strong> {{ event.location }}</p>

        <button @click="registerForEvent" v-if="!isRegistered" class="btn-register">
            Inscrever-se
        </button>
        <p v-else>Você já está inscrito neste evento!</p>
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

button.btn-register {
    background-color: #4CAF50;
    color: white;
    padding: 10px 20px;
    border: none;
    cursor: pointer;
}

button.btn-register:hover {
    background-color: #45a049;
}
</style>
