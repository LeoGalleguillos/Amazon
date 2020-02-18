CREATE TABLE `product_upc` (
  `product_id` int(10) unsigned NOT NULL,
  `upc` char(12) NOT NULL,
  PRIMARY KEY (`product_id`, `upc`),
  CONSTRAINT `product_product_upc` FOREIGN KEY `product_id` (`product_id`)
    REFERENCES `product` (`product_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
