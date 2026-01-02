const db = require("../config/database");

class Console {
  // GET - Listar todas as consolas
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

  // GET - Obter consola por ID
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

  // GET - Obter consolas de um jogo específico
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
