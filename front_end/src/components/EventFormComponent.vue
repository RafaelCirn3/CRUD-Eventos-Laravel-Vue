<template>
    <div>
        <h1 class="text-2xl font-bold mb-4">{{ isEdit ? 'Editar Evento' : 'Criar Novo Evento' }}</h1>
        <form @submit.prevent="handleSubmit">
            <input v-model="event.name" placeholder="Nome do evento" class="border p-2 mb-2 w-full" required>
            <textarea v-model="event.description" placeholder="Descrição" class="border p-2 mb-2 w-full"
                required></textarea>
            <input v-model="event.date" type="date" class="border p-2 mb-2 w-full" required>

            <!-- Campos de upload de arquivos -->
            <input type="file" @change="handleFileChange($event, 'cover')" class="border p-2 mb-2 w-full">
            <input type="file" @change="handleFileChange($event, 'banner')" class="border p-2 mb-2 w-full">
            <input type="file" @change="handleFileChange($event, 'map')" class="border p-2 mb-2 w-full">

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
                date: '',
                cover: null,
                banner: null,
                map: null,
            },
            isEdit: false
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
            // Verifica se os campos obrigatórios estão preenchidos
            if (!this.event.name || !this.event.date) {
                alert('Nome e data são obrigatórios!');
                return;
            }

            // Criação de um novo FormData para enviar os dados com arquivos
            const formData = new FormData();
            formData.append('name', this.event.name);
            formData.append('description', this.event.description);
            formData.append('date', this.event.date);

            // Adiciona os arquivos ao FormData, se houver
            if (this.event.cover) formData.append('cover', this.event.cover);
            if (this.event.banner) formData.append('banner', this.event.banner);
            if (this.event.map) formData.append('map', this.event.map);

            // Verifica se estamos criando ou editando um evento
            if (this.isEdit) {
                await this.updateEvent(formData);
            } else {
                await this.createEvent(formData);
            }
        },

        // Criação de um novo evento
        async createEvent(formData) {
            try {
                await axios.post('/event', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data', // Importante para envio de arquivos
                    }
                });
                alert('Evento criado com sucesso!');
                this.$router.push('/my-events'); // Redireciona para a lista de eventos
            } catch (error) {
                console.error('Erro ao criar evento', error.response.data);
                alert('Erro ao criar evento: ' + error.response.data.message);
            }
        },

        // Atualização de um evento existente
        async updateEvent() {
            const eventId = this.$route.params.id;
            try {
                await axios.put(`/event/${eventId}`, this.event);
                alert('Evento atualizado com sucesso!');
                this.$router.push('/my-events'); // Redireciona para a lista de eventos
            } catch (error) {
                console.error('Erro ao atualizar evento:', error);
                console.log(error.response.data); // Mostra detalhes do erro no console
            }
        },

        // Manipula a mudança de arquivos (como capa, banner, etc.)
        handleFileChange(event, fileType) {
            const file = event.target.files[0];
            if (fileType === 'cover') {
                this.event.cover = file;
            } else if (fileType === 'banner') {
                this.event.banner = file;
            } else if (fileType === 'map') {
                this.event.map = file;
            }
        }
    }
};
</script>
