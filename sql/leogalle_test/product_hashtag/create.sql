CREATE TABLE `product_hashtag` (
      `product_hashtag_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
      `product_id` int(10) unsigned NOT NULL,
      `hashtag_id` int(10) unsigned NOT NULL,
      `product_group_id` int(10) unsigned DEFAULT NULL,
      `binding_id` int(10) unsigned DEFAULT NULL,
      `brand_id` int(10) unsigned DEFAULT NULL,
      PRIMARY KEY (`product_hashtag_id`),
      KEY `hashtag_id` (`hashtag_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
