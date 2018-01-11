CREATE TABLE `search_product_group_toy` (
      `product_id` int(10) unsigned NOT NULL,
      `title` varchar(255) NOT NULL,
      `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      KEY `modified` (`modified`),
      KEY `product_id` (`product_id`),
      FULLTEXT KEY `title` (`title`),
      CONSTRAINT `product_id` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
