
CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tree_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tree_id` (`tree_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=79 ;

CREATE TABLE IF NOT EXISTS `tree` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lft` int(11) NOT NULL,
  `rgt` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=139 ;

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `passhash` varchar(128) NOT NULL,
  `salt` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

ALTER TABLE `category`
  ADD CONSTRAINT `category_ibfk_1` FOREIGN KEY (`tree_id`) REFERENCES `tree` (`id`);
SET FOREIGN_KEY_CHECKS=1;

INSERT INTO `tree` (`id`, `lft`, `rgt`) VALUES
(134, 0, 9),
(135, 1, 2),
(136, 3, 8),
(137, 4, 7),
(138, 5, 6);

INSERT INTO `category` (`id`, `tree_id`, `name`) VALUES
(72, 135, 'Home'),
(73, 136, 'Categorien'),
(74, 137, 'Huizen'),
(75, 138, 'Kamer'),
(78, 134, 'Navigation');
