<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2022-06-06 11:52:27 --> 404 Page Not Found: /index
ERROR - 2022-06-06 11:56:33 --> 404 Page Not Found: /index
ERROR - 2022-06-06 11:56:33 --> 404 Page Not Found: /index
ERROR - 2022-06-06 11:56:33 --> 404 Page Not Found: /index
ERROR - 2022-06-06 11:56:33 --> 404 Page Not Found: /index
ERROR - 2022-06-06 11:56:34 --> 404 Page Not Found: /index
ERROR - 2022-06-06 11:56:34 --> 404 Page Not Found: /index
ERROR - 2022-06-06 11:56:34 --> 404 Page Not Found: /index
ERROR - 2022-06-06 11:56:34 --> 404 Page Not Found: /index
ERROR - 2022-06-06 11:56:51 --> 404 Page Not Found: /index
ERROR - 2022-06-06 11:56:52 --> 404 Page Not Found: /index
ERROR - 2022-06-06 11:56:52 --> Severity: Notice --> Trying to get property 'id' of non-object /home/chawtechsolution/public_html/kidyview/application/models/teachers/Results_model.php 230
ERROR - 2022-06-06 11:56:52 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/chawtechsolution/public_html/kidyview/system/core/Exceptions.php:271) /home/chawtechsolution/public_html/kidyview/system/core/Common.php 570
ERROR - 2022-06-06 11:57:41 --> 404 Page Not Found: /index
ERROR - 2022-06-06 11:57:42 --> 404 Page Not Found: /index
ERROR - 2022-06-06 12:00:53 --> 404 Page Not Found: /index
ERROR - 2022-06-06 12:00:54 --> 404 Page Not Found: /index
ERROR - 2022-06-06 13:14:39 --> 404 Page Not Found: /index
ERROR - 2022-06-06 19:06:50 --> 404 Page Not Found: /index
ERROR - 2022-06-06 19:06:50 --> 404 Page Not Found: /index
ERROR - 2022-06-06 19:06:50 --> 404 Page Not Found: /index
ERROR - 2022-06-06 19:06:51 --> 404 Page Not Found: /index
ERROR - 2022-06-06 19:06:51 --> 404 Page Not Found: /index
ERROR - 2022-06-06 19:06:51 --> 404 Page Not Found: /index
ERROR - 2022-06-06 19:06:51 --> 404 Page Not Found: /index
ERROR - 2022-06-06 19:06:51 --> 404 Page Not Found: /index
ERROR - 2022-06-06 19:06:56 --> Severity: Notice --> Trying to get property 'id' of non-object /home/chawtechsolution/public_html/kidyview/application/models/StudentAttendance_model.php 28
ERROR - 2022-06-06 19:06:56 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'AND `c`.`status` = 1 AND `c`.`schoolId` = 129' at line 5 - Invalid query: SELECT `c`.`id`,CONCAT(c.childfname," ",`c`.`childmname`," ",c.childlname) AS  studentName,`c`.`childphoto`,`sa`.`check_in`,`sa`.`check_out`
					 FROM `child` AS `c`
					 LEFT JOIN (SELECT * FROM `student_attendance` WHERE student_attendance.date = "2022-06-06") sa
					 ON `sa`.`student_id` = `c`.`id`
					 WHERE `c`.`childclass` = 59 AND `c`.`class_session_id` =  AND `c`.`status` = 1 AND `c`.`schoolId` = 129 
ERROR - 2022-06-06 19:06:56 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/chawtechsolution/public_html/kidyview/system/core/Exceptions.php:271) /home/chawtechsolution/public_html/kidyview/system/core/Common.php 570
ERROR - 2022-06-06 19:07:00 --> Severity: Notice --> Trying to get property 'id' of non-object /home/chawtechsolution/public_html/kidyview/application/models/StudentAttendance_model.php 28
ERROR - 2022-06-06 19:07:00 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'AND `c`.`status` = 1 AND `c`.`schoolId` = 129' at line 5 - Invalid query: SELECT `c`.`id`,CONCAT(c.childfname," ",`c`.`childmname`," ",c.childlname) AS  studentName,`c`.`childphoto`,`sa`.`check_in`,`sa`.`check_out`
					 FROM `child` AS `c`
					 LEFT JOIN (SELECT * FROM `student_attendance` WHERE student_attendance.date = "2022-06-06") sa
					 ON `sa`.`student_id` = `c`.`id`
					 WHERE `c`.`childclass` = 60 AND `c`.`class_session_id` =  AND `c`.`status` = 1 AND `c`.`schoolId` = 129 
ERROR - 2022-06-06 19:07:00 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/chawtechsolution/public_html/kidyview/system/core/Exceptions.php:271) /home/chawtechsolution/public_html/kidyview/system/core/Common.php 570
ERROR - 2022-06-06 19:07:07 --> Severity: Notice --> Trying to get property 'id' of non-object /home/chawtechsolution/public_html/kidyview/application/models/StudentAttendance_model.php 28
ERROR - 2022-06-06 19:07:07 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'AND `c`.`status` = 1 AND `c`.`schoolId` = 129' at line 5 - Invalid query: SELECT `c`.`id`,CONCAT(c.childfname," ",`c`.`childmname`," ",c.childlname) AS  studentName,`c`.`childphoto`,`sa`.`check_in`,`sa`.`check_out`
					 FROM `child` AS `c`
					 LEFT JOIN (SELECT * FROM `student_attendance` WHERE student_attendance.date = "2022-06-06") sa
					 ON `sa`.`student_id` = `c`.`id`
					 WHERE `c`.`childclass` = 61 AND `c`.`class_session_id` =  AND `c`.`status` = 1 AND `c`.`schoolId` = 129 
ERROR - 2022-06-06 19:07:07 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/chawtechsolution/public_html/kidyview/system/core/Exceptions.php:271) /home/chawtechsolution/public_html/kidyview/system/core/Common.php 570
ERROR - 2022-06-06 19:07:13 --> 404 Page Not Found: /index
ERROR - 2022-06-06 19:07:13 --> 404 Page Not Found: /index
ERROR - 2022-06-06 19:07:13 --> 404 Page Not Found: /index
ERROR - 2022-06-06 19:07:13 --> 404 Page Not Found: /index
ERROR - 2022-06-06 19:07:14 --> 404 Page Not Found: /index
ERROR - 2022-06-06 19:07:14 --> 404 Page Not Found: /index
ERROR - 2022-06-06 19:07:14 --> 404 Page Not Found: /index
ERROR - 2022-06-06 19:07:14 --> 404 Page Not Found: /index
ERROR - 2022-06-06 19:07:17 --> Severity: Notice --> Trying to get property 'id' of non-object /home/chawtechsolution/public_html/kidyview/application/models/StudentAttendance_model.php 28
ERROR - 2022-06-06 19:07:17 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'AND `c`.`status` = 1 AND `c`.`schoolId` = 129' at line 5 - Invalid query: SELECT `c`.`id`,CONCAT(c.childfname," ",`c`.`childmname`," ",c.childlname) AS  studentName,`c`.`childphoto`,`sa`.`check_in`,`sa`.`check_out`
					 FROM `child` AS `c`
					 LEFT JOIN (SELECT * FROM `student_attendance` WHERE student_attendance.date = "2022-06-06") sa
					 ON `sa`.`student_id` = `c`.`id`
					 WHERE `c`.`childclass` = 59 AND `c`.`class_session_id` =  AND `c`.`status` = 1 AND `c`.`schoolId` = 129 
ERROR - 2022-06-06 19:07:17 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/chawtechsolution/public_html/kidyview/system/core/Exceptions.php:271) /home/chawtechsolution/public_html/kidyview/system/core/Common.php 570
ERROR - 2022-06-06 19:07:18 --> 404 Page Not Found: /index
ERROR - 2022-06-06 19:07:18 --> 404 Page Not Found: /index
ERROR - 2022-06-06 19:07:18 --> 404 Page Not Found: /index
ERROR - 2022-06-06 19:07:18 --> 404 Page Not Found: /index
ERROR - 2022-06-06 19:07:19 --> 404 Page Not Found: /index
ERROR - 2022-06-06 19:07:19 --> 404 Page Not Found: /index
ERROR - 2022-06-06 19:07:19 --> 404 Page Not Found: /index
ERROR - 2022-06-06 19:07:19 --> 404 Page Not Found: /index
ERROR - 2022-06-06 19:07:21 --> 404 Page Not Found: /index
ERROR - 2022-06-06 19:07:21 --> 404 Page Not Found: /index
ERROR - 2022-06-06 19:07:26 --> 404 Page Not Found: /index
ERROR - 2022-06-06 19:07:26 --> 404 Page Not Found: /index
ERROR - 2022-06-06 19:07:30 --> Severity: Notice --> Trying to get property 'id' of non-object /home/chawtechsolution/public_html/kidyview/application/models/Message_model.php 268
ERROR - 2022-06-06 19:07:30 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/chawtechsolution/public_html/kidyview/system/core/Exceptions.php:271) /home/chawtechsolution/public_html/kidyview/system/core/Common.php 570
ERROR - 2022-06-06 19:07:33 --> 404 Page Not Found: /index
ERROR - 2022-06-06 19:07:34 --> 404 Page Not Found: /index
ERROR - 2022-06-06 19:07:40 --> 404 Page Not Found: /index
ERROR - 2022-06-06 19:07:41 --> 404 Page Not Found: /index
ERROR - 2022-06-06 19:07:44 --> 404 Page Not Found: /index
ERROR - 2022-06-06 19:07:44 --> 404 Page Not Found: /index
ERROR - 2022-06-06 19:07:46 --> 404 Page Not Found: /index
ERROR - 2022-06-06 19:07:46 --> 404 Page Not Found: /index
ERROR - 2022-06-06 19:07:46 --> Severity: Notice --> Trying to get property 'id' of non-object /home/chawtechsolution/public_html/kidyview/application/models/teachers/Results_model.php 541
ERROR - 2022-06-06 19:07:46 --> Severity: Notice --> Trying to get property 'id' of non-object /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 290
ERROR - 2022-06-06 19:07:46 --> Severity: Notice --> Trying to get property 'id' of non-object /home/chawtechsolution/public_html/kidyview/application/helpers/common_helper.php 490
ERROR - 2022-06-06 19:07:46 --> Severity: Notice --> Trying to get property 'id' of non-object /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 579
ERROR - 2022-06-06 19:07:46 --> Severity: Notice --> Trying to get property 'id' of non-object /home/chawtechsolution/public_html/kidyview/application/helpers/common_helper.php 490
ERROR - 2022-06-06 19:07:46 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 583
ERROR - 2022-06-06 19:07:46 --> Severity: Warning --> Invalid argument supplied for foreach() /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 588
ERROR - 2022-06-06 19:07:46 --> Severity: Notice --> Undefined index: user_data /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 789
ERROR - 2022-06-06 19:07:46 --> Severity: Notice --> Trying to get property 'id' of non-object /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 790
ERROR - 2022-06-06 19:07:46 --> Severity: Notice --> Undefined index: user_data /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 809
ERROR - 2022-06-06 19:07:46 --> Severity: Notice --> Trying to get property 'id' of non-object /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 810
ERROR - 2022-06-06 19:07:46 --> Severity: Notice --> Undefined index: user_data /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 829
ERROR - 2022-06-06 19:07:46 --> Severity: Notice --> Trying to get property 'id' of non-object /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 830
ERROR - 2022-06-06 19:07:46 --> Severity: Notice --> Undefined index: user_data /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 848
ERROR - 2022-06-06 19:07:46 --> Severity: Notice --> Trying to get property 'id' of non-object /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 849
ERROR - 2022-06-06 19:07:46 --> Severity: Notice --> Trying to get property 'id' of non-object /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 579
ERROR - 2022-06-06 19:07:46 --> Severity: Notice --> Trying to get property 'id' of non-object /home/chawtechsolution/public_html/kidyview/application/helpers/common_helper.php 490
ERROR - 2022-06-06 19:07:46 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 583
ERROR - 2022-06-06 19:07:46 --> Severity: Warning --> Invalid argument supplied for foreach() /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 588
ERROR - 2022-06-06 19:07:46 --> Severity: Notice --> Undefined index: user_data /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 789
ERROR - 2022-06-06 19:07:46 --> Severity: Notice --> Trying to get property 'id' of non-object /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 790
ERROR - 2022-06-06 19:07:46 --> Severity: Notice --> Undefined index: user_data /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 809
ERROR - 2022-06-06 19:07:46 --> Severity: Notice --> Trying to get property 'id' of non-object /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 810
ERROR - 2022-06-06 19:07:46 --> Severity: Notice --> Undefined index: user_data /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 829
ERROR - 2022-06-06 19:07:46 --> Severity: Notice --> Trying to get property 'id' of non-object /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 830
ERROR - 2022-06-06 19:07:46 --> Severity: Notice --> Undefined index: user_data /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 848
ERROR - 2022-06-06 19:07:46 --> Severity: Notice --> Trying to get property 'id' of non-object /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 849
ERROR - 2022-06-06 19:07:46 --> Severity: Notice --> Trying to get property 'id' of non-object /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 579
ERROR - 2022-06-06 19:07:46 --> Severity: Notice --> Trying to get property 'id' of non-object /home/chawtechsolution/public_html/kidyview/application/helpers/common_helper.php 490
ERROR - 2022-06-06 19:07:46 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 583
ERROR - 2022-06-06 19:07:46 --> Severity: Warning --> Invalid argument supplied for foreach() /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 588
ERROR - 2022-06-06 19:07:46 --> Severity: Notice --> Undefined index: user_data /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 789
ERROR - 2022-06-06 19:07:46 --> Severity: Notice --> Trying to get property 'id' of non-object /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 790
ERROR - 2022-06-06 19:07:46 --> Severity: Notice --> Undefined index: user_data /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 809
ERROR - 2022-06-06 19:07:46 --> Severity: Notice --> Trying to get property 'id' of non-object /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 810
ERROR - 2022-06-06 19:07:46 --> Severity: Notice --> Undefined index: user_data /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 829
ERROR - 2022-06-06 19:07:46 --> Severity: Notice --> Trying to get property 'id' of non-object /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 830
ERROR - 2022-06-06 19:07:46 --> Severity: Notice --> Undefined index: user_data /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 848
ERROR - 2022-06-06 19:07:46 --> Severity: Notice --> Trying to get property 'id' of non-object /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 849
ERROR - 2022-06-06 19:07:46 --> Severity: Notice --> Trying to get property 'id' of non-object /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 409
ERROR - 2022-06-06 19:07:46 --> Severity: Notice --> Trying to get property 'id' of non-object /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 409
ERROR - 2022-06-06 19:07:46 --> Severity: Notice --> Trying to get property 'id' of non-object /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 409
ERROR - 2022-06-06 19:07:46 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/chawtechsolution/public_html/kidyview/system/core/Exceptions.php:271) /home/chawtechsolution/public_html/kidyview/system/core/Common.php 570
ERROR - 2022-06-06 19:07:49 --> 404 Page Not Found: /index
ERROR - 2022-06-06 19:07:49 --> 404 Page Not Found: /index
ERROR - 2022-06-06 19:07:49 --> 404 Page Not Found: /index
ERROR - 2022-06-06 19:07:49 --> 404 Page Not Found: /index
ERROR - 2022-06-06 19:07:50 --> 404 Page Not Found: /index
ERROR - 2022-06-06 19:07:50 --> 404 Page Not Found: /index
ERROR - 2022-06-06 19:07:50 --> 404 Page Not Found: /index
ERROR - 2022-06-06 19:07:50 --> 404 Page Not Found: /index
ERROR - 2022-06-06 19:07:50 --> 404 Page Not Found: /index
ERROR - 2022-06-06 19:07:51 --> 404 Page Not Found: /index
ERROR - 2022-06-06 19:07:51 --> 404 Page Not Found: /index
ERROR - 2022-06-06 19:07:51 --> 404 Page Not Found: /index
ERROR - 2022-06-06 19:08:01 --> 404 Page Not Found: /index
ERROR - 2022-06-06 19:08:01 --> 404 Page Not Found: /index
ERROR - 2022-06-06 19:08:02 --> 404 Page Not Found: /index
ERROR - 2022-06-06 19:08:02 --> 404 Page Not Found: /index
ERROR - 2022-06-06 19:08:09 --> 404 Page Not Found: /index
ERROR - 2022-06-06 19:08:09 --> 404 Page Not Found: /index
ERROR - 2022-06-06 19:08:10 --> 404 Page Not Found: /index
ERROR - 2022-06-06 19:08:10 --> 404 Page Not Found: /index
ERROR - 2022-06-06 19:08:43 --> 404 Page Not Found: /index
ERROR - 2022-06-06 19:08:43 --> 404 Page Not Found: /index
ERROR - 2022-06-06 19:08:44 --> 404 Page Not Found: /index
ERROR - 2022-06-06 19:08:44 --> 404 Page Not Found: /index
ERROR - 2022-06-06 19:11:33 --> 404 Page Not Found: /index
ERROR - 2022-06-06 19:11:33 --> 404 Page Not Found: /index
ERROR - 2022-06-06 19:11:34 --> 404 Page Not Found: /index
ERROR - 2022-06-06 19:11:34 --> 404 Page Not Found: /index
ERROR - 2022-06-06 20:02:42 --> 404 Page Not Found: /index
ERROR - 2022-06-06 21:23:29 --> 404 Page Not Found: /index
