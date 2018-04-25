--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `client_id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(32) NULL,
  `surname` varchar(32) NULL,
  `patronymic` varchar(32) NULL,
  `email` varchar(64) NULL,
  `password` varchar(80) NOT NULL,
  `reg_date` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `birth_day` DATE NULL,
  `last_activity` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`client_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Table structure for table `test_su`
--

/* CREATE TABLE `clients` (
  `client_id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(32) NULL,
  `surname` varchar(32) NULL,
  `patronymic` varchar(32) NULL,
  `mail` varchar(64) NULL,
  `password` varchar(80) NOT NULL,
  `reg_date` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `birth_day` DATE NULL,
  `last_activity` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`client_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
 */