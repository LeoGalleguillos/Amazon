CREATE TABLE `product_image` (
  /*
   * @todo Once all product_id values are inserted,
   * product_id can no longer be null
   */
  `product_id` int(10) DEFAULT NULL,

  `asin` varchar(10) NOT NULL,
  `category` varchar(255) NOT NULL,
  `url` varchar(128) NOT NULL,
  `width` int(11) DEFAULT NULL,
  `height` int(11) DEFAULT NULL,
  UNIQUE KEY `asin_category_url` (`asin`,`category`,`url`),
  KEY `url` (`url`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
