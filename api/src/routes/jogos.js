const express = require("express");
const router = express.Router();
const jogoController = require("../controllers/jogoController");
const consoleController = require("../controllers/consoleController");
const genreController = require("../controllers/genreController");

/**
 * @swagger
 * components:
 *   schemas:
 *     Jogo:
 *       type: object
 *       required:
 *         - title
 *         - consoles
 *         - genres
 *       properties:
 *         id:
 *           type: integer
 *           description: ID auto-gerado do jogo
 *         title:
 *           type: string
 *           description: Título do jogo
 *         metacritic_rating:
 *           type: number
 *           description: Avaliação Metacritic (0-100)
 *         release_year:
 *           type: integer
 *           description: Ano de lançamento
 *         game_image:
 *           type: string
 *           description: URL da imagem do jogo
 *         consoles:
 *           type: array
 *           items:
 *             type: integer
 *           description: Array de IDs das consolas
 *         genres:
 *           type: array
 *           items:
 *             type: integer
 *           description: Array de IDs dos géneros
 *       example:
 *         title: The Legend of Zelda
 *         metacritic_rating: 95
 *         release_year: 2023
 *         game_image: https://example.com/zelda.jpg
 *         consoles: [1, 2]
 *         genres: [3, 5]
 */

/**
 * @swagger
 * tags:
 *   name: Jogos
 *   description: API para gestão de jogos
 */

/**
 * @swagger
 * /api/jogos:
 *   get:
 *     summary: Listar todos os jogos
 *     tags: [Jogos]
 *     parameters:
 *       - in: query
 *         name: title
 *         schema:
 *           type: string
 *         description: Filtrar por título
 *       - in: query
 *         name: year
 *         schema:
 *           type: integer
 *         description: Filtrar por ano
 *       - in: query
 *         name: minMetacritic
 *         schema:
 *           type: number
 *         description: Filtrar por Metacritic mínimo
 *     responses:
 *       200:
 *         description: Lista de jogos obtida com sucesso
 *         content:
 *           application/json:
 *             schema:
 *               type: object
 *               properties:
 *                 success:
 *                   type: boolean
 *                 count:
 *                   type: integer
 *                 data:
 *                   type: array
 *                   items:
 *                     $ref: '#/components/schemas/Jogo'
 */
router.get("/", jogoController.getAll);

/**
 * @swagger
 * /api/jogos/{id}:
 *   get:
 *     summary: Obter jogo por ID
 *     tags: [Jogos]
 *     parameters:
 *       - in: path
 *         name: id
 *         required: true
 *         schema:
 *           type: integer
 *         description: ID do jogo
 *     responses:
 *       200:
 *         description: Jogo encontrado
 *         content:
 *           application/json:
 *             schema:
 *               type: object
 *               properties:
 *                 success:
 *                   type: boolean
 *                 data:
 *                   $ref: '#/components/schemas/Jogo'
 *       404:
 *         description: Jogo não encontrado
 */
router.get("/:id", jogoController.getById);

/**
 * @swagger
 * /api/jogos:
 *   post:
 *     summary: Criar novo jogo
 *     tags: [Jogos]
 *     requestBody:
 *       required: true
 *       content:
 *         application/json:
 *           schema:
 *             $ref: '#/components/schemas/Jogo'
 *     responses:
 *       201:
 *         description: Jogo criado com sucesso
 *       400:
 *         description: Dados inválidos
 */
router.post("/", jogoController.create);

/**
 * @swagger
 * /api/jogos/{id}:
 *   put:
 *     summary: Atualizar jogo
 *     tags: [Jogos]
 *     parameters:
 *       - in: path
 *         name: id
 *         required: true
 *         schema:
 *           type: integer
 *     requestBody:
 *       required: true
 *       content:
 *         application/json:
 *           schema:
 *             $ref: '#/components/schemas/Jogo'
 *     responses:
 *       200:
 *         description: Jogo atualizado com sucesso
 *       404:
 *         description: Jogo não encontrado
 */
router.put("/:id", jogoController.update);

/**
 * @swagger
 * /api/jogos/{id}:
 *   delete:
 *     summary: Eliminar jogo
 *     tags: [Jogos]
 *     parameters:
 *       - in: path
 *         name: id
 *         required: true
 *         schema:
 *           type: integer
 *     responses:
 *       200:
 *         description: Jogo eliminado com sucesso
 *       404:
 *         description: Jogo não encontrado
 */
router.delete("/:id", jogoController.delete);

/**
 * @swagger
 * /api/jogos/{id}/consoles:
 *   get:
 *     summary: Obter consolas de um jogo
 *     tags: [Jogos]
 *     parameters:
 *       - in: path
 *         name: id
 *         required: true
 *         schema:
 *           type: integer
 *     responses:
 *       200:
 *         description: Lista de consolas do jogo
 */
router.get("/:id/consoles", consoleController.getByJogoId);

/**
 * @swagger
 * /api/jogos/{id}/genres:
 *   get:
 *     summary: Obter géneros de um jogo
 *     tags: [Jogos]
 *     parameters:
 *       - in: path
 *         name: id
 *         required: true
 *         schema:
 *           type: integer
 *     responses:
 *       200:
 *         description: Lista de géneros do jogo
 */
router.get("/:id/genres", genreController.getByJogoId);

module.exports = router;
