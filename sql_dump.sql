CREATE TABLE `admin` 
( `id` int(11) NOT NULL auto_increment, 
`login` varchar(255) NOT NULL default '', 
`password` varchar(255) NOT NULL default '', 
PRIMARY KEY (`id`)) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

CREATE TABLE `cat` 
( `id` smallint(4) NOT NULL auto_increment, 
`name` varchar(255) NOT NULL default '', 
`category` smallint(3) NOT NULL default '0', 
`short_review` varchar(255) default NULL, 
`price` int(11) NOT NULL default '0',
`date` date NOT NULL default '0000-00-00',
PRIMARY KEY (`id`), KEY `name` (`name`), 
                    KEY `short_review` (`short_review`), 
                    KEY `price` (`price`)) 
                    ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8 AUTO_INCREMENT=38 ;

CREATE TABLE `categories` 
( `id` smallint(3) NOT NULL auto_increment, 
	`category_name` varchar(255) NOT NULL default '', 
	`root_category` smallint(3) NOT NULL default '0', 
	PRIMARY KEY (`id`)) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

CREATE TABLE `clients` 
( `id` int(11) NOT NULL auto_increment, 
	`name` varchar(120) NOT NULL default '', 
	`phone` varchar(120) NOT NULL default '', 
	`email` varchar(64) NOT NULL default '', 
	`text` text, `date` date NOT NULL default '0000-00-00', 
	PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8 PACK_KEYS=0 CHECKSUM=1 AUTO_INCREMENT=1 ;

CREATE TABLE `tovar` 
( `id` int(11) NOT NULL auto_increment, 
	`id_clients` int(11) NOT NULL default '0', 
	`id_tovara` int(11) NOT NULL default '0', 
	`end` enum('yes','no') NOT NULL default 'no', 
	`date` date NOT NULL default '0000-00-00', 
	`time` time NOT NULL default '00:00:00', 
	PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8 PACK_KEYS=0 CHECKSUM=1 AUTO_INCREMENT=1 ;

CREATE TABLE `users` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`login` varchar(200)   NOT NULL,
`password` varchar(200)   NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

INSERT INTO `admin` VALUES (1, 'admin', '21232f297a57a5a743894a0e4a801fc3');
INSERT INTO `cat` VALUES (1, 'Супрастин', 1, 'Краткое описание', 105, '2019-01-06');
INSERT INTO `cat` VALUES (2, 'Цетрин', 1, 'Краткое описание', 200, '2019-01-06');
INSERT INTO `cat` VALUES (4, 'Лоратадин', 1, 'Краткое описание', 300, '2019-01-06');
INSERT INTO `cat` VALUES (6, 'Виброцил', 1, 'Краткое описание', 1000, '2019-01-06');
INSERT INTO `cat` VALUES (7, 'Кордиамин', 2, 'Краткое описание', 1000, '2019-01-06');
INSERT INTO `cat` VALUES (8, 'Активированный уголь', 2, 'Краткое описание', 250, '2019-01-06');
INSERT INTO `cat` VALUES (9, 'Дезал', 1, 'Краткое описание', 280, '2019-01-06');
INSERT INTO `cat` VALUES (10, 'какая-то акция, которую я не придумала', 3, 'Краткое описание', 280, '2019-01-06');
INSERT INTO `categories` VALUES (1, 'Аллергия', 0);
INSERT INTO `categories` VALUES (2, 'Отравления', 0);
INSERT INTO `categories` VALUES (3, 'Акции', 0);
