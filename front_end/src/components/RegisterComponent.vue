<template>
    <div class="register">
        <h1 style="margin-bottom: 10px;">Cadastre Aqui</h1>
        <form v-if="!isAuthenticated" @submit.prevent="registerUser">
            <input type="text" v-model="name" placeholder="Nome" required />
            <input type="email" v-model="email" placeholder="Email" required />
            <input type="password" v-model="password" placeholder="Senha" required />
            
            <!-- Exibindo erros de validação -->
            <div v-if="validationErrors.email" class="error">
                <p>{{ validationErrors.email[0] }}</p>
            </div>
            <div v-if="validationErrors.password" class="error">
                <p>{{ validationErrors.password[0] }}</p>
            </div>

            <button type="submit">Cadastrar</button>
        </form>
        
        <!-- Texto para redirecionar para a tela de login -->
        <div class="text-center mt-4">
            <span class="text-blue-500 cursor-pointer hover:underline" @click="redirectToLogin">
                Já possui uma conta? Ir para Login
            </span>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            name: '',
            email: '',
            password: '',
            message: '',
            isAuthenticated: false, // Variável para verificar se o usuário está autenticado
            validationErrors: {}, // Para armazenar erros de validação
        };
    },
    created() {
        // Verifica se o usuário já está autenticado (exemplo com token no localStorage)
        this.isAuthenticated = localStorage.getItem('token') ? true : false;
    },
    methods: {
        async registerUser() {
            try {
                await axios.post('http://localhost:8000/api/register', {
                    name: this.name,
                    email: this.email,
                    password: this.password
                });
                this.message = 'Usuário registrado com sucesso!';
                // Redireciona para a tela de login após o registro
                this.$router.push('/login');
            } catch (error) {
                // Exibir erro detalhado para depuração
                console.error('Erro ao registrar:', error.response ? error.response.data : error.message);
                if (error.response && error.response.data.errors) {
                    // Atribui os erros de validação ao estado para exibir ao usuário
                    this.validationErrors = error.response.data.errors;
                } else {
                    this.message = error.response ? error.response.data.message : 'Ocorreu um erro ao registrar. Tente novamente.';
                }
            }
        },
        redirectToLogin() {
            this.$router.push('/login'); // Redireciona para a tela de login
        }
    }
};
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
