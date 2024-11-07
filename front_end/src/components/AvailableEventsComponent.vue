<template>
    <div class="p-4 max-w-4xl mx-auto">
        <h2 class="text-3xl font-semibold mb-6 text-center">Eventos Disponíveis</h2>
        
        <!-- Caso não haja eventos disponíveis -->
        <div v-if="events.length === 0" class="text-center">
            <p class="text-lg text-gray-600">Não há eventos disponíveis para inscrição.</p>
        </div>
        
        <!-- Lista de eventos disponíveis -->
        <div v-else>
            <ul class="space-y-4">
                <li v-for="event in events" :key="event.id" class="bg-white p-4 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                    <h3 class="text-xl font-bold text-gray-800">{{ event.name }}</h3>
                    <p class="text-gray-600 mt-2">{{ event.description }}</p>
                    <p class="text-gray-500 mt-2">{{ new Date(event.date).toLocaleDateString() }}</p>
                    
                    <button 
                        @click="subscribe(event.id)" 
                        class="mt-4 bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300 transition-all duration-200"
                    >
                        Inscrever-se
                    </button>
                    
                    <!-- Botão "Ver Mais" -->
                    <router-link :to="'/event/' + event.id" class="mt-2 text-blue-500 hover:underline">
                        Ver Mais
                    </router-link>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            events: [],
        };
    },
    mounted() {
        this.fetchAvailableEvents();
    },
    methods: {
        async fetchAvailableEvents() {
            try {
                const response = await this.$axios.get('/available-event');
                this.events = response.data;
            } catch (error) {
                console.error('Erro ao buscar eventos disponíveis', error);
            }
        },
        async subscribe(eventId) {
            try {
                await this.$axios.post(`/event/${eventId}/subscribe`);
                alert('Inscrição realizada com sucesso!');
                this.fetchAvailableEvents(); // Atualiza a lista de eventos disponíveis
            } catch (error) {
                console.error('Erro ao inscrever-se no evento', error);
                alert('Não foi possível se inscrever neste evento.');
            }
        }
    },
};
</script>

<style scoped>
/* Estilos adicionais, se necessário */
</style>
