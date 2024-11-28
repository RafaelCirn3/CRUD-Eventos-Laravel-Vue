<template>
    <header>
        <nav class="bg-blue-600 text-white p-4 shadow-md">
            <div class="flex justify-between items-center">
                <h1 class="text-xl font-bold">CRUD Eventos</h1>
                <ul class="flex space-x-6 items-center">
                    <!-- Botão de dropdown para "Eventos" -->
                    <li class="relative">
                        <button @click="toggleDropdown" class="flex items-center space-x-2 hover:underline">
                            <span>Eventos</span>
                            <svg class="w-4 h-4 transform" :class="{ 'rotate-180': isDropdownOpen }" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <!-- Links do dropdown -->
                        <ul v-if="isDropdownOpen" class="absolute bg-blue-500 text-white p-2 mt-2 rounded shadow-md space-y-2 w-40 md:w-48 right-0">
                            <li>
                                <router-link to="/events/available" class="hover:underline block">Eventos Disponíveis</router-link>
                            </li>
                            <li>
                                <router-link to="/events/subscribed" class="hover:underline block">Eventos Inscritos</router-link>
                            </li>
                            <li>
                                <router-link to="/events/create" class="hover:underline block">Criar Evento</router-link>
                            </li>
                        </ul>
                    </li>

                    <!-- Link de "Meus Eventos" -->
                    <li>
                        <router-link to="/my-events" class="hover:underline">Meus Eventos</router-link>
                    </li>

                    <!-- Botão de Logoff, posicionado à direita -->
                    <li v-if="isAuthenticated" class="ml-auto">
                        <button 
                            @click="logout" 
                            class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-red-300 transition-all duration-200">
                            Sair
                        </button>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
</template>

<script>
export default {
    data() {
        return {
            isDropdownOpen: false, // Controla a visibilidade do dropdown
        };
    },
    computed: {
        isAuthenticated() {
            return !!localStorage.getItem('token'); // Verifica se há um token no localStorage
        },
    },
    methods: {
        toggleDropdown() {
            this.isDropdownOpen = !this.isDropdownOpen; // Alterna a visibilidade do dropdown
        },
        logout() {
            localStorage.removeItem('token');
            this.$router.push('/login');
        },
    },
};
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap');

nav {
    box-shadow: 0 4px 2px -2px gray;
    font-family: 'Inter', sans-serif;
}

h1 {
    font-family: 'Inter', sans-serif;
    font-weight: 600;
}

ul {
    font-family: 'Inter', sans-serif;
}

button {
    background-color: transparent;
    border: none;
    font-size: 1rem;
    cursor: pointer;
}

button:hover {
    text-decoration: underline;
}

/* Estilo adicional para o menu suspenso */
ul.absolute {
    display: block;
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    z-index: 10;
}

/* Responsividade: ajusta o tamanho do menu e a posição */
@media (max-width: 768px) {
    .absolute {
        width: auto; /* O menu vai se ajustar ao conteúdo */
        right: unset; /* Remove o alinhamento à direita em telas menores */
        left: 0; /* Alinha à esquerda */
    }
}

</style>
