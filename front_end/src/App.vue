<template>
  <div id="app" class="flex flex-col min-h-screen bg-gray-100 overflow-hidden">
    <!-- Header fica no topo -->
    <HeaderComponent v-if="shouldShowHeader" />

    <!-- Conteúdo principal abaixo do cabeçalho -->
    <div class="flex-1 flex justify-center items-center px-4">
      <router-view></router-view> <!-- Renderiza as rotas aqui -->
    </div>

    <!-- Botão de logoff abaixo do conteúdo principal -->
    <div v-if="shouldShowLogoutButton" class="mt-auto mb-4 flex justify-center">
      <button 
        @click="logout" 
        class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-red-300 transition-all duration-200">
        Logoff
      </button>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import HeaderComponent from './components/HeaderComponent.vue';

export default {
  name: 'App',
  components: {
    HeaderComponent
  },
  created() {
    document.title = "CRUD Eventos";
  },
  computed: {
    // Exibe o cabeçalho somente quando a rota não for Login ou Register
    shouldShowHeader() {
      return this.$route.name !== 'Register' && this.$route.name !== 'Login';
    },
    // Já existe para o botão de logoff
    shouldShowLogoutButton() {
      return this.$route.name !== 'Register' && this.$route.name !== 'Login';
    }
  },
  methods: {
    async logout() {
      try {
        await axios.post('http://localhost:8000/api/logout', {}, {
          headers: {
            Authorization: `Bearer ${localStorage.getItem('token')}`
          }
        });
        localStorage.removeItem('token');
        this.$router.push('/login');
      } catch (error) {
        console.error('Erro ao fazer logout:', error);
      }
    }
  }
};
</script>

<style scoped>
/* Ajuste de estilo para que o conteúdo ocupe todo o espaço restante e o cabeçalho fique no topo */
html, body, #app {
  height: 100%;
  margin: 0;
  padding: 0;
  overflow: hidden;
}

#app {
  display: flex;
  flex-direction: column;
  min-height: 100vh;
}

.flex-1 {
  flex: 1;
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 16px;
}

/* Ajusta o botão de logoff para aparecer abaixo do conteúdo, centralizado e pequeno */
.mt-auto {
  margin-top: auto; /* Empurra o botão para baixo */
}

button {
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

button:hover {
  transform: translateY(-3px);
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}
</style>
