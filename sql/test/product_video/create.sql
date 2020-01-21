CREATE TABLE `product_video` (
  `product_video_id` int(10) unsigned NOT NULL auto_increment,
  `product_id` int(10) unsigned not null,
  `asin` varchar(10) NOT NULL,
  `title` text not null,
  `description` text DEFAULT NULL,
  `duration_milliseconds` int(10) default null,
  `created` datetime not null,
  `modified` datetime default null,
  PRIMARY KEY (`product_video_id`),
  UNIQUE (`product_id`),
  UNIQUE (`asin`),
  FULLTEXT `title` (`title`),
  FULLTEXT `description` (`description`),
  INDEX (`created`),
  INDEX (`modified`)
) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
