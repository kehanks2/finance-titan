-- Database: `messages`


CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_to` int(11) NOT NULL,
  `user_from` int(11) NOT NULL,
  `subject` varchar(100) CHARACTER SET latin1 NOT NULL,
  `message` text CHARACTER SET latin1 NOT NULL,
  `respond` int(11) NOT NULL DEFAULT '0',
  `sender_open` enum('y','n') CHARACTER SET latin1 NOT NULL DEFAULT 'y',
  `receiver_open` enum('y','n') CHARACTER SET latin1 NOT NULL DEFAULT 'n',
  `sender_delete` enum('y','n') CHARACTER SET latin1 NOT NULL DEFAULT 'n',
  `receiver_delete` enum('y','n') CHARACTER SET latin1 NOT NULL DEFAULT 'n',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;
