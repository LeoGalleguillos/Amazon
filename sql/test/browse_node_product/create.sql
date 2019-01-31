CREATE TABLE `browse_node_product` (
  `browse_node_id` BIGINT(10) unsigned NOT NULL,
  `product_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`browse_node_id`, `product_id`),
  UNIQUE `product_id_browse_node_id` (`product_id`, `browse_node_id`)
) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

