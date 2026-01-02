/**
 * Model Jogo - Operações de base de dados para jogos
 * 
 * Este model gere todas as operações CRUD (Create, Read, Update, Delete) 
 * relacionadas com jogos, incluindo as relações many-to-many com consolas e géneros.
 * Utiliza transações de base de dados para garantir a integridade dos dados.
 */

const db = require("../config/database");

class Jogo {
  /**
   * Obtém todos os jogos da base de dados com filtros opcionais
   * 
   * Executa uma query com múltiplos JOINs para obter os jogos juntamente com 
   * as suas consolas e géneros associados. Os resultados são agrupados por jogo
   * e as consolas/géneros são concatenados numa string separada por vírgulas.
   * 
   * @param {Object} filters - Objeto com filtros opcionais
   * @param {string} filters.title - Filtro por título (pesquisa parcial LIKE)
   * @param {number} filters.year - Filtro por ano de lançamento (igualdade exata)
   * @param {number} filters.minMetacritic - Filtro por rating mínimo Metacritic (>=)
   * @returns {Promise<Array>} Array de objetos de jogos com consolas e géneros
   * @throws {Error} Lança erro se a query falhar
   */
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

  /**
   * Obtém um jogo específico pelo seu ID com todas as relações
   * 
   * Primeiro obtém os dados básicos do jogo, depois executa queries adicionais
   * para obter as consolas e géneros associados através das tabelas de relação.
   * Retorna um objeto completo com todos os dados e relações do jogo.
   * 
   * @param {number} id - ID do jogo a obter
   * @returns {Promise<Object|null>} Objeto do jogo com arrays de consolas e géneros, ou null se não encontrado
   * @throws {Error} Lança erro se a query falhar
   */
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

  /**
   * Cria um novo jogo na base de dados com as suas relações
   * 
   * Utiliza uma transação de base de dados para garantir que todas as operações
   * são executadas com sucesso ou todas falham (atomicidade). Primeiro insere
   * o jogo na tabela principal, depois insere as relações com consolas e géneros
   * nas tabelas de junção many-to-many.
   * 
   * @param {Object} jogoData - Dados do novo jogo
   * @param {string} jogoData.title - Título do jogo (obrigatório)
   * @param {number} jogoData.metacritic_rating - Rating Metacritic (opcional)
   * @param {number} jogoData.release_year - Ano de lançamento (opcional)
   * @param {string} jogoData.game_image - URL da imagem do jogo (opcional)
   * @param {Array<number>} jogoData.consoles - Array de IDs de consolas (opcional)
   * @param {Array<number>} jogoData.genres - Array de IDs de géneros (opcional)
   * @returns {Promise<number>} ID do jogo criado
   * @throws {Error} Lança erro e faz rollback da transação se algo falhar
   */
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
   **
   * Atualiza um jogo existente e as suas relações
   * 
   * Utiliza uma transação para atualizar os dados básicos do jogo e substituir
   * completamente as relações com consolas e géneros. Remove todas as relações
   * antigas e insere as novas, garantindo que o estado final reflete exatamente
   * os dados fornecidos.
   * 
   * @param {number} id - ID do jogo a atualizar
   * @param {Object} jogoData - Novos dados do jogo (mesma estrutura que create)
   * @param {string} jogoData.title - Título do jogo
   * @param {number} jogoData.metacritic_rating - Rating Metacritic
   * @param {number} jogoData.release_year - Ano de lançamento
   * @param {string} jogoData.game_image - URL da imagem
   * @param {Array<number>} jogoData.consoles - Array de IDs de consolas
   * @param {Array<number>} jogoData.genres - Array de IDs de géneros
   * @returns {Promise<boolean>} true se atualizado com sucesso
   * @throws {Error} Lança erro e faz rollback da transação se algo falhar
   */ = jogoData.genres.map((genreId) => [jogoId, genreId]);
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
   **
   * Elimina um jogo e todas as suas relações da base de dados
   * 
   * Utiliza uma transação para garantir que tanto as relações (consolas e géneros)
   * como o registo do jogo são eliminados. A ordem é importante: primeiro eliminam-se
   * as relações nas tabelas de junção, depois o jogo principal.
   * 
   * @param {number} id - ID do jogo a eliminar
   * @returns {Promise<boolean>} true se eliminado com sucesso, false se o jogo não existia
   * @throws {Error} Lança erro e faz rollback da transação se algo falhar
   */& jogoData.genres.length > 0) {
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
