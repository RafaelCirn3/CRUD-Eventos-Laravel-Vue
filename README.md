# CRUD de Eventos com Laravel e Vue.js

## Descrição do Projeto

Este projeto é uma aplicação de gerenciamento de eventos construída com o framework Laravel para o back-end e Vue.js para o front-end. A aplicação permite que os usuários realizem operações CRUD (Criar, Ler, Atualizar, Deletar) em eventos, proporcionando uma interface simples e intuitiva para interação.

### Funcionalidades

- **Cadastro de Eventos**: Usuários autenticados podem criar novos eventos, fornecendo informações como nome, descrição, data e imagens.
- **Listagem de Eventos**: A aplicação exibe uma lista de eventos cadastrados, permitindo que os usuários visualizem detalhes de cada evento.
- **Atualização de Eventos**: Usuários podem editar as informações de eventos existentes.
- **Remoção de Eventos**: Possibilidade de deletar eventos que não são mais necessários.
- **Autenticação de Usuários**: Implementação de autenticação usando Laravel Sanctum, permitindo que apenas usuários autenticados realizem operações no CRUD.

## Tecnologias Utilizadas

- **Back-end**: Laravel 9.x
- **Front-end**: Vue.js 3.x
- **Banco de Dados**: MySQL ou SQLite
- **Autenticação**: Laravel Sanctum
- **Gerenciamento de Pacotes**: Composer e NPM

## Pré-requisitos

Antes de executar o projeto, certifique-se de ter as seguintes ferramentas instaladas:

- [PHP](https://www.php.net/downloads) (>= 8.0)
- [Composer](https://getcomposer.org/download/)
- [Node.js](https://nodejs.org/en/download/)
- [NPM](https://www.npmjs.com/get-npm)

## Como Utilizar

### 1. Clonar o Repositório

Clone este repositório em sua máquina local usando o seguinte comando:

```bash
git clone https://github.com/RafaelCirn3/CRUD-Eventos-Laravel-Vue
cd CRUD
```
### 2. Instalar Dependências do Back-end
Navegue até o diretório do projeto e instale as dependências do Laravel:
```bash
composer install
```
### 3. Configurar o Banco de Dados
Crie um banco de dados e configure o arquivo .env na raiz do projeto para refletir suas credenciais do banco de dados:
```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nome_do_banco
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
```
### 4. Migrations e Seeders
Execute as migrations para criar as tabelas no banco de dados:
```bash
php artisan migrate
```
Se você tiver seeders para popular o banco de dados, execute:
```bash
php artisan db:seed
```` 
### 5. Instalar Dependências do Front-end
Navegue até o diretório do front-end (se estiver separado) e instale as dependências do Vue.js:

```bash
npm install
```
6. Compilar Assets
Compile os assets do front-end:

bash
Copiar código
npm run dev
### 7. Executar o Servidor
Inicie o servidor do Laravel:
```bash
php artisan serve
````
A aplicação estará disponível em http://127.0.0.1:8000.

### 8. Acessar a Aplicação
Abra o seu navegador e vá para http://127.0.0.1:8000 para acessar a interface da aplicação.

### 9. Testar a Autenticação
Para realizar operações no CRUD, é necessário fazer login. Use a rota /api/register para se registrar e em seguida /api/login para obter um token. Insira este token no cabeçalho das requisições para acessar as rotas protegidas.

## Contribuição
Contribuições são bem-vindas! Sinta-se à vontade para abrir uma issue ou enviar um pull request.
