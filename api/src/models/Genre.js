const db = require("../config/database");

class Genre {
  // GET - Listar todos os géneros
  static async getAll() {
    try {
      const [rows] = await db.query("SELECT * FROM genres ORDER BY genre");
      return rows;
    } catch (error) {
      throw error;
    }
  }

  // GET - Obter género por ID
  static async getById(id) {
    try {
      const [rows] = await db.query("SELECT * FROM genres WHERE id = ?", [id]);
      return rows.length > 0 ? rows[0] : null;
    } catch (error) {
      throw error;
    }
  }

  // GET - Obter géneros de um jogo específico
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
