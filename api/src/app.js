const express = require("express");
const cors = require("cors");
const swaggerUi = require("swagger-ui-express");
const swaggerJsdoc = require("swagger-jsdoc");
const errorHandler = require("./middleware/errorHandler");

const app = express();

// Middleware
app.use(cors());
app.use(express.json());
app.use(express.urlencoded({ extended: true }));

// Servir arquivos estáticos (Frontend)
app.use(express.static("public"));

// Configuração do Swagger
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

const swaggerSpec = swaggerJsdoc(swaggerOptions);
app.use("/api-docs", swaggerUi.serve, swaggerUi.setup(swaggerSpec));

// Rotas da API
app.use("/api/jogos", require("./routes/jogos"));
app.use("/api/consoles", require("./routes/consoles"));
app.use("/api/genres", require("./routes/genres"));

// Rota raiz
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

// Middleware de tratamento de erros (deve ser o último)
app.use(errorHandler);

module.exports = app;
