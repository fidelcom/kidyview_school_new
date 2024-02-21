<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2022-05-09 12:05:54 --> 404 Page Not Found: /index
ERROR - 2022-05-09 14:05:52 --> Query error: Expression #12 of SELECT list is not in GROUP BY clause and contains nonaggregated column 'chawtech_kiddyVewDevlopment.s.sessionstart' which is not functionally dependent on columns in GROUP BY clause; this is incompatible with sql_mode=only_full_group_by - Invalid query: SELECT `c`.*, COUNT(ch.id) as num_child, CONCAT(t.teacherfname, " ", `t`.`teachermname`, " ", t.teacherlname) as teacher, `s`.`sessionstart`, `s`.`sessionend`
FROM `class` `c`
LEFT JOIN `child` `ch` ON `ch`.`childclass` = `c`.`id`
LEFT JOIN `teacher` `t` ON `t`.`id` = `c`.`classteacher`
LEFT JOIN `sessions` `s` ON `s`.`schoolId` = `c`.`schoolId`
WHERE `c`.`schoolId` = '191'
AND `s`.`current_sesion` = 1
GROUP BY `c`.`id`
ERROR - 2022-05-09 14:06:02 --> Query error: Expression #12 of SELECT list is not in GROUP BY clause and contains nonaggregated column 'chawtech_kiddyVewDevlopment.s.sessionstart' which is not functionally dependent on columns in GROUP BY clause; this is incompatible with sql_mode=only_full_group_by - Invalid query: SELECT `c`.*, COUNT(ch.id) as num_child, CONCAT(t.teacherfname, " ", `t`.`teachermname`, " ", t.teacherlname) as teacher, `s`.`sessionstart`, `s`.`sessionend`
FROM `class` `c`
LEFT JOIN `child` `ch` ON `ch`.`childclass` = `c`.`id`
LEFT JOIN `teacher` `t` ON `t`.`id` = `c`.`classteacher`
LEFT JOIN `sessions` `s` ON `s`.`schoolId` = `c`.`schoolId`
WHERE `c`.`schoolId` = '191'
AND `s`.`current_sesion` = 1
GROUP BY `c`.`id`
