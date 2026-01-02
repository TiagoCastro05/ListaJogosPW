#  GUIA RÁPIDO - EXECUÇÃO E APRESENTAÇÃO

##  PROJETO INTEGRADO PRONTO!

**Estrutura:**
-  jogosapp/ - Aplicação PHP original (TP#1)
-  jogosapp/api/ - REST API Node.js (TP#2) 

**Base de Dados:** jogosdb (partilhada entre PHP e Node.js)

---

##  COMO EXECUTAR

### 1 Aplicação PHP (TP#1)
```powershell
# Iniciar XAMPP (Apache + MySQL)
# Aceder: http://localhost/jogosapp/
```

### 2 API Node.js (TP#2)
```powershell
cd C:\ECGM\PW\jogosapp\api
npm install    # só primeira vez
npm start      # ou: npm run dev
```

**URLs da API:**
- Frontend: http://localhost:3000
- Swagger: http://localhost:3000/api-docs
- API: http://localhost:3000/api

---

##  APRESENTAÇÃO (TP#2)

### 1. Mostrar Swagger (http://localhost:3000/api-docs)
- Explorar endpoints documentados
- Testar um endpoint (Try it out)

### 2. Testar com Postman/EchoAPI
```
GET http://localhost:3000/api/jogos
GET http://localhost:3000/api/jogos/1
POST http://localhost:3000/api/jogos
PUT http://localhost:3000/api/jogos/1
DELETE http://localhost:3000/api/jogos/1
```

### 3. Demonstrar Frontend (http://localhost:3000)
- Listar jogos (GET)
- Criar jogo (POST)
- Ver detalhes (GET by ID)
- Eliminar jogo (DELETE)

### 4. Mostrar Código
- Estrutura MVC em pi/src/
- Models com queries
- Controllers com validação
- Routes com Swagger docs

---

##  EXEMPLO POST (Postman)

```json
POST http://localhost:3000/api/jogos
Content-Type: application/json

{
  "title": "Elden Ring",
  "metacritic_rating": 96,
  "release_year": 2022,
  "game_image": "https://exemplo.com/elden.jpg",
  "consoles": [1, 2],
  "genres": [3, 5]
}
```

---

##  ENTREGA

```powershell
# Criar ZIP (sem node_modules!)
cd C:\ECGM\PW
Compress-Archive -Path jogosapp\* -DestinationPath PW_Node_GrupoX.zip -Force
```

**IMPORTANTE:** 
-  Incluir pasta pi/ completa
-  EXCLUIR pi/node_modules/
-  Incluir pi/.env

**Quem descompactar deve executar:**
```powershell
cd jogosapp\api
npm install
```

---

##  REQUISITOS CUMPRIDOS

 API em Node.js + Express  
 Endpoints GET, POST, PUT, DELETE  
 Documentação Swagger  
 Frontend consumindo API  
 Mesma temática TP#1  
 Mesmo modelo de dados (jogosdb)  
 **INTEGRADO** com projeto PHP  

---

##  DESTAQUES

**Valorização Extra:**
- Pool de conexões MySQL
- Filtros avançados
- Relações M:N completas
- Transações de BD
- Validação client + server
- Frontend responsivo
- Estatísticas em tempo real

**Integração TP#1 + TP#2:**
- Mesma BD partilhada
- Design consistente
- Projeto unificado

---

**Tudo pronto para apresentação! **
