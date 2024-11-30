# Api-Notepad

Esta é uma API para um bloco de notas simples, construída usando Laravel. A API permite aos usuários autenticados criar, ler, atualizar e deletar notas.

__Colaboradores:__ <a href="https://github.com/GustavoSachetto" target="_blank">@Gustavo Sachetto</a> e
<a href="https://github.com/iCrowleySHR" target="_blank">@Gustavo Gualda</a>.

#laravel #php

## Requisitos

- PHP >= 8.3.4
- Composer
- Laravel 11.4.0
- MySQL

## Instalação
1. Instale as dependências:
    ```bash
    composer install
    ```
2. Copie o arquivo `.env.example` para `.env` e configure suas variáveis de ambiente:
    ```bash
    cp .env.example .env
    ```
3. Gere a chave da aplicação:
    ```bash
    php artisan key:generate
    ```
4. Configure seu banco de dados no arquivo `.env` e execute as migrações:
    ```bash
    php artisan migrate
    ```
6. Instale o pacote JWT Auth:
    ```bash
    composer require tymon/jwt-auth
    php artisan jwt:secret
    ```
## Rotas    
### Registrar Usuário

- **URL:** `http://localhost/api_notepad/public/api/v1/users/`
- **Método:** `POST`
- **Parâmetros:**
  - `name`: Nome do usuário
  - `email`: Email do usuário
  - `password`: Senha do usuário
- **Exemplo de Request:**
    ```json
    {
        "name": "John Doe",
        "email": "john@example.com",
        "password": "password",
    }
    ```
- **Resposta de Sucesso:**
    ```json
    {
        "message": "Usuário registrado com sucesso!"
    }
    ```

### Login

- **URL:** `http://localhost/api_notepad/public/api/v1/users/validate`
- **Método:** `POST`
- **Parâmetros:**
  - `email`: Email do usuário
  - `password`: Senha do usuário
- **Exemplo de Request:**
    ```json
    {
        "email": "john@example.com",
        "password": "password"
    }
    ```
- **Resposta de Sucesso:**
    ```json
    {
        "success": "Usuário autenticado",
        "name": "Jorge da Silva Pereira",
        "email": "teste@gustavo.com",
        "id": 3,
        "created_at": "2024-05-16T00:19:06.000000Z",
        "updated_at": "2024-05-16T00:19:06.000000Z",
        "token": "{token}",
        "token_type": "bearer"
    }
    ```

### Notas

#### Listar Notas

- **URL:** `/api/notes`
- **Método:** `GET`
- **Cabeçalho:**
  - `Authorization`: `Bearer {seu_token_jwt}`
- **Resposta de Sucesso:**
    ```json
    [
        {
            "id": 1,
            "title": "Minha Primeira Nota",
            "content": "Conteúdo da nota",
            "created_at": "2023-05-15T14:00:00.000000Z",
            "updated_at": "2023-05-15T14:00:00.000000Z"
        }
    ]
    ```

#### Criar Nota

- **URL:** `http://localhost/api_notepad/public/api/v1/notes`
- **Método:** `POST`
- **Cabeçalho:**
  - `Authorization`: `Bearer {seu_token_jwt}`
- **Parâmetros:**
  - `title`: Título da nota
  - `content`: Conteúdo da nota
   - `id_user`: Usuário que criou a nota
- **Exemplo de Request:**
    ```json
    {
        "title": "Minha Primeira Nota",
        "content": "Conteúdo da nota"
        "id_user": "Usuário que criou a nota (1)"
    }
    ```
- **Resposta de Sucesso:**
    ```json
    {
        "success": "Anotação salva!."
    }
    ```

#### Visualizar Nota

- **URL:** `http://localhost/api_notepad/public/api/v1/notes/{id}`
- **Método:** `GET`
- **Cabeçalho:**
  - `Authorization`: `Bearer {seu_token_jwt}`
- **Resposta de Sucesso:**
    ```json
    [
        {
            "id": 12,
            "title": "Minha Amada",
            "content": "não existe",
            "id_user": 3,
            "created_at": "2024-05-16T00:19:43.000000Z",
            "updated_at": "2024-05-16T00:19:43.000000Z"
        }
    ]
    ```

#### Atualizar Nota

- **URL:** `http://localhost/api_notepad/public/api/v1/notes/{id}`
- **Método:** `PUT`
- **Cabeçalho:**
  - `Authorization`: `Bearer {seu_token_jwt}`
- **Parâmetros:**
  - `title`: Título da nota
  - `content`: Conteúdo da nota
- **Exemplo de Request:**
    ```json
    {
        "title": "Título Atualizado",
        "content": "Conteúdo atualizado da nota"
    }
    ```
- **Resposta de Sucesso:**
    ```json
    {
        "id": 3,
        "title": "Quero",
        "content": "Minha casa!",
        "id_user": 1,
        "created_at": "2024-05-07T22:32:25.000000Z",
        "updated_at": "2024-05-16T00:32:01.000000Z"
    }
    ```

#### Deletar Nota

- **URL:** `http://localhost/api_notepad/public/api/v1/notes/{id}`
- **Método:** `DELETE`
- **Cabeçalho:**
  - `Authorization`: `Bearer {seu_token_jwt}`
- **Resposta de Sucesso:**
    ```json
    {
        "success": "Nota apagada"
    }
    ```
