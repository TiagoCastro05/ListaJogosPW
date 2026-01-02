# 🎮 REST API Node.js - Gestão de Jogos

## 📋 Sobre o Projeto

Esta REST API em Node.js foi desenvolvida como continuação do Trabalho Prático #1 (aplicação PHP).

**Integração com TP#1:**

- ✅ Usa a **mesma base de dados** MySQL (jogosdb)
- ✅ Reutiliza o **mesmo design/CSS** do projeto PHP
- ✅ Mantém a **mesma estrutura de dados**
- ✅ Permite **convivência** entre PHP e Node.js

## 🚀 Como Executar

### 1. Instalar dependências

```powershell
cd C:\ECGM\PW\jogosapp\api
npm install
```

### 2. Configurar .env

O ficheiro `.env` já está configurado para usar a BD do TP#1:

```env
PORT=3000
DB_HOST=localhost
DB_USER=root
DB_PASSWORD=
DB_NAME=jogosdb
```

### 3. Garantir que MySQL está a correr

- Iniciar XAMPP
- BD `jogosdb` deve existir (criada no TP#1)

### 4. Executar a API

```powershell
# Modo desenvolvimento (com auto-reload)
npm run dev

# Modo produção
npm start
```

## 🔌 URLs

- **API**: http://localhost:3000/api
- **Swagger**: http://localhost:3000/api-docs
- **Frontend API**: http://localhost:3000
- **App PHP Original**: http://localhost/jogosapp/

## 📦 Endpoints

### Jogos

- `GET /api/jogos` - Listar (com filtros: title, year, minMetacritic)
- `GET /api/jogos/:id` - Obter por ID
- `POST /api/jogos` - Criar
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

## 🎯 Requisitos Cumpridos

✅ Node.js + Express  
✅ GET, POST, PUT, DELETE  
✅ Documentação Swagger  
✅ Frontend consumindo API  
✅ Mesma temática do TP#1  
✅ Mesmo modelo de dados

## 📁 Estrutura

```
api/
├── src/
│   ├── config/          # Conexão MySQL
│   ├── controllers/     # Lógica de negócio
│   ├── models/          # Queries BD
│   ├── routes/          # Rotas REST
│   ├── middleware/      # Error handler
│   └── app.js          # Express config
├── public/
│   └── index.html      # Frontend
├── server.js           # Entry point
├── package.json
└── .env
```

## 🧪 Testar com Postman

### POST - Criar Jogo

```json
POST http://localhost:3000/api/jogos
Content-Type: application/json

{
  "title": "Elden Ring",
  "metacritic_rating": 96,
  "release_year": 2022,
  "consoles": [1, 2],
  "genres": [3, 5]
}
```

### GET - Filtros

```
GET http://localhost:3000/api/jogos?title=zelda
GET http://localhost:3000/api/jogos?year=2023&minMetacritic=90
```

## 💡 Funcionalidades Extra

- ✅ Filtros avançados combinados
- ✅ Relações M:N (jogos ↔ consolas/géneros)
- ✅ Transações de BD
- ✅ Pool de conexões MySQL
- ✅ Validação dupla (client + server)
- ✅ Frontend responsivo
- ✅ Estatísticas em tempo real

## 📝 Entrega

Para submeter no Moodle:

```powershell
# Compactar projeto completo (exclui node_modules)
Compress-Archive -Path C:\ECGM\PW\jogosapp\* -DestinationPath PW_Node_Grupo.zip -Force
```

**NOTA**: Não incluir pasta `node_modules/` no ZIP

---

**Desenvolvido para Programação Web - Janeiro 2026**
