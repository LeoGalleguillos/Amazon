ALTER TABLE `product_ean`
    DROP FOREIGN KEY `product_id`,
    ADD CONSTRAINT `product_product_ean` FOREIGN KEY `product_id` (`product_id`)
        REFERENCES `product` (`product_id`)
        ON DELETE CASCADE
        ON UPDATE CASCADE
    ;
