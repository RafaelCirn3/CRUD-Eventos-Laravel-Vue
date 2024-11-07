<template>
    <div>
        <h1 class="text-2xl font-bold mb-4">{{ isEdit ? 'Editar Evento' : 'Criar Novo Evento' }}</h1>
        <form @submit.prevent="handleSubmit">
            <!-- Campo de Nome do Evento -->
            <input v-model="event.name" placeholder="Nome do evento" class="border p-2 mb-4 w-full" required />

            <!-- Campo de Descrição -->
            <textarea v-model="event.description" placeholder="Descrição" class="border p-2 mb-4 w-full" required></textarea>

            <!-- Campo de Data -->
            <input v-model="event.date" type="date" class="border p-2 mb-4 w-full" required />

            <!-- Seção de Upload de Arquivos -->
            <div class="mb-6">                
                <!-- Upload de Capa -->
                <div class="mb-4">
                    <label for="cover" class="block text-sm font-medium text-gray-700">Capa do Evento</label>
                    <input type="file" @change="handleFileChange($event, 'cover')" id="cover" class="border p-2 mb-2 w-full" />

                </div>

                <!-- Upload de Banner -->
                <div class="mb-4">
                    <label for="banner" class="block text-sm font-medium text-gray-700">Banner do Evento</label>
                    <input type="file" @change="handleFileChange($event, 'banner')" id="banner" class="border p-2 mb-2 w-full" />

                </div>

                <!-- Upload de Mapa -->
                <div class="mb-4">
                    <label for="map" class="block text-sm font-medium text-gray-700">Mapa do Evento</label>
                    <input type="file" @change="handleFileChange($event, 'map')" id="map" class="border p-2 mb-2 w-full" />

                </div>
            </div>

            <!-- Botão de Submissão -->
            <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded w-full hover:bg-blue-600">
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
            isEdit: false,
        };
    },
    mounted() {
        this.checkIfEdit();
    },
    methods: {
        checkIfEdit() {
            const eventId = this.$route.params.id;
            if (eventId) {
                this.isEdit = true;
                this.fetchEvent(eventId);
            }
        },

        async fetchEvent(eventId) {
            try {
                const response = await axios.get(`/event/${eventId}`);
                this.event = response.data;
            } catch (error) {
                console.error('Erro ao buscar evento', error);
            }
        },

        async handleSubmit() {
            if (!this.event.name || !this.event.date) {
                alert('Nome e data são obrigatórios!');
                return;
            }

            const formData = new FormData();
            formData.append('name', this.event.name);
            formData.append('description', this.event.description);
            formData.append('date', this.event.date);

            if (this.event.cover) formData.append('cover', this.event.cover);
            if (this.event.banner) formData.append('banner', this.event.banner);
            if (this.event.map) formData.append('map', this.event.map);

            if (this.isEdit) {
                await this.updateEvent(formData);
            } else {
                await this.createEvent(formData);
            }
        },

        async createEvent(formData) {
            try {
                await axios.post('/event', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    }
                });
                alert('Evento criado com sucesso!');
                this.$router.push('/my-events');
            } catch (error) {
                console.error('Erro ao criar evento', error.response.data);
                alert('Erro ao criar evento: ' + error.response.data.message);
            }
        },

        async updateEvent(formData) {
            const eventId = this.$route.params.id;
            try {
                await axios.put(`/event/${eventId}`, formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    }
                });
                alert('Evento atualizado com sucesso!');
                this.$router.push('/my-events');
            } catch (error) {
                console.error('Erro ao atualizar evento', error);
                alert('Erro ao atualizar evento.');
            }
        },

        handleFileChange(event, fileType) {
            const file = event.target.files[0];
            if (fileType === 'cover') {
                this.event.cover = file;
            } else if (fileType === 'banner') {
                this.event.banner = file;
            } else if (fileType === 'map') {
                this.event.map = file;
            }
        },
    },
};
</script>

<style scoped>
/* O estilo do formulário foi movido para Tailwind CSS */
</style>
