<template>
    <div class="p-4 max-w-4xl mx-auto">
        <h2 class="text-3xl font-semibold mb-6 text-center">Eventos Inscritos</h2>
        
        <!-- Caso o usuário não esteja inscrito em nenhum evento -->
        <div v-if="events.length === 0" class="text-center">
            <p class="text-lg text-gray-600">Você não está inscrito em nenhum evento.</p>
        </div>
        
        <!-- Lista de eventos em que o usuário está inscrito -->
        <div v-else>
            <ul class="space-y-4">
                <li v-for="event in events" :key="event.id" class="bg-white p-4 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                    <h3 class="text-xl font-bold text-gray-800">{{ event.name }}</h3>
                    <p class="text-gray-600 mt-2">{{ event.description }}</p>
                    <p class="text-gray-500 mt-2">{{ new Date(event.date).toLocaleDateString() }}</p>

                    <!-- Botão para cancelar inscrição -->
                    <button 
                        @click="unsubscribe(event.id)" 
                        class="mt-4 bg-red-500 text-white py-2 px-4 rounded-lg hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-300 transition-all duration-200"
                    >
                        Cancelar Inscrição
                    </button>

                    <!-- Botão de "Ver Mais" dentro do card, que redireciona para a página de detalhes do evento -->
                    <button 
                        @click="viewMore(event.id)" 
                        class="mt-4 ml-4 bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300 transition-all duration-200"
                    >
                        Ver Mais
                    </button>
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
        this.fetchSubscribedEvents();
    },
    methods: {
        // Busca os eventos inscritos do usuário
        async fetchSubscribedEvents() {
            try {
                const { data } = await this.$axios.get('/subscribed-event');
                this.events = data;
            } catch (error) {
                console.error('Erro ao buscar eventos inscritos', error);
            }
        },

        // Cancelar a inscrição no evento
        async unsubscribe(eventId) {
            try {
                await this.$axios.post(`event/${eventId}/unsubscribe`);
                alert('Inscrição cancelada com sucesso!');
                this.fetchSubscribedEvents(); // Atualiza a lista de eventos inscritos
            } catch (error) {
                console.error('Erro ao cancelar inscrição', error);
                alert('Não foi possível cancelar a inscrição neste evento.');
            }
        },

        // Redireciona para a página de detalhes do evento
        viewMore(eventId) {
            this.$router.push(`/event/${eventId}`);
        }
    },
};
</script>

<style scoped>
/* Adicione mais estilos se necessário, mas a estilização principal já está no Tailwind CSS */
</style>
