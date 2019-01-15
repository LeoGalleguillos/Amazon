CREATE TABLE `browse_node_hierarchy` (
  `browse_node_id_parent` BIGINT(10) unsigned NOT NULL,
  `browse_node_id_child` BIGINT(10) unsigned NOT NULL,
  PRIMARY KEY (`browse_node_id_parent`, `browse_node_id_child`)
) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

