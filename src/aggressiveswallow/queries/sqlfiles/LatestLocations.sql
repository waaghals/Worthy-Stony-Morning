SELECT `l`.`id`             AS `location_id` 
       , `l`.`price`        AS `location_price` 
       , `l`.`description`  AS `location_description` 
       , `l`.`area`         AS `location_area` 
       , `l`.`yardarea`     AS `location_yardarea` 
       , `l`.`foto`         AS `location_foto` 
       , `l`.`newbuild`     AS `location_newbuild` 
       , `l`.`energylabel`  AS `location_energylabel` 
       , `a`.`id`           AS `address_id` 
       , `a`.`street`       AS `address_street` 
       , `a`.`housenumber`  AS `address_housenumber` 
       , `a`.`zipcode`      AS `address_zipcode` 
       , `a`.`city`         AS `address_city` 
       , `a`.`neighborhood` AS `address_neighborhood` 
       , `c`.`id`           AS `menuitem_id` 
       , `c`.`name`         AS `menuitem_name` 
       , `c`.`uri`          AS `menuitem_uri` 
FROM   `location` AS `l` 
       JOIN `address` AS `a` 
         ON ( `l`.`address_id` = `a`.`id` ) 
       JOIN `menuitem` AS `c` 
         ON ( `l`.`menuitem_id` = `c`.`id` ) 
WHERE `l`.`order_id` IS NULL
LIMIT  10; 