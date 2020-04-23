CREATE TABLE `resources_offers_summaries` (
  `resources_offers_summaries_id` int(10) NOT NULL AUTO_INCREMENT,
  `product_id` int(10) unsigned NOT NULL,
  `condition` varchar(32) NOT NULL,
  `highest_price` float(16,2) unsigned NOT NULL,
  `lowest_price` float(16,2) unsigned NOT NULL,
  `offer_count` int(2) unsigned NOT NULL,
  PRIMARY KEY (`resources_offers_summaries_id`),
  UNIQUE `product_id_condition` (`product_id`, `condition`),
  CONSTRAINT `product_resources_offers_summaries` FOREIGN KEY `product_id` (`product_id`)
    REFERENCES `product` (`product_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
