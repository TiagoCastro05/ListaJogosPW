const Console = require("../models/Console");

// GET /api/consoles - Listar todas as consolas
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

// GET /api/consoles/:id - Obter consola por ID
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

// GET /api/jogos/:id/consoles - Obter consolas de um jogo
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
