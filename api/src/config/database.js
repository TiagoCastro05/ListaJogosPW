/**
 * Configuração da Base de Dados MySQL
 *
 * Este módulo cria e exporta um pool de conexões MySQL para otimizar a performance
 * e gestão de conexões à base de dados. Utiliza variáveis de ambiente para
 * configuração segura das credenciais.
 *
 * Pool Settings:
 * - connectionLimit: 10 conexões simultâneas máximas
 * - waitForConnections: true - aguarda por conexão disponível quando pool está cheio
 * - queueLimit: 0 - sem limite de pedidos em espera
 */

const mysql = require("mysql2/promise");
require("dotenv").config();

/**
 * Pool de conexões MySQL
 *
 * Configurado com credenciais do ficheiro .env:
 * - DB_HOST: endereço do servidor MySQL
 * - DB_USER: utilizador da base de dados
 * - DB_PASSWORD: palavra-passe
 * - DB_NAME: nome da base de dados
 * - DB_PORT: porta MySQL (geralmente 3306)
 */
const pool = mysql.createPool({
  host: process.env.DB_HOST,
  user: process.env.DB_USER,
  password: process.env.DB_PASSWORD,
  database: process.env.DB_NAME,
  port: process.env.DB_PORT,
  waitForConnections: true,
  connectionLimit: 10,
  queueLimit: 0,
});

/**
 * Teste de Conexão à Base de Dados
 *
 * Executado ao iniciar a aplicação para verificar se a conexão está funcional.
 * Obtém uma conexão do pool, confirma sucesso e liberta-a de volta.
 */
pool
  .getConnection()
  .then((connection) => {
    console.log("✅ Conectado à base de dados MySQL");
    connection.release();
  })
  .catch((err) => {
    console.error("❌ Erro ao conectar à base de dados:", err.message);
  });

module.exports = pool;
