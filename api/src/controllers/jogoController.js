const Jogo = require("../models/Jogo");

// GET /api/jogos - Listar todos os jogos
exports.getAll = async (req, res) => {
  try {
    const filters = {
      title: req.query.title,
      year: req.query.year,
      minMetacritic: req.query.minMetacritic,
    };

    const jogos = await Jogo.getAll(filters);
    res.json({
      success: true,
      count: jogos.length,
      data: jogos,
    });
  } catch (error) {
    res.status(500).json({
      success: false,
      message: "Erro ao obter jogos",
      error: error.message,
    });
  }
};

// GET /api/jogos/:id - Obter jogo por ID
exports.getById = async (req, res) => {
  try {
    const jogo = await Jogo.getById(req.params.id);

    if (!jogo) {
      return res.status(404).json({
        success: false,
        message: "Jogo não encontrado",
      });
    }

    res.json({
      success: true,
      data: jogo,
    });
  } catch (error) {
    res.status(500).json({
      success: false,
      message: "Erro ao obter jogo",
      error: error.message,
    });
  }
};

// POST /api/jogos - Criar novo jogo
exports.create = async (req, res) => {
  try {
    const {
      title,
      metacritic_rating,
      release_year,
      game_image,
      consoles,
      genres,
    } = req.body;

    // Validação básica
    if (!title) {
      return res.status(400).json({
        success: false,
        message: "O título é obrigatório",
      });
    }

    if (!consoles || consoles.length === 0) {
      return res.status(400).json({
        success: false,
        message: "Selecione pelo menos uma consola",
      });
    }

    if (!genres || genres.length === 0) {
      return res.status(400).json({
        success: false,
        message: "Selecione pelo menos um género",
      });
    }

    const jogoId = await Jogo.create(req.body);
    const novoJogo = await Jogo.getById(jogoId);

    res.status(201).json({
      success: true,
      message: "Jogo criado com sucesso",
      data: novoJogo,
    });
  } catch (error) {
    res.status(500).json({
      success: false,
      message: "Erro ao criar jogo",
      error: error.message,
    });
  }
};

// PUT /api/jogos/:id - Atualizar jogo
exports.update = async (req, res) => {
  try {
    const {
      title,
      metacritic_rating,
      release_year,
      game_image,
      consoles,
      genres,
    } = req.body;

    // Validação básica
    if (!title) {
      return res.status(400).json({
        success: false,
        message: "O título é obrigatório",
      });
    }

    // Verificar se o jogo existe
    const jogoExiste = await Jogo.getById(req.params.id);
    if (!jogoExiste) {
      return res.status(404).json({
        success: false,
        message: "Jogo não encontrado",
      });
    }

    await Jogo.update(req.params.id, req.body);
    const jogoAtualizado = await Jogo.getById(req.params.id);

    res.json({
      success: true,
      message: "Jogo atualizado com sucesso",
      data: jogoAtualizado,
    });
  } catch (error) {
    res.status(500).json({
      success: false,
      message: "Erro ao atualizar jogo",
      error: error.message,
    });
  }
};

// DELETE /api/jogos/:id - Eliminar jogo
exports.delete = async (req, res) => {
  try {
    // Verificar se o jogo existe
    const jogo = await Jogo.getById(req.params.id);
    if (!jogo) {
      return res.status(404).json({
        success: false,
        message: "Jogo não encontrado",
      });
    }

    await Jogo.delete(req.params.id);

    res.json({
      success: true,
      message: "Jogo eliminado com sucesso",
      data: jogo,
    });
  } catch (error) {
    res.status(500).json({
      success: false,
      message: "Erro ao eliminar jogo",
      error: error.message,
    });
  }
};
