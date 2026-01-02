const mysql = require("mysql2/promise");
require("dotenv").config();

// Pool de conexões para otimizar performance
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

// Testar conexão
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
