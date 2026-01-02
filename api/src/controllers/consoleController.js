/**
 * Controller Console - Gestão de pedidos HTTP para consolas
 *
 * Este controller trata todos os endpoints relacionados com consolas,
 * incluindo listagem, obtenção por ID e obtenção de consolas de um jogo específico.
 */

const Console = require("../models/Console");

/**
 * GET /api/consoles - Obtém lista de todas as consolas
 *
 * @returns {Object} JSON com success, count e array de consolas
 */
exports.getAll = async (req, res) => {
  try {
    const consoles = await Console.getAll();
    res.json({
      success: true,
      count: consoles.length,
      data: consoles,
    });
  } catch (error) {
    res.status(500).json({
      success: false,
      message: "Erro ao obter consolas",
      error: error.message,
    });
  }
};

/**
 * GET /api/consoles/:id - Obtém uma consola específica pelo ID
 *
 * @param {number} req.params.id - ID da consola a obter
 * @returns {Object} JSON com success e dados da consola (ou erro 404 se não encontrada)
 */
exports.getById = async (req, res) => {
  try {
    const console = await Console.getById(req.params.id);

    if (!console) {
      return res.status(404).json({
        success: false,
        message: "Consola não encontrada",
      });
    }

    res.json({
      success: true,
      data: console,
    });
  } catch (error) {
    res.status(500).json({
      success: false,
      message: "Erro ao obter consola",
      error: error.message,
    });
  }
};

/**
 * GET /api/jogos/:id/consoles - Obtém todas as consolas de um jogo específico
 *
 * @param {number} req.params.id - ID do jogo
 * @returns {Object} JSON com success, count e array de consolas do jogo
 */
exports.getByJogoId = async (req, res) => {
  try {
    const consoles = await Console.getByJogoId(req.params.id);
    res.json({
      success: true,
      count: consoles.length,
      data: consoles,
    });
  } catch (error) {
    res.status(500).json({
      success: false,
      message: "Erro ao obter consolas do jogo",
      error: error.message,
    });
  }
};
