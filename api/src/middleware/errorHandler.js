// Middleware para tratamento de erros
const errorHandler = (err, req, res, next) => {
  console.error("Erro:", err);

  res.status(err.status || 500).json({
    success: false,
    message: err.message || "Erro interno do servidor",
    error: process.env.NODE_ENV === "development" ? err : {},
  });
};

module.exports = errorHandler;
