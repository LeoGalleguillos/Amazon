CREATE TABLE `product_video` (
  `product_video_id` int(10) unsigned NOT NULL auto_increment,
  `product_id` int(10) unsigned not null,
  `title` text not null,
  `description` text DEFAULT NULL,
  `duration_milliseconds` int(10) default null,
  `created` datetime not null,
  `modified` datetime default null,
  PRIMARY KEY (`product_video_id`),
  UNIQUE (`product_id`),
  INDEX (`created`),
  INDEX (`modified`),
  FULLTEXT (`title`)
) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
