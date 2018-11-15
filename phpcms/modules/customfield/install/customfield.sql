CREATE TABLE `phpcms_customfield` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL,
  `siteid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `description` char(50) NOT NULL,
  `name` char(30) NOT NULL,
  `val` text NOT NULL,
  `conf` char(255) NOT NULL,
  `listorder` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pos` (`name`),
  KEY `siteid` (`siteid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
INSERT INTO `phpcms_customfield` VALUES ('1', '0', '1', '分页配置', '', '', 'array (\n  \'status\' => \'1\',\n)', '0');
INSERT INTO `phpcms_customfield` VALUES ('2', '0', '1', '联系方式', '', '', 'array (\n  \'status\' => \'1\',\n)', '0');
INSERT INTO `phpcms_customfield` VALUES ('3', '1', '1', '新闻分页数', 'pages_news', '1', 'array (\n  \'status\' => \'1\',\n  \'textarea\' => \'0\',\n)', '0');
INSERT INTO `phpcms_customfield` VALUES ('4', '1', '1', '产品分页数', 'pages_pro', '2', 'array (\n  \'status\' => \'1\',\n  \'textarea\' => \'0\',\n)', '0');
INSERT INTO `phpcms_customfield` VALUES ('5', '1', '1', '案例分页数', 'pages_case', '3', 'array (\n  \'status\' => \'1\',\n  \'textarea\' => \'0\',\n)', '0');
INSERT INTO `phpcms_customfield` VALUES ('6', '2', '1', '姓名', 'contact_name', '张三', 'array (\n  \'status\' => \'1\',\n  \'textarea\' => \'0\',\n)', '0');
INSERT INTO `phpcms_customfield` VALUES ('7', '2', '1', '电话', 'contact_mob', '13312341234', 'array (\n  \'status\' => \'1\',\n  \'textarea\' => \'0\',\n)', '0');
INSERT INTO `phpcms_customfield` VALUES ('8', '2', '1', '邮箱', 'contact_mail', 'example@example.com', 'array (\n  \'status\' => \'1\',\n  \'textarea\' => \'0\',\n)', '0');
INSERT INTO `phpcms_customfield` VALUES ('9', '2', '1', 'QQ', 'contact_qq', '123456789', 'array (\n  \'status\' => \'1\',\n  \'textarea\' => \'0\',\n)', '0');
INSERT INTO `phpcms_customfield` VALUES ('10', '2', '1', '地址', 'conact_adress', '三里屯位于北京市朝阳区中西部。<br />\r\n因距内城三里而得名。现在因三里屯酒吧街而闻名。<br />\r\n三里屯酒吧街是北京夜生活最“繁华”的娱乐街之一，是居住北京地区的老外们以及国内名流大款经常光顾娱乐的地方。', 'array (\n  \'status\' => \'1\',\n  \'textarea\' => \'1\',\n)', '0');
