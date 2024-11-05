<template>
    <div class="event-form">
        <h1 class="text-2xl font-bold mb-4">{{ isEditing ? 'Editar Evento' : 'Criar Evento' }}</h1>
        <form @submit.prevent="handleSubmit">
            <input v-model="event.name" placeholder="Nome do evento" class="border p-2 mb-2 w-full" required>
            <textarea v-model="event.description" placeholder="Descrição" class="border p-2 mb-2 w-full"
                required></textarea>
            <input v-model="event.date" type="date" class="border p-2 mb-2 w-full" required>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
                {{ isEditing ? 'Salvar' : 'Criar' }}
            </button>
        </form>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    props: {
        eventId: {
            type: Number,
            default: null
        }
    },
    data() {
        return {
            event: {
                name: '',
                description: '',
                date: ''
            }
        };
    },
    computed: {
        isEditing() {
            return !!this.eventId;
        }
    },
    created() {
        if (this.isEditing) {
            this.fetchEvent();
        }
    },
    methods: {
        async fetchEvent() {
            try {
                const response = await axios.get(`http://localhost:8000/api/events/${this.eventId}`);
                this.event = response.data;
            } catch (error) {
                console.error("Erro ao buscar evento:", error);
            }
        },
        async handleSubmit() {
            try {
                if (this.isEditing) {
                    await axios.put(`http://localhost:8000/api/events/${this.eventId}`, this.event);
                    alert('Evento atualizado com sucesso!');
                } else {
                    await axios.post('http://localhost:8000/api/events', this.event);
                    alert('Evento criado com sucesso!');
                }
            } catch (error) {
                console.error("Erro ao salvar evento:", error);
            }
        }
    }
};
</script>

<style scoped>
.event-form {
    padding: 1rem;
}
</style>