SELECT `l`.`id`             AS `location_id` 
       , `l`.`price`        AS `location_price` 
       , `l`.`description`  AS `location_description` 
       , `l`.`area`         AS `location_area` 
       , `l`.`yardarea`     AS `location_yardarea` 
       , `l`.`newbuild`     AS `location_newbuild` 
       , `l`.`energylabel`  AS `location_energylabel` 
       , `l`.`foto`         AS `location_foto` 
       , `a`.`id`           AS `address_id` 
       , `a`.`street`       AS `address_street` 
       , `a`.`housenumber`  AS `address_housenumber` 
       , `a`.`zipcode`      AS `address_zipcode` 
       , `a`.`city`         AS `address_city` 
       , `a`.`neighborhood` AS `address_neighborhood` 
       , `c`.`id`           AS `menuitem_id` 
       , `c`.`name`         AS `menuitem_name` 
       , `c`.`uri`          AS `menuitem_uri` 
       , `t`.`id`           AS `tree_id`
       , `t`.`lft`          AS `tree_lft`
       , `t`.`rgt`          AS `tree_rgt`
FROM   `location` AS `l` 
       JOIN `address` AS `a` 
         ON ( `l`.`address_id` = `a`.`id` ) 
       JOIN `menuitem` AS `c` 
         ON ( `l`.`menuitem_id` = `c`.`id` ) 
       JOIN `tree` AS `t`
         ON ( `c`.`tree_id` = `t`.`id`)
WHERE  `l`.`id` = :id 
AND  `l`.`order_id` IS NULL