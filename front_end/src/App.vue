<template>
  <div id="app" class="flex flex-col items-center justify-center h-screen bg-gray-100 relative">
    <div class="max-w-md w-full">
      <h1 class="text-3xl font-bold mb-4 text-center">Bem-vindo ao CRUD de Eventos</h1>
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
  computed: {
    shouldShowLogoutButton() {
      // Verifica se a rota atual não é a página de registro
      return this.$route.name !== 'Register' && this.$route.name !== 'Login';
    }
  },
  methods: {
    async logout() {
      try {
        // Envia a requisição de logout para a API com o token no cabeçalho
        await axios.post('http://localhost:8000/api/logout', {}, {
          headers: {
            Authorization: `Bearer ${localStorage.getItem('token')}`
          }
        });
        
        // Limpa o token do localStorage
        localStorage.removeItem('token');
        
        // Redireciona para a tela de login após o logout
        this.$router.push('/login');
      } catch (error) {
        console.error('Erro ao fazer logout:', error);
      }
    }
  }
}
</script>

<style>
/* Remover qualquer estilo desnecessário, se houver */
</style>
