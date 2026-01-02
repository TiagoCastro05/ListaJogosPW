const express = require("express");
const router = express.Router();
const consoleController = require("../controllers/consoleController");

/**
 * @swagger
 * components:
 *   schemas:
 *     Console:
 *       type: object
 *       properties:
 *         id:
 *           type: integer
 *         console_name:
 *           type: string
 */

/**
 * @swagger
 * tags:
 *   name: Consoles
 *   description: API para gestão de consolas
 */

/**
 * @swagger
 * /api/consoles:
 *   get:
 *     summary: Listar todas as consolas
 *     tags: [Consoles]
 *     responses:
 *       200:
 *         description: Lista de consolas
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
 *                     $ref: '#/components/schemas/Console'
 */
router.get("/", consoleController.getAll);

/**
 * @swagger
 * /api/consoles/{id}:
 *   get:
 *     summary: Obter consola por ID
 *     tags: [Consoles]
 *     parameters:
 *       - in: path
 *         name: id
 *         required: true
 *         schema:
 *           type: integer
 *     responses:
 *       200:
 *         description: Consola encontrada
 *       404:
 *         description: Consola não encontrada
 */
router.get("/:id", consoleController.getById);

module.exports = router;
