CREATE TABLE `browse_node_product` (
  `browse_node_id` bigint(10) unsigned NOT NULL,
  `product_id` int(10) unsigned NOT NULL,
  `sales_rank` int(10) unsigned DEFAULT NULL,
  `order` TINYINT(2) unsigned NOT NULL,
  PRIMARY KEY (`browse_node_id`, `product_id`),
  UNIQUE `product_id_order` (`product_id`, `order`),
  CONSTRAINT `browse_node_browse_node_product` FOREIGN KEY (`browse_node_id`)
    REFERENCES `browse_node` (`browse_node_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `product_browse_node_product` FOREIGN KEY (`product_id`)
    REFERENCES `product` (`product_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

