const db = require("../config/database");

class Jogo {
  // GET - Listar todos os jogos
  static async getAll(filters = {}) {
    try {
      let query = `
        SELECT j.*, 
          GROUP_CONCAT(DISTINCT c.console_name ORDER BY c.console_name SEPARATOR ', ') as consoles,
          GROUP_CONCAT(DISTINCT g.genre ORDER BY g.genre SEPARATOR ', ') as genres
        FROM jogos j
        LEFT JOIN jogo_consoles jc ON j.id = jc.jogo_id
        LEFT JOIN consoles c ON jc.console_id = c.id
        LEFT JOIN jogo_genres jg ON j.id = jg.jogo_id
        LEFT JOIN genres g ON jg.genre_id = g.id
        WHERE 1=1
      `;
      const params = [];

      // Filtros opcionais
      if (filters.title) {
        query += " AND j.title LIKE ?";
        params.push(`%${filters.title}%`);
      }
      if (filters.year) {
        query += " AND j.release_year = ?";
        params.push(filters.year);
      }
      if (filters.minMetacritic) {
        query += " AND j.metacritic_rating >= ?";
        params.push(filters.minMetacritic);
      }

      query += " GROUP BY j.id ORDER BY j.title";

      const [rows] = await db.query(query, params);
      return rows;
    } catch (error) {
      throw error;
    }
  }

  // GET - Obter jogo por ID
  static async getById(id) {
    try {
      const [rows] = await db.query("SELECT * FROM jogos WHERE id = ?", [id]);
      if (rows.length === 0) return null;

      const jogo = rows[0];

      // Obter consolas do jogo
      const [consoles] = await db.query(
        `
        SELECT c.* FROM consoles c
        INNER JOIN jogo_consoles jc ON c.id = jc.console_id
        WHERE jc.jogo_id = ?
      `,
        [id]
      );

      // Obter géneros do jogo
      const [genres] = await db.query(
        `
        SELECT g.* FROM genres g
        INNER JOIN jogo_genres jg ON g.id = jg.genre_id
        WHERE jg.jogo_id = ?
      `,
        [id]
      );

      jogo.consoles = consoles;
      jogo.genres = genres;

      return jogo;
    } catch (error) {
      throw error;
    }
  }

  // POST - Criar novo jogo
  static async create(jogoData) {
    const connection = await db.getConnection();
    try {
      await connection.beginTransaction();

      // Inserir jogo
      const [result] = await connection.query(
        "INSERT INTO jogos (title, metacritic_rating, release_year, game_image) VALUES (?, ?, ?, ?)",
        [
          jogoData.title,
          jogoData.metacritic_rating,
          jogoData.release_year,
          jogoData.game_image,
        ]
      );

      const jogoId = result.insertId;

      // Inserir relações com consolas
      if (jogoData.consoles && jogoData.consoles.length > 0) {
        const consoleValues = jogoData.consoles.map((consoleId) => [
          jogoId,
          consoleId,
        ]);
        await connection.query(
          "INSERT INTO jogo_consoles (jogo_id, console_id) VALUES ?",
          [consoleValues]
        );
      }

      // Inserir relações com géneros
      if (jogoData.genres && jogoData.genres.length > 0) {
        const genreValues = jogoData.genres.map((genreId) => [jogoId, genreId]);
        await connection.query(
          "INSERT INTO jogo_genres (jogo_id, genre_id) VALUES ?",
          [genreValues]
        );
      }

      await connection.commit();
      return jogoId;
    } catch (error) {
      await connection.rollback();
      throw error;
    } finally {
      connection.release();
    }
  }

  // PUT - Atualizar jogo
  static async update(id, jogoData) {
    const connection = await db.getConnection();
    try {
      await connection.beginTransaction();

      // Atualizar dados básicos do jogo
      await connection.query(
        "UPDATE jogos SET title = ?, metacritic_rating = ?, release_year = ?, game_image = ? WHERE id = ?",
        [
          jogoData.title,
          jogoData.metacritic_rating,
          jogoData.release_year,
          jogoData.game_image,
          id,
        ]
      );

      // Remover relações antigas
      await connection.query("DELETE FROM jogo_consoles WHERE jogo_id = ?", [
        id,
      ]);
      await connection.query("DELETE FROM jogo_genres WHERE jogo_id = ?", [id]);

      // Inserir novas relações com consolas
      if (jogoData.consoles && jogoData.consoles.length > 0) {
        const consoleValues = jogoData.consoles.map((consoleId) => [
          id,
          consoleId,
        ]);
        await connection.query(
          "INSERT INTO jogo_consoles (jogo_id, console_id) VALUES ?",
          [consoleValues]
        );
      }

      // Inserir novas relações com géneros
      if (jogoData.genres && jogoData.genres.length > 0) {
        const genreValues = jogoData.genres.map((genreId) => [id, genreId]);
        await connection.query(
          "INSERT INTO jogo_genres (jogo_id, genre_id) VALUES ?",
          [genreValues]
        );
      }

      await connection.commit();
      return true;
    } catch (error) {
      await connection.rollback();
      throw error;
    } finally {
      connection.release();
    }
  }

  // DELETE - Eliminar jogo
  static async delete(id) {
    const connection = await db.getConnection();
    try {
      await connection.beginTransaction();

      // Eliminar relações
      await connection.query("DELETE FROM jogo_consoles WHERE jogo_id = ?", [
        id,
      ]);
      await connection.query("DELETE FROM jogo_genres WHERE jogo_id = ?", [id]);

      // Eliminar jogo
      const [result] = await connection.query(
        "DELETE FROM jogos WHERE id = ?",
        [id]
      );

      await connection.commit();
      return result.affectedRows > 0;
    } catch (error) {
      await connection.rollback();
      throw error;
    } finally {
      connection.release();
    }
  }
}

module.exports = Jogo;
