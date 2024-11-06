<template>
    <div class="flex flex-col items-center justify-center min-h-screen ">
        <div class="max-w-md w-full">
            <h2 class="text-2xl font-semibold mb-6 text-center">Entrar</h2>
            <form @submit.prevent="login" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email:</label>
                    <input type="email" v-model="email" required
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
                </div>
                <div class="mb-6">
                    <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Senha:</label>
                    <input type="password" v-model="password" required
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
                </div>
                <div class="flex items-center justify-between">
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Entrar</button>
                </div>
            </form>

            <!-- Exibindo mensagens de erro ou sucesso -->
            <div v-if="errorMessage" class="text-red-500 mb-4">{{ errorMessage }}</div>
            <div v-if="successMessage" class="text-green-500 mb-4">{{ successMessage }}</div>

            <!-- Link para a página de registro -->
            <p class="mt-4 text-center">
                Ainda não possui uma conta? 
                <router-link to="/register" class="text-blue-500 hover:text-blue-700 font-bold">Crie uma aqui</router-link>
            </p>
        </div>
    </div>
</template>

<script>
import axios from 'axios'; // Certifique-se de importar o axios

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
                // Enviando dados para a API de login
                const response = await axios.post('http://localhost:8000/api/login', {
                    email: this.email,
                    password: this.password
                });

                // Se o login for bem-sucedido
                if (response.data.token) {
                    // Armazenando o token no localStorage
                    localStorage.setItem('token', response.data.token);

                    // Definindo a mensagem de sucesso
                    this.successMessage = 'Login realizado com sucesso!';

                    // Verificando se a rota atual é diferente da rota de destino
                    const currentRoute = this.$route.name;
                    const targetRoute = 'event-list';  // Nome da rota de destino

                    // Se a rota atual for diferente, redireciona para a lista de eventos
                    if (currentRoute !== targetRoute) {
                        this.$router.push('/event-list'); // Redireciona para a página de lista de eventos
                    }
                }
            } catch (error) {
                // Se houver erro no login
                this.errorMessage = 'Erro ao tentar fazer login. Verifique suas credenciais e tente novamente.';
            }
        }
    }
}
</script>


<style scoped>
.register-form {
    max-width: 400px;
    margin: 0 auto;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: #f9f9f9;
}

h1 {
    text-align: center;
}

label {
    display: block;
    margin: 10px 0 5px;
}

input {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

button {
    width: 100%;
    padding: 10px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

button:hover {
    background-color: #45a049;
}

p {
    color: red;
    text-align: center;
}
</style>
