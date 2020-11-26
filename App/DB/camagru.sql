--
-- Database: 'camagru'
--

SET AUTOCOMMIT = 0;
START TRANSACTION;

-- DROP DATABASE IF EXISTS camagru;
-- CREATE DATABASE camagru;
-- USE camagru;

-- --------------------------------------------------------

--
-- Table structure for table 'filter'
--

DROP TABLE IF EXISTS comments;
DROP TABLE IF EXISTS likes;
DROP TABLE IF EXISTS img;
DROP TABLE IF EXISTS filter;
DROP TABLE IF EXISTS users;

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

CREATE TABLE img (
  id SERIAL PRIMARY KEY,
  title varchar(255) NOT NULL,
  author_id bigint UNSIGNED NOT NULL,
  url text NOT NULL,
  cloudinary_id varchar(255),
  date date NOT NULL
);

ALTER TABLE img
ADD FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE CASCADE; 

-- --------------------------------------------------------

--
-- Table structure for table 'comment'
--

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

CREATE TABLE likes (
  id SERIAL PRIMARY KEY,
  img_id bigint UNSIGNED NOT NULL,
  author_id bigint UNSIGNED NOT NULL,
  FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (img_id) REFERENCES img(id) ON DELETE CASCADE
);

INSERT INTO filter (id, title, url, x, y) VALUES
(1, 'troll', 'public/img/filter/trollface.png', 0, 0),
(2, 'rick', 'public/img/filter/rick.png', 0, 0),
(3, 'mouton', 'public/img/filter/mouton.png', 0, 0),
(4, 'bambou', 'public/img/filter/bambou.png', 0, 0),
(5, 'flamme', 'public/img/filter/flamme.png', 0, 0),
(6, 'rick2', 'public/img/filter/rick2.png', 0, 0),
(7, 'rick3', 'public/img/filter/rick3.png', 0, 0),
(8, 'rick4', 'public/img/filter/rick4.png', 0, 0),
(9, 'rick5', 'public/img/filter/rick5.png', 0, 0);

INSERT INTO users (pseudo, passwd, validkey, email) VALUES
('troll2', 'test', 'aiue', 'lol@lol.fr');

COMMIT;
