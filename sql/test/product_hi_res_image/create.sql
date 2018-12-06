CREATE TABLE `product_hi_res_image` (
  `product_id` int(10) unsigned NOT NULL,
  `url` varchar(255) NOT NULL,
  `order` tinyint(3) NOT NULL,
  PRIMARY KEY (`product_id`, `url`),
  UNIQUE `product_id_order` (`product_id`, `order`)
) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

