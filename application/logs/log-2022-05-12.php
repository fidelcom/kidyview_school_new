<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2022-05-12 11:48:36 --> 404 Page Not Found: /index
ERROR - 2022-05-12 11:54:11 --> 404 Page Not Found: /index
ERROR - 2022-05-12 11:54:37 --> 404 Page Not Found: /index
ERROR - 2022-05-12 11:54:53 --> 404 Page Not Found: /index
ERROR - 2022-05-12 11:55:03 --> 404 Page Not Found: /index
ERROR - 2022-05-12 12:15:44 --> Severity: Warning --> mysqli::query(): MySQL server has gone away /home/chawtechsolution/public_html/kidyview/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2022-05-12 12:15:44 --> Severity: Warning --> mysqli::query(): MySQL server has gone away /home/chawtechsolution/public_html/kidyview/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2022-05-12 12:15:44 --> Severity: Warning --> mysqli::query(): Error reading result set's header /home/chawtechsolution/public_html/kidyview/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2022-05-12 12:15:44 --> Severity: Warning --> mysqli::query(): Error reading result set's header /home/chawtechsolution/public_html/kidyview/system/database/drivers/mysqli/mysqli_driver.php 305
ERROR - 2022-05-12 12:15:44 --> Query error: MySQL server has gone away - Invalid query: SELECT GET_LOCK('4a3ce31042124a2affea598a7ed4d824', 300) AS ci_session_lock
ERROR - 2022-05-12 12:15:44 --> Query error: MySQL server has gone away - Invalid query: SELECT GET_LOCK('4a3ce31042124a2affea598a7ed4d824', 300) AS ci_session_lock
ERROR - 2022-05-12 12:15:44 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/chawtechsolution/public_html/kidyview/system/core/Exceptions.php:271) /home/chawtechsolution/public_html/kidyview/system/core/Common.php 570
ERROR - 2022-05-12 12:15:44 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/chawtechsolution/public_html/kidyview/system/core/Exceptions.php:271) /home/chawtechsolution/public_html/kidyview/system/core/Common.php 570
ERROR - 2022-05-12 12:15:44 --> Severity: Warning --> session_write_close(): Cannot call session save handler in a recursive manner Unknown 0
ERROR - 2022-05-12 12:15:44 --> Severity: Warning --> session_write_close(): Cannot call session save handler in a recursive manner Unknown 0
ERROR - 2022-05-12 12:15:44 --> Severity: Warning --> session_write_close(): Failed to write session data using user defined save handler. (session.save_path: /var/cpanel/php/sessions/ea-php72) Unknown 0
ERROR - 2022-05-12 12:15:44 --> Severity: Warning --> session_write_close(): Failed to write session data using user defined save handler. (session.save_path: /var/cpanel/php/sessions/ea-php72) Unknown 0
ERROR - 2022-05-12 12:15:44 --> Severity: Warning --> mysqli::real_connect(): (HY000/2002): Connection refused /home/chawtechsolution/public_html/kidyview/system/database/drivers/mysqli/mysqli_driver.php 201
ERROR - 2022-05-12 12:15:44 --> Unable to connect to the database
ERROR - 2022-05-12 12:15:44 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/chawtechsolution/public_html/kidyview/system/core/Exceptions.php:271) /home/chawtechsolution/public_html/kidyview/system/core/Common.php 570
ERROR - 2022-05-12 12:15:46 --> Severity: Warning --> mysqli::real_connect(): (HY000/2002): Connection refused /home/chawtechsolution/public_html/kidyview/system/database/drivers/mysqli/mysqli_driver.php 201
ERROR - 2022-05-12 12:15:46 --> Unable to connect to the database
ERROR - 2022-05-12 12:15:46 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/chawtechsolution/public_html/kidyview/system/core/Exceptions.php:271) /home/chawtechsolution/public_html/kidyview/system/core/Common.php 570
ERROR - 2022-05-12 13:07:17 --> 404 Page Not Found: /index
ERROR - 2022-05-12 13:07:17 --> 404 Page Not Found: /index
ERROR - 2022-05-12 13:07:17 --> 404 Page Not Found: /index
ERROR - 2022-05-12 13:07:17 --> 404 Page Not Found: /index
ERROR - 2022-05-12 13:07:17 --> 404 Page Not Found: /index
ERROR - 2022-05-12 13:07:17 --> 404 Page Not Found: /index
ERROR - 2022-05-12 13:07:18 --> 404 Page Not Found: /index
ERROR - 2022-05-12 13:07:18 --> 404 Page Not Found: /index
ERROR - 2022-05-12 13:07:19 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '"29
				GROUP BY
				    sd.subject_id' at line 18 - Invalid query: SELECT
			    sd.term_id,CONCAT(c.childfname," ",c.childmname," ",c.childlname) as student,
			    s.subject,sd.is_approved,sd.reason,
			    SUM(sd.`total_exam_marks`) AS totalExamMarks,
			    SUM(sd.`obtain_exam_marks`) AS obtainExamMarks,
			    SUM(sd.`total_test_marks`) AS totalTestMarks,
			    SUM(sd.`obtain_test_marks`) AS obtainTestMarks,
			    SUM(sd.`total_assignment_marks`) AS totalAssignmentMarks,
			    SUM(sd.`obtain_assignment_marks`) AS obtainAssignmentMarks,
			    SUM(sd.`total_project_marks`) AS totalProjectMarks,
			    SUM(sd.`obtain_project_marks`) AS obtainProjectMarks
			   
				FROM
				    `result_term_subject_data` AS sd
				LEFT JOIN child as c ON c.id = sd.student_id
				LEFT JOIN subjects as s ON s.id = sd.subject_id
				WHERE
				    `student_id` = 9 AND sd.term_id = 1 AND `sd`.`session_id` = "29
				GROUP BY
				    sd.subject_id 
ERROR - 2022-05-12 13:07:27 --> 404 Page Not Found: /index
ERROR - 2022-05-12 13:07:27 --> 404 Page Not Found: /index
ERROR - 2022-05-12 13:07:27 --> 404 Page Not Found: /index
ERROR - 2022-05-12 13:07:27 --> 404 Page Not Found: /index
ERROR - 2022-05-12 13:07:28 --> 404 Page Not Found: /index
ERROR - 2022-05-12 13:07:28 --> 404 Page Not Found: /index
ERROR - 2022-05-12 13:07:28 --> 404 Page Not Found: /index
ERROR - 2022-05-12 13:07:28 --> 404 Page Not Found: /index
ERROR - 2022-05-12 13:08:01 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '"43
				GROUP BY
				    sd.subject_id' at line 18 - Invalid query: SELECT
			    sd.term_id,CONCAT(c.childfname," ",c.childmname," ",c.childlname) as student,
			    s.subject,sd.is_approved,sd.reason,
			    SUM(sd.`total_exam_marks`) AS totalExamMarks,
			    SUM(sd.`obtain_exam_marks`) AS obtainExamMarks,
			    SUM(sd.`total_test_marks`) AS totalTestMarks,
			    SUM(sd.`obtain_test_marks`) AS obtainTestMarks,
			    SUM(sd.`total_assignment_marks`) AS totalAssignmentMarks,
			    SUM(sd.`obtain_assignment_marks`) AS obtainAssignmentMarks,
			    SUM(sd.`total_project_marks`) AS totalProjectMarks,
			    SUM(sd.`obtain_project_marks`) AS obtainProjectMarks
			   
				FROM
				    `result_term_subject_data` AS sd
				LEFT JOIN child as c ON c.id = sd.student_id
				LEFT JOIN subjects as s ON s.id = sd.subject_id
				WHERE
				    `student_id` = 128 AND sd.term_id = 21 AND `sd`.`session_id` = "43
				GROUP BY
				    sd.subject_id 
ERROR - 2022-05-12 13:10:04 --> 404 Page Not Found: /index
ERROR - 2022-05-12 13:10:04 --> 404 Page Not Found: /index
ERROR - 2022-05-12 13:10:04 --> 404 Page Not Found: /index
ERROR - 2022-05-12 13:10:05 --> 404 Page Not Found: /index
ERROR - 2022-05-12 13:10:05 --> 404 Page Not Found: /index
ERROR - 2022-05-12 13:10:05 --> 404 Page Not Found: /index
ERROR - 2022-05-12 13:10:06 --> 404 Page Not Found: /index
ERROR - 2022-05-12 13:10:06 --> 404 Page Not Found: /index
ERROR - 2022-05-12 13:10:40 --> 404 Page Not Found: /index
ERROR - 2022-05-12 13:10:40 --> 404 Page Not Found: /index
ERROR - 2022-05-12 13:10:40 --> 404 Page Not Found: /index
ERROR - 2022-05-12 13:10:41 --> 404 Page Not Found: /index
ERROR - 2022-05-12 13:10:41 --> 404 Page Not Found: /index
ERROR - 2022-05-12 13:10:41 --> 404 Page Not Found: /index
ERROR - 2022-05-12 13:21:01 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '"43
				GROUP BY
				    sd.subject_id' at line 18 - Invalid query: SELECT
			    sd.term_id,CONCAT(c.childfname," ",c.childmname," ",c.childlname) as student,
			    s.subject,sd.is_approved,sd.reason,
			    SUM(sd.`total_exam_marks`) AS totalExamMarks,
			    SUM(sd.`obtain_exam_marks`) AS obtainExamMarks,
			    SUM(sd.`total_test_marks`) AS totalTestMarks,
			    SUM(sd.`obtain_test_marks`) AS obtainTestMarks,
			    SUM(sd.`total_assignment_marks`) AS totalAssignmentMarks,
			    SUM(sd.`obtain_assignment_marks`) AS obtainAssignmentMarks,
			    SUM(sd.`total_project_marks`) AS totalProjectMarks,
			    SUM(sd.`obtain_project_marks`) AS obtainProjectMarks
			   
				FROM
				    `result_term_subject_data` AS sd
				LEFT JOIN child as c ON c.id = sd.student_id
				LEFT JOIN subjects as s ON s.id = sd.subject_id
				WHERE
				    `student_id` = 128 AND sd.term_id = 21 AND `sd`.`session_id` = "43
				GROUP BY
				    sd.subject_id 
ERROR - 2022-05-12 14:11:37 --> 404 Page Not Found: /index
ERROR - 2022-05-12 14:11:38 --> 404 Page Not Found: /index
ERROR - 2022-05-12 14:20:54 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/chawtechsolution/public_html/kidyview/application/controllers/api/admin/Subscription.php:40) /home/chawtechsolution/public_html/kidyview/system/core/Common.php 570
ERROR - 2022-05-12 21:42:37 --> 404 Page Not Found: /index
ERROR - 2022-05-12 16:57:50 --> 404 Page Not Found: /index
ERROR - 2022-05-12 16:57:51 --> 404 Page Not Found: /index
ERROR - 2022-05-12 16:57:53 --> 404 Page Not Found: /index
ERROR - 2022-05-12 16:57:54 --> 404 Page Not Found: /index
ERROR - 2022-05-12 16:57:55 --> 404 Page Not Found: /index
ERROR - 2022-05-12 16:57:56 --> 404 Page Not Found: /index
ERROR - 2022-05-12 16:57:57 --> 404 Page Not Found: /index
ERROR - 2022-05-12 16:58:00 --> 404 Page Not Found: /index
ERROR - 2022-05-12 16:58:02 --> 404 Page Not Found: /index
