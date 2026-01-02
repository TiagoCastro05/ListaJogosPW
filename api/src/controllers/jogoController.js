/**
 * Controller Jogo - Lógica de negócio e gestão de pedidos HTTP para jogos
 *
 * Este controller gere todos os endpoints relacionados com jogos, incluindo
 * validação de dados, tratamento de erros e formatação de respostas.
 * Atua como camada intermédia entre as routes e o model Jogo.
 */

const Jogo = require("../models/Jogo");

/**
 * GET /api/jogos - Obtém lista de todos os jogos com filtros opcionais
 *
 * @param {Object} req.query.title - Filtro por título (pesquisa parcial)
 * @param {number} req.query.year - Filtro por ano de lançamento
 * @param {number} req.query.minMetacritic - Filtro por rating mínimo
 * @returns {Object} JSON com success, count e array de jogos
 */
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

/**
 * GET /api/jogos/:id - Obtém um jogo específico pelo ID
 *
 * @param {number} req.params.id - ID do jogo a obter
 * @returns {Object} JSON com success e dados do jogo (ou erro 404 se não encontrado)
 */
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

/**
 * POST /api/jogos - Cria um novo jogo
 *
 * Valida que o título, consolas e géneros são fornecidos.
 * Após criação bem-sucedida, retorna o jogo completo com todas as relações.
 *
 * @param {Object} req.body - Dados do novo jogo
 * @param {string} req.body.title - Título do jogo (obrigatório)
 * @param {Array<number>} req.body.consoles - IDs das consolas (obrigatório, mínimo 1)
 * @param {Array<number>} req.body.genres - IDs dos géneros (obrigatório, mínimo 1)
 * @param {number} req.body.metacritic_rating - Rating Metacritic (opcional)
 * @param {number} req.body.release_year - Ano de lançamento (opcional)
 * @param {string} req.body.game_image - URL da imagem (opcional)
 * @returns {Object} JSON com success, message e dados do jogo criado (status 201)
 */
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

/**
 * PUT /api/jogos/:id - Atualiza um jogo existente
 *
 * Valida que o jogo existe e que o título é fornecido.
 * Após atualização bem-sucedida, retorna o jogo atualizado com todas as relações.
 *
 * @param {number} req.params.id - ID do jogo a atualizar
 * @param {Object} req.body - Novos dados do jogo (mesma estrutura que POST)
 * @returns {Object} JSON com success, message e dados atualizados (ou erro 404 se não encontrado)
 */
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

/**
 * DELETE /api/jogos/:id - Elimina um jogo
 *
 * Valida que o jogo existe antes de eliminar.
 * Retorna os dados do jogo eliminado na resposta.
 *
 * @param {number} req.params.id - ID do jogo a eliminar
 * @returns {Object} JSON com success, message e dados do jogo eliminado (ou erro 404 se não encontrado)
 */
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
