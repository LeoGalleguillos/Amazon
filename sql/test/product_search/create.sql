CREATE TABLE `product_search` (
  `product_id` int(10) unsigned NOT NULL,
  `title_first_3_words` varchar(255) NOT NULL,
  PRIMARY KEY (`product_id`),
  FULLTEXT KEY `title_first_3_words` (`title_first_3_words`),
  CONSTRAINT `product_product_search` FOREIGN KEY (`product_id`)
    REFERENCES `product` (`product_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
