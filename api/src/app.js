/**
 * Configuração Principal da Aplicação Express
 *
 * Este módulo configura e exporta a aplicação Express com todos os middlewares,
 * rotas e documentação Swagger. Atua como ponto central de configuração da API REST.
 *
 * Principais componentes:
 * - CORS: Permite pedidos cross-origin
 * - Body parsers: JSON e URL-encoded
 * - Static files: Servir frontend da pasta public/
 * - Swagger: Documentação interativa da API
 * - Routes: Endpoints REST para jogos, consolas e géneros
 * - Error handler: Middleware centralizado de erros
 */

const express = require("express");
const cors = require("cors");
const swaggerUi = require("swagger-ui-express");
const swaggerJsdoc = require("swagger-jsdoc");
const errorHandler = require("./middleware/errorHandler");

const app = express();

/**
 * Configuração de Middlewares
 *
 * - cors(): Permite pedidos de qualquer origem (CORS aberto)
 * - express.json(): Parse de bodies JSON
 * - express.urlencoded(): Parse de bodies URL-encoded (formulários)
 */
app.use(cors());
app.use(express.json());
app.use(express.urlencoded({ extended: true }));

/**
 * Servir Ficheiros Estáticos
 *
 * A pasta public/ contém o frontend da aplicação (HTML, CSS, JS)
 * Acessível diretamente em http://localhost:3000/
 */
app.use(express.static("public"));

/**
 * Configuração do Swagger/OpenAPI
 *
 * Gera documentação interativa automaticamente a partir de anotações JSDoc
 * nas routes. A documentação fica disponível em /api-docs
 */
const swaggerOptions = {
  definition: {
    openapi: "3.0.0",
    info: {
      title: "Jogos REST API",
      version: "1.0.0",
      description: "REST API para gestão de jogos, consolas e géneros",
      contact: {
        name: "Equipa de Desenvolvimento",
      },
    },
    servers: [
      {
        url: "http://localhost:3000",
        description: "Servidor de Desenvolvimento",
      },
    ],
  },
  apis: ["./src/routes/*.js"],
};

// Gerar especificação Swagger a partir das anotações
const swaggerSpec = swaggerJsdoc(swaggerOptions);
// Montar interface Swagger UI no endpoint /api-docs
app.use("/api-docs", swaggerUi.serve, swaggerUi.setup(swaggerSpec));

/**
 * Rotas da REST API
 *
 * Monta os routers de cada recurso nos seus respetivos endpoints:
 * - /api/jogos - CRUD completo de jogos
 * - /api/consoles - Listagem e consulta de consolas
 * - /api/genres - Listagem e consulta de géneros
 */
app.use("/api/jogos", require("./routes/jogos"));
app.use("/api/consoles", require("./routes/consoles"));
app.use("/api/genres", require("./routes/genres"));

/**
 * Rota Raiz da API
 *
 * Endpoint de informação básica e descoberta de endpoints disponíveis
 */
app.get("/api", (req, res) => {
  res.json({
    message: "Bem-vindo à Jogos API",
    version: "1.0.0",
    endpoints: {
      jogos: "/api/jogos",
      consoles: "/api/consoles",
      genres: "/api/genres",
      documentation: "/api-docs",
    },
  });
});

/**
 * Middleware de Tratamento de Erros
 *
 * IMPORTANTE: Este middleware deve ser sempre o último a ser registado.
 * Captura todos os erros que ocorrem nas routes e controllers.
 */
app.use(errorHandler);

module.exports = app;
