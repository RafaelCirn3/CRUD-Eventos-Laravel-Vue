<template>
  <!--mudando o nome do site-->
  
  <div id="app" class="flex flex-col items-center justify-center min-h-screen bg-gray-100 relative overflow-hidden">
    <div class="max-w-md w-full px-4">
      <router-view></router-view> <!-- Renderiza as rotas aqui -->
    </div>

    <!-- Botão de logoff no canto superior direito -->
    <button 
      v-if="shouldShowLogoutButton" 
      @click="logout" 
      class="absolute bottom-4 right-4 px-4 py-2 bg-red-600 text-white rounded hover:bg-red-500">
      Logoff
    </button>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'App',
  created() {
    // Define o título da aba do navegador
    document.title = "CRUD Eventos";
  },
  computed: {
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
}
</script>

<style scoped>
/* Ajuste do estilo de overflow para prevenir scroll */
html, body, #app {
  height: 100%;
  margin: 0;
  padding: 0;
  overflow: hidden;
}
</style>
