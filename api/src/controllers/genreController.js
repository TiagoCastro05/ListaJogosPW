const Genre = require("../models/Genre");

// GET /api/genres - Listar todos os géneros
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

// GET /api/genres/:id - Obter género por ID
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
      error: error.message,
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
