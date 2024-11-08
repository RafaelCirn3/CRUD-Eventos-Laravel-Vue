<template>
    <div class="flex justify-center items-center min-h-screen bg-gray-100">
        <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-lg">
            <h2 class="text-2xl font-bold text-center mb-6">Cadastre-se Aqui</h2>

            <!-- Formulário de Registro -->
            <form @submit.prevent="register" class="space-y-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nome</label>
                    <input type="text" id="name" v-model="name" required
                        class="mt-2 px-4 py-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Seu nome completo" />
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">E-mail</label>
                    <input type="email" id="email" v-model="email" required
                        class="mt-2 px-4 py-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Seu e-mail" />
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Senha</label>
                    <input type="password" id="password" v-model="password" required
                        class="mt-2 px-4 py-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Sua senha" />
                </div>

                <div>
                    <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-500">
                        Criar Conta
                    </button>
                </div>
            </form>

            <!-- Link para a página de Login -->
            <p class="text-center text-sm text-gray-600 mt-4">
                Já possui uma conta?
                <router-link to="/login" class="text-blue-600 hover:underline">Ir para Login</router-link>
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
            name: '',
            email: '',
            password: ''
        };
    },
    methods: {
        async register() {
            try {
                await axios.post('http://localhost:8000/api/register', {
                    name: this.name,
                    email: this.email,
                    password: this.password
                });

                // Exibe um SweetAlert de sucesso
                Swal.fire({
                    title: 'Cadastro realizado!',
                    text: 'Agora você pode fazer login.',
                    icon: 'success',
                    confirmButtonText: 'Ok'
                }).then(() => {
                    this.$router.push('/login'); // Redireciona para a tela de login
                });
            } catch (error) {
                // Exibe um SweetAlert de erro
                Swal.fire({
                    title: 'Erro ao registrar!',
                    text: 'Ocorreu um erro ao tentar registrar sua conta. Tente novamente.',
                    icon: 'error',
                    confirmButtonText: 'Ok'
                });
            }
        }
    }
};
</script>

<style scoped>
/* Estilos para o formulário */
</style>
