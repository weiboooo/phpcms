DROP TABLE IF EXISTS `phpcms_mobile`;
CREATE TABLE IF NOT EXISTS `phpcms_mobile` (
  `siteid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `sitename` varchar(100) NOT NULL,
  `logo` varchar(100) DEFAULT NULL,
  `domain` varchar(100) DEFAULT NULL,
  `status` tinyint(2) DEFAULT NULL,
  `keywords` varchar(100) DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`siteid`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `phpcms_mobile_cate`;
CREATE TABLE IF NOT EXISTS `phpcms_mobile_cate` (
  `catid` smallint(5) unsigned NOT NULL,
  `parentid` smallint(5) NOT NULL,
  `catname` varchar(30) NOT NULL,
  `siteid` smallint(5) unsigned NOT NULL,
  `listorder` smallint(5) unsigned NOT NULL DEFAULT '0',
  `type` tinyint(1) unsigned NOT NULL,
  `url` varchar(100) NOT NULL,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `child` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`catid`)
) TYPE=MyISAM;

INSERT INTO `phpcms_mobile` (`siteid`, `sitename`, `logo`, `domain`,  `status`) VALUES(1,'手机门户', '', '', 1);
