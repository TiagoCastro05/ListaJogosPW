# 🎮 Projeto Jogos - TP#1 (PHP) + TP#2 (Node.js API)

## 📋 Sobre o Projeto

Este projeto integra **duas tecnologias** numa única aplicação:

1. **TP#1**: Aplicação PHP com MVC (pasta raiz)
2. **TP#2**: REST API Node.js + Express (pasta `api/`)

**Ambos partilham a mesma base de dados MySQL (`jogosdb`)**

---

## 📁 Estrutura do Projeto

```
jogosapp/                           # Projeto principal
├── app/                            # TP#1 - Aplicação PHP (MVC)
│   ├── controllers/
│   ├── models/
│   ├── views/
│   └── core/
├── assets/                         # CSS e JS da app PHP
│   ├── css/
│   └── js/
├── sql/                            # Scripts de base de dados
│   ├── db.sql
│   ├── genres_moviesdb.sql
│   └── movies_moviesdb.sql
├── index.php                       # Entry point da app PHP
├── api/                            # TP#2 - REST API Node.js 🆕
│   ├── src/
│   │   ├── config/                 # Conexão MySQL
│   │   ├── controllers/            # Lógica da API
│   │   ├── models/                 # Queries BD
│   │   ├── routes/                 # Endpoints REST
│   │   ├── middleware/             # Error handling
│   │   └── app.js                  # Express setup
│   ├── public/
│   │   └── index.html              # Frontend da API
│   ├── server.js                   # Entry point Node.js
│   ├── package.json                # Dependências
│   ├── .env                        # Configuração
│   └── README.md                   # Docs da API
├── README.md                       # Este ficheiro
└── .gitignore
```

---

## 🚀 Como Executar

### Pré-requisitos

- ✅ XAMPP (Apache + MySQL) instalado
- ✅ Node.js instalado
- ✅ Base de dados `jogosdb` criada

---

### 1️⃣ Executar Aplicação PHP (TP#1)

1. **Iniciar XAMPP** (Apache + MySQL)
2. **Importar BD**:
   ```sql
   -- Executar scripts em sql/
   - db.sql
   - genres_moviesdb.sql
   - movies_moviesdb.sql
   ```
3. **Aceder à app PHP**:
   ```
   http://localhost/jogosapp/
   ```

**Funcionalidades PHP:**

- ✅ CRUD completo de jogos
- ✅ Pesquisa e filtros
- ✅ Interface web responsiva
- ✅ Validação client + server

---

### 2️⃣ Executar API Node.js (TP#2)

1. **Navegar para a pasta da API**:

   ```powershell
   cd C:\ECGM\PW\jogosapp\api
   ```

2. **Instalar dependências** (primeira vez):

   ```powershell
   npm install
   ```

3. **Executar servidor**:

   ```powershell
   # Modo desenvolvimento (auto-reload)
   npm run dev

   # Modo produção
   npm start
   ```

4. **Aceder à API**:
   - **Frontend**: http://localhost:3000
   - **Swagger**: http://localhost:3000/api-docs
   - **API**: http://localhost:3000/api

**Funcionalidades API:**

- ✅ REST API completa (GET, POST, PUT, DELETE)
- ✅ Documentação Swagger
- ✅ Frontend consumindo API
- ✅ Filtros avançados
- ✅ Mesma BD que o PHP

---

## 🔌 Endpoints da API Node.js

### Jogos

- `GET /api/jogos` - Listar todos (filtros: title, year, minMetacritic)
- `GET /api/jogos/:id` - Obter por ID
- `POST /api/jogos` - Criar novo
- `PUT /api/jogos/:id` - Atualizar
- `DELETE /api/jogos/:id` - Eliminar
- `GET /api/jogos/:id/consoles` - Consolas de um jogo
- `GET /api/jogos/:id/genres` - Géneros de um jogo

### Consolas

- `GET /api/consoles` - Listar todas
- `GET /api/consoles/:id` - Obter por ID

### Géneros

- `GET /api/genres` - Listar todos
- `GET /api/genres/:id` - Obter por ID

---

## 🗄️ Base de Dados Partilhada

**BD MySQL: `jogosdb`**

### Tabelas

- `jogos` - Informação dos jogos
- `consoles` - Plataformas de jogo
- `genres` - Géneros
- `jogo_consoles` - Relação M:N (Jogos ↔ Consolas)
- `jogo_genres` - Relação M:N (Jogos ↔ Géneros)

**IMPORTANTE**: Tanto o PHP quanto o Node.js acedem à **mesma base de dados**. As alterações feitas numa aplicação são visíveis na outra!

---

## 🎯 Comparação TP#1 vs TP#2

| Aspecto           | TP#1 (PHP)       | TP#2 (Node.js)    |
| ----------------- | ---------------- | ----------------- |
| **Tecnologia**    | PHP MVC          | Node.js + Express |
| **Frontend**      | PHP views        | HTML + Fetch API  |
| **Base de Dados** | mysqli           | mysql2 (pool)     |
| **Arquitetura**   | MVC tradicional  | REST API          |
| **Documentação**  | Comentários      | Swagger           |
| **Resposta**      | HTML renderizado | JSON              |
| **Validação**     | PHP + JS         | Controllers + JS  |

---

## 📦 Entrega (TP#2)

### Criar ZIP para submissão

```powershell
# Compactar projeto (exclui node_modules)
Compress-Archive -Path C:\ECGM\PW\jogosapp\* -DestinationPath PW_Node_GrupoX.zip -Force
```

### O que incluir:

✅ Pasta `app/` (PHP)  
✅ Pasta `assets/` (CSS/JS)  
✅ Pasta `sql/` (Scripts BD)  
✅ Pasta `api/` (Node.js) - **SEM node_modules/**  
✅ `index.php`  
✅ `README.md`  
✅ `.gitignore`

### O que **NÃO** incluir:

❌ `api/node_modules/` (muito pesado!)  
❌ Ficheiros de cache

**NOTA**: Quem receber o projeto deve executar `npm install` na pasta `api/`

---

## 🧪 Testar a API

### Com Postman/EchoAPI

#### POST - Criar Jogo

```json
POST http://localhost:3000/api/jogos
Content-Type: application/json

{
  "title": "Elden Ring",
  "metacritic_rating": 96,
  "release_year": 2022,
  "game_image": "https://example.com/elden.jpg",
  "consoles": [1, 2],
  "genres": [3, 5]
}
```

#### GET - Filtros

```
GET http://localhost:3000/api/jogos?title=zelda
GET http://localhost:3000/api/jogos?year=2023&minMetacritic=90
```

#### DELETE

```
DELETE http://localhost:3000/api/jogos/10
```

### Com cURL (PowerShell)

```powershell
# GET - Listar jogos
curl http://localhost:3000/api/jogos

# POST - Criar
curl -X POST http://localhost:3000/api/jogos -H "Content-Type: application/json" -d '{\"title\":\"Test\",\"consoles\":[1],\"genres\":[1]}'
```

---

## 📚 Documentação Swagger

Aceder a: **http://localhost:3000/api-docs**

- ✅ Todos os endpoints documentados
- ✅ Schemas de dados
- ✅ Exemplos de requests/responses
- ✅ Testável diretamente (Try it out)

---

## 💡 Vantagens desta Integração

✅ **Reutilização**: Mesma BD, menos setup  
✅ **Comparação**: Ver diferenças PHP vs Node.js  
✅ **Aprendizagem**: Duas abordagens no mesmo projeto  
✅ **Flexibilidade**: Escolher PHP ou API conforme necessidade  
✅ **Realismo**: Simula ambientes híbridos reais

---

## ⚡ Troubleshooting

### PHP não funciona

**Problema**: `http://localhost/jogosapp/` não abre  
**Solução**: Verificar se Apache está a correr no XAMPP

### API Node.js não conecta à BD

**Problema**: `❌ Erro ao conectar à base de dados`  
**Solução**:

1. Verificar se MySQL está a correr
2. Confirmar credenciais em `api/.env`
3. Garantir que BD `jogosdb` existe

### Porta 3000 em uso

**Problema**: `Error: listen EADDRINUSE`  
**Solução**: Alterar `PORT=3001` em `api/.env`

### node_modules não existe

**Problema**: Erro ao executar `npm start`  
**Solução**: Executar `npm install` na pasta `api/`

---

## 🏆 Funcionalidades Extra (Valorização)

### TP#2 - API Node.js

✅ Filtros avançados combinados  
✅ Relações M:N completas  
✅ Transações de BD  
✅ Pool de conexões MySQL  
✅ Validação dupla (client + server)  
✅ Frontend responsivo  
✅ Estatísticas em tempo real  
✅ Documentação Swagger completa  
✅ Middleware de tratamento de erros  
✅ Código MVC organizado

---

## 👥 Autores

[Nomes dos elementos do grupo]

---

## 📄 Licença

Projeto académico - Programação Web 2025/2026

---

**Desenvolvido com ❤️ para Programação Web**
