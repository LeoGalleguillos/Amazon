CREATE TABLE `product_isbn` (
  `product_id` int(10) unsigned NOT NULL,
  `isbn` char(10) NOT NULL,
  PRIMARY KEY (`product_id`, `isbn`),
  CONSTRAINT `product_product_isbn` FOREIGN KEY `product_id` (`product_id`)
    REFERENCES `product` (`product_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
