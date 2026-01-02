/**
 * Model Genre - Representa géneros de videojogos na base de dados
 * Responsável por todas as operações relacionadas com a tabela 'genres'
 */

const db = require("../config/database");

class Genre {
  /**
   * Obtém todos os géneros da base de dados
   * @returns {Promise<Array>} Array de objetos genre ordenados por nome
   * @throws {Error} Erro de base de dados
   */
  static async getAll() {
    try {
      const [rows] = await db.query("SELECT * FROM genres ORDER BY genre");
      return rows;
    } catch (error) {
      throw error;
    }
  }

  /**
   * Obtém um género específico pelo ID
   * @param {number} id - ID do género
   * @returns {Promise<Object|null>} Objeto genre ou null se não encontrado
   * @throws {Error} Erro de base de dados
   */
  static async getById(id) {
    try {
      const [rows] = await db.query("SELECT * FROM genres WHERE id = ?", [id]);
      return rows.length > 0 ? rows[0] : null;
    } catch (error) {
      throw error;
    }
  }

  /**
   * Obtém todos os géneros associados a um jogo específico
   * Faz JOIN com a tabela jogo_genres (relação M:N)
   * @param {number} jogoId - ID do jogo
   * @returns {Promise<Array>} Array de géneros do jogo
   * @throws {Error} Erro de base de dados
   */
  static async getByJogoId(jogoId) {
    try {
      const [rows] = await db.query(
        `
        SELECT g.* FROM genres g
        INNER JOIN jogo_genres jg ON g.id = jg.genre_id
        WHERE jg.jogo_id = ?
        ORDER BY g.genre
      `,
        [jogoId]
      );
      return rows;
    } catch (error) {
      throw error;
    }
  }
}

module.exports = Genre;
