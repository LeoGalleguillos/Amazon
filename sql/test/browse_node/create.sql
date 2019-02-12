CREATE TABLE `browse_node` (
  `browse_node_id` BIGINT(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`browse_node_id`),
  UNIQUE `name_browse_node_id` (`name`, `browse_node_id`)
) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

