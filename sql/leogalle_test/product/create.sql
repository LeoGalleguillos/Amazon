CREATE TABLE `product` (
  `product_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `asin` varchar(10) NOT NULL,
  `title` varchar(255) NOT NULL,
  `product_group` varchar(255) NOT NULL,
  `binding` varchar(255) DEFAULT NULL,
  `brand` varchar(255) DEFAULT NULL,
  `list_price` float(16,2) DEFAULT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `similar_retrieved` datetime DEFAULT NULL,
  PRIMARY KEY (`product_id`),
  UNIQUE KEY `asin` (`asin`),
  KEY `product_group_modified` (`product_group`,`modified`),
  KEY `modified` (`modified`),
  KEY `product_group_binding_modified` (`product_group`,`binding`,`modified`),
  KEY `product_group_brand_modified` (`product_group`,`brand`,`modified`),
  KEY `product_group_binding_brand_modified` (`product_group`,`binding`,`brand`,`modified`),
  KEY `product_group_similar_retrieved` (`product_group`,`similar_retrieved`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8
