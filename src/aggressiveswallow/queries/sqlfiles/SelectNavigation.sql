SELECT `mi`.`name`                                  AS `menuitem_name` 
       , `mi`.`uri`                                 AS `menuitem_uri` 
       , `mi`.`id`                                  AS `menuitem_id` 
       , ( COUNT(`parent`.`id`) - 1 )               AS `depth` 
       , `node`.`id`                                AS `tree_id` 
       , `node`.`lft`                               AS `tree_lft` 
       , `node`.`rgt`                               AS `tree_rgt` 
FROM   `tree` AS `node` 
       JOIN `menuitem` AS `mi` 
         ON ( `mi`.`tree_id` = `node`.`id` ) 
       CROSS JOIN `tree` AS `parent` 
WHERE  `node`.`lft` BETWEEN `parent`.`lft` AND `parent`.`rgt` 
GROUP  BY `node`.`id` 
ORDER  BY `node`.`lft` 