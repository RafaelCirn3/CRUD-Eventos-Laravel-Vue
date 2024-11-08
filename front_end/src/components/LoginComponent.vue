<template>
    <div class="flex justify-center items-center min-h-screen bg-gray-100">
        <div class="max-w-md w-full bg-white p-8 rounded-lg shadow-md">
            <h2 class="text-2xl font-semibold mb-6 text-center">Entrar</h2>

            <form @submit.prevent="login" class="space-y-4">
                <!-- Campo de E-mail -->
                <div>
                    <label for="email" class="block text-sm font-bold text-gray-700">Email:</label>
                    <input type="email" v-model="email" required
                        class="mt-2 px-4 py-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-700"
                        placeholder="Digite seu e-mail" />
                </div>

                <!-- Campo de Senha -->
                <div>
                    <label for="password" class="block text-sm font-bold text-gray-700">Senha:</label>
                    <input type="password" v-model="password" required
                        class="mt-2 px-4 py-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-700"
                        placeholder="Digite sua senha" />
                </div>

                <!-- Botão de Login -->
                <div>
                    <button type="submit"
                        class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Entrar
                    </button>
                </div>
            </form>

            <!-- Exibindo Mensagens de Erro ou Sucesso -->
            <div v-if="errorMessage" class="text-red-500 mt-4 text-center">
                {{ errorMessage }}
            </div>
            <div v-if="successMessage" class="text-green-500 mt-4 text-center">
                {{ successMessage }}
            </div>

            <!-- Link para Página de Registro -->
            <p class="mt-4 text-center text-sm text-gray-600">
                Ainda não tem uma conta?
                <router-link to="/register" class="text-blue-600 hover:text-blue-700 font-bold">Crie uma
                    aqui</router-link>
            </p>
        </div>
    </div>
</template>

<script>
// Importando SweetAlert2
import Swal from 'sweetalert2';
import axios from 'axios';

export default {
    data() {
        return {
            email: '',
            password: '',
            errorMessage: '',
            successMessage: ''
        };
    },
    methods: {
        async login() {
            try {
                const response = await axios.post('http://localhost:8000/api/login', {
                    email: this.email,
                    password: this.password
                });

                if (response.data.token) {
                    localStorage.setItem('token', response.data.token);

                    // Configura o token no axios para as requisições subsequentes
                    axios.defaults.headers.common['Authorization'] = 'Bearer ' + response.data.token;

                    // Exibe um SweetAlert de sucesso
                    Swal.fire({
                        title: 'Login realizado!',
                        text: 'Você está logado com sucesso.',
                        icon: 'success',
                        confirmButtonText: 'Ok'
                    }).then(() => {
                       this.$router.push('/events/available'); // Redireciona para a página de eventos
                    });
                }
            } catch (error) {
                // Exibe um SweetAlert de erro
                Swal.fire({
                    title: 'Erro ao tentar fazer login!',
                    text: 'Verifique suas credenciais e tente novamente.',
                    icon: 'error',
                    confirmButtonText: 'Ok'
                });
            }
        }
    }
}
</script>

<style scoped>
/* O estilo do formulário foi movido para Tailwind CSS */
</style>
