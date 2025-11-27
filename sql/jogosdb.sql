CREATE DATABASE IF NOT EXISTS `jogosdb` DEFAULT CHARACTER SET utf8mb4 ;
USE `jogosdb` ;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `jogosdb`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `consoles`
--

CREATE TABLE `consoles` (
  `id` int(11) NOT NULL,
  `console_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `consoles`
--

INSERT INTO `consoles` (`id`, `console_name`) VALUES
(1, 'PC'),
(2, 'PlayStation 5'),
(3, 'PlayStation 4'),
(4, 'PlayStation 3'),
(5, 'PlayStation 2'),
(6, 'PlayStation 1'),
(7, 'PSP'),
(8, 'PS Vita'),
(9, 'Xbox Series X'),
(10, 'Xbox Series S'),
(11, 'Xbox One'),
(12, 'Xbox 360'),
(13, 'Xbox'),
(14, 'Nintendo Switch'),
(15, 'Nintendo Wii U'),
(16, 'Nintendo Wii'),
(17, 'Nintendo GameCube'),
(18, 'Nintendo 64'),
(19, 'Super Nintendo'),
(20, 'NES'),
(21, 'Game Boy'),
(22, 'Game Boy Color'),
(23, 'Game Boy Advance'),
(24, 'Nintendo DS'),
(25, 'Nintendo 3DS'),
(26, 'Sega Genesis'),
(27, 'Sega Saturn'),
(28, 'Sega Dreamcast');

-- --------------------------------------------------------

--
-- Estrutura da tabela `genres`
--

CREATE TABLE `genres` (
  `id` int(11) NOT NULL,
  `genre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `genres`
--

INSERT INTO `genres` (`id`, `genre`) VALUES
(1, 'Action'),
(2, 'Action Adventure'),
(3, 'Adventure'),
(4, 'Puzzle'),
(5, 'Arcade'),
(6, 'Roguelike'),
(7, 'Gambling'),
(8, 'First-Person Shooter'),
(9, 'MMORPG'),
(10, 'Fighting'),
(11, 'Platformer'),
(12, 'RPG'),
(13, 'Racing'),
(14, 'SandBox'),
(15, 'Sports'),
(16, 'Survival'),
(17, 'Strategy'),
(18, 'Multiplayer'),
(19, 'Turn-Based Strategy'),
(20, 'Third-Person Shooter'),
(21, 'Simulation'),
(22, 'Horror'),
(23, 'SinglePlayer');

-- --------------------------------------------------------

--
-- Estrutura da tabela `jogos`
--

CREATE TABLE `jogos` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `metacritic_rating` varchar(255) DEFAULT NULL,
  `release_year` varchar(255) DEFAULT NULL,
  `game_image` varchar(4000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `jogos`
--

INSERT INTO `jogos` (`id`, `title`, `metacritic_rating`, `release_year`, `game_image`) VALUES
(1, 'The Legend of Zelda: Ocarina of Time', '99', '1998', 'https://m.media-amazon.com/images/M/MV5BNGVjMjgxZWEtYTUyNi00MTE3LWFjYWMtMjM3ZGQzMDQ3NGI3XkEyXkFqcGc@._V1_FMjpg_UX1000_.jpg'),
(2, 'SoulCaliber', '98', '1999', ''),
(3, 'Grand Theft Auto IV', '98', '2008', ''),
(4, 'Super Mario Galaxy', '97', '2007', ''),
(5, 'Super Mario Galaxy 2', '97', '2010', ''),
(6, 'The Legend of Zelda: Breath of the Wild', '97', '2017', ''),
(7, 'Perfect Dark', '97', '2000', ''),
(8, 'Red Dead Redemption 2', '97', '2018', ''),
(9, 'Resident Evil 4', '96', '2005', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `jogo_consoles`
--

CREATE TABLE `jogo_consoles` (
  `jogo_id` int(11) NOT NULL,
  `console_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `jogo_consoles`
--

INSERT INTO `jogo_consoles` (`jogo_id`, `console_id`) VALUES
(1, 18),
(2, 28),
(3, 1),
(3, 4),
(3, 12),
(4, 16),
(5, 16),
(6, 14),
(6, 15),
(7, 12),
(7, 18),
(8, 1),
(8, 3),
(8, 11),
(9, 17);

-- --------------------------------------------------------

--
-- Estrutura da tabela `jogo_genres`
--

CREATE TABLE `jogo_genres` (
  `jogo_id` int(11) NOT NULL,
  `genre_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `jogo_genres`
--

INSERT INTO `jogo_genres` (`jogo_id`, `genre_id`) VALUES
(1, 3),
(2, 10),
(3, 1),
(3, 3),
(4, 3),
(4, 11),
(5, 3),
(5, 11),
(6, 3),
(6, 12),
(7, 8),
(8, 1),
(8, 12),
(9, 1),
(9, 22);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `consoles`
--
ALTER TABLE `consoles`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `jogos`
--
ALTER TABLE `jogos`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `jogo_consoles`
--
ALTER TABLE `jogo_consoles`
  ADD PRIMARY KEY (`jogo_id`,`console_id`),
  ADD KEY `console_id` (`console_id`);

--
-- Índices para tabela `jogo_genres`
--
ALTER TABLE `jogo_genres`
  ADD PRIMARY KEY (`jogo_id`,`genre_id`),
  ADD KEY `genre_id` (`genre_id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `consoles`
--
ALTER TABLE `consoles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de tabela `jogos`
--
ALTER TABLE `jogos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `jogo_consoles`
--
ALTER TABLE `jogo_consoles`
  ADD CONSTRAINT `jogo_consoles_ibfk_1` FOREIGN KEY (`jogo_id`) REFERENCES `jogos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `jogo_consoles_ibfk_2` FOREIGN KEY (`console_id`) REFERENCES `consoles` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `jogo_genres`
--
ALTER TABLE `jogo_genres`
  ADD CONSTRAINT `jogo_genres_ibfk_1` FOREIGN KEY (`jogo_id`) REFERENCES `jogos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `jogo_genres_ibfk_2` FOREIGN KEY (`genre_id`) REFERENCES `genres` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
