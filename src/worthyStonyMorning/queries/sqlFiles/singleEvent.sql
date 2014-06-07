SELECT   `id`        AS `event_id`
        ,`title`     AS `event_title`
        ,`time`      AS `event_time`
        ,`shortdesc` AS `event_shortdesc`
        ,`longdesc`  AS `event_longdesc`
        ,`email`     AS `event_email`
FROM `event` AS `e`
WHERE `id` = :id