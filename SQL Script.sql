-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Machine: 127.0.0.1
-- Gegenereerd op: 09 jun 2014 om 16:12
-- Serverversie: 5.6.16
-- PHP-versie: 5.5.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databank: `wsm`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tree_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tree_id` (`tree_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=79 ;

--
-- Gegevens worden uitgevoerd voor tabel `category`
--

INSERT INTO `category` (`id`, `tree_id`, `name`) VALUES
(72, 135, 'Home'),
(73, 136, 'Categorien'),
(74, 137, 'Huizen'),
(75, 138, 'Kamer'),
(78, 134, 'Navigation');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `content`
--

CREATE TABLE IF NOT EXISTS `content` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `page` varchar(65) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `page` (`page`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Gegevens worden uitgevoerd voor tabel `content`
--

INSERT INTO `content` (`id`, `page`, `content`) VALUES
(1, 'home', '<h2>Wie</h2>\r\n<p>Dit is de website van het <em>World Wide Fund for Nature</em></p>\r\n<h2>Waarom</h2>\r\n<p>De Stichting stelt zich ten doel het bevorderen van natuurbehoud en natuurontwikkeling.\r\nDe Stichting tracht haar doel te bereiken door het bijeenbrengen van gelden en door het verrichten van alle overige handelingen die voor haar doelstelling dienstig zijn, waaronder voorlichting en educatie.</p>'),
(2, 'contact', '<h1>Contact <small>opnemen</small></h1>\r\nHeb je een vraag aan het WWF?\r\nStuur ons gerust een berichtje via onderstaand formulier. Wij zullen zo spoedig mogelijk je vraag in behandeling nemen.');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `event`
--

CREATE TABLE IF NOT EXISTS `event` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `time` datetime NOT NULL,
  `shortdesc` tinytext NOT NULL,
  `longdesc` text NOT NULL,
  `email` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Gegevens worden uitgevoerd voor tabel `event`
--

INSERT INTO `event` (`id`, `title`, `time`, `shortdesc`, `longdesc`, `email`) VALUES
(4, 'Panda''s uitzetten', '2014-08-06 13:00:00', 'Uit zetten van panda''s terug in de natuur', 'Alle panda''s zijn inmiddels op geknapt en kunnen weer vrijgelaten worden in de natuur.\r\nHet WWF zal de panda''s gaat de panda''s vrijlaten op een natuur reservaat in China.', 'parberen@student.avans.nl'),
(5, 'Zeehondjes saien', '2014-06-08 12:00:00', 'Aaien van tamme zeehondjes', 'Heb je altijd al zeehondjes willen knuffelen?\r\nHet WWF organiseert een open dag in het zeehonden opvang centrum.\r\n\r\nDus kom ook en krijg een kans om een zeehondje te aaien!', 'parberen@student.avans.nl');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `image`
--

CREATE TABLE IF NOT EXISTS `image` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `path` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Gegevens worden uitgevoerd voor tabel `image`
--

INSERT INTO `image` (`id`, `path`) VALUES
(10, '9c3dcb1f9185a314ea25d51aed3b5881b32f420c'),
(11, '3b15be84aff20b322a93c0b9aaa62e25ad33b4b4'),
(12, 'df7be9dc4f467187783aca68c7ce98e4df2172d0');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `tree`
--

CREATE TABLE IF NOT EXISTS `tree` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lft` int(11) NOT NULL,
  `rgt` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=139 ;

--
-- Gegevens worden uitgevoerd voor tabel `tree`
--

INSERT INTO `tree` (`id`, `lft`, `rgt`) VALUES
(134, 0, 9),
(135, 1, 2),
(136, 3, 8),
(137, 4, 7),
(138, 5, 6);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `passhash` varchar(128) NOT NULL,
  `salt` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Gegevens worden uitgevoerd voor tabel `user`
--

INSERT INTO `user` (`id`, `name`, `passhash`, `salt`) VALUES
(2, 'Patrick', 'cc66c127b541db896fd4ba750f8cb0d105b2f94a3ec9d22e09212680e619c5c569b1266853bc97795043acffa17a11c0ffca4caa2caad7adca6d6b7562414ae8', '963932192');

--
-- Beperkingen voor gedumpte tabellen
--

--
-- Beperkingen voor tabel `category`
--
ALTER TABLE `category`
  ADD CONSTRAINT `category_ibfk_1` FOREIGN KEY (`tree_id`) REFERENCES `tree` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
