--
-- Database: 'camagru'
--

DROP DATABASE IF EXISTS camagru;
CREATE DATABASE camagru;
USE camagru;

-- --------------------------------------------------------

--
-- Table structure for table 'filter'
--

DROP TABLE IF EXISTS filter;
CREATE TABLE filter (
  id SERIAL PRIMARY KEY,
  title varchar(255) NOT NULL,
  url text NOT NULL,
  x int NOT NULL DEFAULT '0',
  y int NOT NULL DEFAULT '0'
);

--
-- Dumping data for table 'filter'
--

-- --------------------------------------------------------

--
-- Table structure for table 'user'
--

DROP TABLE IF EXISTS users;
CREATE TABLE users (
  id SERIAL PRIMARY KEY,
  pseudo varchar(30) NOT NULL,
  passwd varchar(255) NOT NULL,
  email varchar(255) NOT NULL,
  alert bool NOT NULL DEFAULT false,
  validkey varchar(32) NOT NULL,
  actif bool NOT NULL DEFAULT true
);

-- --------------------------------------------------------

--
-- Table structure for table 'img'
--

DROP TABLE IF EXISTS img;
CREATE TABLE img (
  id SERIAL PRIMARY KEY,
  title varchar(255) NOT NULL,
  author_id bigint UNSIGNED NOT NULL,
  nb_like int NOT NULL DEFAULT '0',
  url text NOT NULL,
  date date NOT NULL
);

ALTER TABLE img
ADD FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE CASCADE; 

-- --------------------------------------------------------

--
-- Table structure for table 'comment'
--
DROP TABLE IF EXISTS comments;
CREATE TABLE comments (
  id SERIAL PRIMARY KEY,
  img_id bigint UNSIGNED NOT NULL,
  author_id bigint UNSIGNED NOT NULL,
  date datetime NOT NULL,
  content text NOT NULL,
  FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (img_id) REFERENCES img(id) ON DELETE CASCADE
);

-- --------------------------------------------------------
--
-- Table structure for table 'likes'
--

DROP TABLE IF EXISTS likes;
CREATE TABLE likes (
  id SERIAL PRIMARY KEY,
  img_id bigint UNSIGNED NOT NULL,
  author_id bigint UNSIGNED NOT NULL,
  FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (img_id) REFERENCES img(id) ON DELETE CASCADE
);

INSERT INTO filter (id, title, url, x, y) VALUES
(1, 'troll', 'img/filter/trollface.png', 0, 0),
(3, 'mouton', 'img/filter/mouton.png', -19, 140),
(4, 'bambou', 'img/filter/bambou.png', 0, -8),
(5, 'flamme', 'img/filter/flamme.png', 2, 185);

INSERT INTO users (pseudo, passwd, validkey, email) VALUES
('troll2', 'test', 'aiue', 'lol@lol.fr');
