<template>
    <div>
        <h1 class="text-2xl font-bold mb-4">{{ isEdit ? 'Editar Evento' : 'Criar Novo Evento' }}</h1>
        
        <!-- Formulário de Evento -->
        <form @submit.prevent="handleSubmit">
            <input v-model="event.name" placeholder="Nome do evento" class="border p-2 mb-4 w-full" required />
            <textarea v-model="event.description" placeholder="Descrição" class="border p-2 mb-4 w-full" required></textarea>
            <input v-model="event.date" type="date" class="border p-2 mb-4 w-full" required />

            <div class="mb-6">
                <div class="mb-4">
                    <label for="cover" class="block text-sm font-medium text-gray-700">Capa do Evento</label>
                    <input type="file" @change="handleFileChange($event, 'cover')" id="cover" class="border p-2 mb-2 w-full" />
                </div>

                <div class="mb-4">
                    <label for="banner" class="block text-sm font-medium text-gray-700">Banner do Evento</label>
                    <input type="file" @change="handleFileChange($event, 'banner')" id="banner" class="border p-2 mb-2 w-full" />
                </div>

                <div class="mb-4">
                    <label for="map" class="block text-sm font-medium text-gray-700">Mapa do Evento</label>
                    <input type="file" @change="handleFileChange($event, 'map')" id="map" class="border p-2 mb-2 w-full" />
                </div>
            </div>

            <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded w-full hover:bg-blue-600">
                {{ isEdit ? 'Atualizar Evento' : 'Criar Evento' }}
            </button>
        </form>
    </div>
</template>

<script>
import axios from 'axios';
import Swal from 'sweetalert2'; // Importando SweetAlert2

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
                this.showError('Nome e data são obrigatórios!');
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
                this.showSuccess('Evento criado com sucesso!');
                await this.$router.push('/my-events');
            } catch (error) {
                console.error('Erro ao criar evento', error.response.data);
                this.showError('Erro ao criar evento: ' + error.response.data.message);
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
                this.showSuccess('Evento atualizado com sucesso!');
                this.$router.push('/my-events');
            } catch (error) {
                console.error('Erro ao atualizar evento', error);
                this.showError('Erro ao atualizar evento.');
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

        // Função para exibir mensagem de sucesso
        showSuccess(message) {
            Swal.fire({
                icon: 'success',
                title: 'Sucesso!',
                text: message,
                showConfirmButton: false,
                timer: 1500
            });
        },

        // Função para exibir mensagem de erro
        showError(message) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: message,
            });
        }
    },
};
</script>

<style scoped>
/* O estilo do formulário foi movido para Tailwind CSS */
</style>
