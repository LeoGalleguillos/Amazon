CREATE TABLE `product_feature` (
  `product_id` int(10) unsigned NOT NULL,
  `asin` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `feature` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  KEY `asin` (`asin`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
