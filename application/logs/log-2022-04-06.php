<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2022-04-06 01:25:08 --> 404 Page Not Found: /index
ERROR - 2022-04-06 06:28:13 --> 404 Page Not Found: /index
ERROR - 2022-04-06 06:28:27 --> 404 Page Not Found: /index
ERROR - 2022-04-06 06:28:32 --> 404 Page Not Found: /index
ERROR - 2022-04-06 06:28:33 --> 404 Page Not Found: /index
ERROR - 2022-04-06 06:28:35 --> 404 Page Not Found: /index
ERROR - 2022-04-06 06:28:35 --> 404 Page Not Found: /index
ERROR - 2022-04-06 06:28:36 --> 404 Page Not Found: /index
ERROR - 2022-04-06 06:28:37 --> 404 Page Not Found: /index
ERROR - 2022-04-06 06:28:38 --> 404 Page Not Found: /index
ERROR - 2022-04-06 06:28:38 --> 404 Page Not Found: /index
ERROR - 2022-04-06 06:28:39 --> 404 Page Not Found: /index
ERROR - 2022-04-06 06:28:40 --> 404 Page Not Found: /index
ERROR - 2022-04-06 06:28:41 --> 404 Page Not Found: /index
ERROR - 2022-04-06 06:28:41 --> 404 Page Not Found: /index
ERROR - 2022-04-06 06:28:42 --> 404 Page Not Found: /index
ERROR - 2022-04-06 06:28:43 --> 404 Page Not Found: /index
ERROR - 2022-04-06 06:28:44 --> 404 Page Not Found: /index
ERROR - 2022-04-06 06:28:56 --> 404 Page Not Found: /index
ERROR - 2022-04-06 06:28:56 --> 404 Page Not Found: /index
ERROR - 2022-04-06 06:28:57 --> 404 Page Not Found: /index
ERROR - 2022-04-06 06:28:58 --> 404 Page Not Found: /index
ERROR - 2022-04-06 06:29:01 --> 404 Page Not Found: /index
ERROR - 2022-04-06 06:29:01 --> 404 Page Not Found: /index
ERROR - 2022-04-06 06:29:01 --> 404 Page Not Found: /index
ERROR - 2022-04-06 06:29:01 --> 404 Page Not Found: /index
ERROR - 2022-04-06 06:29:02 --> 404 Page Not Found: /index
ERROR - 2022-04-06 06:29:04 --> 404 Page Not Found: /index
ERROR - 2022-04-06 06:29:05 --> 404 Page Not Found: /index
ERROR - 2022-04-06 06:29:05 --> 404 Page Not Found: /index
ERROR - 2022-04-06 06:29:05 --> 404 Page Not Found: /index
ERROR - 2022-04-06 06:29:05 --> 404 Page Not Found: /index
ERROR - 2022-04-06 06:29:05 --> 404 Page Not Found: /index
ERROR - 2022-04-06 06:29:06 --> 404 Page Not Found: /index
ERROR - 2022-04-06 06:29:06 --> 404 Page Not Found: /index
ERROR - 2022-04-06 06:29:06 --> 404 Page Not Found: /index
ERROR - 2022-04-06 06:29:06 --> 404 Page Not Found: /index
ERROR - 2022-04-06 11:50:46 --> 404 Page Not Found: /index
ERROR - 2022-04-06 11:50:49 --> Severity: Notice --> Undefined index: email /home/chawtechsolution/public_html/kidyview/application/controllers/api/Auth.php 348
ERROR - 2022-04-06 11:50:49 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/chawtechsolution/public_html/kidyview/system/core/Exceptions.php:271) /home/chawtechsolution/public_html/kidyview/system/core/Common.php 570
ERROR - 2022-04-06 11:50:50 --> Severity: Notice --> Undefined index: email /home/chawtechsolution/public_html/kidyview/application/controllers/api/Auth.php 348
ERROR - 2022-04-06 11:50:50 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/chawtechsolution/public_html/kidyview/system/core/Exceptions.php:271) /home/chawtechsolution/public_html/kidyview/system/core/Common.php 570
ERROR - 2022-04-06 11:54:58 --> 404 Page Not Found: /index
ERROR - 2022-04-06 11:54:58 --> 404 Page Not Found: /index
ERROR - 2022-04-06 11:54:58 --> 404 Page Not Found: /index
ERROR - 2022-04-06 11:54:58 --> 404 Page Not Found: /index
ERROR - 2022-04-06 11:55:53 --> 404 Page Not Found: /index
ERROR - 2022-04-06 11:57:14 --> 404 Page Not Found: /index
ERROR - 2022-04-06 11:57:26 --> 404 Page Not Found: /index
ERROR - 2022-04-06 11:57:47 --> 404 Page Not Found: /index
ERROR - 2022-04-06 11:57:47 --> 404 Page Not Found: /index
ERROR - 2022-04-06 12:03:35 --> 404 Page Not Found: /index
ERROR - 2022-04-06 12:03:45 --> Severity: error --> Exception: syntax error, unexpected '}', expecting end of file /home/chawtechsolution/public_html/kidyview/application/modules/schooluser/views/school-left-menu.php 243
ERROR - 2022-04-06 14:26:26 --> 404 Page Not Found: /index
ERROR - 2022-04-06 14:28:50 --> 404 Page Not Found: /index
ERROR - 2022-04-06 14:29:17 --> 404 Page Not Found: /index
ERROR - 2022-04-06 14:29:32 --> 404 Page Not Found: /index
ERROR - 2022-04-06 18:26:27 --> Query error: Column 'session_id' in where clause is ambiguous - Invalid query: SELECT `f`.*, CONCAT( c.class, " ", c.section) as class, `curr`.`currency_name`, `curr`.`currency_symbol`, `curr`.`currency_code`
FROM `fees` as `f`
LEFT JOIN `class` as `c` ON `c`.`id`=`f`.`class_id`
LEFT JOIN `school` as `school` ON `school`.`id`=20
LEFT JOIN `admin_currency` as `curr` ON `curr`.`id`=`school`.`currency_id`
WHERE `session_id` = '29'
AND `school_id` = '20'
ERROR - 2022-04-06 18:27:07 --> Query error: Column 'session_id' in where clause is ambiguous - Invalid query: SELECT `f`.*, CONCAT( c.class, " ", c.section) as class, `curr`.`currency_name`, `curr`.`currency_symbol`, `curr`.`currency_code`
FROM `fees` as `f`
LEFT JOIN `class` as `c` ON `c`.`id`=`f`.`class_id`
LEFT JOIN `school` as `school` ON `school`.`id`=20
LEFT JOIN `admin_currency` as `curr` ON `curr`.`id`=`school`.`currency_id`
WHERE `session_id` = '29'
AND `school_id` = '20'
ERROR - 2022-04-06 18:28:40 --> Query error: Column 'session_id' in where clause is ambiguous - Invalid query: SELECT `f`.*, CONCAT( c.class, " ", c.section) as class, `curr`.`currency_name`, `curr`.`currency_symbol`, `curr`.`currency_code`
FROM `fees` as `f`
LEFT JOIN `class` as `c` ON `c`.`id`=`f`.`class_id`
LEFT JOIN `school` as `school` ON `school`.`id`=20
LEFT JOIN `admin_currency` as `curr` ON `curr`.`id`=`school`.`currency_id`
WHERE `session_id` = '29'
AND `school_id` = '20'
ERROR - 2022-04-06 15:34:05 --> 404 Page Not Found: /index
