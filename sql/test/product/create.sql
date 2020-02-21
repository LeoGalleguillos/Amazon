CREATE TABLE `product` (
  `product_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `asin` varchar(10) NOT NULL,
  `title` TEXT NOT NULL,
  `product_group` varchar(255) NOT NULL,
  `binding` varchar(255) DEFAULT NULL,
  `brand` varchar(255) DEFAULT NULL,
  `part_number` varchar(127) DEFAULT NULL,
  `model` varchar(63) DEFAULT NULL,
  `warranty` varchar(1023) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  `is_adult_product` tinyint(1) unsigned DEFAULT NULL,
  `height_value` float(16,2) unsigned DEFAULT NULL,
  `height_units` varchar(16) DEFAULT NULL,
  `length_value` float(16,2) unsigned DEFAULT NULL,
  `length_units` varchar(16) DEFAULT NULL,
  `weight_value` float(16,2) unsigned DEFAULT NULL,
  `weight_units` varchar(31) DEFAULT NULL,
  `width_value` float(16,2) unsigned DEFAULT NULL,
  `width_units` varchar(16) DEFAULT NULL,
  `released` datetime DEFAULT NULL,
  `size` varchar(128) DEFAULT NULL,
  `unit_count` int(10) unsigned DEFAULT NULL,
  `list_price` float(16,2) unsigned DEFAULT NULL,
  `created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` DATETIME DEFAULT NULL,
  `hi_res_images_retrieved` datetime DEFAULT NULL,
  `similar_retrieved` datetime DEFAULT NULL,
  `video_generated` datetime DEFAULT NULL,
  `is_valid` tinyint(1) unsigned DEFAULT NULL,
  PRIMARY KEY (`product_id`),
  UNIQUE KEY `asin` (`asin`),
  KEY `product_group_modified` (`product_group`,`modified`),
  KEY `product_group_binding_modified` (`product_group`,`binding`,`modified`),
  KEY `product_group_brand_modified` (`product_group`,`brand`,`modified`),
  KEY `product_group_binding_brand_modified` (`product_group`,`binding`,`brand`,`modified`),
  KEY `product_group_similar_retrieved_created` (`product_group`,`similar_retrieved`, `created`),
  KEY `product_group_video_generated_created` (`product_group`,`video_generated`, `created`),
  KEY `brand` (`brand`),
  KEY `created` (`created`),
  KEY `modified_product_id` (`modified`, `product_id`),
  KEY `hi_res_images_retrieved_video_generated_created` (`hi_res_images_retrieved`,`video_generated`, `created`),
  KEY `similar_retrieved_created` (`similar_retrieved`, `created`),
  KEY `video_generated_created` (`video_generated`, `created`),
  KEY `is_valid_modified_product_id` (`is_valid`, `modified`, `product_id`)
) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
