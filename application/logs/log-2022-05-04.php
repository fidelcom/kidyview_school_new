<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2022-05-04 11:39:11 --> 404 Page Not Found: /index
ERROR - 2022-05-04 11:44:50 --> 404 Page Not Found: /index
ERROR - 2022-05-04 11:44:50 --> 404 Page Not Found: /index
ERROR - 2022-05-04 11:47:41 --> 404 Page Not Found: /index
ERROR - 2022-05-04 11:47:42 --> 404 Page Not Found: /index
ERROR - 2022-05-04 11:54:25 --> Query error: Unknown column 's.school_name' in 'field list' - Invalid query: SELECT `sf`.*, `s`.`school_name` as `school_name`, `s`.`phone` as `phone`, `s`.`bank_name` as `bank_name`, `s`.`sub_acc_number` as `sub_acc_number`, `s`.`sort_code` as `sort_code`, `s`.`location` as `school_location`, `s`.`city` as `school_city`, `s`.`state` as `school_state`, `s`.`country` as `school_country`, `s`.`pincode` as `school_pincode`, `s`.`pic` as `school_pic`, `st`.`name` as `schooltype`, `country`.`name` as `countryname`, `c`.`section` as `student_section`, `c`.`class` as `student_class`, CONCAT(child.childfname, " ", `child`.`childmname`, " ", child.childlname) AS childname, `child`.`childgender` as `childgender`, `child`.`childdob` as `childdob`, `child`.`childemail` as `childemail`, `child`.`childgender` as `studentgender`, CONCAT(p.fatherfname, " ", p.fatherlname) AS fathername, `p`.`fatherphone` as `fatherphone`, `p`.`fatheremail` as `fatheremail`, `p`.`fatheraddress` as `fatheraddress`, `ft`.`fee_type` as `fee_type`, `sessions`.`academicsession` as `academicsession`, `sessions`.`id` as `academicsessionID`, `terms`.`termname` as `termname`, `f`.`category_id` as `cat_id`, `f`.`description` as `comment`
FROM `student_fees` as `sf`
LEFT JOIN `class` as `c` ON `c`.`id` = `sf`.`class_id`
LEFT JOIN `fees` as `f` ON `f`.`class_id` = `c`.`id`
LEFT JOIN `schooltype` as `st` ON `st`.`id` = `c`.`school_type`
LEFT JOIN `child` as `child` ON `child`.`id` = `sf`.`student_id`
LEFT JOIN `parent` as `p` ON `p`.`id` = `sf`.`parent_id`
LEFT JOIN `fee_types` as `ft` ON `ft`.`id` = `sf`.`feeType_id`
WHERE `sf`.`school_id` = '20'
AND `sf`.`session_id` = '29'
AND `sf`.`class_id` = '12'
AND `sf`.`student_id` = '59'
AND `sf`.`is_paid` = 'paid'
AND `sf`.`transaction_status` = 'successful'
GROUP BY `sf`.`tx_ref`
ERROR - 2022-05-04 11:56:39 --> Query error: Unknown column 'sessions.academicsession' in 'field list' - Invalid query: SELECT `sf`.*, `c`.`section` as `student_section`, `c`.`class` as `student_class`, CONCAT(child.childfname, " ", `child`.`childmname`, " ", child.childlname) AS childname, `child`.`childgender` as `childgender`, `child`.`childdob` as `childdob`, `child`.`childemail` as `childemail`, `child`.`childgender` as `studentgender`, CONCAT(p.fatherfname, " ", p.fatherlname) AS fathername, `p`.`fatherphone` as `fatherphone`, `p`.`fatheremail` as `fatheremail`, `p`.`fatheraddress` as `fatheraddress`, `ft`.`fee_type` as `fee_type`, `sessions`.`academicsession` as `academicsession`, `sessions`.`id` as `academicsessionID`, `terms`.`termname` as `termname`, `f`.`category_id` as `cat_id`, `f`.`description` as `comment`
FROM `student_fees` as `sf`
LEFT JOIN `class` as `c` ON `c`.`id` = `sf`.`class_id`
LEFT JOIN `fees` as `f` ON `f`.`class_id` = `c`.`id`
LEFT JOIN `schooltype` as `st` ON `st`.`id` = `c`.`school_type`
LEFT JOIN `child` as `child` ON `child`.`id` = `sf`.`student_id`
LEFT JOIN `parent` as `p` ON `p`.`id` = `sf`.`parent_id`
LEFT JOIN `fee_types` as `ft` ON `ft`.`id` = `sf`.`feeType_id`
WHERE `sf`.`school_id` = '20'
AND `sf`.`session_id` = '29'
AND `sf`.`class_id` = '12'
AND `sf`.`student_id` = '59'
AND `sf`.`is_paid` = 'paid'
AND `sf`.`transaction_status` = 'successful'
GROUP BY `sf`.`tx_ref`
ERROR - 2022-05-04 12:22:12 --> 404 Page Not Found: /index
ERROR - 2022-05-04 13:23:45 --> 404 Page Not Found: /index
ERROR - 2022-05-04 13:57:30 --> 404 Page Not Found: /index
ERROR - 2022-05-04 13:57:30 --> 404 Page Not Found: /index
ERROR - 2022-05-04 13:57:40 --> 404 Page Not Found: /index
ERROR - 2022-05-04 13:57:40 --> 404 Page Not Found: /index
ERROR - 2022-05-04 13:58:13 --> 404 Page Not Found: /index
ERROR - 2022-05-04 13:58:13 --> 404 Page Not Found: /index
ERROR - 2022-05-04 13:58:28 --> 404 Page Not Found: /index
ERROR - 2022-05-04 13:58:28 --> 404 Page Not Found: /index
ERROR - 2022-05-04 14:19:33 --> Severity: error --> Exception: syntax error, unexpected '}' /home/chawtechsolution/public_html/kidyview/application/views/fees_invoice.php 195
ERROR - 2022-05-04 14:33:39 --> 404 Page Not Found: /index
ERROR - 2022-05-04 14:33:39 --> 404 Page Not Found: /index
ERROR - 2022-05-04 14:33:39 --> 404 Page Not Found: /index
ERROR - 2022-05-04 14:33:40 --> 404 Page Not Found: /index
ERROR - 2022-05-04 14:33:45 --> 404 Page Not Found: /index
ERROR - 2022-05-04 14:33:45 --> 404 Page Not Found: /index
ERROR - 2022-05-04 14:33:49 --> 404 Page Not Found: /index
ERROR - 2022-05-04 14:33:49 --> 404 Page Not Found: /index
ERROR - 2022-05-04 14:33:49 --> 404 Page Not Found: /index
ERROR - 2022-05-04 14:33:58 --> 404 Page Not Found: /index
ERROR - 2022-05-04 14:33:58 --> 404 Page Not Found: /index
ERROR - 2022-05-04 14:33:58 --> 404 Page Not Found: /index
ERROR - 2022-05-04 14:33:59 --> 404 Page Not Found: /index
ERROR - 2022-05-04 14:33:59 --> 404 Page Not Found: /index
ERROR - 2022-05-04 14:33:59 --> 404 Page Not Found: /index
ERROR - 2022-05-04 14:33:59 --> 404 Page Not Found: /index
ERROR - 2022-05-04 14:33:59 --> 404 Page Not Found: /index
ERROR - 2022-05-04 14:34:00 --> 404 Page Not Found: /index
ERROR - 2022-05-04 14:34:00 --> 404 Page Not Found: /index
ERROR - 2022-05-04 14:34:00 --> 404 Page Not Found: /index
ERROR - 2022-05-04 14:34:00 --> 404 Page Not Found: /index
ERROR - 2022-05-04 14:34:00 --> 404 Page Not Found: /index
ERROR - 2022-05-04 16:00:49 --> 404 Page Not Found: /index
ERROR - 2022-05-04 16:00:49 --> 404 Page Not Found: /index
ERROR - 2022-05-04 16:00:49 --> 404 Page Not Found: /index
ERROR - 2022-05-04 16:00:49 --> 404 Page Not Found: /index
ERROR - 2022-05-04 16:00:49 --> 404 Page Not Found: /index
ERROR - 2022-05-04 16:00:49 --> 404 Page Not Found: /index
ERROR - 2022-05-04 16:00:49 --> 404 Page Not Found: /index
ERROR - 2022-05-04 16:00:50 --> 404 Page Not Found: /index
ERROR - 2022-05-04 16:00:50 --> 404 Page Not Found: /index
ERROR - 2022-05-04 16:00:59 --> 404 Page Not Found: /index
ERROR - 2022-05-04 16:00:59 --> 404 Page Not Found: /index
ERROR - 2022-05-04 16:00:59 --> 404 Page Not Found: /index
ERROR - 2022-05-04 16:00:59 --> 404 Page Not Found: /index
ERROR - 2022-05-04 16:00:59 --> 404 Page Not Found: /index
ERROR - 2022-05-04 16:00:59 --> 404 Page Not Found: /index
ERROR - 2022-05-04 16:00:59 --> 404 Page Not Found: /index
ERROR - 2022-05-04 16:00:59 --> 404 Page Not Found: /index
ERROR - 2022-05-04 16:01:00 --> 404 Page Not Found: /index
ERROR - 2022-05-04 16:01:18 --> 404 Page Not Found: /index
ERROR - 2022-05-04 16:01:18 --> 404 Page Not Found: /index
ERROR - 2022-05-04 16:01:18 --> 404 Page Not Found: /index
ERROR - 2022-05-04 16:01:18 --> 404 Page Not Found: /index
ERROR - 2022-05-04 16:01:19 --> 404 Page Not Found: /index
ERROR - 2022-05-04 16:01:23 --> 404 Page Not Found: /index
ERROR - 2022-05-04 16:02:11 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable /home/chawtechsolution/public_html/kidyview/application/controllers/apiApp/teacher/Directoryapp.php 81
ERROR - 2022-05-04 16:02:11 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable /home/chawtechsolution/public_html/kidyview/application/controllers/apiApp/teacher/Directoryapp.php 81
ERROR - 2022-05-04 16:02:11 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/chawtechsolution/public_html/kidyview/system/core/Exceptions.php:271) /home/chawtechsolution/public_html/kidyview/system/core/Common.php 570
ERROR - 2022-05-04 16:03:51 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '"43
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
ERROR - 2022-05-04 16:03:57 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'AND session_id= ORDER BY `result`.`overall_percent`  DESC' at line 1 - Invalid query: SELECT id,student_id,@rank := @rank + 1 rank FROM `result`, (SELECT @rank := 0) init WHERE class_id =  AND session_id= ORDER BY `result`.`overall_percent`  DESC
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Undefined variable: sesion_id /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 585
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Undefined index: user_data /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 667
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Trying to get property 'id' of non-object /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 668
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Undefined variable: sesion_id /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 586
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Undefined index: user_data /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 685
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Trying to get property 'id' of non-object /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 686
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Undefined variable: sesion_id /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 587
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Undefined index: user_data /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 703
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Trying to get property 'id' of non-object /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 704
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Undefined variable: sesion_id /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 588
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Undefined index: user_data /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 722
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Trying to get property 'id' of non-object /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 723
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Undefined variable: sesion_id /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 585
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Undefined index: user_data /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 667
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Trying to get property 'id' of non-object /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 668
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Undefined variable: sesion_id /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 586
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Undefined index: user_data /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 685
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Trying to get property 'id' of non-object /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 686
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Undefined variable: sesion_id /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 587
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Undefined index: user_data /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 703
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Trying to get property 'id' of non-object /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 704
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Undefined variable: sesion_id /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 588
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Undefined index: user_data /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 722
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Trying to get property 'id' of non-object /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 723
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Undefined variable: sesion_id /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 585
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Undefined index: user_data /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 667
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Trying to get property 'id' of non-object /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 668
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Undefined variable: sesion_id /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 586
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Undefined index: user_data /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 685
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Trying to get property 'id' of non-object /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 686
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Undefined variable: sesion_id /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 587
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Undefined index: user_data /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 703
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Trying to get property 'id' of non-object /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 704
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Undefined variable: sesion_id /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 588
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Undefined index: user_data /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 722
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Trying to get property 'id' of non-object /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 723
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Undefined variable: sesion_id /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 585
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Undefined index: user_data /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 667
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Trying to get property 'id' of non-object /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 668
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Undefined variable: sesion_id /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 586
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Undefined index: user_data /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 685
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Trying to get property 'id' of non-object /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 686
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Undefined variable: sesion_id /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 587
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Undefined index: user_data /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 703
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Trying to get property 'id' of non-object /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 704
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Undefined variable: sesion_id /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 588
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Undefined index: user_data /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 722
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Trying to get property 'id' of non-object /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 723
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Undefined variable: sesion_id /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 585
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Undefined index: user_data /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 667
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Trying to get property 'id' of non-object /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 668
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Undefined variable: sesion_id /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 586
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Undefined index: user_data /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 685
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Trying to get property 'id' of non-object /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 686
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Undefined variable: sesion_id /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 587
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Undefined index: user_data /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 703
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Trying to get property 'id' of non-object /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 704
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Undefined variable: sesion_id /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 588
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Undefined index: user_data /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 722
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Trying to get property 'id' of non-object /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 723
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Undefined variable: sesion_id /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 585
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Undefined index: user_data /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 667
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Trying to get property 'id' of non-object /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 668
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Undefined variable: sesion_id /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 586
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Undefined index: user_data /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 685
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Trying to get property 'id' of non-object /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 686
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Undefined variable: sesion_id /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 587
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Undefined index: user_data /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 703
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Trying to get property 'id' of non-object /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 704
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Undefined variable: sesion_id /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 588
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Undefined index: user_data /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 722
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Trying to get property 'id' of non-object /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 723
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Undefined variable: sesion_id /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 585
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Undefined index: user_data /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 667
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Trying to get property 'id' of non-object /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 668
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Undefined variable: sesion_id /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 586
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Undefined index: user_data /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 685
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Trying to get property 'id' of non-object /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 686
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Undefined variable: sesion_id /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 587
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Undefined index: user_data /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 703
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Trying to get property 'id' of non-object /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 704
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Undefined variable: sesion_id /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 588
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Undefined index: user_data /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 722
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Trying to get property 'id' of non-object /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 723
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Undefined variable: sesion_id /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 585
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Undefined index: user_data /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 667
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Trying to get property 'id' of non-object /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 668
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Undefined variable: sesion_id /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 586
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Undefined index: user_data /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 685
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Trying to get property 'id' of non-object /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 686
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Undefined variable: sesion_id /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 587
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Undefined index: user_data /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 703
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Trying to get property 'id' of non-object /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 704
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Undefined variable: sesion_id /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 588
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Undefined index: user_data /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 722
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Trying to get property 'id' of non-object /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 723
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Undefined variable: sesion_id /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 585
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Undefined index: user_data /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 667
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Trying to get property 'id' of non-object /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 668
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Undefined variable: sesion_id /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 586
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Undefined index: user_data /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 685
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Trying to get property 'id' of non-object /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 686
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Undefined variable: sesion_id /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 587
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Undefined index: user_data /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 703
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Trying to get property 'id' of non-object /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 704
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Undefined variable: sesion_id /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 588
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Undefined index: user_data /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 722
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Trying to get property 'id' of non-object /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 723
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Undefined variable: sesion_id /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 585
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Undefined index: user_data /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 667
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Trying to get property 'id' of non-object /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 668
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Undefined variable: sesion_id /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 586
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Undefined index: user_data /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 685
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Trying to get property 'id' of non-object /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 686
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Undefined variable: sesion_id /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 587
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Undefined index: user_data /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 703
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Trying to get property 'id' of non-object /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 704
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Undefined variable: sesion_id /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 588
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Undefined index: user_data /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 722
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Trying to get property 'id' of non-object /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 723
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Undefined variable: sesion_id /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 585
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Undefined index: user_data /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 667
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Trying to get property 'id' of non-object /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 668
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Undefined variable: sesion_id /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 586
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Undefined index: user_data /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 685
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Trying to get property 'id' of non-object /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 686
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Undefined variable: sesion_id /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 587
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Undefined index: user_data /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 703
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Trying to get property 'id' of non-object /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 704
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Undefined variable: sesion_id /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 588
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Undefined index: user_data /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 722
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Trying to get property 'id' of non-object /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 723
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Undefined variable: sesion_id /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 585
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Undefined index: user_data /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 667
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Trying to get property 'id' of non-object /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 668
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Undefined variable: sesion_id /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 586
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Undefined index: user_data /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 685
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Trying to get property 'id' of non-object /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 686
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Undefined variable: sesion_id /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 587
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Undefined index: user_data /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 703
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Trying to get property 'id' of non-object /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 704
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Undefined variable: sesion_id /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 588
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Undefined index: user_data /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 722
ERROR - 2022-05-04 16:04:03 --> Severity: Notice --> Trying to get property 'id' of non-object /home/chawtechsolution/public_html/kidyview/application/models/admin/Result_model.php 723
ERROR - 2022-05-04 16:04:04 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/chawtechsolution/public_html/kidyview/system/core/Exceptions.php:271) /home/chawtechsolution/public_html/kidyview/system/core/Common.php 570
ERROR - 2022-05-04 16:04:08 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '"43
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
ERROR - 2022-05-04 16:04:14 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '"43
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
				    `student_id` = 126 AND sd.term_id = 21 AND `sd`.`session_id` = "43
				GROUP BY
				    sd.subject_id 
ERROR - 2022-05-04 16:04:19 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '"43
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
				    `student_id` = 122 AND sd.term_id = 21 AND `sd`.`session_id` = "43
				GROUP BY
				    sd.subject_id 
ERROR - 2022-05-04 16:04:30 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '"43
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
				    `student_id` = 122 AND sd.term_id = 21 AND `sd`.`session_id` = "43
				GROUP BY
				    sd.subject_id 
ERROR - 2022-05-04 16:04:38 --> 404 Page Not Found: /index
ERROR - 2022-05-04 16:04:38 --> 404 Page Not Found: /index
ERROR - 2022-05-04 16:04:39 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '"43
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
				    `student_id` = 120 AND sd.term_id = 21 AND `sd`.`session_id` = "43
				GROUP BY
				    sd.subject_id 
ERROR - 2022-05-04 16:05:06 --> Severity: error --> Exception: syntax error, unexpected '/' /home/chawtechsolution/public_html/kidyview/application/controllers/apiApp/parent/Fees.php 203
ERROR - 2022-05-04 16:05:43 --> Severity: error --> Exception: syntax error, unexpected '/' /home/chawtechsolution/public_html/kidyview/application/controllers/apiApp/parent/Fees.php 203
ERROR - 2022-05-04 16:05:54 --> Severity: error --> Exception: syntax error, unexpected '/' /home/chawtechsolution/public_html/kidyview/application/controllers/apiApp/parent/Fees.php 203
ERROR - 2022-05-04 16:11:38 --> Severity: error --> Exception: syntax error, unexpected '/' /home/chawtechsolution/public_html/kidyview/application/controllers/apiApp/parent/Fees.php 203
ERROR - 2022-05-04 17:01:51 --> 404 Page Not Found: /index
ERROR - 2022-05-04 17:01:52 --> 404 Page Not Found: /index
ERROR - 2022-05-04 18:14:44 --> Query error: Unknown column '$school_id' in 'where clause' - Invalid query: SELECT CONCAT(ch.childfname, " ", `ch`.`childmname`, " ", ch.childlname ) as studentName, `ch`.`id`
FROM `child` as `ch`
LEFT JOIN `child_class` as `chc` ON `ch`.`id`=`chc`.`child_id`
WHERE `chc`.`school_id` = '20'
AND `chc`.`session_id` = '29'
AND `chc`.`class_id` = '12'
AND id IN (SELECT student_id FROM student_fees where school_id=$school_id AND session_id=$session_id AND class_id=$class_id)
ERROR - 2022-05-04 18:15:57 --> Query error: Column 'id' in IN/ALL/ANY subquery is ambiguous - Invalid query: SELECT CONCAT(ch.childfname, " ", `ch`.`childmname`, " ", ch.childlname ) as studentName, `ch`.`id`
FROM `child` as `ch`
LEFT JOIN `child_class` as `chc` ON `ch`.`id`=`chc`.`child_id`
WHERE `chc`.`school_id` = '20'
AND `chc`.`session_id` = '29'
AND `chc`.`class_id` = '12'
AND id IN (SELECT student_id FROM student_fees where school_id=20 AND session_id=29 AND class_id=12)
ERROR - 2022-05-04 18:20:40 --> 404 Page Not Found: /index
ERROR - 2022-05-04 18:21:27 --> 404 Page Not Found: /index
ERROR - 2022-05-04 18:21:27 --> 404 Page Not Found: /index
ERROR - 2022-05-04 15:31:06 --> 404 Page Not Found: /index
ERROR - 2022-05-04 15:31:07 --> 404 Page Not Found: /index
ERROR - 2022-05-04 23:25:37 --> 404 Page Not Found: /index
