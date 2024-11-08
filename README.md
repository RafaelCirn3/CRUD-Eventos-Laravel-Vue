
# Desafio para Processo Seletivo - Laravel + Vue.js

Este projeto foi desenvolvido como parte do processo seletivo para a vaga de desenvolvedor Laravel + Vue.js.

## Tecnologias Utilizadas

### Back-End:
- **Laravel**: Framework PHP para o desenvolvimento da API Restful, com rotas, controllers e autenticação.
- **Laravel Sanctum**: Utilizado para autenticação de APIs com tokens de sessão, permitindo a criação de usuários, login e validação de permissões de acesso às rotas protegidas.
- **MySQL**: Banco de dados utilizado para persistência de dados.

### Front-End:
- **Vue.js (v2)**: Framework JavaScript para construção do front-end interativo e reativo, usando componentes para gerenciar a UI e a lógica de interação com a API.
- **Vue Router**: Utilizado para navegação entre as páginas do aplicativo.
- **Axios**: Biblioteca para realizar requisições HTTP entre o front-end e o back-end.
- **Tailwind CSS**: Framework CSS utilitário para estilização rápida e responsiva.

## Funcionalidades

- **Cadastro e Login**: Sistema de autenticação com Laravel Sanctum.
- **CRUD de Eventos**: Criação, listagem, detalhamento, edição e cancelamento de eventos.
- **Filtros de Eventos**: Filtro por nome, data e status de eventos.
- **Subscrição em Eventos**: Usuários podem se inscrever e desinscrever de eventos.
- **Interface de Administração**: Apenas o dono do evento pode visualizar os inscritos.
- **Exibição de Detalhes de Evento**: Mostra informações detalhadas de eventos, incluindo imagens (mapa, capa, banner).

## Como Rodar o Projeto

### 1. Clonando o Repositório

Clone o repositório com os seguintes comandos:

```bash
git clone https://github.com/RafaelCirn3/CRUD-Eventos-Laravel-Vue
cd CRUD-Eventos-Laravel-Vue
```

### 2. Configurando o Back-End

1. **Acesse a pasta do back-end**:
   ```bash
   cd back-end
   ```

2. **Instale as dependências do Laravel**:
   ```bash
   composer install
   ```

3. **Crie um arquivo `.env` com as variáveis de ambiente**:
   Copie o arquivo `.env.example` para `.env` e configure as variáveis, como banco de dados, chave de app, etc.

   ```bash
   cp .env.example .env
   ```

4. **Gere a chave de aplicação do Laravel**:
   ```bash
   php artisan key:generate
   ```

5. **Migre o banco de dados**:
   ```bash
   php artisan migrate
   ```

6. **Rodando o servidor**:
   Inicie o servidor do back-end:
   ```bash
   php artisan serve
   ```

   O servidor estará disponível em `http://localhost:8000`.

### 3. Configurando o Front-End

1. **Acesse a pasta do front-end**:
   ```bash
   cd front_end
   ```

2. **Instale as dependências do Vue.js**:
   ```bash
   npm install
   ```

3. **Configuração do Axios**:
   Certifique-se de que o Axios está apontando para a URL do back-end (geralmente `http://localhost:8000`).

4. **Rodando o servidor do front-end**:
   Inicie o servidor do Vue.js:
   ```bash
   npm run serve
   ```

   O servidor estará disponível em `http://localhost:8080`.

### 4. Testando a Aplicação

1. **Acesse o Front-End** em `http://localhost:8080` e utilize as funcionalidades de cadastro, login, inscrição em eventos e visualização de detalhes de eventos.
2. **Acesse a API** em `http://localhost:8000/api` para verificar as rotas e interações com o back-end.

## Observações

- Este projeto foi desenvolvido com foco em uma aplicação completa utilizando **Laravel** no back-end e **Vue.js** no front-end.
- A autenticação é gerida por **Laravel Sanctum** para permitir o login de usuários e proteção de rotas sensíveis.
- O front-end foi estilizado utilizando **Tailwind CSS** para garantir uma interface limpa e responsiva.

## Fontes
- https://sweetalert2.github.io
- https://laravel.com/docs/11.x
- https://vuejs.org/guide/introduction.html