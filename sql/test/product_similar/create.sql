CREATE TABLE `product_similar` (
  `asin` varchar(10) NOT NULL, 
  `similar_asin` varchar(10) NOT NULL, 
  UNIQUE KEY `asin` (`asin`,`similar_asin`),
  KEY `similar_asin` (`similar_asin`)     
) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
