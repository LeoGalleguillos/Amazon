CREATE TABLE `product_banned` (
  `asin` varchar(10) NOT NULL,
  PRIMARY KEY (`asin`)
  /*
   * No foreign key constraints required because ASIN's in this table
   * (and their respective product ID's) should not exist in any other tables.
   */
) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
