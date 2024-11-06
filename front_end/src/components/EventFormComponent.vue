<template>
    <div>
        <h1 class="text-2xl font-bold mb-4">{{ isEdit ? 'Editar Evento' : 'Criar Novo Evento' }}</h1>
        <form @submit.prevent="handleSubmit">
            <input v-model="event.name" placeholder="Nome do evento" class="border p-2 mb-2 w-full" required>
            <textarea v-model="event.description" placeholder="Descrição" class="border p-2 mb-2 w-full"
                required></textarea>
            <input v-model="event.date" type="date" class="border p-2 mb-2 w-full" required>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
                {{ isEdit ? 'Atualizar Evento' : 'Criar Evento' }}
            </button>
        </form>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            event: {
                name: '',
                description: '',
                date: ''
            },
            isEdit: false // Controla se é edição ou criação
        };
    },
    mounted() {
        this.checkIfEdit();
    },
    methods: {
        // Verifica se o componente está sendo usado para editar ou criar
        checkIfEdit() {
            const eventId = this.$route.params.id;
            if (eventId) {
                this.isEdit = true; // Caso haja um ID, estamos editando
                this.fetchEvent(eventId); // Busca os dados do evento para edição
            }
        },

        // Faz uma requisição para buscar os dados do evento
        async fetchEvent(eventId) {
            try {
                const response = await axios.get(`/event/${eventId}`);
                this.event = response.data;
            } catch (error) {
                console.error('Erro ao buscar evento', error);
            }
        },

        // Handle de envio do formulário
        async handleSubmit() {
            if (this.isEdit) {
                // Atualiza o evento existente
                await this.updateEvent();
            } else {
                // Cria um novo evento
                await this.createEvent();
            }
        },

        // Criação de um novo evento
        async createEvent() {
            try {
                await axios.post('/event', this.event);
                alert('Evento criado com sucesso!');
                this.$router.push('/events/created'); // Redireciona para a lista de eventos
            } catch (error) {
                console.error('Erro ao criar evento', error);
            }
        },

        // Atualização de um evento existente
        async updateEvent() {
            const eventId = this.$route.params.id;
            try {
                await axios.put(`/event/${eventId}`, this.event);
                alert('Evento atualizado com sucesso!');
                this.$router.push('/events/created'); // Redireciona para a lista de eventos
            } catch (error) {
                console.error('Erro ao atualizar evento', error);
            }
        }
    }
};
</script>