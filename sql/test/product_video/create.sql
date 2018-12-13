CREATE TABLE `product_video` (
  `product_video_id` int(10) unsigned NOT NULL auto_increment,
  `product_id` int(10) unsigned not null,
  `title` text not null,
  `created` datetime not null,
  PRIMARY KEY (`product_video_id`),
  UNIQUE (`product_id`),
  FULLTEXT (`title`)
) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
