CREATE TABLE `product_image` (
  `product_id` int(10) unsigned NOT NULL,
  `category` varchar(255) NOT NULL,
  `url` varchar(128) NOT NULL,
  `width` int(11) DEFAULT NULL,
  `height` int(11) DEFAULT NULL,
  KEY `product_id` (`product_id`),
  UNIQUE KEY `product_id_category_url` (`product_id`, `category`, `url`),
  KEY `url` (`url`),
  CONSTRAINT `product_product_image` FOREIGN KEY `product_id` (`product_id`)
    REFERENCES `product` (`product_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
