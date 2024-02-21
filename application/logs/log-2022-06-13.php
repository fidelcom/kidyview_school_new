<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2022-06-13 12:07:12 --> 404 Page Not Found: /index
ERROR - 2022-06-13 08:50:19 --> 404 Page Not Found: /index
ERROR - 2022-06-13 09:07:08 --> 404 Page Not Found: /index
ERROR - 2022-06-13 09:10:36 --> 404 Page Not Found: /index
ERROR - 2022-06-13 13:05:52 --> 404 Page Not Found: /index
ERROR - 2022-06-13 13:05:52 --> 404 Page Not Found: /index
ERROR - 2022-06-13 13:05:52 --> 404 Page Not Found: /index
ERROR - 2022-06-13 13:05:52 --> 404 Page Not Found: /index
ERROR - 2022-06-13 13:05:52 --> 404 Page Not Found: /index
ERROR - 2022-06-13 13:05:53 --> 404 Page Not Found: /index
ERROR - 2022-06-13 13:05:53 --> 404 Page Not Found: /index
ERROR - 2022-06-13 13:05:53 --> 404 Page Not Found: /index
ERROR - 2022-06-13 13:06:22 --> 404 Page Not Found: /index
ERROR - 2022-06-13 13:06:22 --> 404 Page Not Found: /index
ERROR - 2022-06-13 13:06:23 --> 404 Page Not Found: /index
ERROR - 2022-06-13 13:06:23 --> 404 Page Not Found: /index
ERROR - 2022-06-13 13:06:23 --> 404 Page Not Found: /index
ERROR - 2022-06-13 13:06:24 --> 404 Page Not Found: /index
ERROR - 2022-06-13 13:06:24 --> 404 Page Not Found: /index
ERROR - 2022-06-13 13:06:25 --> Query error: Expression #4 of SELECT list is not in GROUP BY clause and contains nonaggregated column 'chawtech_kiddyVewDevlopment.sd.is_approved' which is not functionally dependent on columns in GROUP BY clause; this is incompatible with sql_mode=only_full_group_by - Invalid query: SELECT
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
				    `student_id` = 57 AND sd.term_id = 1 AND `sd`.`session_id` = "29"
				GROUP BY
				    sd.subject_id 
ERROR - 2022-06-13 13:06:25 --> 404 Page Not Found: /index
ERROR - 2022-06-13 13:06:25 --> 404 Page Not Found: /index
ERROR - 2022-06-13 13:06:33 --> 404 Page Not Found: /index
ERROR - 2022-06-13 13:06:33 --> 404 Page Not Found: /index
ERROR - 2022-06-13 13:06:33 --> 404 Page Not Found: /index
ERROR - 2022-06-13 13:06:33 --> 404 Page Not Found: /index
ERROR - 2022-06-13 13:06:34 --> 404 Page Not Found: /index
ERROR - 2022-06-13 13:06:34 --> 404 Page Not Found: /index
ERROR - 2022-06-13 13:06:34 --> 404 Page Not Found: /index
ERROR - 2022-06-13 13:06:34 --> 404 Page Not Found: /index
ERROR - 2022-06-13 13:06:34 --> 404 Page Not Found: /index
ERROR - 2022-06-13 13:06:35 --> 404 Page Not Found: /index
ERROR - 2022-06-13 13:06:35 --> 404 Page Not Found: /index
ERROR - 2022-06-13 13:06:35 --> 404 Page Not Found: /index
ERROR - 2022-06-13 13:06:35 --> 404 Page Not Found: /index
ERROR - 2022-06-13 13:06:35 --> 404 Page Not Found: /index
ERROR - 2022-06-13 13:06:35 --> 404 Page Not Found: /index
ERROR - 2022-06-13 13:06:36 --> Query error: Expression #4 of SELECT list is not in GROUP BY clause and contains nonaggregated column 'chawtech_kiddyVewDevlopment.sd.is_approved' which is not functionally dependent on columns in GROUP BY clause; this is incompatible with sql_mode=only_full_group_by - Invalid query: SELECT
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
				    `student_id` = 57 AND sd.term_id = 1 AND `sd`.`session_id` = "29"
				GROUP BY
				    sd.subject_id 
ERROR - 2022-06-13 13:06:45 --> 404 Page Not Found: /index
ERROR - 2022-06-13 13:06:45 --> 404 Page Not Found: /index
ERROR - 2022-06-13 13:06:45 --> 404 Page Not Found: /index
ERROR - 2022-06-13 13:06:45 --> 404 Page Not Found: /index
ERROR - 2022-06-13 13:06:45 --> 404 Page Not Found: /index
ERROR - 2022-06-13 13:06:45 --> 404 Page Not Found: /index
ERROR - 2022-06-13 13:06:45 --> 404 Page Not Found: /index
ERROR - 2022-06-13 13:06:45 --> 404 Page Not Found: /index
ERROR - 2022-06-13 13:06:46 --> 404 Page Not Found: /index
ERROR - 2022-06-13 13:06:46 --> 404 Page Not Found: /index
ERROR - 2022-06-13 13:06:46 --> 404 Page Not Found: /index
ERROR - 2022-06-13 13:06:46 --> 404 Page Not Found: /index
ERROR - 2022-06-13 13:06:47 --> 404 Page Not Found: /index
ERROR - 2022-06-13 13:06:47 --> 404 Page Not Found: /index
ERROR - 2022-06-13 13:06:47 --> 404 Page Not Found: /index
ERROR - 2022-06-13 13:06:47 --> 404 Page Not Found: /index
ERROR - 2022-06-13 13:06:50 --> 404 Page Not Found: /index
ERROR - 2022-06-13 13:06:50 --> 404 Page Not Found: /index
ERROR - 2022-06-13 13:06:50 --> 404 Page Not Found: /index
ERROR - 2022-06-13 13:06:50 --> 404 Page Not Found: /index
ERROR - 2022-06-13 13:06:50 --> 404 Page Not Found: /index
ERROR - 2022-06-13 13:06:51 --> 404 Page Not Found: /index
ERROR - 2022-06-13 13:06:51 --> 404 Page Not Found: /index
ERROR - 2022-06-13 13:06:51 --> 404 Page Not Found: /index
ERROR - 2022-06-13 13:06:51 --> 404 Page Not Found: /index
ERROR - 2022-06-13 13:06:51 --> 404 Page Not Found: /index
ERROR - 2022-06-13 13:06:52 --> 404 Page Not Found: /index
ERROR - 2022-06-13 13:06:52 --> 404 Page Not Found: /index
ERROR - 2022-06-13 13:06:52 --> 404 Page Not Found: /index
ERROR - 2022-06-13 13:06:52 --> 404 Page Not Found: /index
ERROR - 2022-06-13 13:06:52 --> 404 Page Not Found: /index
ERROR - 2022-06-13 13:06:52 --> 404 Page Not Found: /index
ERROR - 2022-06-13 13:06:53 --> 404 Page Not Found: /index
ERROR - 2022-06-13 13:06:53 --> Query error: Expression #4 of SELECT list is not in GROUP BY clause and contains nonaggregated column 'chawtech_kiddyVewDevlopment.sd.is_approved' which is not functionally dependent on columns in GROUP BY clause; this is incompatible with sql_mode=only_full_group_by - Invalid query: SELECT
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
				    `student_id` = 57 AND sd.term_id = 1 AND `sd`.`session_id` = "29"
				GROUP BY
				    sd.subject_id 
ERROR - 2022-06-13 13:09:01 --> 404 Page Not Found: /index
ERROR - 2022-06-13 13:09:01 --> 404 Page Not Found: /index
ERROR - 2022-06-13 13:09:01 --> 404 Page Not Found: /index
ERROR - 2022-06-13 13:09:01 --> 404 Page Not Found: /index
ERROR - 2022-06-13 13:09:02 --> 404 Page Not Found: /index
ERROR - 2022-06-13 13:09:02 --> 404 Page Not Found: /index
ERROR - 2022-06-13 13:09:02 --> 404 Page Not Found: /index
ERROR - 2022-06-13 13:09:02 --> 404 Page Not Found: /index
ERROR - 2022-06-13 13:09:02 --> 404 Page Not Found: /index
ERROR - 2022-06-13 13:09:03 --> 404 Page Not Found: /index
ERROR - 2022-06-13 13:09:04 --> Query error: Expression #4 of SELECT list is not in GROUP BY clause and contains nonaggregated column 'chawtech_kiddyVewDevlopment.sd.is_approved' which is not functionally dependent on columns in GROUP BY clause; this is incompatible with sql_mode=only_full_group_by - Invalid query: SELECT
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
				    `student_id` = 57 AND sd.term_id = 1 AND `sd`.`session_id` = "29"
				GROUP BY
				    sd.subject_id 
ERROR - 2022-06-13 09:33:02 --> Query error: Expression #4 of SELECT list is not in GROUP BY clause and contains nonaggregated column 'chawtech_kiddyVewDevlopment.sd.is_approved' which is not functionally dependent on columns in GROUP BY clause; this is incompatible with sql_mode=only_full_group_by - Invalid query: SELECT
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
				    `student_id` = 57 AND sd.term_id = 1
				GROUP BY
				    sd.subject_id 
ERROR - 2022-06-13 09:35:28 --> 404 Page Not Found: /index
ERROR - 2022-06-13 09:36:22 --> Query error: Expression #12 of SELECT list is not in GROUP BY clause and contains nonaggregated column 'chawtech_kiddyVewDevlopment.s.sessionstart' which is not functionally dependent on columns in GROUP BY clause; this is incompatible with sql_mode=only_full_group_by - Invalid query: SELECT `c`.*, COUNT(ch.id) as num_child, CONCAT(t.teacherfname, " ", `t`.`teachermname`, " ", t.teacherlname) as teacher, `s`.`sessionstart`, `s`.`sessionend`
FROM `class` `c`
LEFT JOIN `child` `ch` ON `ch`.`childclass` = `c`.`id`
LEFT JOIN `teacher` `t` ON `t`.`id` = `c`.`classteacher`
LEFT JOIN `sessions` `s` ON `s`.`schoolId` = `c`.`schoolId`
WHERE `c`.`schoolId` = '191'
AND `s`.`current_sesion` = 1
GROUP BY `c`.`id`
ERROR - 2022-06-13 09:36:23 --> Query error: Expression #8 of SELECT list is not in GROUP BY clause and contains nonaggregated column 'chawtech_kiddyVewDevlopment.child_class.class_id' which is not functionally dependent on columns in GROUP BY clause; this is incompatible with sql_mode=only_full_group_by - Invalid query: SELECT `c`.`id` as `studentID`, CONCAT(c.childfname, " ", `c`.`childmname`, " ", c.childlname) as stud_name, `c`.`childphoto`, `c`.`schoolId`, `p`.`id` as `parent_id`, CONCAT(p.fatherfname, " ", p.fatherlname) as father_name, CONCAT(p.motherfname, " ", p.motherlname) as mother_name, `child_class`.`class_id`, CONCAT(cs.class, " ", cs.section) as class, `t`.`id` as `teacher_id`, CONCAT(t.teacherfname, " ", `t`.`teachermname`, " ", t.teacherlname) as teacher_name, `ss`.`id` as `session_id`, `ss`.`academicsession`, `child_class`.`session_id`
FROM `child` as `c`
LEFT JOIN `child_class` ON `c`.`id` = `child_class`.`child_id`
LEFT JOIN `parent` as `p` ON `c`.`parent_id`=`p`.`id`
LEFT JOIN `class` `cs` ON `child_class`.`class_id`=`cs`.`id`
LEFT JOIN `teacher` as `t` ON `cs`.`classteacher`=`t`.`id`
LEFT JOIN `sessions` as `ss` ON `child_class`.`session_id`=`ss`.`id`
WHERE `c`.`schoolId` = '191'
AND `c`.`status` = 1
GROUP BY `c`.`id`
ERROR - 2022-06-13 09:36:40 --> Query error: Expression #4 of SELECT list is not in GROUP BY clause and contains nonaggregated column 'chawtech_kiddyVewDevlopment.sd.is_approved' which is not functionally dependent on columns in GROUP BY clause; this is incompatible with sql_mode=only_full_group_by - Invalid query: SELECT
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
				    `student_id` = 57 AND sd.term_id = 1
				GROUP BY
				    sd.subject_id 
ERROR - 2022-06-13 09:41:15 --> Query error: Expression #1 of SELECT list is not in GROUP BY clause and contains nonaggregated column 'chawtech_kiddyVewDevlopment.result_term_subject_data.is_approved' which is not functionally dependent on columns in GROUP BY clause; this is incompatible with sql_mode=only_full_group_by - Invalid query: SELECT `is_approved`, `reason`, `term_id`, `student_id`, SUM(total_exam_marks) as totalTermExam, SUM(obtain_exam_marks) as totalTermObtainExam, SUM(total_test_marks) as totalTermTest, SUM(obtain_test_marks) as totalTermTestObtain, SUM(total_assignment_marks) as totalTermAssign, SUM(obtain_assignment_marks) as totalTermAssignObtain, SUM(total_project_marks) as totalTermProj, SUM(obtain_project_marks) as totalTermProjObtain, SUM(total_assessment_marks) as totalTermAssesment, SUM(obtain_assessment_marks) as totalObtainAssesment
FROM `result_term_subject_data`
WHERE `student_id` = '128'
AND `session_id` = '43'
GROUP BY `term_id`
ERROR - 2022-06-13 09:41:15 --> Query error: Expression #1 of SELECT list is not in GROUP BY clause and contains nonaggregated column 'chawtech_kiddyVewDevlopment.result_term_subject_data.term_id' which is not functionally dependent on columns in GROUP BY clause; this is incompatible with sql_mode=only_full_group_by - Invalid query: SELECT `term_id`, `student_id`, `subject_id`, `sb`.`subject`, SUM(total_exam_marks) as totalTermExam, SUM(obtain_exam_marks) as totalTermObtainExam, SUM(total_test_marks) as totalTermTest, SUM(obtain_test_marks) as totalTermTestObtain, SUM(total_assignment_marks) as totalTermAssign, SUM(obtain_assignment_marks) as totalTermAssignObtain, SUM(total_project_marks) as totalTermProj, SUM(obtain_project_marks) as totalTermProjObtain, SUM(total_assessment_marks) as totalTermAssesment, SUM(obtain_assessment_marks) as totalObtainAssesment
FROM `result_term_subject_data`
INNER JOIN `subjects` as `sb` ON `sb`.`id`=`result_term_subject_data`.`subject_id`
WHERE `session_id` = '43'
AND `student_id` = '128'
AND `is_approved` = 'approved'
GROUP BY `subject_id`
ERROR - 2022-06-13 09:41:17 --> 404 Page Not Found: /index
ERROR - 2022-06-13 09:45:02 --> Query error: Expression #4 of SELECT list is not in GROUP BY clause and contains nonaggregated column 'chawtech_kiddyVewDevlopment.sd.is_approved' which is not functionally dependent on columns in GROUP BY clause; this is incompatible with sql_mode=only_full_group_by - Invalid query: SELECT
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
				    `student_id` = 57 AND sd.term_id = 1
				GROUP BY
				    sd.subject_id 
ERROR - 2022-06-13 09:46:52 --> 404 Page Not Found: /index
ERROR - 2022-06-13 16:45:12 --> 404 Page Not Found: /index
ERROR - 2022-06-13 16:45:13 --> 404 Page Not Found: /index
ERROR - 2022-06-13 16:45:13 --> 404 Page Not Found: /index
ERROR - 2022-06-13 16:45:13 --> 404 Page Not Found: /index
ERROR - 2022-06-13 16:45:13 --> 404 Page Not Found: /index
ERROR - 2022-06-13 16:45:14 --> 404 Page Not Found: /index
ERROR - 2022-06-13 16:45:14 --> 404 Page Not Found: /index
ERROR - 2022-06-13 16:45:14 --> 404 Page Not Found: /index
ERROR - 2022-06-13 16:45:16 --> Severity: Notice --> Trying to get property 'id' of non-object /home/chawtechsolution/public_html/kidyview/application/models/StudentAttendance_model.php 28
ERROR - 2022-06-13 16:45:16 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'AND `c`.`status` = 1 AND `c`.`schoolId` = 129' at line 5 - Invalid query: SELECT `c`.`id`,CONCAT(c.childfname," ",`c`.`childmname`," ",c.childlname) AS  studentName,`c`.`childphoto`,`sa`.`check_in`,`sa`.`check_out`
					 FROM `child` AS `c`
					 LEFT JOIN (SELECT * FROM `student_attendance` WHERE student_attendance.date = "2022-06-13") sa
					 ON `sa`.`student_id` = `c`.`id`
					 WHERE `c`.`childclass` = 59 AND `c`.`class_session_id` =  AND `c`.`status` = 1 AND `c`.`schoolId` = 129 
ERROR - 2022-06-13 16:45:16 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/chawtechsolution/public_html/kidyview/system/core/Exceptions.php:271) /home/chawtechsolution/public_html/kidyview/system/core/Common.php 570
ERROR - 2022-06-13 16:45:19 --> Severity: Notice --> Trying to get property 'id' of non-object /home/chawtechsolution/public_html/kidyview/application/models/StudentAttendance_model.php 28
ERROR - 2022-06-13 16:45:19 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'AND `c`.`status` = 1 AND `c`.`schoolId` = 129' at line 5 - Invalid query: SELECT `c`.`id`,CONCAT(c.childfname," ",`c`.`childmname`," ",c.childlname) AS  studentName,`c`.`childphoto`,`sa`.`check_in`,`sa`.`check_out`
					 FROM `child` AS `c`
					 LEFT JOIN (SELECT * FROM `student_attendance` WHERE student_attendance.date = "2022-06-13") sa
					 ON `sa`.`student_id` = `c`.`id`
					 WHERE `c`.`childclass` = 60 AND `c`.`class_session_id` =  AND `c`.`status` = 1 AND `c`.`schoolId` = 129 
ERROR - 2022-06-13 16:45:19 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/chawtechsolution/public_html/kidyview/system/core/Exceptions.php:271) /home/chawtechsolution/public_html/kidyview/system/core/Common.php 570
ERROR - 2022-06-13 12:06:21 --> 404 Page Not Found: /index
ERROR - 2022-06-13 12:06:23 --> 404 Page Not Found: /index
ERROR - 2022-06-13 12:06:24 --> 404 Page Not Found: /index
ERROR - 2022-06-13 12:06:25 --> 404 Page Not Found: /index
ERROR - 2022-06-13 12:06:26 --> 404 Page Not Found: /index
ERROR - 2022-06-13 12:06:26 --> 404 Page Not Found: /index
ERROR - 2022-06-13 12:06:27 --> 404 Page Not Found: /index
ERROR - 2022-06-13 12:06:28 --> 404 Page Not Found: /index
ERROR - 2022-06-13 12:06:29 --> Severity: Notice --> Undefined variable: bgimage /home/chawtechsolution/public_html/kidyview/application/views/schoolLogin.php 31
ERROR - 2022-06-13 12:06:29 --> Severity: Notice --> Undefined variable: image /home/chawtechsolution/public_html/kidyview/application/views/schoolLogin.php 75
ERROR - 2022-06-13 18:31:43 --> 404 Page Not Found: /index
ERROR - 2022-06-13 18:31:45 --> 404 Page Not Found: /index
ERROR - 2022-06-13 18:31:46 --> 404 Page Not Found: /index
ERROR - 2022-06-13 18:31:47 --> 404 Page Not Found: /index
ERROR - 2022-06-13 18:31:48 --> 404 Page Not Found: /index
ERROR - 2022-06-13 18:31:49 --> 404 Page Not Found: /index
ERROR - 2022-06-13 18:31:50 --> 404 Page Not Found: /index
ERROR - 2022-06-13 18:31:51 --> 404 Page Not Found: /index
ERROR - 2022-06-13 18:31:52 --> Severity: Notice --> Undefined variable: bgimage /home/chawtechsolution/public_html/kidyview/application/views/schoolLogin.php 31
ERROR - 2022-06-13 18:31:52 --> Severity: Notice --> Undefined variable: image /home/chawtechsolution/public_html/kidyview/application/views/schoolLogin.php 75
