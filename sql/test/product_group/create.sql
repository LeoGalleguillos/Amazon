CREATE TABLE `product_group` (
      `product_group_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
      `name` varchar(255) NOT NULL,
      `slug` varchar(255) NOT NULL,
      `search_table` varchar(255) DEFAULT NULL,
      PRIMARY KEY (`product_group_id`),
      UNIQUE KEY `slug` (`slug`),
      UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
