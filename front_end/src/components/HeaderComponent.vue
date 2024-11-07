<template>
    <header>
        <nav class="bg-blue-600 text-white p-4 shadow-md">
            <div class="flex justify-between items-center">
                <h1 class="text-xl font-bold">CRUD Eventos</h1>
                <ul class="flex space-x-6">
                    <li>
                        <router-link to="/my-events" class="hover:underline">Meus Eventos</router-link>
                    </li>
                    <li>
                        <router-link to="/events/available" class="hover:underline">Eventos Disponíveis</router-link>
                    </li>
                    <li>
                        <router-link to="/events/subscribed" class="hover:underline">Eventos Inscritos</router-link>
                    </li>
                    <li>
                        <router-link to="/events/create" class="hover:underline">Criar Evento</router-link>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
</template>

<script>
export default {
    computed: {
        isAuthenticated() {
            return !!localStorage.getItem('token'); // Verifica se o token está presente no localStorage
        },
    },
    methods: {
        logout() {
            // Lógica de logout, removendo o token do localStorage e redirecionando
            localStorage.removeItem('token');
            this.$router.push('/login');
        },
    },
};
</script>

<style scoped>
/* Importação da fonte do Google Fonts */
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap');

nav {
    box-shadow: 0 4px 2px -2px gray;
    font-family: 'Inter', sans-serif; /* Aplica a fonte Inter ao nav */
}

h1 {
    font-family: 'Inter', sans-serif; /* Aplica a fonte Inter ao título */
    font-weight: 600; /* Deixa o título em negrito */
}

ul {
    font-family: 'Inter', sans-serif; /* Aplica a fonte Inter aos itens do menu */
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
</style>
