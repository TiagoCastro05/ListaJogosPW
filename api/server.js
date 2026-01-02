/**
 * Servidor HTTP - Ponto de Entrada da Aplicação
 *
 * Este ficheiro inicia o servidor Express e exibe informações de startup.
 * Carrega variáveis de ambiente do ficheiro .env e inicia a aplicação
 * configurada em app.js.
 *
 * Endpoints disponíveis após startup:
 * - http://localhost:3000 - Frontend (interface web)
 * - http://localhost:3000/api - Informação da API
 * - http://localhost:3000/api-docs - Documentação Swagger
 */

require("dotenv").config();
const app = require("./src/app");

// Porta do servidor (3000 por defeito, ou configurada em .env)
const PORT = process.env.PORT || 3000;

/**
 * Iniciar Servidor HTTP
 *
 * Coloca o servidor a escutar na porta especificada e exibe
 * mensagens informativas com os URLs disponíveis.
 */
app.listen(PORT, () => {
  console.log(`🚀 Servidor a correr em http://localhost:${PORT}`);
  console.log(`📚 Documentação Swagger: http://localhost:${PORT}/api-docs`);
  console.log(`🎮 Frontend: http://localhost:${PORT}`);
});
