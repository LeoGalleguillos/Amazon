CREATE TABLE `product_ean` (
  `product_id` int(10) unsigned NOT NULL,
  `ean` char(13) NOT NULL,
  PRIMARY KEY (`product_id`, `ean`),
  CONSTRAINT `product_product_ean` FOREIGN KEY `product_id` (`product_id`)
    REFERENCES `product` (`product_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
