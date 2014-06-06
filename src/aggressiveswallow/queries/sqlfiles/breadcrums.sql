SELECT `m`.`id`     AS `menuitem_id` 
       , `m`.`name` AS `menuitem_name` 
       , `m`.`uri`  AS `menuitem_uri` 
FROM   `tree` AS `node` 
       CROSS JOIN `tree` AS `parent` 
       JOIN `menuitem` AS `m` 
         ON ( `m`.`tree_id` = `parent`.`id` ) 
WHERE  `node`.`lft` BETWEEN `parent`.`lft` AND `parent`.`rgt` 
   AND `node`.`id` = :id
ORDER  BY `node`.`lft` 