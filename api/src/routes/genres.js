const express = require("express");
const router = express.Router();
const genreController = require("../controllers/genreController");

/**
 * @swagger
 * components:
 *   schemas:
 *     Genre:
 *       type: object
 *       properties:
 *         id:
 *           type: integer
 *         genre:
 *           type: string
 */

/**
 * @swagger
 * tags:
 *   name: Genres
 *   description: API para gestão de géneros
 */

/**
 * @swagger
 * /api/genres:
 *   get:
 *     summary: Listar todos os géneros
 *     tags: [Genres]
 *     responses:
 *       200:
 *         description: Lista de géneros
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
 *                     $ref: '#/components/schemas/Genre'
 */
router.get("/", genreController.getAll);

/**
 * @swagger
 * /api/genres/{id}:
 *   get:
 *     summary: Obter género por ID
 *     tags: [Genres]
 *     parameters:
 *       - in: path
 *         name: id
 *         required: true
 *         schema:
 *           type: integer
 *     responses:
 *       200:
 *         description: Género encontrado
 *       404:
 *         description: Género não encontrado
 */
router.get("/:id", genreController.getById);

module.exports = router;
