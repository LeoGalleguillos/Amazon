ALTER TABLE `browse_node_product`
    ADD COLUMN `website_sales_rank` int(10) unsigned DEFAULT NULL
    AFTER `product_id`
    ;
