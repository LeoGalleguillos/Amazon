CREATE TABLE `resources_offers_listings` (
  `resources_offers_listings_id` int(10) NOT NULL AUTO_INCREMENT,
  `product_id` int(10) unsigned NOT NULL,
  `availability` varchar(32) NOT NULL,
  `minimum_order_quantity` int(10) unsigned NOT NULL,
  `maximum_order_quantity` int(10) unsigned DEFAULT NULL,
  `condition` varchar(32) NOT NULL,
  `sub_condition` varchar(32) NOT NULL,
  `is_fulfilled_by_amazon` tinyint(1) unsigned NOT NULL,
  `is_eligible_for_free_shipping` tinyint(1) unsigned NOT NULL,
  `is_eligible_for_prime` tinyint(1) unsigned NOT NULL,
  `price` float(16,2) unsigned NOT NULL,
  `savings` float(16,2) unsigned DEFAULT NULL,
  `is_prime_exclusive` tinyint(1) unsigned NOT NULL,
  `is_prime_pantry` tinyint(1) unsigned NOT NULL,
  `violates_map` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`resources_offers_listings_id`),
  INDEX `product_id` (`product_id`),
  CONSTRAINT `product_resources_offers_listings` FOREIGN KEY `product_id` (`product_id`)
    REFERENCES `product` (`product_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
