/**
 * Controller Genre - Gestão de pedidos HTTP para géneros
 * 
 * Este controller trata todos os endpoints relacionados com géneros,
 * incluindo listagem, obtenção por ID e obtenção de géneros de um jogo específico.
 */

const Genre = require("../models/Genre");

/**
 * GET /api/genres - Obtém lista de todos os géneros
 * 
 * @returns {Object} JSON com success, count e array de géneros
 */
exports.getAll = async (req, res) => {
  try {
    const genres = await Genre.getAll();
    res.json({
      success: true,
      count: genres.length,
      data: genres,
    });
  } catch (error) {
    res.status(500).json({
      success: false,
      message: "Erro ao obter géneros",
      error: error.message,
    });
  }
};

/**
 * GET /api/genres/:id - Obtém um género específico pelo ID
 * 
 * @param {number} req.params.id - ID do género a obter
 * @returns {Object} JSON com success e dados do género (ou erro 404 se não encontrado)
 */
exports.getById = async (req, res) => {
  try {
    const genre = await Genre.getById(req.params.id);

    if (!genre) {
      return res.status(404).json({
        success: false,
        message: "Género não encontrado",
      });
    }

    res.json({
      success: true,
      data: genre,
    });
  } catch (error) {
    res.status(500).json({
      success: false,
      message: "Erro ao obter género",
 **
 * GET /api/jogos/:id/genres - Obtém todos os géneros de um jogo específico
 * 
 * @param {number} req.params.id - ID do jogo
 * @returns {Object} JSON com success, count e array de géneros do jogo
 */
    });
  }
};

// GET /api/jogos/:id/genres - Obter géneros de um jogo
exports.getByJogoId = async (req, res) => {
  try {
    const genres = await Genre.getByJogoId(req.params.id);
    res.json({
      success: true,
      count: genres.length,
      data: genres,
    });
  } catch (error) {
    res.status(500).json({
      success: false,
      message: "Erro ao obter géneros do jogo",
      error: error.message,
    });
  }
};
