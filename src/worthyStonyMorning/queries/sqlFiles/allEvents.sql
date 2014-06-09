SELECT   `e`.`id`             AS `event_id`
         , `e`.`title`        AS `event_title`
         , `e`.`shortdesc`    AS `event_shortdesc`
         , `e`.`longdesc`     AS `event_longdesc`
         , `e`.`email`        AS `event_email`
         , `e`.`time`         AS `event_time`
FROM     `event` AS `e`
