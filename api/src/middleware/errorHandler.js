/**
 * Middleware de Tratamento de Erros
 *
 * Este middleware centralizado captura todos os erros que ocorrem na aplicação
 * e envia uma resposta JSON formatada ao cliente. Em modo desenvolvimento,
 * inclui detalhes completos do erro para facilitar debugging.
 *
 * @param {Error} err - Objeto de erro capturado
 * @param {Object} req - Objeto de pedido Express
 * @param {Object} res - Objeto de resposta Express
 * @param {Function} next - Função next do Express (não utilizada, mas necessária)
 */
const errorHandler = (err, req, res, next) => {
  // Log do erro no servidor para debugging
  console.error("Erro:", err);

  // Resposta JSON formatada
  res.status(err.status || 500).json({
    success: false,
    message: err.message || "Erro interno do servidor",
    // Detalhes do erro apenas em desenvolvimento (segurança)
    error: process.env.NODE_ENV === "development" ? err : {},
  });
};

module.exports = errorHandler;
