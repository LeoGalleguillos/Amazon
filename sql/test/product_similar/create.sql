CREATE TABLE `product_similar` (
  `asin` varchar(10) NOT NULL, 
  `similar_asin` varchar(10) NOT NULL, 
  UNIQUE KEY `asin` (`asin`,`similar_asin`),
  KEY `similar_asin` (`similar_asin`),
  CONSTRAINT `product_product_similar_asin` FOREIGN KEY (`asin`)
    REFERENCES `product` (`asin`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `product_product_similar_similar_asin` FOREIGN KEY (`similar_asin`)
    REFERENCES `product` (`asin`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
