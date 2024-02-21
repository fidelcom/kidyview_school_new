<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2022-04-29 11:27:00 --> 404 Page Not Found: /index
ERROR - 2022-04-29 12:04:40 --> 404 Page Not Found: /index
ERROR - 2022-04-29 13:05:39 --> 404 Page Not Found: /index
ERROR - 2022-04-29 13:05:39 --> 404 Page Not Found: /index
ERROR - 2022-04-29 13:13:01 --> 404 Page Not Found: /index
ERROR - 2022-04-29 13:13:01 --> 404 Page Not Found: /index
ERROR - 2022-04-29 13:13:39 --> 404 Page Not Found: /index
ERROR - 2022-04-29 13:13:40 --> 404 Page Not Found: /index
ERROR - 2022-04-29 13:15:17 --> 404 Page Not Found: /index
ERROR - 2022-04-29 13:15:18 --> 404 Page Not Found: /index
ERROR - 2022-04-29 13:15:22 --> 404 Page Not Found: /index
ERROR - 2022-04-29 13:15:23 --> 404 Page Not Found: /index
ERROR - 2022-04-29 13:15:26 --> 404 Page Not Found: /index
ERROR - 2022-04-29 13:15:27 --> 404 Page Not Found: /index
ERROR - 2022-04-29 13:18:46 --> 404 Page Not Found: /index
ERROR - 2022-04-29 13:18:47 --> 404 Page Not Found: /index
ERROR - 2022-04-29 13:20:04 --> 404 Page Not Found: /index
ERROR - 2022-04-29 13:20:05 --> 404 Page Not Found: /index
ERROR - 2022-04-29 13:20:14 --> 404 Page Not Found: /index
ERROR - 2022-04-29 13:20:14 --> 404 Page Not Found: /index
ERROR - 2022-04-29 13:29:09 --> 404 Page Not Found: /index
ERROR - 2022-04-29 13:29:09 --> 404 Page Not Found: /index
ERROR - 2022-04-29 13:29:47 --> 404 Page Not Found: /index
ERROR - 2022-04-29 13:29:48 --> 404 Page Not Found: /index
ERROR - 2022-04-29 13:30:54 --> 404 Page Not Found: /index
ERROR - 2022-04-29 13:30:55 --> 404 Page Not Found: /index
ERROR - 2022-04-29 13:31:04 --> 404 Page Not Found: api/School/getClassStudentBySession
ERROR - 2022-04-29 13:31:25 --> 404 Page Not Found: api/School/getClassStudentBySession
ERROR - 2022-04-29 13:32:09 --> 404 Page Not Found: /index
ERROR - 2022-04-29 13:32:10 --> 404 Page Not Found: /index
ERROR - 2022-04-29 13:32:21 --> 404 Page Not Found: /index
ERROR - 2022-04-29 13:32:22 --> 404 Page Not Found: /index
ERROR - 2022-04-29 13:32:34 --> 404 Page Not Found: api/School/getClassStudentBySession
ERROR - 2022-04-29 14:03:26 --> 404 Page Not Found: /index
ERROR - 2022-04-29 14:03:28 --> 404 Page Not Found: /index
ERROR - 2022-04-29 14:03:36 --> 404 Page Not Found: api/School/getClassStudentBySession
ERROR - 2022-04-29 14:06:07 --> 404 Page Not Found: /index
ERROR - 2022-04-29 14:06:07 --> 404 Page Not Found: /index
ERROR - 2022-04-29 14:06:12 --> 404 Page Not Found: /index
ERROR - 2022-04-29 14:06:13 --> 404 Page Not Found: /index
ERROR - 2022-04-29 14:07:20 --> 404 Page Not Found: /index
ERROR - 2022-04-29 14:07:21 --> 404 Page Not Found: /index
ERROR - 2022-04-29 14:07:55 --> 404 Page Not Found: /index
ERROR - 2022-04-29 14:08:45 --> 404 Page Not Found: /index
ERROR - 2022-04-29 14:08:46 --> 404 Page Not Found: /index
ERROR - 2022-04-29 14:08:52 --> 404 Page Not Found: /index
ERROR - 2022-04-29 14:08:52 --> 404 Page Not Found: /index
ERROR - 2022-04-29 14:09:03 --> Severity: error --> Exception: Too few arguments to function Fees::getClassStudentBySession_get(), 0 passed in /home/chawtechsolution/public_html/kidyview/application/libraries/REST_Controller.php on line 739 and exactly 3 expected /home/chawtechsolution/public_html/kidyview/application/controllers/api/school/Fees.php 383
ERROR - 2022-04-29 14:10:14 --> 404 Page Not Found: /index
ERROR - 2022-04-29 14:10:15 --> 404 Page Not Found: /index
ERROR - 2022-04-29 14:10:20 --> 404 Page Not Found: /index
ERROR - 2022-04-29 14:10:20 --> 404 Page Not Found: /index
ERROR - 2022-04-29 14:32:23 --> 404 Page Not Found: /index
ERROR - 2022-04-29 14:32:23 --> 404 Page Not Found: /index
ERROR - 2022-04-29 14:33:33 --> Query error: Unknown column 'child.childlname' in 'field list' - Invalid query: SELECT CONCAT(ch.childfname, " ", `ch`.`childmname`, " ", child.childlname ) as studentName, `ch`.`id`
FROM `child` as `ch`
LEFT JOIN `child_class` as `chc` ON `child`.`id`=`chc`.`chil_id`
WHERE `chc`.`school_id` = '191'
AND `chc`.`session_id` = '43'
AND `chc`.`classid` = '74'
ERROR - 2022-04-29 14:34:37 --> Query error: Unknown column 'chc.classid' in 'where clause' - Invalid query: SELECT CONCAT(ch.childfname, " ", `ch`.`childmname`, " ", ch.childlname ) as studentName, `ch`.`id`
FROM `child` as `ch`
LEFT JOIN `child_class` as `chc` ON `child`.`id`=`chc`.`chil_id`
WHERE `chc`.`school_id` = '191'
AND `chc`.`session_id` = '43'
AND `chc`.`classid` = '74'
ERROR - 2022-04-29 14:35:04 --> Query error: Unknown column 'child.id' in 'on clause' - Invalid query: SELECT CONCAT(ch.childfname, " ", `ch`.`childmname`, " ", ch.childlname ) as studentName, `ch`.`id`
FROM `child` as `ch`
LEFT JOIN `child_class` as `chc` ON `child`.`id`=`chc`.`chil_id`
WHERE `chc`.`school_id` = '191'
AND `chc`.`session_id` = '43'
AND `chc`.`class_id` = '74'
ERROR - 2022-04-29 14:36:21 --> Query error: Unknown column 'chc.chil_id' in 'on clause' - Invalid query: SELECT CONCAT(ch.childfname, " ", `ch`.`childmname`, " ", ch.childlname ) as studentName, `ch`.`id`
FROM `child` as `ch`
LEFT JOIN `child_class` as `chc` ON `ch`.`id`=`chc`.`chil_id`
WHERE `chc`.`school_id` = '191'
AND `chc`.`session_id` = '43'
AND `chc`.`class_id` = '74'
ERROR - 2022-04-29 14:40:34 --> 404 Page Not Found: /index
ERROR - 2022-04-29 14:40:34 --> 404 Page Not Found: /index
ERROR - 2022-04-29 14:42:58 --> 404 Page Not Found: /index
ERROR - 2022-04-29 14:42:59 --> 404 Page Not Found: /index
ERROR - 2022-04-29 14:50:18 --> 404 Page Not Found: /index
ERROR - 2022-04-29 14:50:18 --> 404 Page Not Found: /index
ERROR - 2022-04-29 14:52:45 --> 404 Page Not Found: /index
ERROR - 2022-04-29 14:52:45 --> 404 Page Not Found: /index
ERROR - 2022-04-29 14:52:51 --> 404 Page Not Found: /index
ERROR - 2022-04-29 14:52:51 --> 404 Page Not Found: /index
ERROR - 2022-04-29 05:45:59 --> 404 Page Not Found: /index
ERROR - 2022-04-29 05:46:01 --> 404 Page Not Found: /index
ERROR - 2022-04-29 05:46:02 --> 404 Page Not Found: /index
ERROR - 2022-04-29 05:46:03 --> 404 Page Not Found: /index
ERROR - 2022-04-29 05:46:05 --> 404 Page Not Found: /index
ERROR - 2022-04-29 05:46:06 --> 404 Page Not Found: /index
ERROR - 2022-04-29 05:46:07 --> 404 Page Not Found: /index
ERROR - 2022-04-29 05:46:08 --> 404 Page Not Found: /index
ERROR - 2022-04-29 05:46:09 --> 404 Page Not Found: /index
ERROR - 2022-04-29 05:46:10 --> 404 Page Not Found: api/Env/index
ERROR - 2022-04-29 05:46:11 --> 404 Page Not Found: /index
ERROR - 2022-04-29 05:46:13 --> 404 Page Not Found: /index
ERROR - 2022-04-29 05:46:14 --> 404 Page Not Found: /index
ERROR - 2022-04-29 05:46:15 --> 404 Page Not Found: /index
ERROR - 2022-04-29 05:46:16 --> 404 Page Not Found: /index
ERROR - 2022-04-29 05:46:17 --> 404 Page Not Found: /index
ERROR - 2022-04-29 05:46:18 --> 404 Page Not Found: /index
ERROR - 2022-04-29 05:46:19 --> 404 Page Not Found: /index
ERROR - 2022-04-29 05:46:21 --> 404 Page Not Found: /index
ERROR - 2022-04-29 05:46:22 --> 404 Page Not Found: /index
ERROR - 2022-04-29 05:46:23 --> 404 Page Not Found: /index
ERROR - 2022-04-29 05:46:24 --> 404 Page Not Found: /index
ERROR - 2022-04-29 05:46:25 --> 404 Page Not Found: /index
ERROR - 2022-04-29 05:46:26 --> 404 Page Not Found: /index
ERROR - 2022-04-29 05:46:27 --> 404 Page Not Found: /index
ERROR - 2022-04-29 05:46:29 --> 404 Page Not Found: /index
ERROR - 2022-04-29 05:46:30 --> 404 Page Not Found: /index
ERROR - 2022-04-29 05:46:31 --> 404 Page Not Found: /index
ERROR - 2022-04-29 05:46:32 --> 404 Page Not Found: /index
ERROR - 2022-04-29 05:46:33 --> 404 Page Not Found: /index
ERROR - 2022-04-29 05:46:34 --> 404 Page Not Found: /index
ERROR - 2022-04-29 05:46:35 --> 404 Page Not Found: /index
ERROR - 2022-04-29 05:46:38 --> 404 Page Not Found: /index
ERROR - 2022-04-29 15:55:19 --> 404 Page Not Found: /index
ERROR - 2022-04-29 16:00:51 --> 404 Page Not Found: /index
ERROR - 2022-04-29 16:00:57 --> Severity: Notice --> Undefined index: email /home/chawtechsolution/public_html/kidyview/application/controllers/api/Auth.php 400
ERROR - 2022-04-29 16:00:57 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/chawtechsolution/public_html/kidyview/system/core/Exceptions.php:271) /home/chawtechsolution/public_html/kidyview/system/core/Common.php 570
ERROR - 2022-04-29 16:15:12 --> 404 Page Not Found: /index
ERROR - 2022-04-29 16:15:13 --> 404 Page Not Found: /index
ERROR - 2022-04-29 16:16:42 --> 404 Page Not Found: /index
ERROR - 2022-04-29 16:16:43 --> 404 Page Not Found: /index
ERROR - 2022-04-29 16:28:41 --> 404 Page Not Found: /index
ERROR - 2022-04-29 16:28:42 --> 404 Page Not Found: /index
ERROR - 2022-04-29 16:28:52 --> 404 Page Not Found: /index
ERROR - 2022-04-29 16:28:53 --> 404 Page Not Found: /index
ERROR - 2022-04-29 16:32:00 --> 404 Page Not Found: /index
ERROR - 2022-04-29 16:39:32 --> 404 Page Not Found: /index
ERROR - 2022-04-29 16:39:32 --> 404 Page Not Found: /index
ERROR - 2022-04-29 16:39:49 --> 404 Page Not Found: /index
ERROR - 2022-04-29 16:39:49 --> 404 Page Not Found: /index
ERROR - 2022-04-29 16:41:18 --> 404 Page Not Found: /index
ERROR - 2022-04-29 16:41:19 --> 404 Page Not Found: /index
ERROR - 2022-04-29 16:41:31 --> 404 Page Not Found: /index
ERROR - 2022-04-29 16:41:32 --> 404 Page Not Found: /index
ERROR - 2022-04-29 16:43:31 --> 404 Page Not Found: api/Invoicedownload/studentinvoicebysession
ERROR - 2022-04-29 16:43:37 --> 404 Page Not Found: /index
ERROR - 2022-04-29 16:43:37 --> 404 Page Not Found: /index
ERROR - 2022-04-29 16:43:49 --> 404 Page Not Found: api/Invoicedownload/studentinvoicebysession
ERROR - 2022-04-29 16:43:59 --> 404 Page Not Found: /index
ERROR - 2022-04-29 16:44:00 --> 404 Page Not Found: /index
ERROR - 2022-04-29 16:45:13 --> 404 Page Not Found: /index
ERROR - 2022-04-29 16:45:13 --> 404 Page Not Found: /index
ERROR - 2022-04-29 16:45:29 --> 404 Page Not Found: api/Invoicedownload/studentinvoicebysession
ERROR - 2022-04-29 16:49:56 --> 404 Page Not Found: /index
ERROR - 2022-04-29 16:49:56 --> 404 Page Not Found: /index
ERROR - 2022-04-29 16:49:56 --> 404 Page Not Found: /index
ERROR - 2022-04-29 16:49:56 --> 404 Page Not Found: /index
ERROR - 2022-04-29 16:49:57 --> 404 Page Not Found: /index
ERROR - 2022-04-29 16:49:57 --> 404 Page Not Found: /index
ERROR - 2022-04-29 16:49:57 --> 404 Page Not Found: /index
ERROR - 2022-04-29 16:49:57 --> 404 Page Not Found: /index
ERROR - 2022-04-29 16:49:57 --> 404 Page Not Found: /index
ERROR - 2022-04-29 16:49:58 --> 404 Page Not Found: /index
ERROR - 2022-04-29 16:49:58 --> 404 Page Not Found: /index
ERROR - 2022-04-29 16:49:58 --> 404 Page Not Found: /index
ERROR - 2022-04-29 16:49:58 --> 404 Page Not Found: /index
ERROR - 2022-04-29 17:14:15 --> 404 Page Not Found: /index
ERROR - 2022-04-29 17:14:16 --> 404 Page Not Found: /index
ERROR - 2022-04-29 17:15:04 --> 404 Page Not Found: /index
ERROR - 2022-04-29 18:12:19 --> Severity: error --> Exception: Call to undefined function dd() /home/chawtechsolution/public_html/kidyview/application/controllers/api/Invoicedownload.php 170
ERROR - 2022-04-29 18:12:22 --> Severity: error --> Exception: Call to undefined function dd() /home/chawtechsolution/public_html/kidyview/application/controllers/api/Invoicedownload.php 170
ERROR - 2022-04-29 18:12:34 --> Severity: error --> Exception: syntax error, unexpected 'print_r' (T_STRING), expecting ',' or ';' /home/chawtechsolution/public_html/kidyview/application/controllers/api/Invoicedownload.php 170
ERROR - 2022-04-29 18:12:36 --> Severity: error --> Exception: syntax error, unexpected 'print_r' (T_STRING), expecting ',' or ';' /home/chawtechsolution/public_html/kidyview/application/controllers/api/Invoicedownload.php 170
ERROR - 2022-04-29 09:04:49 --> 404 Page Not Found: /index
