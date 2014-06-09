SELECT   `id`      AS `content_id`
        ,`page`    AS `content_page`
        ,`content` AS `content_content`
FROM `content`
WHERE `page` = :name