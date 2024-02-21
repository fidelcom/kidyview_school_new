<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2022-06-15 11:50:25 --> 404 Page Not Found: /index
ERROR - 2022-06-15 11:58:47 --> Query error: Expression #12 of SELECT list is not in GROUP BY clause and contains nonaggregated column 'chawtech_kiddyVewDevlopment.s.sessionstart' which is not functionally dependent on columns in GROUP BY clause; this is incompatible with sql_mode=only_full_group_by - Invalid query: SELECT `c`.*, COUNT(ch.id) as num_child, CONCAT(t.teacherfname, " ", `t`.`teachermname`, " ", t.teacherlname) as teacher, `s`.`sessionstart`, `s`.`sessionend`
FROM `class` `c`
LEFT JOIN `child` `ch` ON `ch`.`childclass` = `c`.`id`
LEFT JOIN `teacher` `t` ON `t`.`id` = `c`.`classteacher`
LEFT JOIN `sessions` `s` ON `s`.`schoolId` = `c`.`schoolId`
WHERE `c`.`schoolId` = '191'
AND `s`.`current_sesion` = 1
GROUP BY `c`.`id`
ERROR - 2022-06-15 11:58:48 --> Query error: Expression #8 of SELECT list is not in GROUP BY clause and contains nonaggregated column 'chawtech_kiddyVewDevlopment.child_class.class_id' which is not functionally dependent on columns in GROUP BY clause; this is incompatible with sql_mode=only_full_group_by - Invalid query: SELECT `c`.`id` as `studentID`, CONCAT(c.childfname, " ", `c`.`childmname`, " ", c.childlname) as stud_name, `c`.`childphoto`, `c`.`schoolId`, `p`.`id` as `parent_id`, CONCAT(p.fatherfname, " ", p.fatherlname) as father_name, CONCAT(p.motherfname, " ", p.motherlname) as mother_name, `child_class`.`class_id`, CONCAT(cs.class, " ", cs.section) as class, `t`.`id` as `teacher_id`, CONCAT(t.teacherfname, " ", `t`.`teachermname`, " ", t.teacherlname) as teacher_name, `ss`.`id` as `session_id`, `ss`.`academicsession`, `child_class`.`session_id`
FROM `child` as `c`
LEFT JOIN `child_class` ON `c`.`id` = `child_class`.`child_id`
LEFT JOIN `parent` as `p` ON `c`.`parent_id`=`p`.`id`
LEFT JOIN `class` `cs` ON `child_class`.`class_id`=`cs`.`id`
LEFT JOIN `teacher` as `t` ON `cs`.`classteacher`=`t`.`id`
LEFT JOIN `sessions` as `ss` ON `child_class`.`session_id`=`ss`.`id`
WHERE `c`.`schoolId` = '191'
AND `c`.`status` = 1
GROUP BY `c`.`id`
ERROR - 2022-06-15 11:59:01 --> 404 Page Not Found: /index
ERROR - 2022-06-15 11:59:01 --> 404 Page Not Found: /index
ERROR - 2022-06-15 11:59:10 --> 404 Page Not Found: /index
ERROR - 2022-06-15 11:59:11 --> 404 Page Not Found: /index
ERROR - 2022-06-15 11:59:12 --> Query error: Expression #12 of SELECT list is not in GROUP BY clause and contains nonaggregated column 'chawtech_kiddyVewDevlopment.s.sessionstart' which is not functionally dependent on columns in GROUP BY clause; this is incompatible with sql_mode=only_full_group_by - Invalid query: SELECT `c`.*, COUNT(ch.id) as num_child, CONCAT(t.teacherfname, " ", `t`.`teachermname`, " ", t.teacherlname) as teacher, `s`.`sessionstart`, `s`.`sessionend`
FROM `class` `c`
LEFT JOIN `child` `ch` ON `ch`.`childclass` = `c`.`id`
LEFT JOIN `teacher` `t` ON `t`.`id` = `c`.`classteacher`
LEFT JOIN `sessions` `s` ON `s`.`schoolId` = `c`.`schoolId`
WHERE `c`.`schoolId` = '191'
AND `s`.`current_sesion` = 1
GROUP BY `c`.`id`
ERROR - 2022-06-15 11:59:13 --> Query error: Expression #8 of SELECT list is not in GROUP BY clause and contains nonaggregated column 'chawtech_kiddyVewDevlopment.child_class.class_id' which is not functionally dependent on columns in GROUP BY clause; this is incompatible with sql_mode=only_full_group_by - Invalid query: SELECT `c`.`id` as `studentID`, CONCAT(c.childfname, " ", `c`.`childmname`, " ", c.childlname) as stud_name, `c`.`childphoto`, `c`.`schoolId`, `p`.`id` as `parent_id`, CONCAT(p.fatherfname, " ", p.fatherlname) as father_name, CONCAT(p.motherfname, " ", p.motherlname) as mother_name, `child_class`.`class_id`, CONCAT(cs.class, " ", cs.section) as class, `t`.`id` as `teacher_id`, CONCAT(t.teacherfname, " ", `t`.`teachermname`, " ", t.teacherlname) as teacher_name, `ss`.`id` as `session_id`, `ss`.`academicsession`, `child_class`.`session_id`
FROM `child` as `c`
LEFT JOIN `child_class` ON `c`.`id` = `child_class`.`child_id`
LEFT JOIN `parent` as `p` ON `c`.`parent_id`=`p`.`id`
LEFT JOIN `class` `cs` ON `child_class`.`class_id`=`cs`.`id`
LEFT JOIN `teacher` as `t` ON `cs`.`classteacher`=`t`.`id`
LEFT JOIN `sessions` as `ss` ON `child_class`.`session_id`=`ss`.`id`
WHERE `c`.`schoolId` = '191'
AND `c`.`status` = 1
GROUP BY `c`.`id`
ERROR - 2022-06-15 11:59:45 --> 404 Page Not Found: /index
ERROR - 2022-06-15 11:59:46 --> 404 Page Not Found: /index
ERROR - 2022-06-15 11:59:47 --> Query error: Expression #12 of SELECT list is not in GROUP BY clause and contains nonaggregated column 'chawtech_kiddyVewDevlopment.s.sessionstart' which is not functionally dependent on columns in GROUP BY clause; this is incompatible with sql_mode=only_full_group_by - Invalid query: SELECT `c`.*, COUNT(ch.id) as num_child, CONCAT(t.teacherfname, " ", `t`.`teachermname`, " ", t.teacherlname) as teacher, `s`.`sessionstart`, `s`.`sessionend`
FROM `class` `c`
LEFT JOIN `child` `ch` ON `ch`.`childclass` = `c`.`id`
LEFT JOIN `teacher` `t` ON `t`.`id` = `c`.`classteacher`
LEFT JOIN `sessions` `s` ON `s`.`schoolId` = `c`.`schoolId`
WHERE `c`.`schoolId` = '191'
AND `s`.`current_sesion` = 1
GROUP BY `c`.`id`
ERROR - 2022-06-15 11:59:47 --> Query error: Expression #8 of SELECT list is not in GROUP BY clause and contains nonaggregated column 'chawtech_kiddyVewDevlopment.child_class.class_id' which is not functionally dependent on columns in GROUP BY clause; this is incompatible with sql_mode=only_full_group_by - Invalid query: SELECT `c`.`id` as `studentID`, CONCAT(c.childfname, " ", `c`.`childmname`, " ", c.childlname) as stud_name, `c`.`childphoto`, `c`.`schoolId`, `p`.`id` as `parent_id`, CONCAT(p.fatherfname, " ", p.fatherlname) as father_name, CONCAT(p.motherfname, " ", p.motherlname) as mother_name, `child_class`.`class_id`, CONCAT(cs.class, " ", cs.section) as class, `t`.`id` as `teacher_id`, CONCAT(t.teacherfname, " ", `t`.`teachermname`, " ", t.teacherlname) as teacher_name, `ss`.`id` as `session_id`, `ss`.`academicsession`, `child_class`.`session_id`
FROM `child` as `c`
LEFT JOIN `child_class` ON `c`.`id` = `child_class`.`child_id`
LEFT JOIN `parent` as `p` ON `c`.`parent_id`=`p`.`id`
LEFT JOIN `class` `cs` ON `child_class`.`class_id`=`cs`.`id`
LEFT JOIN `teacher` as `t` ON `cs`.`classteacher`=`t`.`id`
LEFT JOIN `sessions` as `ss` ON `child_class`.`session_id`=`ss`.`id`
WHERE `c`.`schoolId` = '191'
AND `c`.`status` = 1
GROUP BY `c`.`id`
ERROR - 2022-06-15 12:02:39 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:02:39 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:03:48 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:04:48 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:05:42 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:06:32 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:06:32 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:06:52 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:06:52 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:06:58 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:06:58 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:06:59 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:07:00 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:07:43 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:07:44 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:08:06 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:08:30 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:08:31 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:08:35 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:08:35 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:08:36 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:08:37 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:11:10 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:11:10 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:11:11 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:11:17 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:11:17 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:11:23 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:11:24 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:11:24 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:13:26 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:13:26 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:13:36 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:13:36 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:13:43 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:15:27 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:16:05 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:16:09 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:16:09 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:16:14 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:16:14 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:16:15 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:18:58 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:19:18 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:19:18 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:19:23 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:19:23 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:19:24 --> 404 Page Not Found: /index
ERROR - 2022-06-15 07:50:30 --> 404 Page Not Found: /index
ERROR - 2022-06-15 07:54:14 --> 404 Page Not Found: /index
ERROR - 2022-06-15 07:54:15 --> 404 Page Not Found: /index
ERROR - 2022-06-15 07:54:16 --> 404 Page Not Found: /index
ERROR - 2022-06-15 07:54:32 --> 404 Page Not Found: /index
ERROR - 2022-06-15 07:54:32 --> 404 Page Not Found: /index
ERROR - 2022-06-15 07:54:33 --> 404 Page Not Found: /index
ERROR - 2022-06-15 07:55:14 --> 404 Page Not Found: /index
ERROR - 2022-06-15 07:55:34 --> 404 Page Not Found: /index
ERROR - 2022-06-15 07:55:35 --> 404 Page Not Found: /index
ERROR - 2022-06-15 07:55:36 --> 404 Page Not Found: /index
ERROR - 2022-06-15 07:58:48 --> 404 Page Not Found: /index
ERROR - 2022-06-15 07:58:48 --> 404 Page Not Found: /index
ERROR - 2022-06-15 08:04:18 --> 404 Page Not Found: /index
ERROR - 2022-06-15 08:04:18 --> 404 Page Not Found: /index
ERROR - 2022-06-15 08:04:28 --> 404 Page Not Found: /index
ERROR - 2022-06-15 08:04:28 --> 404 Page Not Found: /index
ERROR - 2022-06-15 08:04:29 --> 404 Page Not Found: /index
ERROR - 2022-06-15 08:06:06 --> 404 Page Not Found: /index
ERROR - 2022-06-15 08:06:07 --> 404 Page Not Found: /index
ERROR - 2022-06-15 08:06:08 --> 404 Page Not Found: /index
ERROR - 2022-06-15 08:06:17 --> 404 Page Not Found: /index
ERROR - 2022-06-15 08:06:18 --> 404 Page Not Found: /index
ERROR - 2022-06-15 08:06:19 --> 404 Page Not Found: /index
ERROR - 2022-06-15 08:06:25 --> 404 Page Not Found: /index
ERROR - 2022-06-15 08:06:25 --> 404 Page Not Found: /index
ERROR - 2022-06-15 08:06:26 --> 404 Page Not Found: /index
ERROR - 2022-06-15 08:17:55 --> 404 Page Not Found: /index
ERROR - 2022-06-15 08:17:55 --> 404 Page Not Found: /index
ERROR - 2022-06-15 08:21:07 --> 404 Page Not Found: /index
ERROR - 2022-06-15 08:21:07 --> 404 Page Not Found: /index
ERROR - 2022-06-15 08:21:08 --> 404 Page Not Found: /index
ERROR - 2022-06-15 08:21:31 --> 404 Page Not Found: /index
ERROR - 2022-06-15 08:21:31 --> 404 Page Not Found: /index
ERROR - 2022-06-15 08:21:32 --> 404 Page Not Found: /index
ERROR - 2022-06-15 08:22:08 --> 404 Page Not Found: /index
ERROR - 2022-06-15 08:22:09 --> 404 Page Not Found: /index
ERROR - 2022-06-15 08:22:10 --> 404 Page Not Found: /index
ERROR - 2022-06-15 08:24:43 --> 404 Page Not Found: /index
ERROR - 2022-06-15 08:24:44 --> 404 Page Not Found: /index
ERROR - 2022-06-15 08:24:44 --> 404 Page Not Found: /index
ERROR - 2022-06-15 08:31:50 --> 404 Page Not Found: /index
ERROR - 2022-06-15 08:31:51 --> 404 Page Not Found: /index
ERROR - 2022-06-15 08:31:55 --> 404 Page Not Found: /index
ERROR - 2022-06-15 08:31:57 --> 404 Page Not Found: /index
ERROR - 2022-06-15 08:31:57 --> 404 Page Not Found: /index
ERROR - 2022-06-15 08:31:58 --> 404 Page Not Found: /index
ERROR - 2022-06-15 08:33:36 --> 404 Page Not Found: /index
ERROR - 2022-06-15 08:33:37 --> 404 Page Not Found: /index
ERROR - 2022-06-15 08:33:44 --> 404 Page Not Found: /index
ERROR - 2022-06-15 08:33:45 --> 404 Page Not Found: /index
ERROR - 2022-06-15 08:33:45 --> 404 Page Not Found: /index
ERROR - 2022-06-15 08:35:10 --> 404 Page Not Found: /index
ERROR - 2022-06-15 08:35:10 --> 404 Page Not Found: /index
ERROR - 2022-06-15 08:35:11 --> 404 Page Not Found: /index
ERROR - 2022-06-15 08:39:10 --> 404 Page Not Found: /index
ERROR - 2022-06-15 08:39:11 --> 404 Page Not Found: /index
ERROR - 2022-06-15 08:39:14 --> 404 Page Not Found: /index
ERROR - 2022-06-15 08:46:50 --> 404 Page Not Found: /index
ERROR - 2022-06-15 08:46:50 --> 404 Page Not Found: /index
ERROR - 2022-06-15 08:57:31 --> 404 Page Not Found: /index
ERROR - 2022-06-15 08:57:32 --> 404 Page Not Found: /index
ERROR - 2022-06-15 08:57:32 --> 404 Page Not Found: /index
ERROR - 2022-06-15 08:58:41 --> Severity: Notice --> Undefined property: User::$model /home/chawtechsolution/public_html/kidyview/application/controllers/api/User.php 8858
ERROR - 2022-06-15 08:58:41 --> Severity: error --> Exception: Call to a member function activityResultUpdate() on null /home/chawtechsolution/public_html/kidyview/application/controllers/api/User.php 8858
ERROR - 2022-06-15 08:58:41 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/chawtechsolution/public_html/kidyview/system/core/Exceptions.php:271) /home/chawtechsolution/public_html/kidyview/system/core/Common.php 570
ERROR - 2022-06-15 09:00:20 --> 404 Page Not Found: /index
ERROR - 2022-06-15 09:00:20 --> 404 Page Not Found: /index
ERROR - 2022-06-15 09:00:21 --> 404 Page Not Found: /index
ERROR - 2022-06-15 09:00:35 --> Severity: error --> Exception: Unable to locate the model you have specified: Result_model /home/chawtechsolution/public_html/kidyview/system/core/Loader.php 344
ERROR - 2022-06-15 09:01:37 --> 404 Page Not Found: /index
ERROR - 2022-06-15 09:01:37 --> 404 Page Not Found: /index
ERROR - 2022-06-15 09:01:38 --> 404 Page Not Found: /index
ERROR - 2022-06-15 09:02:14 --> 404 Page Not Found: /index
ERROR - 2022-06-15 09:02:30 --> 404 Page Not Found: /index
ERROR - 2022-06-15 09:17:02 --> 404 Page Not Found: /index
ERROR - 2022-06-15 09:17:02 --> 404 Page Not Found: /index
ERROR - 2022-06-15 09:17:12 --> 404 Page Not Found: /index
ERROR - 2022-06-15 09:17:13 --> 404 Page Not Found: /index
ERROR - 2022-06-15 09:17:13 --> 404 Page Not Found: /index
ERROR - 2022-06-15 09:17:29 --> 404 Page Not Found: /index
ERROR - 2022-06-15 09:17:31 --> Severity: Notice --> Undefined index: email /home/chawtechsolution/public_html/kidyview/application/controllers/api/Auth.php 400
ERROR - 2022-06-15 09:17:31 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/chawtechsolution/public_html/kidyview/system/core/Exceptions.php:271) /home/chawtechsolution/public_html/kidyview/system/core/Common.php 570
ERROR - 2022-06-15 09:17:34 --> Severity: Warning --> openssl_decrypt(): IV passed is only 6 bytes long, cipher expects an IV of precisely 16 bytes, padding with \0 /home/chawtechsolution/public_html/kidyview/application/libraries/Settings.php 59
ERROR - 2022-06-15 09:17:34 --> Severity: Warning --> hash_equals(): Expected known_string to be a string, boolean given /home/chawtechsolution/public_html/kidyview/application/libraries/Settings.php 61
ERROR - 2022-06-15 09:17:34 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/chawtechsolution/public_html/kidyview/system/core/Exceptions.php:271) /home/chawtechsolution/public_html/kidyview/application/libraries/Token.php 105
ERROR - 2022-06-15 09:17:34 --> Severity: Warning --> openssl_decrypt(): IV passed is only 6 bytes long, cipher expects an IV of precisely 16 bytes, padding with \0 /home/chawtechsolution/public_html/kidyview/application/libraries/Settings.php 59
ERROR - 2022-06-15 09:17:34 --> Severity: Warning --> hash_equals(): Expected known_string to be a string, boolean given /home/chawtechsolution/public_html/kidyview/application/libraries/Settings.php 61
ERROR - 2022-06-15 09:17:34 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/chawtechsolution/public_html/kidyview/system/core/Exceptions.php:271) /home/chawtechsolution/public_html/kidyview/application/libraries/Token.php 105
ERROR - 2022-06-15 09:17:34 --> Severity: Warning --> openssl_decrypt(): IV passed is only 6 bytes long, cipher expects an IV of precisely 16 bytes, padding with \0 /home/chawtechsolution/public_html/kidyview/application/libraries/Settings.php 59
ERROR - 2022-06-15 09:17:34 --> Severity: Warning --> hash_equals(): Expected known_string to be a string, boolean given /home/chawtechsolution/public_html/kidyview/application/libraries/Settings.php 61
ERROR - 2022-06-15 09:17:34 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/chawtechsolution/public_html/kidyview/system/core/Exceptions.php:271) /home/chawtechsolution/public_html/kidyview/application/libraries/Token.php 105
ERROR - 2022-06-15 09:17:34 --> Severity: Warning --> openssl_decrypt(): IV passed is only 6 bytes long, cipher expects an IV of precisely 16 bytes, padding with \0 /home/chawtechsolution/public_html/kidyview/application/libraries/Settings.php 59
ERROR - 2022-06-15 09:17:34 --> Severity: Warning --> hash_equals(): Expected known_string to be a string, boolean given /home/chawtechsolution/public_html/kidyview/application/libraries/Settings.php 61
ERROR - 2022-06-15 09:17:34 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/chawtechsolution/public_html/kidyview/system/core/Exceptions.php:271) /home/chawtechsolution/public_html/kidyview/application/libraries/Token.php 105
ERROR - 2022-06-15 09:17:34 --> Severity: Warning --> openssl_decrypt(): IV passed is only 6 bytes long, cipher expects an IV of precisely 16 bytes, padding with \0 /home/chawtechsolution/public_html/kidyview/application/libraries/Settings.php 59
ERROR - 2022-06-15 09:17:34 --> Severity: Warning --> hash_equals(): Expected known_string to be a string, boolean given /home/chawtechsolution/public_html/kidyview/application/libraries/Settings.php 61
ERROR - 2022-06-15 09:17:34 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/chawtechsolution/public_html/kidyview/system/core/Exceptions.php:271) /home/chawtechsolution/public_html/kidyview/application/libraries/Token.php 105
ERROR - 2022-06-15 09:17:34 --> Severity: Warning --> openssl_decrypt(): IV passed is only 6 bytes long, cipher expects an IV of precisely 16 bytes, padding with \0 /home/chawtechsolution/public_html/kidyview/application/libraries/Settings.php 59
ERROR - 2022-06-15 09:17:34 --> Severity: Warning --> hash_equals(): Expected known_string to be a string, boolean given /home/chawtechsolution/public_html/kidyview/application/libraries/Settings.php 61
ERROR - 2022-06-15 09:17:34 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/chawtechsolution/public_html/kidyview/system/core/Exceptions.php:271) /home/chawtechsolution/public_html/kidyview/application/libraries/Token.php 105
ERROR - 2022-06-15 09:17:41 --> 404 Page Not Found: /index
ERROR - 2022-06-15 09:17:41 --> Severity: Warning --> openssl_decrypt(): IV passed is only 6 bytes long, cipher expects an IV of precisely 16 bytes, padding with \0 /home/chawtechsolution/public_html/kidyview/application/libraries/Settings.php 59
ERROR - 2022-06-15 09:17:41 --> Severity: Warning --> hash_equals(): Expected known_string to be a string, boolean given /home/chawtechsolution/public_html/kidyview/application/libraries/Settings.php 61
ERROR - 2022-06-15 09:17:41 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/chawtechsolution/public_html/kidyview/system/core/Exceptions.php:271) /home/chawtechsolution/public_html/kidyview/application/libraries/Token.php 105
ERROR - 2022-06-15 09:17:41 --> Severity: Warning --> openssl_decrypt(): IV passed is only 6 bytes long, cipher expects an IV of precisely 16 bytes, padding with \0 /home/chawtechsolution/public_html/kidyview/application/libraries/Settings.php 59
ERROR - 2022-06-15 09:17:41 --> Severity: Warning --> hash_equals(): Expected known_string to be a string, boolean given /home/chawtechsolution/public_html/kidyview/application/libraries/Settings.php 61
ERROR - 2022-06-15 09:17:41 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/chawtechsolution/public_html/kidyview/system/core/Exceptions.php:271) /home/chawtechsolution/public_html/kidyview/application/libraries/Token.php 105
ERROR - 2022-06-15 09:17:41 --> Severity: Warning --> openssl_decrypt(): IV passed is only 6 bytes long, cipher expects an IV of precisely 16 bytes, padding with \0 /home/chawtechsolution/public_html/kidyview/application/libraries/Settings.php 59
ERROR - 2022-06-15 09:17:41 --> Severity: Warning --> hash_equals(): Expected known_string to be a string, boolean given /home/chawtechsolution/public_html/kidyview/application/libraries/Settings.php 61
ERROR - 2022-06-15 09:17:41 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/chawtechsolution/public_html/kidyview/system/core/Exceptions.php:271) /home/chawtechsolution/public_html/kidyview/application/libraries/Token.php 105
ERROR - 2022-06-15 09:17:47 --> 404 Page Not Found: /index
ERROR - 2022-06-15 09:17:47 --> Severity: Warning --> openssl_decrypt(): IV passed is only 6 bytes long, cipher expects an IV of precisely 16 bytes, padding with \0 /home/chawtechsolution/public_html/kidyview/application/libraries/Settings.php 59
ERROR - 2022-06-15 09:17:47 --> Severity: Warning --> hash_equals(): Expected known_string to be a string, boolean given /home/chawtechsolution/public_html/kidyview/application/libraries/Settings.php 61
ERROR - 2022-06-15 09:17:47 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/chawtechsolution/public_html/kidyview/system/core/Exceptions.php:271) /home/chawtechsolution/public_html/kidyview/application/libraries/Token.php 105
ERROR - 2022-06-15 09:17:47 --> Severity: Warning --> openssl_decrypt(): IV passed is only 6 bytes long, cipher expects an IV of precisely 16 bytes, padding with \0 /home/chawtechsolution/public_html/kidyview/application/libraries/Settings.php 59
ERROR - 2022-06-15 09:17:47 --> Severity: Warning --> hash_equals(): Expected known_string to be a string, boolean given /home/chawtechsolution/public_html/kidyview/application/libraries/Settings.php 61
ERROR - 2022-06-15 09:17:47 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/chawtechsolution/public_html/kidyview/system/core/Exceptions.php:271) /home/chawtechsolution/public_html/kidyview/application/libraries/Token.php 105
ERROR - 2022-06-15 09:17:47 --> Severity: Warning --> openssl_decrypt(): IV passed is only 6 bytes long, cipher expects an IV of precisely 16 bytes, padding with \0 /home/chawtechsolution/public_html/kidyview/application/libraries/Settings.php 59
ERROR - 2022-06-15 09:17:47 --> Severity: Warning --> hash_equals(): Expected known_string to be a string, boolean given /home/chawtechsolution/public_html/kidyview/application/libraries/Settings.php 61
ERROR - 2022-06-15 09:17:47 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/chawtechsolution/public_html/kidyview/system/core/Exceptions.php:271) /home/chawtechsolution/public_html/kidyview/application/libraries/Token.php 105
ERROR - 2022-06-15 09:17:51 --> 404 Page Not Found: /index
ERROR - 2022-06-15 09:17:51 --> 404 Page Not Found: /index
ERROR - 2022-06-15 09:17:59 --> 404 Page Not Found: /index
ERROR - 2022-06-15 09:17:59 --> 404 Page Not Found: /index
ERROR - 2022-06-15 09:18:00 --> Severity: Warning --> openssl_decrypt(): IV passed is only 6 bytes long, cipher expects an IV of precisely 16 bytes, padding with \0 /home/chawtechsolution/public_html/kidyview/application/libraries/Settings.php 59
ERROR - 2022-06-15 09:18:00 --> Severity: Warning --> hash_equals(): Expected known_string to be a string, boolean given /home/chawtechsolution/public_html/kidyview/application/libraries/Settings.php 61
ERROR - 2022-06-15 09:18:00 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/chawtechsolution/public_html/kidyview/system/core/Exceptions.php:271) /home/chawtechsolution/public_html/kidyview/application/libraries/Token.php 105
ERROR - 2022-06-15 09:18:00 --> 404 Page Not Found: /index
ERROR - 2022-06-15 09:18:00 --> Severity: Warning --> openssl_decrypt(): IV passed is only 6 bytes long, cipher expects an IV of precisely 16 bytes, padding with \0 /home/chawtechsolution/public_html/kidyview/application/libraries/Settings.php 59
ERROR - 2022-06-15 09:18:00 --> Severity: Warning --> hash_equals(): Expected known_string to be a string, boolean given /home/chawtechsolution/public_html/kidyview/application/libraries/Settings.php 61
ERROR - 2022-06-15 09:18:00 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/chawtechsolution/public_html/kidyview/system/core/Exceptions.php:271) /home/chawtechsolution/public_html/kidyview/application/libraries/Token.php 105
ERROR - 2022-06-15 09:18:00 --> Severity: Warning --> openssl_decrypt(): IV passed is only 6 bytes long, cipher expects an IV of precisely 16 bytes, padding with \0 /home/chawtechsolution/public_html/kidyview/application/libraries/Settings.php 59
ERROR - 2022-06-15 09:18:00 --> Severity: Warning --> hash_equals(): Expected known_string to be a string, boolean given /home/chawtechsolution/public_html/kidyview/application/libraries/Settings.php 61
ERROR - 2022-06-15 09:18:00 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/chawtechsolution/public_html/kidyview/system/core/Exceptions.php:271) /home/chawtechsolution/public_html/kidyview/application/libraries/Token.php 105
ERROR - 2022-06-15 09:18:09 --> 404 Page Not Found: /index
ERROR - 2022-06-15 09:18:09 --> 404 Page Not Found: /index
ERROR - 2022-06-15 09:18:10 --> 404 Page Not Found: /index
ERROR - 2022-06-15 09:18:10 --> Severity: Warning --> openssl_decrypt(): IV passed is only 6 bytes long, cipher expects an IV of precisely 16 bytes, padding with \0 /home/chawtechsolution/public_html/kidyview/application/libraries/Settings.php 59
ERROR - 2022-06-15 09:18:10 --> Severity: Warning --> hash_equals(): Expected known_string to be a string, boolean given /home/chawtechsolution/public_html/kidyview/application/libraries/Settings.php 61
ERROR - 2022-06-15 09:18:10 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/chawtechsolution/public_html/kidyview/system/core/Exceptions.php:271) /home/chawtechsolution/public_html/kidyview/application/libraries/Token.php 105
ERROR - 2022-06-15 09:18:10 --> Severity: Warning --> openssl_decrypt(): IV passed is only 6 bytes long, cipher expects an IV of precisely 16 bytes, padding with \0 /home/chawtechsolution/public_html/kidyview/application/libraries/Settings.php 59
ERROR - 2022-06-15 09:18:10 --> Severity: Warning --> hash_equals(): Expected known_string to be a string, boolean given /home/chawtechsolution/public_html/kidyview/application/libraries/Settings.php 61
ERROR - 2022-06-15 09:18:10 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/chawtechsolution/public_html/kidyview/system/core/Exceptions.php:271) /home/chawtechsolution/public_html/kidyview/application/libraries/Token.php 105
ERROR - 2022-06-15 09:18:10 --> Severity: Warning --> openssl_decrypt(): IV passed is only 6 bytes long, cipher expects an IV of precisely 16 bytes, padding with \0 /home/chawtechsolution/public_html/kidyview/application/libraries/Settings.php 59
ERROR - 2022-06-15 09:18:10 --> Severity: Warning --> hash_equals(): Expected known_string to be a string, boolean given /home/chawtechsolution/public_html/kidyview/application/libraries/Settings.php 61
ERROR - 2022-06-15 09:18:10 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/chawtechsolution/public_html/kidyview/system/core/Exceptions.php:271) /home/chawtechsolution/public_html/kidyview/application/libraries/Token.php 105
ERROR - 2022-06-15 09:18:15 --> 404 Page Not Found: /index
ERROR - 2022-06-15 09:18:22 --> 404 Page Not Found: /index
ERROR - 2022-06-15 09:18:22 --> 404 Page Not Found: /index
ERROR - 2022-06-15 09:19:01 --> 404 Page Not Found: /index
ERROR - 2022-06-15 09:20:04 --> 404 Page Not Found: /index
ERROR - 2022-06-15 09:20:05 --> 404 Page Not Found: /index
ERROR - 2022-06-15 09:20:05 --> 404 Page Not Found: /index
ERROR - 2022-06-15 09:20:28 --> 404 Page Not Found: /index
ERROR - 2022-06-15 09:20:29 --> 404 Page Not Found: /index
ERROR - 2022-06-15 09:20:30 --> 404 Page Not Found: /index
ERROR - 2022-06-15 09:23:15 --> 404 Page Not Found: /index
ERROR - 2022-06-15 09:23:15 --> 404 Page Not Found: /index
ERROR - 2022-06-15 09:23:16 --> 404 Page Not Found: /index
ERROR - 2022-06-15 09:26:54 --> Severity: Notice --> Undefined variable: totalSubject /home/chawtechsolution/public_html/kidyview/application/views/marksheet.php 501
ERROR - 2022-06-15 09:29:10 --> 404 Page Not Found: /index
ERROR - 2022-06-15 09:30:12 --> 404 Page Not Found: /index
ERROR - 2022-06-15 09:30:12 --> 404 Page Not Found: /index
ERROR - 2022-06-15 09:30:17 --> 404 Page Not Found: /index
ERROR - 2022-06-15 09:30:17 --> 404 Page Not Found: /index
ERROR - 2022-06-15 09:32:19 --> 404 Page Not Found: /index
ERROR - 2022-06-15 09:32:19 --> 404 Page Not Found: /index
ERROR - 2022-06-15 09:32:43 --> 404 Page Not Found: /index
ERROR - 2022-06-15 09:32:44 --> 404 Page Not Found: /index
ERROR - 2022-06-15 09:33:10 --> 404 Page Not Found: /index
ERROR - 2022-06-15 09:34:45 --> Severity: Notice --> Undefined variable: totalSubject /home/chawtechsolution/public_html/kidyview/application/views/marksheet.php 501
ERROR - 2022-06-15 09:35:15 --> 404 Page Not Found: /index
ERROR - 2022-06-15 09:35:15 --> 404 Page Not Found: /index
ERROR - 2022-06-15 09:35:20 --> 404 Page Not Found: /index
ERROR - 2022-06-15 09:35:24 --> 404 Page Not Found: /index
ERROR - 2022-06-15 09:41:50 --> 404 Page Not Found: /index
ERROR - 2022-06-15 09:41:51 --> 404 Page Not Found: /index
ERROR - 2022-06-15 09:41:56 --> 404 Page Not Found: /index
ERROR - 2022-06-15 09:41:56 --> 404 Page Not Found: /index
ERROR - 2022-06-15 09:52:22 --> 404 Page Not Found: /index
ERROR - 2022-06-15 09:52:23 --> 404 Page Not Found: /index
ERROR - 2022-06-15 09:52:23 --> 404 Page Not Found: /index
ERROR - 2022-06-15 09:55:41 --> 404 Page Not Found: /index
ERROR - 2022-06-15 09:55:41 --> Severity: Notice --> Undefined variable: termsList /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 44
ERROR - 2022-06-15 09:55:41 --> Severity: Notice --> Undefined variable: studentsList /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 45
ERROR - 2022-06-15 09:55:41 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/chawtechsolution/public_html/kidyview/system/core/Exceptions.php:271) /home/chawtechsolution/public_html/kidyview/system/core/Common.php 570
ERROR - 2022-06-15 09:55:47 --> 404 Page Not Found: /index
ERROR - 2022-06-15 09:55:47 --> 404 Page Not Found: /index
ERROR - 2022-06-15 09:55:51 --> 404 Page Not Found: /index
ERROR - 2022-06-15 09:55:51 --> 404 Page Not Found: /index
ERROR - 2022-06-15 09:55:52 --> 404 Page Not Found: /index
ERROR - 2022-06-15 09:55:52 --> Severity: Notice --> Undefined variable: termsList /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 44
ERROR - 2022-06-15 09:55:52 --> Severity: Notice --> Undefined variable: studentsList /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 45
ERROR - 2022-06-15 09:55:52 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/chawtechsolution/public_html/kidyview/system/core/Exceptions.php:271) /home/chawtechsolution/public_html/kidyview/system/core/Common.php 570
ERROR - 2022-06-15 09:56:46 --> 404 Page Not Found: /index
ERROR - 2022-06-15 09:56:46 --> 404 Page Not Found: /index
ERROR - 2022-06-15 09:56:47 --> 404 Page Not Found: /index
ERROR - 2022-06-15 09:57:40 --> 404 Page Not Found: /index
ERROR - 2022-06-15 09:58:15 --> 404 Page Not Found: /index
ERROR - 2022-06-15 09:58:32 --> 404 Page Not Found: /index
ERROR - 2022-06-15 09:58:33 --> 404 Page Not Found: /index
ERROR - 2022-06-15 09:58:38 --> 404 Page Not Found: /index
ERROR - 2022-06-15 09:58:38 --> 404 Page Not Found: /index
ERROR - 2022-06-15 09:58:39 --> 404 Page Not Found: /index
ERROR - 2022-06-15 10:00:27 --> 404 Page Not Found: /index
ERROR - 2022-06-15 10:01:07 --> 404 Page Not Found: /index
ERROR - 2022-06-15 10:01:07 --> 404 Page Not Found: /index
ERROR - 2022-06-15 10:01:07 --> 404 Page Not Found: /index
ERROR - 2022-06-15 10:01:07 --> 404 Page Not Found: /index
ERROR - 2022-06-15 10:01:08 --> 404 Page Not Found: /index
ERROR - 2022-06-15 10:01:08 --> 404 Page Not Found: /index
ERROR - 2022-06-15 10:01:08 --> 404 Page Not Found: /index
ERROR - 2022-06-15 10:01:08 --> 404 Page Not Found: /index
ERROR - 2022-06-15 10:01:09 --> 404 Page Not Found: /index
ERROR - 2022-06-15 10:01:09 --> 404 Page Not Found: /index
ERROR - 2022-06-15 10:01:09 --> 404 Page Not Found: /index
ERROR - 2022-06-15 10:01:10 --> 404 Page Not Found: /index
ERROR - 2022-06-15 10:01:10 --> 404 Page Not Found: /index
ERROR - 2022-06-15 10:01:10 --> 404 Page Not Found: /index
ERROR - 2022-06-15 10:01:21 --> 404 Page Not Found: /index
ERROR - 2022-06-15 10:01:57 --> 404 Page Not Found: /index
ERROR - 2022-06-15 10:01:57 --> 404 Page Not Found: /index
ERROR - 2022-06-15 10:01:57 --> 404 Page Not Found: /index
ERROR - 2022-06-15 10:01:58 --> 404 Page Not Found: /index
ERROR - 2022-06-15 10:01:58 --> 404 Page Not Found: /index
ERROR - 2022-06-15 10:01:58 --> 404 Page Not Found: /index
ERROR - 2022-06-15 10:02:30 --> 404 Page Not Found: /index
ERROR - 2022-06-15 10:02:30 --> 404 Page Not Found: /index
ERROR - 2022-06-15 10:03:19 --> 404 Page Not Found: /index
ERROR - 2022-06-15 10:03:20 --> 404 Page Not Found: /index
ERROR - 2022-06-15 10:03:26 --> 404 Page Not Found: /index
ERROR - 2022-06-15 10:03:26 --> 404 Page Not Found: /index
ERROR - 2022-06-15 10:03:27 --> 404 Page Not Found: /index
ERROR - 2022-06-15 10:05:03 --> 404 Page Not Found: /index
ERROR - 2022-06-15 10:05:15 --> 404 Page Not Found: /index
ERROR - 2022-06-15 10:05:15 --> 404 Page Not Found: /index
ERROR - 2022-06-15 10:05:19 --> 404 Page Not Found: /index
ERROR - 2022-06-15 10:05:19 --> 404 Page Not Found: /index
ERROR - 2022-06-15 10:06:16 --> 404 Page Not Found: /index
ERROR - 2022-06-15 10:06:17 --> 404 Page Not Found: /index
ERROR - 2022-06-15 10:07:00 --> 404 Page Not Found: /index
ERROR - 2022-06-15 10:07:01 --> 404 Page Not Found: /index
ERROR - 2022-06-15 10:07:44 --> 404 Page Not Found: /index
ERROR - 2022-06-15 10:07:44 --> 404 Page Not Found: /index
ERROR - 2022-06-15 10:13:57 --> 404 Page Not Found: /index
ERROR - 2022-06-15 10:13:59 --> 404 Page Not Found: /index
ERROR - 2022-06-15 10:14:17 --> 404 Page Not Found: /index
ERROR - 2022-06-15 10:14:17 --> 404 Page Not Found: /index
ERROR - 2022-06-15 10:17:00 --> 404 Page Not Found: /index
ERROR - 2022-06-15 10:17:00 --> 404 Page Not Found: /index
ERROR - 2022-06-15 10:17:00 --> 404 Page Not Found: /index
ERROR - 2022-06-15 10:17:00 --> 404 Page Not Found: /index
ERROR - 2022-06-15 10:17:00 --> 404 Page Not Found: /index
ERROR - 2022-06-15 10:17:00 --> 404 Page Not Found: /index
ERROR - 2022-06-15 10:21:41 --> 404 Page Not Found: /index
ERROR - 2022-06-15 10:21:42 --> 404 Page Not Found: /index
ERROR - 2022-06-15 10:21:48 --> 404 Page Not Found: /index
ERROR - 2022-06-15 10:21:49 --> 404 Page Not Found: /index
ERROR - 2022-06-15 10:21:50 --> 404 Page Not Found: /index
ERROR - 2022-06-15 10:21:51 --> 404 Page Not Found: /index
ERROR - 2022-06-15 10:21:51 --> 404 Page Not Found: /index
ERROR - 2022-06-15 10:21:51 --> 404 Page Not Found: /index
ERROR - 2022-06-15 10:21:51 --> 404 Page Not Found: /index
ERROR - 2022-06-15 10:21:51 --> 404 Page Not Found: /index
ERROR - 2022-06-15 10:21:52 --> 404 Page Not Found: /index
ERROR - 2022-06-15 10:21:52 --> 404 Page Not Found: /index
ERROR - 2022-06-15 10:21:52 --> 404 Page Not Found: /index
ERROR - 2022-06-15 10:21:53 --> 404 Page Not Found: /index
ERROR - 2022-06-15 10:24:33 --> 404 Page Not Found: /index
ERROR - 2022-06-15 10:24:34 --> 404 Page Not Found: /index
ERROR - 2022-06-15 10:25:53 --> 404 Page Not Found: /index
ERROR - 2022-06-15 10:25:53 --> 404 Page Not Found: /index
ERROR - 2022-06-15 10:26:59 --> 404 Page Not Found: /index
ERROR - 2022-06-15 15:56:06 --> 404 Page Not Found: /index
ERROR - 2022-06-15 15:56:56 --> 404 Page Not Found: /index
ERROR - 2022-06-15 15:57:22 --> 404 Page Not Found: /index
ERROR - 2022-06-15 15:57:32 --> 404 Page Not Found: /index
ERROR - 2022-06-15 15:57:36 --> 404 Page Not Found: /index
ERROR - 2022-06-15 15:58:12 --> 404 Page Not Found: /index
ERROR - 2022-06-15 15:58:40 --> 404 Page Not Found: /index
ERROR - 2022-06-15 16:03:42 --> 404 Page Not Found: /index
ERROR - 2022-06-15 16:05:02 --> 404 Page Not Found: /index
ERROR - 2022-06-15 16:05:08 --> Severity: Notice --> Undefined index: subject_id /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 1205
ERROR - 2022-06-15 16:05:08 --> Severity: Notice --> Undefined index: term_id /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 1207
ERROR - 2022-06-15 16:05:08 --> Severity: Notice --> Undefined index: term_id /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 1210
ERROR - 2022-06-15 16:05:08 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/chawtechsolution/public_html/kidyview/system/core/Exceptions.php:271) /home/chawtechsolution/public_html/kidyview/system/core/Common.php 570
ERROR - 2022-06-15 16:05:15 --> 404 Page Not Found: /index
ERROR - 2022-06-15 16:05:16 --> 404 Page Not Found: /index
ERROR - 2022-06-15 16:05:19 --> Severity: Notice --> Undefined index: subject_id /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 1205
ERROR - 2022-06-15 16:05:19 --> Severity: Notice --> Undefined index: term_id /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 1207
ERROR - 2022-06-15 16:05:19 --> Severity: Notice --> Undefined index: term_id /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 1210
ERROR - 2022-06-15 16:05:19 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/chawtechsolution/public_html/kidyview/system/core/Exceptions.php:271) /home/chawtechsolution/public_html/kidyview/system/core/Common.php 570
ERROR - 2022-06-15 16:07:01 --> Severity: Notice --> Undefined variable: students /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 301
ERROR - 2022-06-15 16:07:02 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/chawtechsolution/public_html/kidyview/system/core/Exceptions.php:271) /home/chawtechsolution/public_html/kidyview/system/core/Common.php 570
ERROR - 2022-06-15 16:07:03 --> Severity: Notice --> Undefined index: subject_id /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 1205
ERROR - 2022-06-15 16:07:03 --> Severity: Notice --> Undefined index: term_id /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 1207
ERROR - 2022-06-15 16:07:03 --> Severity: Notice --> Undefined index: term_id /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 1210
ERROR - 2022-06-15 16:07:03 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/chawtechsolution/public_html/kidyview/system/core/Exceptions.php:271) /home/chawtechsolution/public_html/kidyview/system/core/Common.php 570
ERROR - 2022-06-15 16:07:10 --> Severity: Notice --> Undefined index: subject_id /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 1205
ERROR - 2022-06-15 16:07:10 --> Severity: Notice --> Undefined index: term_id /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 1207
ERROR - 2022-06-15 16:07:10 --> Severity: Notice --> Undefined index: term_id /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 1210
ERROR - 2022-06-15 16:07:10 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/chawtechsolution/public_html/kidyview/system/core/Exceptions.php:271) /home/chawtechsolution/public_html/kidyview/system/core/Common.php 570
ERROR - 2022-06-15 16:07:15 --> 404 Page Not Found: /index
ERROR - 2022-06-15 16:07:38 --> Severity: Notice --> Undefined variable: students /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 301
ERROR - 2022-06-15 16:07:41 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/chawtechsolution/public_html/kidyview/system/core/Exceptions.php:271) /home/chawtechsolution/public_html/kidyview/system/core/Common.php 570
ERROR - 2022-06-15 16:07:47 --> 404 Page Not Found: /index
ERROR - 2022-06-15 16:07:52 --> 404 Page Not Found: /index
ERROR - 2022-06-15 16:07:57 --> 404 Page Not Found: /index
ERROR - 2022-06-15 16:08:01 --> 404 Page Not Found: /index
ERROR - 2022-06-15 16:08:02 --> 404 Page Not Found: /index
ERROR - 2022-06-15 16:08:03 --> 404 Page Not Found: /index
ERROR - 2022-06-15 16:08:18 --> Severity: Notice --> Undefined index: subject_id /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 1205
ERROR - 2022-06-15 16:08:18 --> Severity: Notice --> Undefined index: term_id /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 1207
ERROR - 2022-06-15 16:08:18 --> Severity: Notice --> Undefined index: term_id /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 1210
ERROR - 2022-06-15 16:08:18 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/chawtechsolution/public_html/kidyview/system/core/Exceptions.php:271) /home/chawtechsolution/public_html/kidyview/system/core/Common.php 570
ERROR - 2022-06-15 16:08:22 --> 404 Page Not Found: /index
ERROR - 2022-06-15 16:10:11 --> Severity: Notice --> Undefined index: subject_id /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 1161
ERROR - 2022-06-15 16:10:11 --> Severity: Notice --> Undefined index: term_id /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 1163
ERROR - 2022-06-15 16:10:11 --> Severity: Notice --> Undefined index: term_id /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 1166
ERROR - 2022-06-15 16:10:11 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/chawtechsolution/public_html/kidyview/system/core/Exceptions.php:271) /home/chawtechsolution/public_html/kidyview/system/core/Common.php 570
ERROR - 2022-06-15 16:10:19 --> Severity: Notice --> Undefined index: subject_id /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 1161
ERROR - 2022-06-15 16:10:19 --> Severity: Notice --> Undefined index: term_id /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 1163
ERROR - 2022-06-15 16:10:19 --> Severity: Notice --> Undefined index: term_id /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 1166
ERROR - 2022-06-15 16:10:19 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/chawtechsolution/public_html/kidyview/system/core/Exceptions.php:271) /home/chawtechsolution/public_html/kidyview/system/core/Common.php 570
ERROR - 2022-06-15 16:11:33 --> 404 Page Not Found: /index
ERROR - 2022-06-15 16:11:33 --> 404 Page Not Found: /index
ERROR - 2022-06-15 16:11:34 --> 404 Page Not Found: /index
ERROR - 2022-06-15 16:11:34 --> 404 Page Not Found: /index
ERROR - 2022-06-15 11:41:52 --> 404 Page Not Found: /index
ERROR - 2022-06-15 11:41:53 --> 404 Page Not Found: /index
ERROR - 2022-06-15 11:42:16 --> 404 Page Not Found: /index
ERROR - 2022-06-15 11:42:36 --> Severity: Notice --> Undefined index: term_id /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 1163
ERROR - 2022-06-15 11:42:36 --> Severity: Notice --> Undefined index: term_id /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 1166
ERROR - 2022-06-15 11:42:36 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/chawtechsolution/public_html/kidyview/system/core/Exceptions.php:271) /home/chawtechsolution/public_html/kidyview/system/core/Common.php 570
ERROR - 2022-06-15 11:43:27 --> 404 Page Not Found: /index
ERROR - 2022-06-15 11:43:27 --> 404 Page Not Found: /index
ERROR - 2022-06-15 11:43:28 --> 404 Page Not Found: /index
ERROR - 2022-06-15 11:44:35 --> 404 Page Not Found: /index
ERROR - 2022-06-15 11:44:44 --> 404 Page Not Found: /index
ERROR - 2022-06-15 11:44:45 --> 404 Page Not Found: /index
ERROR - 2022-06-15 11:45:11 --> 404 Page Not Found: /index
ERROR - 2022-06-15 11:45:29 --> 404 Page Not Found: /index
ERROR - 2022-06-15 11:45:30 --> 404 Page Not Found: /index
ERROR - 2022-06-15 11:48:51 --> 404 Page Not Found: /index
ERROR - 2022-06-15 11:48:51 --> 404 Page Not Found: /index
ERROR - 2022-06-15 11:48:53 --> 404 Page Not Found: /index
ERROR - 2022-06-15 11:50:04 --> 404 Page Not Found: /index
ERROR - 2022-06-15 11:50:05 --> 404 Page Not Found: /index
ERROR - 2022-06-15 11:50:05 --> 404 Page Not Found: /index
ERROR - 2022-06-15 11:51:42 --> 404 Page Not Found: /index
ERROR - 2022-06-15 11:51:42 --> 404 Page Not Found: /index
ERROR - 2022-06-15 11:51:43 --> 404 Page Not Found: /index
ERROR - 2022-06-15 11:54:21 --> 404 Page Not Found: /index
ERROR - 2022-06-15 11:54:37 --> 404 Page Not Found: /index
ERROR - 2022-06-15 11:54:38 --> 404 Page Not Found: /index
ERROR - 2022-06-15 11:54:38 --> 404 Page Not Found: /index
ERROR - 2022-06-15 11:54:52 --> 404 Page Not Found: /index
ERROR - 2022-06-15 11:55:06 --> 404 Page Not Found: /index
ERROR - 2022-06-15 11:55:07 --> 404 Page Not Found: /index
ERROR - 2022-06-15 11:55:07 --> 404 Page Not Found: /index
ERROR - 2022-06-15 11:55:39 --> 404 Page Not Found: /index
ERROR - 2022-06-15 11:55:48 --> 404 Page Not Found: /index
ERROR - 2022-06-15 11:55:49 --> 404 Page Not Found: /index
ERROR - 2022-06-15 11:56:32 --> 404 Page Not Found: /index
ERROR - 2022-06-15 11:56:46 --> 404 Page Not Found: /index
ERROR - 2022-06-15 11:56:47 --> 404 Page Not Found: /index
ERROR - 2022-06-15 11:56:47 --> 404 Page Not Found: /index
ERROR - 2022-06-15 11:57:05 --> 404 Page Not Found: /index
ERROR - 2022-06-15 11:57:21 --> 404 Page Not Found: /index
ERROR - 2022-06-15 11:57:22 --> 404 Page Not Found: /index
ERROR - 2022-06-15 11:57:22 --> 404 Page Not Found: /index
ERROR - 2022-06-15 11:57:44 --> 404 Page Not Found: /index
ERROR - 2022-06-15 11:57:55 --> 404 Page Not Found: /index
ERROR - 2022-06-15 11:57:56 --> 404 Page Not Found: /index
ERROR - 2022-06-15 11:57:56 --> 404 Page Not Found: /index
ERROR - 2022-06-15 11:58:15 --> 404 Page Not Found: /index
ERROR - 2022-06-15 11:58:15 --> 404 Page Not Found: /index
ERROR - 2022-06-15 11:58:16 --> 404 Page Not Found: /index
ERROR - 2022-06-15 11:59:03 --> 404 Page Not Found: /index
ERROR - 2022-06-15 11:59:03 --> 404 Page Not Found: /index
ERROR - 2022-06-15 11:59:04 --> 404 Page Not Found: /index
ERROR - 2022-06-15 11:59:04 --> 404 Page Not Found: /index
ERROR - 2022-06-15 11:59:11 --> 404 Page Not Found: /index
ERROR - 2022-06-15 11:59:11 --> 404 Page Not Found: /index
ERROR - 2022-06-15 11:59:21 --> 404 Page Not Found: /index
ERROR - 2022-06-15 11:59:32 --> 404 Page Not Found: /index
ERROR - 2022-06-15 11:59:33 --> 404 Page Not Found: /index
ERROR - 2022-06-15 11:59:33 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:00:03 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:00:04 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:00:05 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:00:30 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:00:36 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:00:37 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:01:10 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:01:22 --> Query error: Unknown column 'term_id' in 'where clause' - Invalid query: UPDATE `activities_final_subject_result` SET `is_beginner` = '0', `is_intermediate` = '1', `is_advanced` = '0', `is_expert` = '0', `remarks` = ''
WHERE `session_id` = '29'
AND `school_id` = '20'
AND `class_id` = '13'
AND `student_id` = '57'
AND `subject_id` = '85'
AND `term_id` = 'all_terms'
ERROR - 2022-06-15 12:01:25 --> Query error: Unknown column 'term_id' in 'where clause' - Invalid query: UPDATE `activities_final_subject_result` SET `is_beginner` = '0', `is_intermediate` = '0', `is_advanced` = '1', `is_expert` = '0', `remarks` = ''
WHERE `session_id` = '29'
AND `school_id` = '20'
AND `class_id` = '13'
AND `student_id` = '57'
AND `subject_id` = '88'
AND `term_id` = 'all_terms'
ERROR - 2022-06-15 12:01:29 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:01:29 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:01:32 --> Query error: Unknown column 'term_id' in 'where clause' - Invalid query: UPDATE `activities_final_subject_result` SET `is_beginner` = '0', `is_intermediate` = '0', `is_advanced` = '1', `is_expert` = '0', `remarks` = ''
WHERE `session_id` = '29'
AND `school_id` = '20'
AND `class_id` = '13'
AND `student_id` = '57'
AND `subject_id` = '86'
AND `term_id` = 'all_terms'
ERROR - 2022-06-15 12:01:58 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:01:58 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:01:58 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:01:58 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:01:59 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:01:59 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:01:59 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:01:59 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:01:59 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:02:00 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:02:13 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:02:26 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:02:27 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:02:27 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:02:27 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:02:28 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:02:28 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:02:28 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:02:28 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:02:29 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:02:29 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:02:29 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:02:30 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:02:42 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:03:03 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:03:38 --> Severity: Notice --> Undefined variable: students /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 301
ERROR - 2022-06-15 12:03:42 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/chawtechsolution/public_html/kidyview/system/core/Exceptions.php:271) /home/chawtechsolution/public_html/kidyview/system/core/Common.php 570
ERROR - 2022-06-15 12:04:56 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:04:56 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:04:56 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:04:56 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:04:56 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:04:57 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:04:57 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:04:57 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:04:59 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:04:59 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:04:59 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:04:59 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:04:59 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:04:59 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:06:35 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:06:35 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:06:35 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:06:35 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:06:36 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:06:36 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:09:51 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:09:51 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:09:51 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:09:51 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:09:52 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:09:52 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:09:52 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:09:52 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:09:54 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:09:55 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:10:23 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:10:23 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:10:23 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:10:23 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:10:23 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:10:23 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:10:23 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:10:24 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:10:24 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:10:24 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:12:00 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:12:05 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:12:16 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:12:16 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:13:04 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:13:05 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:13:09 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:13:10 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:13:13 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:13:16 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:13:17 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:13:17 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:13:19 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:14:33 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:14:39 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:14:47 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:14:47 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:14:47 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:14:59 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:15:00 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:15:00 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:15:00 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:15:03 --> Severity: Notice --> Undefined variable: students /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 301
ERROR - 2022-06-15 12:15:06 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/chawtechsolution/public_html/kidyview/system/core/Exceptions.php:271) /home/chawtechsolution/public_html/kidyview/system/core/Common.php 570
ERROR - 2022-06-15 12:15:13 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:15:13 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:15:15 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:15:15 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:15:19 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:15:19 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:15:28 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:15:30 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:15:56 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:15:56 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:16:30 --> Severity: Notice --> Undefined variable: students /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 301
ERROR - 2022-06-15 12:16:33 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/chawtechsolution/public_html/kidyview/system/core/Exceptions.php:271) /home/chawtechsolution/public_html/kidyview/system/core/Common.php 570
ERROR - 2022-06-15 12:16:45 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:17:01 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:17:13 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:17:59 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:18:11 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:18:11 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:30:03 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:30:03 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:30:05 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:30:41 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:31:04 --> Severity: Notice --> Undefined index: resultStatus /home/chawtechsolution/public_html/kidyview/application/controllers/api/User.php 8889
ERROR - 2022-06-15 12:31:04 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/chawtechsolution/public_html/kidyview/system/core/Exceptions.php:271) /home/chawtechsolution/public_html/kidyview/system/core/Common.php 570
ERROR - 2022-06-15 12:31:09 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:31:10 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:31:17 --> Severity: Notice --> Undefined index: resultStatus /home/chawtechsolution/public_html/kidyview/application/controllers/api/User.php 8897
ERROR - 2022-06-15 12:31:17 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/chawtechsolution/public_html/kidyview/system/core/Exceptions.php:271) /home/chawtechsolution/public_html/kidyview/system/core/Common.php 570
ERROR - 2022-06-15 12:31:21 --> Severity: Notice --> Undefined index: resultStatus /home/chawtechsolution/public_html/kidyview/application/controllers/api/User.php 8897
ERROR - 2022-06-15 12:31:21 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/chawtechsolution/public_html/kidyview/system/core/Exceptions.php:271) /home/chawtechsolution/public_html/kidyview/system/core/Common.php 570
ERROR - 2022-06-15 12:33:36 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:34:02 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:34:02 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:37:03 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:37:03 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:37:04 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:38:03 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:38:08 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:38:56 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:40:17 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:41:27 --> Severity: Notice --> Undefined variable: students /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 301
ERROR - 2022-06-15 12:41:30 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/chawtechsolution/public_html/kidyview/system/core/Exceptions.php:271) /home/chawtechsolution/public_html/kidyview/system/core/Common.php 570
ERROR - 2022-06-15 12:50:58 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:50:58 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:52:01 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:52:01 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:52:07 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:52:10 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:53:40 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:53:59 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:53:59 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:55:57 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:55:57 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:56:03 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:56:26 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:56:26 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:57:26 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:57:43 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:58:50 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:58:50 --> 404 Page Not Found: /index
ERROR - 2022-06-15 12:59:03 --> Severity: Notice --> Undefined variable: students /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 301
ERROR - 2022-06-15 12:59:06 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/chawtechsolution/public_html/kidyview/system/core/Exceptions.php:271) /home/chawtechsolution/public_html/kidyview/system/core/Common.php 570
ERROR - 2022-06-15 12:59:17 --> 404 Page Not Found: /index
ERROR - 2022-06-15 13:00:03 --> 404 Page Not Found: /index
ERROR - 2022-06-15 13:00:37 --> 404 Page Not Found: /index
ERROR - 2022-06-15 13:00:52 --> 404 Page Not Found: /index
ERROR - 2022-06-15 13:00:52 --> 404 Page Not Found: /index
ERROR - 2022-06-15 13:00:58 --> 404 Page Not Found: /index
ERROR - 2022-06-15 13:00:59 --> 404 Page Not Found: /index
ERROR - 2022-06-15 13:01:00 --> 404 Page Not Found: /index
ERROR - 2022-06-15 13:01:13 --> Severity: Notice --> Undefined variable: students /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 301
ERROR - 2022-06-15 13:01:16 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/chawtechsolution/public_html/kidyview/system/core/Exceptions.php:271) /home/chawtechsolution/public_html/kidyview/system/core/Common.php 570
ERROR - 2022-06-15 13:01:49 --> 404 Page Not Found: /index
ERROR - 2022-06-15 13:01:49 --> 404 Page Not Found: /index
ERROR - 2022-06-15 13:02:23 --> 404 Page Not Found: /index
ERROR - 2022-06-15 13:02:47 --> Severity: Notice --> Undefined variable: students /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 301
ERROR - 2022-06-15 13:02:50 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/chawtechsolution/public_html/kidyview/system/core/Exceptions.php:271) /home/chawtechsolution/public_html/kidyview/system/core/Common.php 570
ERROR - 2022-06-15 13:02:59 --> 404 Page Not Found: /index
ERROR - 2022-06-15 13:02:59 --> 404 Page Not Found: /index
ERROR - 2022-06-15 13:05:47 --> 404 Page Not Found: /index
ERROR - 2022-06-15 13:06:14 --> 404 Page Not Found: /index
ERROR - 2022-06-15 13:06:53 --> 404 Page Not Found: /index
ERROR - 2022-06-15 13:07:06 --> 404 Page Not Found: /index
ERROR - 2022-06-15 13:08:03 --> 404 Page Not Found: /index
ERROR - 2022-06-15 13:08:19 --> 404 Page Not Found: /index
ERROR - 2022-06-15 13:10:38 --> 404 Page Not Found: /index
ERROR - 2022-06-15 13:10:40 --> 404 Page Not Found: /index
ERROR - 2022-06-15 13:10:53 --> Severity: Notice --> Undefined variable: students /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 301
ERROR - 2022-06-15 13:10:56 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/chawtechsolution/public_html/kidyview/system/core/Exceptions.php:271) /home/chawtechsolution/public_html/kidyview/system/core/Common.php 570
ERROR - 2022-06-15 13:11:54 --> 404 Page Not Found: /index
ERROR - 2022-06-15 13:13:00 --> 404 Page Not Found: /index
ERROR - 2022-06-15 13:14:05 --> 404 Page Not Found: /index
ERROR - 2022-06-15 13:14:15 --> Severity: Notice --> Undefined variable: students /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 301
ERROR - 2022-06-15 13:14:18 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/chawtechsolution/public_html/kidyview/system/core/Exceptions.php:271) /home/chawtechsolution/public_html/kidyview/system/core/Common.php 570
ERROR - 2022-06-15 13:14:28 --> 404 Page Not Found: /index
ERROR - 2022-06-15 13:14:28 --> 404 Page Not Found: /index
ERROR - 2022-06-15 13:14:31 --> 404 Page Not Found: /index
ERROR - 2022-06-15 13:14:32 --> 404 Page Not Found: /index
ERROR - 2022-06-15 13:14:33 --> 404 Page Not Found: /index
ERROR - 2022-06-15 13:20:59 --> 404 Page Not Found: /index
ERROR - 2022-06-15 13:21:00 --> 404 Page Not Found: /index
ERROR - 2022-06-15 13:21:00 --> 404 Page Not Found: /index
ERROR - 2022-06-15 13:21:00 --> 404 Page Not Found: /index
ERROR - 2022-06-15 13:21:00 --> 404 Page Not Found: /index
ERROR - 2022-06-15 13:21:01 --> 404 Page Not Found: /index
ERROR - 2022-06-15 13:21:01 --> 404 Page Not Found: /index
ERROR - 2022-06-15 13:21:01 --> 404 Page Not Found: /index
ERROR - 2022-06-15 13:25:28 --> Severity: Notice --> Undefined variable: students /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 301
ERROR - 2022-06-15 13:25:31 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/chawtechsolution/public_html/kidyview/system/core/Exceptions.php:271) /home/chawtechsolution/public_html/kidyview/system/core/Common.php 570
ERROR - 2022-06-15 13:32:37 --> 404 Page Not Found: /index
ERROR - 2022-06-15 13:34:17 --> Severity: Notice --> Undefined variable: students /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 301
ERROR - 2022-06-15 13:34:20 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/chawtechsolution/public_html/kidyview/system/core/Exceptions.php:271) /home/chawtechsolution/public_html/kidyview/system/core/Common.php 570
ERROR - 2022-06-15 13:42:16 --> Severity: Notice --> Undefined variable: students /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 301
ERROR - 2022-06-15 13:42:20 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/chawtechsolution/public_html/kidyview/system/core/Exceptions.php:271) /home/chawtechsolution/public_html/kidyview/system/core/Common.php 570
ERROR - 2022-06-15 13:42:37 --> Severity: error --> Exception: syntax error, unexpected end of file /home/chawtechsolution/public_html/kidyview/application/views/marksheet.php 623
ERROR - 2022-06-15 13:46:11 --> Severity: Notice --> Undefined variable: students /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 301
ERROR - 2022-06-15 13:46:14 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/chawtechsolution/public_html/kidyview/system/core/Exceptions.php:271) /home/chawtechsolution/public_html/kidyview/system/core/Common.php 570
ERROR - 2022-06-15 13:56:27 --> Severity: Notice --> Undefined variable: students /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 301
ERROR - 2022-06-15 13:56:30 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/chawtechsolution/public_html/kidyview/system/core/Exceptions.php:271) /home/chawtechsolution/public_html/kidyview/system/core/Common.php 570
ERROR - 2022-06-15 13:57:19 --> Severity: Notice --> Undefined variable: totalSubject /home/chawtechsolution/public_html/kidyview/application/views/marksheet.php 552
ERROR - 2022-06-15 13:58:50 --> Severity: Notice --> Undefined variable: students /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 301
ERROR - 2022-06-15 13:58:53 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/chawtechsolution/public_html/kidyview/system/core/Exceptions.php:271) /home/chawtechsolution/public_html/kidyview/system/core/Common.php 570
ERROR - 2022-06-15 19:08:35 --> Severity: Notice --> Undefined variable: students /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 301
ERROR - 2022-06-15 19:08:38 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/chawtechsolution/public_html/kidyview/system/core/Exceptions.php:271) /home/chawtechsolution/public_html/kidyview/system/core/Common.php 570
ERROR - 2022-06-15 19:15:02 --> Severity: Notice --> Undefined variable: students /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 301
ERROR - 2022-06-15 19:15:05 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/chawtechsolution/public_html/kidyview/system/core/Exceptions.php:271) /home/chawtechsolution/public_html/kidyview/system/core/Common.php 570
ERROR - 2022-06-15 19:15:21 --> Severity: Notice --> Undefined variable: totalSubject /home/chawtechsolution/public_html/kidyview/application/views/marksheet.php 552
ERROR - 2022-06-15 19:18:31 --> Severity: Notice --> Undefined variable: students /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 301
ERROR - 2022-06-15 19:18:34 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/chawtechsolution/public_html/kidyview/system/core/Exceptions.php:271) /home/chawtechsolution/public_html/kidyview/system/core/Common.php 570
ERROR - 2022-06-15 19:21:38 --> Severity: Notice --> Undefined variable: students /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 301
ERROR - 2022-06-15 19:21:42 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/chawtechsolution/public_html/kidyview/system/core/Exceptions.php:271) /home/chawtechsolution/public_html/kidyview/system/core/Common.php 570
ERROR - 2022-06-15 19:23:36 --> Severity: Notice --> Undefined variable: students /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 301
ERROR - 2022-06-15 19:23:39 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/chawtechsolution/public_html/kidyview/system/core/Exceptions.php:271) /home/chawtechsolution/public_html/kidyview/system/core/Common.php 570
ERROR - 2022-06-15 19:25:08 --> Severity: Notice --> Undefined variable: students /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 301
ERROR - 2022-06-15 19:25:11 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/chawtechsolution/public_html/kidyview/system/core/Exceptions.php:271) /home/chawtechsolution/public_html/kidyview/system/core/Common.php 570
ERROR - 2022-06-15 13:54:50 --> 404 Page Not Found: /index
ERROR - 2022-06-15 13:54:53 --> 404 Page Not Found: /index
ERROR - 2022-06-15 22:00:11 --> 404 Page Not Found: /index
ERROR - 2022-06-15 22:15:06 --> 404 Page Not Found: /index
ERROR - 2022-06-15 22:41:26 --> 404 Page Not Found: /index
