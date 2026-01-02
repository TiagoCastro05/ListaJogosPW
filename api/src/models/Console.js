/**
 * Model Console - Representa consolas de videojogos na base de dados
 * Responsável por todas as operações relacionadas com a tabela 'consoles'
 */

const db = require("../config/database");

class Console {
  /**
   * Obtém todas as consolas da base de dados
   * @returns {Promise<Array>} Array de objetos console ordenados por nome
   * @throws {Error} Erro de base de dados
   */
  static async getAll() {
    try {
      const [rows] = await db.query(
        "SELECT * FROM consoles ORDER BY console_name"
      );
      return rows;
    } catch (error) {
      throw error;
    }
  }

  /**
   * Obtém uma consola específica pelo ID
   * @param {number} id - ID da consola
   * @returns {Promise<Object|null>} Objeto console ou null se não encontrado
   * @throws {Error} Erro de base de dados
   */
  static async getById(id) {
    try {
      const [rows] = await db.query("SELECT * FROM consoles WHERE id = ?", [
        id,
      ]);
      return rows.length > 0 ? rows[0] : null;
    } catch (error) {
      throw error;
    }
  }

  /**
   * Obtém todas as consolas associadas a um jogo específico
   * Faz JOIN com a tabela jogo_consoles (relação M:N)
   * @param {number} jogoId - ID do jogo
   * @returns {Promise<Array>} Array de consolas do jogo
   * @throws {Error} Erro de base de dados
   */
  static async getByJogoId(jogoId) {
    try {
      const [rows] = await db.query(
        `
        SELECT c.* FROM consoles c
        INNER JOIN jogo_consoles jc ON c.id = jc.console_id
        WHERE jc.jogo_id = ?
        ORDER BY c.console_name
      `,
        [jogoId]
      );
      return rows;
    } catch (error) {
      throw error;
    }
  }
}

module.exports = Console;
