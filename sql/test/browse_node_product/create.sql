CREATE TABLE `browse_node_product` (
  `browse_node_id` bigint(10) unsigned NOT NULL,
  `product_id` int(10) unsigned NOT NULL,
  `order` TINYINT(2) unsigned NOT NULL,
  PRIMARY KEY (`browse_node_id`, `product_id`),
  UNIQUE `product_id_order` (`product_id`, `order`)
) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

