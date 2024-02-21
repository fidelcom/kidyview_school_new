<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2022-05-16 03:17:21 --> 404 Page Not Found: /index
ERROR - 2022-05-16 03:19:21 --> Query error: Expression #12 of SELECT list is not in GROUP BY clause and contains nonaggregated column 'chawtech_kiddyVewDevlopment.s.sessionstart' which is not functionally dependent on columns in GROUP BY clause; this is incompatible with sql_mode=only_full_group_by - Invalid query: SELECT `c`.*, COUNT(ch.id) as num_child, CONCAT(t.teacherfname, " ", `t`.`teachermname`, " ", t.teacherlname) as teacher, `s`.`sessionstart`, `s`.`sessionend`
FROM `class` `c`
LEFT JOIN `child` `ch` ON `ch`.`childclass` = `c`.`id`
LEFT JOIN `teacher` `t` ON `t`.`id` = `c`.`classteacher`
LEFT JOIN `sessions` `s` ON `s`.`schoolId` = `c`.`schoolId`
WHERE `c`.`schoolId` = '191'
AND `s`.`current_sesion` = 1
GROUP BY `c`.`id`
ERROR - 2022-05-16 03:21:40 --> Query error: Expression #12 of SELECT list is not in GROUP BY clause and contains nonaggregated column 'chawtech_kiddyVewDevlopment.s.sessionstart' which is not functionally dependent on columns in GROUP BY clause; this is incompatible with sql_mode=only_full_group_by - Invalid query: SELECT `c`.*, COUNT(ch.id) as num_child, CONCAT(t.teacherfname, " ", `t`.`teachermname`, " ", t.teacherlname) as teacher, `s`.`sessionstart`, `s`.`sessionend`
FROM `class` `c`
LEFT JOIN `child` `ch` ON `ch`.`childclass` = `c`.`id`
LEFT JOIN `teacher` `t` ON `t`.`id` = `c`.`classteacher`
LEFT JOIN `sessions` `s` ON `s`.`schoolId` = `c`.`schoolId`
WHERE `c`.`schoolId` = '191'
AND `s`.`current_sesion` = 1
GROUP BY `c`.`id`
ERROR - 2022-05-16 03:21:40 --> Query error: Expression #8 of SELECT list is not in GROUP BY clause and contains nonaggregated column 'chawtech_kiddyVewDevlopment.child_class.class_id' which is not functionally dependent on columns in GROUP BY clause; this is incompatible with sql_mode=only_full_group_by - Invalid query: SELECT `c`.`id` as `studentID`, CONCAT(c.childfname, " ", `c`.`childmname`, " ", c.childlname) as stud_name, `c`.`childphoto`, `c`.`schoolId`, `p`.`id` as `parent_id`, CONCAT(p.fatherfname, " ", p.fatherlname) as father_name, CONCAT(p.motherfname, " ", p.motherlname) as mother_name, `child_class`.`class_id`, CONCAT(cs.class, " ", cs.section) as class, `t`.`id` as `teacher_id`, CONCAT(t.teacherfname, " ", `t`.`teachermname`, " ", t.teacherlname) as teacher_name, `ss`.`id` as `session_id`, `ss`.`academicsession`, `child_class`.`session_id`
FROM `child` as `c`
LEFT JOIN `child_class` ON `c`.`id` = `child_class`.`child_id`
LEFT JOIN `parent` as `p` ON `c`.`parent_id`=`p`.`id`
LEFT JOIN `class` `cs` ON `child_class`.`class_id`=`cs`.`id`
LEFT JOIN `teacher` as `t` ON `cs`.`classteacher`=`t`.`id`
LEFT JOIN `sessions` as `ss` ON `child_class`.`session_id`=`ss`.`id`
WHERE `c`.`schoolId` = '191'
AND `c`.`status` = 1
GROUP BY `c`.`id`
ERROR - 2022-05-16 03:22:03 --> Query error: Expression #10 of SELECT list is not in GROUP BY clause and contains nonaggregated column 'chawtech_kiddyVewDevlopment.cs.class' which is not functionally dependent on columns in GROUP BY clause; this is incompatible with sql_mode=only_full_group_by - Invalid query: SELECT `c`.`id` as `studentID`, `c`.`class_session_id`, CONCAT(c.childfname, " ", `c`.`childmname`, " ", c.childlname) as stud_name, `c`.`childphoto`, `c`.`schoolId`, `p`.`id` as `parent_id`, CONCAT(p.fatherfname, " ", p.fatherlname) as father_name, CONCAT(p.motherfname, " ", p.motherlname) as mother_name, `c`.`childclass` as `class_id`, CONCAT(cs.class, " ", cs.section) as class, `t`.`id` as `teacher_id`, CONCAT(t.teacherfname, " ", `t`.`teachermname`, " ", t.teacherlname) as teacher_name, `r`.`overall_total_marks`, `r`.`overall_marks_obtain`, `r`.`overall_grade`, `child_class`.`session_id`, `r`.`id`
FROM `child` as `c`
LEFT JOIN `child_class` ON `c`.`id`=`child_class`.`child_id`
LEFT JOIN `result` as `r` ON `child_class`.`class_id`=`r`.`class_id` AND `child_class`.`child_id` = `r`.`student_id` AND `child_class`.`session_id` = `r`.`session_id`
LEFT JOIN `parent` as `p` ON `c`.`parent_id`=`p`.`id`
LEFT JOIN `class` `cs` ON `child_class`.`class_id`=`cs`.`id`
LEFT JOIN `teacher` as `t` ON `cs`.`classteacher`=`t`.`id`
WHERE `child_class`.`session_id` = '46'
AND `c`.`schoolId` = '191'
AND `c`.`status` = 1
GROUP BY `c`.`id`
ERROR - 2022-05-16 03:22:22 --> Query error: Expression #10 of SELECT list is not in GROUP BY clause and contains nonaggregated column 'chawtech_kiddyVewDevlopment.cs.class' which is not functionally dependent on columns in GROUP BY clause; this is incompatible with sql_mode=only_full_group_by - Invalid query: SELECT `c`.`id` as `studentID`, `c`.`class_session_id`, CONCAT(c.childfname, " ", `c`.`childmname`, " ", c.childlname) as stud_name, `c`.`childphoto`, `c`.`schoolId`, `p`.`id` as `parent_id`, CONCAT(p.fatherfname, " ", p.fatherlname) as father_name, CONCAT(p.motherfname, " ", p.motherlname) as mother_name, `c`.`childclass` as `class_id`, CONCAT(cs.class, " ", cs.section) as class, `t`.`id` as `teacher_id`, CONCAT(t.teacherfname, " ", `t`.`teachermname`, " ", t.teacherlname) as teacher_name, `r`.`overall_total_marks`, `r`.`overall_marks_obtain`, `r`.`overall_grade`, `child_class`.`session_id`, `r`.`id`
FROM `child` as `c`
LEFT JOIN `child_class` ON `c`.`id`=`child_class`.`child_id`
LEFT JOIN `result` as `r` ON `child_class`.`class_id`=`r`.`class_id` AND `child_class`.`child_id` = `r`.`student_id` AND `child_class`.`session_id` = `r`.`session_id`
LEFT JOIN `parent` as `p` ON `c`.`parent_id`=`p`.`id`
LEFT JOIN `class` `cs` ON `child_class`.`class_id`=`cs`.`id`
LEFT JOIN `teacher` as `t` ON `cs`.`classteacher`=`t`.`id`
WHERE `child_class`.`session_id` = '43'
AND `c`.`schoolId` = '191'
AND `c`.`status` = 1
GROUP BY `c`.`id`
ERROR - 2022-05-16 03:22:43 --> Query error: Expression #10 of SELECT list is not in GROUP BY clause and contains nonaggregated column 'chawtech_kiddyVewDevlopment.cs.class' which is not functionally dependent on columns in GROUP BY clause; this is incompatible with sql_mode=only_full_group_by - Invalid query: SELECT `c`.`id` as `studentID`, `c`.`class_session_id`, CONCAT(c.childfname, " ", `c`.`childmname`, " ", c.childlname) as stud_name, `c`.`childphoto`, `c`.`schoolId`, `p`.`id` as `parent_id`, CONCAT(p.fatherfname, " ", p.fatherlname) as father_name, CONCAT(p.motherfname, " ", p.motherlname) as mother_name, `c`.`childclass` as `class_id`, CONCAT(cs.class, " ", cs.section) as class, `t`.`id` as `teacher_id`, CONCAT(t.teacherfname, " ", `t`.`teachermname`, " ", t.teacherlname) as teacher_name, `r`.`overall_total_marks`, `r`.`overall_marks_obtain`, `r`.`overall_grade`, `child_class`.`session_id`, `r`.`id`
FROM `child` as `c`
LEFT JOIN `child_class` ON `c`.`id`=`child_class`.`child_id`
LEFT JOIN `result` as `r` ON `child_class`.`class_id`=`r`.`class_id` AND `child_class`.`child_id` = `r`.`student_id` AND `child_class`.`session_id` = `r`.`session_id`
LEFT JOIN `parent` as `p` ON `c`.`parent_id`=`p`.`id`
LEFT JOIN `class` `cs` ON `child_class`.`class_id`=`cs`.`id`
LEFT JOIN `teacher` as `t` ON `cs`.`classteacher`=`t`.`id`
WHERE `child_class`.`session_id` = '41'
AND `c`.`schoolId` = '191'
AND `c`.`status` = 1
GROUP BY `c`.`id`
ERROR - 2022-05-16 13:56:55 --> 404 Page Not Found: /index
ERROR - 2022-05-16 13:57:45 --> 404 Page Not Found: /index
ERROR - 2022-05-16 13:57:45 --> Query error: Expression #1 of SELECT list is not in GROUP BY clause and contains nonaggregated column 'chawtech_kiddyVewDevlopment.result_term_subject_data.is_approved' which is not functionally dependent on columns in GROUP BY clause; this is incompatible with sql_mode=only_full_group_by - Invalid query: SELECT `is_approved`, `reason`, `term_id`, `student_id`, SUM(total_exam_marks) as totalTermExam, SUM(obtain_exam_marks) as totalTermObtainExam, SUM(total_test_marks) as totalTermTest, SUM(obtain_test_marks) as totalTermTestObtain, SUM(total_assignment_marks) as totalTermAssign, SUM(obtain_assignment_marks) as totalTermAssignObtain, SUM(total_project_marks) as totalTermProj, SUM(obtain_project_marks) as totalTermProjObtain, SUM(total_assessment_marks) as totalTermAssesment, SUM(obtain_assessment_marks) as totalObtainAssesment
FROM `result_term_subject_data`
WHERE `student_id` = '127'
AND `session_id` = '43'
GROUP BY `term_id`
ERROR - 2022-05-16 13:57:45 --> Query error: Expression #1 of SELECT list is not in GROUP BY clause and contains nonaggregated column 'chawtech_kiddyVewDevlopment.result_term_subject_data.term_id' which is not functionally dependent on columns in GROUP BY clause; this is incompatible with sql_mode=only_full_group_by - Invalid query: SELECT `term_id`, `student_id`, `subject_id`, `sb`.`subject`, SUM(total_exam_marks) as totalTermExam, SUM(obtain_exam_marks) as totalTermObtainExam, SUM(total_test_marks) as totalTermTest, SUM(obtain_test_marks) as totalTermTestObtain, SUM(total_assignment_marks) as totalTermAssign, SUM(obtain_assignment_marks) as totalTermAssignObtain, SUM(total_project_marks) as totalTermProj, SUM(obtain_project_marks) as totalTermProjObtain, SUM(total_assessment_marks) as totalTermAssesment, SUM(obtain_assessment_marks) as totalObtainAssesment
FROM `result_term_subject_data`
INNER JOIN `subjects` as `sb` ON `sb`.`id`=`result_term_subject_data`.`subject_id`
WHERE `session_id` = '43'
AND `student_id` = '127'
AND `is_approved` = 'approved'
GROUP BY `subject_id`
ERROR - 2022-05-16 13:57:45 --> Query error: Expression #1 of SELECT list is not in GROUP BY clause and contains nonaggregated column 'chawtech_kiddyVewDevlopment.result_term_subject_data.is_approved' which is not functionally dependent on columns in GROUP BY clause; this is incompatible with sql_mode=only_full_group_by - Invalid query: SELECT `is_approved`, `reason`, `term_id`, `student_id`, SUM(total_exam_marks) as totalTermExam, SUM(obtain_exam_marks) as totalTermObtainExam, SUM(total_test_marks) as totalTermTest, SUM(obtain_test_marks) as totalTermTestObtain, SUM(total_assignment_marks) as totalTermAssign, SUM(obtain_assignment_marks) as totalTermAssignObtain, SUM(total_project_marks) as totalTermProj, SUM(obtain_project_marks) as totalTermProjObtain, SUM(total_assessment_marks) as totalTermAssesment, SUM(obtain_assessment_marks) as totalObtainAssesment
FROM `result_term_subject_data`
WHERE `student_id` = '127'
AND `session_id` = '43'
GROUP BY `term_id`
ERROR - 2022-05-16 13:57:45 --> Query error: Expression #1 of SELECT list is not in GROUP BY clause and contains nonaggregated column 'chawtech_kiddyVewDevlopment.result_term_subject_data.term_id' which is not functionally dependent on columns in GROUP BY clause; this is incompatible with sql_mode=only_full_group_by - Invalid query: SELECT `term_id`, `student_id`, `subject_id`, `sb`.`subject`, SUM(total_exam_marks) as totalTermExam, SUM(obtain_exam_marks) as totalTermObtainExam, SUM(total_test_marks) as totalTermTest, SUM(obtain_test_marks) as totalTermTestObtain, SUM(total_assignment_marks) as totalTermAssign, SUM(obtain_assignment_marks) as totalTermAssignObtain, SUM(total_project_marks) as totalTermProj, SUM(obtain_project_marks) as totalTermProjObtain, SUM(total_assessment_marks) as totalTermAssesment, SUM(obtain_assessment_marks) as totalObtainAssesment
FROM `result_term_subject_data`
INNER JOIN `subjects` as `sb` ON `sb`.`id`=`result_term_subject_data`.`subject_id`
WHERE `session_id` = '43'
AND `student_id` = '127'
AND `is_approved` = 'approved'
GROUP BY `subject_id`
ERROR - 2022-05-16 03:29:16 --> 404 Page Not Found: /index
ERROR - 2022-05-16 03:29:16 --> 404 Page Not Found: /index
ERROR - 2022-05-16 03:29:24 --> 404 Page Not Found: /index
ERROR - 2022-05-16 03:29:24 --> 404 Page Not Found: /index
ERROR - 2022-05-16 03:29:24 --> Query error: Expression #1 of SELECT list is not in GROUP BY clause and contains nonaggregated column 'chawtech_kiddyVewDevlopment.result_term_subject_data.is_approved' which is not functionally dependent on columns in GROUP BY clause; this is incompatible with sql_mode=only_full_group_by - Invalid query: SELECT `is_approved`, `reason`, `term_id`, `student_id`, SUM(total_exam_marks) as totalTermExam, SUM(obtain_exam_marks) as totalTermObtainExam, SUM(total_test_marks) as totalTermTest, SUM(obtain_test_marks) as totalTermTestObtain, SUM(total_assignment_marks) as totalTermAssign, SUM(obtain_assignment_marks) as totalTermAssignObtain, SUM(total_project_marks) as totalTermProj, SUM(obtain_project_marks) as totalTermProjObtain, SUM(total_assessment_marks) as totalTermAssesment, SUM(obtain_assessment_marks) as totalObtainAssesment
FROM `result_term_subject_data`
WHERE `student_id` = '127'
AND `session_id` = '43'
GROUP BY `term_id`
ERROR - 2022-05-16 03:29:24 --> Query error: Expression #1 of SELECT list is not in GROUP BY clause and contains nonaggregated column 'chawtech_kiddyVewDevlopment.result_term_subject_data.term_id' which is not functionally dependent on columns in GROUP BY clause; this is incompatible with sql_mode=only_full_group_by - Invalid query: SELECT `term_id`, `student_id`, `subject_id`, `sb`.`subject`, SUM(total_exam_marks) as totalTermExam, SUM(obtain_exam_marks) as totalTermObtainExam, SUM(total_test_marks) as totalTermTest, SUM(obtain_test_marks) as totalTermTestObtain, SUM(total_assignment_marks) as totalTermAssign, SUM(obtain_assignment_marks) as totalTermAssignObtain, SUM(total_project_marks) as totalTermProj, SUM(obtain_project_marks) as totalTermProjObtain, SUM(total_assessment_marks) as totalTermAssesment, SUM(obtain_assessment_marks) as totalObtainAssesment
FROM `result_term_subject_data`
INNER JOIN `subjects` as `sb` ON `sb`.`id`=`result_term_subject_data`.`subject_id`
WHERE `session_id` = '43'
AND `student_id` = '127'
AND `is_approved` = 'approved'
GROUP BY `subject_id`
ERROR - 2022-05-16 03:29:25 --> Query error: Expression #1 of SELECT list is not in GROUP BY clause and contains nonaggregated column 'chawtech_kiddyVewDevlopment.result_term_subject_data.term_id' which is not functionally dependent on columns in GROUP BY clause; this is incompatible with sql_mode=only_full_group_by - Invalid query: SELECT `term_id`, `student_id`, `subject_id`, `sb`.`subject`, SUM(total_exam_marks) as totalTermExam, SUM(obtain_exam_marks) as totalTermObtainExam, SUM(total_test_marks) as totalTermTest, SUM(obtain_test_marks) as totalTermTestObtain, SUM(total_assignment_marks) as totalTermAssign, SUM(obtain_assignment_marks) as totalTermAssignObtain, SUM(total_project_marks) as totalTermProj, SUM(obtain_project_marks) as totalTermProjObtain, SUM(total_assessment_marks) as totalTermAssesment, SUM(obtain_assessment_marks) as totalObtainAssesment
FROM `result_term_subject_data`
INNER JOIN `subjects` as `sb` ON `sb`.`id`=`result_term_subject_data`.`subject_id`
WHERE `session_id` = '43'
AND `student_id` = '127'
AND `is_approved` = 'approved'
GROUP BY `subject_id`
ERROR - 2022-05-16 03:29:25 --> Query error: Expression #1 of SELECT list is not in GROUP BY clause and contains nonaggregated column 'chawtech_kiddyVewDevlopment.result_term_subject_data.is_approved' which is not functionally dependent on columns in GROUP BY clause; this is incompatible with sql_mode=only_full_group_by - Invalid query: SELECT `is_approved`, `reason`, `term_id`, `student_id`, SUM(total_exam_marks) as totalTermExam, SUM(obtain_exam_marks) as totalTermObtainExam, SUM(total_test_marks) as totalTermTest, SUM(obtain_test_marks) as totalTermTestObtain, SUM(total_assignment_marks) as totalTermAssign, SUM(obtain_assignment_marks) as totalTermAssignObtain, SUM(total_project_marks) as totalTermProj, SUM(obtain_project_marks) as totalTermProjObtain, SUM(total_assessment_marks) as totalTermAssesment, SUM(obtain_assessment_marks) as totalObtainAssesment
FROM `result_term_subject_data`
WHERE `student_id` = '127'
AND `session_id` = '43'
GROUP BY `term_id`
ERROR - 2022-05-16 14:12:46 --> 404 Page Not Found: /index
ERROR - 2022-05-16 14:12:50 --> Severity: Notice --> Trying to get property 'school_name' of non-object /home/chawtechsolution/public_html/kidyview/application/models/User_model.php 258
ERROR - 2022-05-16 14:12:50 --> Severity: Notice --> Trying to get property 'subscription_id' of non-object /home/chawtechsolution/public_html/kidyview/application/models/User_model.php 259
ERROR - 2022-05-16 14:12:50 --> Severity: Notice --> Trying to get property 'phone' of non-object /home/chawtechsolution/public_html/kidyview/application/models/User_model.php 260
ERROR - 2022-05-16 14:12:50 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/chawtechsolution/public_html/kidyview/system/core/Exceptions.php:271) /home/chawtechsolution/public_html/kidyview/system/core/Common.php 570
ERROR - 2022-05-16 14:12:59 --> Severity: Warning --> openssl_decrypt(): IV passed is only 6 bytes long, cipher expects an IV of precisely 16 bytes, padding with \0 /home/chawtechsolution/public_html/kidyview/application/libraries/Settings.php 59
ERROR - 2022-05-16 14:12:59 --> Severity: Warning --> hash_equals(): Expected known_string to be a string, boolean given /home/chawtechsolution/public_html/kidyview/application/libraries/Settings.php 61
ERROR - 2022-05-16 14:12:59 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/chawtechsolution/public_html/kidyview/system/core/Exceptions.php:271) /home/chawtechsolution/public_html/kidyview/application/libraries/Token.php 105
ERROR - 2022-05-16 14:12:59 --> Severity: Warning --> openssl_decrypt(): IV passed is only 6 bytes long, cipher expects an IV of precisely 16 bytes, padding with \0 /home/chawtechsolution/public_html/kidyview/application/libraries/Settings.php 59
ERROR - 2022-05-16 14:12:59 --> Severity: Warning --> hash_equals(): Expected known_string to be a string, boolean given /home/chawtechsolution/public_html/kidyview/application/libraries/Settings.php 61
ERROR - 2022-05-16 14:12:59 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/chawtechsolution/public_html/kidyview/system/core/Exceptions.php:271) /home/chawtechsolution/public_html/kidyview/application/libraries/Token.php 105
ERROR - 2022-05-16 14:12:59 --> Severity: Warning --> openssl_decrypt(): IV passed is only 6 bytes long, cipher expects an IV of precisely 16 bytes, padding with \0 /home/chawtechsolution/public_html/kidyview/application/libraries/Settings.php 59
ERROR - 2022-05-16 14:12:59 --> Severity: Warning --> hash_equals(): Expected known_string to be a string, boolean given /home/chawtechsolution/public_html/kidyview/application/libraries/Settings.php 61
ERROR - 2022-05-16 14:12:59 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/chawtechsolution/public_html/kidyview/system/core/Exceptions.php:271) /home/chawtechsolution/public_html/kidyview/application/libraries/Token.php 105
ERROR - 2022-05-16 14:12:59 --> Severity: Warning --> openssl_decrypt(): IV passed is only 6 bytes long, cipher expects an IV of precisely 16 bytes, padding with \0 /home/chawtechsolution/public_html/kidyview/application/libraries/Settings.php 59
ERROR - 2022-05-16 14:12:59 --> Severity: Warning --> hash_equals(): Expected known_string to be a string, boolean given /home/chawtechsolution/public_html/kidyview/application/libraries/Settings.php 61
ERROR - 2022-05-16 14:12:59 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/chawtechsolution/public_html/kidyview/system/core/Exceptions.php:271) /home/chawtechsolution/public_html/kidyview/application/libraries/Token.php 105
ERROR - 2022-05-16 14:12:59 --> Severity: Warning --> openssl_decrypt(): IV passed is only 6 bytes long, cipher expects an IV of precisely 16 bytes, padding with \0 /home/chawtechsolution/public_html/kidyview/application/libraries/Settings.php 59
ERROR - 2022-05-16 14:12:59 --> Severity: Warning --> hash_equals(): Expected known_string to be a string, boolean given /home/chawtechsolution/public_html/kidyview/application/libraries/Settings.php 61
ERROR - 2022-05-16 14:12:59 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/chawtechsolution/public_html/kidyview/system/core/Exceptions.php:271) /home/chawtechsolution/public_html/kidyview/application/libraries/Token.php 105
ERROR - 2022-05-16 14:12:59 --> Severity: Warning --> openssl_decrypt(): IV passed is only 6 bytes long, cipher expects an IV of precisely 16 bytes, padding with \0 /home/chawtechsolution/public_html/kidyview/application/libraries/Settings.php 59
ERROR - 2022-05-16 14:12:59 --> Severity: Warning --> hash_equals(): Expected known_string to be a string, boolean given /home/chawtechsolution/public_html/kidyview/application/libraries/Settings.php 61
ERROR - 2022-05-16 14:12:59 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/chawtechsolution/public_html/kidyview/system/core/Exceptions.php:271) /home/chawtechsolution/public_html/kidyview/application/libraries/Token.php 105
ERROR - 2022-05-16 14:13:38 --> 404 Page Not Found: /index
ERROR - 2022-05-16 14:13:38 --> Severity: Warning --> openssl_decrypt(): IV passed is only 6 bytes long, cipher expects an IV of precisely 16 bytes, padding with \0 /home/chawtechsolution/public_html/kidyview/application/libraries/Settings.php 59
ERROR - 2022-05-16 14:13:38 --> Severity: Warning --> hash_equals(): Expected known_string to be a string, boolean given /home/chawtechsolution/public_html/kidyview/application/libraries/Settings.php 61
ERROR - 2022-05-16 14:13:38 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/chawtechsolution/public_html/kidyview/system/core/Exceptions.php:271) /home/chawtechsolution/public_html/kidyview/application/libraries/Token.php 105
ERROR - 2022-05-16 14:13:38 --> Severity: Warning --> openssl_decrypt(): IV passed is only 6 bytes long, cipher expects an IV of precisely 16 bytes, padding with \0 /home/chawtechsolution/public_html/kidyview/application/libraries/Settings.php 59
ERROR - 2022-05-16 14:13:38 --> Severity: Warning --> hash_equals(): Expected known_string to be a string, boolean given /home/chawtechsolution/public_html/kidyview/application/libraries/Settings.php 61
ERROR - 2022-05-16 14:13:38 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/chawtechsolution/public_html/kidyview/system/core/Exceptions.php:271) /home/chawtechsolution/public_html/kidyview/application/libraries/Token.php 105
ERROR - 2022-05-16 14:13:38 --> Severity: Warning --> openssl_decrypt(): IV passed is only 6 bytes long, cipher expects an IV of precisely 16 bytes, padding with \0 /home/chawtechsolution/public_html/kidyview/application/libraries/Settings.php 59
ERROR - 2022-05-16 14:13:38 --> Severity: Warning --> hash_equals(): Expected known_string to be a string, boolean given /home/chawtechsolution/public_html/kidyview/application/libraries/Settings.php 61
ERROR - 2022-05-16 14:13:38 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/chawtechsolution/public_html/kidyview/system/core/Exceptions.php:271) /home/chawtechsolution/public_html/kidyview/application/libraries/Token.php 105
ERROR - 2022-05-16 14:13:43 --> Severity: Warning --> openssl_decrypt(): IV passed is only 6 bytes long, cipher expects an IV of precisely 16 bytes, padding with \0 /home/chawtechsolution/public_html/kidyview/application/libraries/Settings.php 59
ERROR - 2022-05-16 14:13:43 --> Severity: Warning --> hash_equals(): Expected known_string to be a string, boolean given /home/chawtechsolution/public_html/kidyview/application/libraries/Settings.php 61
ERROR - 2022-05-16 14:13:43 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/chawtechsolution/public_html/kidyview/system/core/Exceptions.php:271) /home/chawtechsolution/public_html/kidyview/application/libraries/Token.php 105
ERROR - 2022-05-16 14:13:44 --> 404 Page Not Found: /index
ERROR - 2022-05-16 14:13:44 --> Severity: Warning --> openssl_decrypt(): IV passed is only 6 bytes long, cipher expects an IV of precisely 16 bytes, padding with \0 /home/chawtechsolution/public_html/kidyview/application/libraries/Settings.php 59
ERROR - 2022-05-16 14:13:44 --> Severity: Warning --> hash_equals(): Expected known_string to be a string, boolean given /home/chawtechsolution/public_html/kidyview/application/libraries/Settings.php 61
ERROR - 2022-05-16 14:13:44 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/chawtechsolution/public_html/kidyview/system/core/Exceptions.php:271) /home/chawtechsolution/public_html/kidyview/application/libraries/Token.php 105
ERROR - 2022-05-16 14:13:44 --> Severity: Warning --> openssl_decrypt(): IV passed is only 6 bytes long, cipher expects an IV of precisely 16 bytes, padding with \0 /home/chawtechsolution/public_html/kidyview/application/libraries/Settings.php 59
ERROR - 2022-05-16 14:13:44 --> Severity: Warning --> hash_equals(): Expected known_string to be a string, boolean given /home/chawtechsolution/public_html/kidyview/application/libraries/Settings.php 61
ERROR - 2022-05-16 14:13:44 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/chawtechsolution/public_html/kidyview/system/core/Exceptions.php:271) /home/chawtechsolution/public_html/kidyview/application/libraries/Token.php 105
ERROR - 2022-05-16 14:14:58 --> Query error: Expression #1 of SELECT list is not in GROUP BY clause and contains nonaggregated column 'chawtech_kiddyVewDevlopment.result_term_subject_data.is_approved' which is not functionally dependent on columns in GROUP BY clause; this is incompatible with sql_mode=only_full_group_by - Invalid query: SELECT `is_approved`, `reason`, `term_id`, `student_id`, SUM(total_exam_marks) as totalTermExam, SUM(obtain_exam_marks) as totalTermObtainExam, SUM(total_test_marks) as totalTermTest, SUM(obtain_test_marks) as totalTermTestObtain, SUM(total_assignment_marks) as totalTermAssign, SUM(obtain_assignment_marks) as totalTermAssignObtain, SUM(total_project_marks) as totalTermProj, SUM(obtain_project_marks) as totalTermProjObtain, SUM(total_assessment_marks) as totalTermAssesment, SUM(obtain_assessment_marks) as totalObtainAssesment
FROM `result_term_subject_data`
WHERE `student_id` = '127'
AND `session_id` = '43'
GROUP BY `term_id`
ERROR - 2022-05-16 14:14:58 --> Query error: Expression #1 of SELECT list is not in GROUP BY clause and contains nonaggregated column 'chawtech_kiddyVewDevlopment.result_term_subject_data.term_id' which is not functionally dependent on columns in GROUP BY clause; this is incompatible with sql_mode=only_full_group_by - Invalid query: SELECT `term_id`, `student_id`, `subject_id`, `sb`.`subject`, SUM(total_exam_marks) as totalTermExam, SUM(obtain_exam_marks) as totalTermObtainExam, SUM(total_test_marks) as totalTermTest, SUM(obtain_test_marks) as totalTermTestObtain, SUM(total_assignment_marks) as totalTermAssign, SUM(obtain_assignment_marks) as totalTermAssignObtain, SUM(total_project_marks) as totalTermProj, SUM(obtain_project_marks) as totalTermProjObtain, SUM(total_assessment_marks) as totalTermAssesment, SUM(obtain_assessment_marks) as totalObtainAssesment
FROM `result_term_subject_data`
INNER JOIN `subjects` as `sb` ON `sb`.`id`=`result_term_subject_data`.`subject_id`
WHERE `session_id` = '43'
AND `student_id` = '127'
AND `is_approved` = 'approved'
GROUP BY `subject_id`
ERROR - 2022-05-16 14:14:58 --> 404 Page Not Found: /index
ERROR - 2022-05-16 14:14:59 --> Query error: Expression #1 of SELECT list is not in GROUP BY clause and contains nonaggregated column 'chawtech_kiddyVewDevlopment.result_term_subject_data.is_approved' which is not functionally dependent on columns in GROUP BY clause; this is incompatible with sql_mode=only_full_group_by - Invalid query: SELECT `is_approved`, `reason`, `term_id`, `student_id`, SUM(total_exam_marks) as totalTermExam, SUM(obtain_exam_marks) as totalTermObtainExam, SUM(total_test_marks) as totalTermTest, SUM(obtain_test_marks) as totalTermTestObtain, SUM(total_assignment_marks) as totalTermAssign, SUM(obtain_assignment_marks) as totalTermAssignObtain, SUM(total_project_marks) as totalTermProj, SUM(obtain_project_marks) as totalTermProjObtain, SUM(total_assessment_marks) as totalTermAssesment, SUM(obtain_assessment_marks) as totalObtainAssesment
FROM `result_term_subject_data`
WHERE `student_id` = '127'
AND `session_id` = '43'
GROUP BY `term_id`
ERROR - 2022-05-16 14:14:59 --> Query error: Expression #1 of SELECT list is not in GROUP BY clause and contains nonaggregated column 'chawtech_kiddyVewDevlopment.result_term_subject_data.term_id' which is not functionally dependent on columns in GROUP BY clause; this is incompatible with sql_mode=only_full_group_by - Invalid query: SELECT `term_id`, `student_id`, `subject_id`, `sb`.`subject`, SUM(total_exam_marks) as totalTermExam, SUM(obtain_exam_marks) as totalTermObtainExam, SUM(total_test_marks) as totalTermTest, SUM(obtain_test_marks) as totalTermTestObtain, SUM(total_assignment_marks) as totalTermAssign, SUM(obtain_assignment_marks) as totalTermAssignObtain, SUM(total_project_marks) as totalTermProj, SUM(obtain_project_marks) as totalTermProjObtain, SUM(total_assessment_marks) as totalTermAssesment, SUM(obtain_assessment_marks) as totalObtainAssesment
FROM `result_term_subject_data`
INNER JOIN `subjects` as `sb` ON `sb`.`id`=`result_term_subject_data`.`subject_id`
WHERE `session_id` = '43'
AND `student_id` = '127'
AND `is_approved` = 'approved'
GROUP BY `subject_id`
ERROR - 2022-05-16 14:21:20 --> 404 Page Not Found: /index
ERROR - 2022-05-16 14:32:09 --> 404 Page Not Found: /index
ERROR - 2022-05-16 14:32:09 --> 404 Page Not Found: /index
ERROR - 2022-05-16 14:32:20 --> 404 Page Not Found: /index
ERROR - 2022-05-16 14:32:20 --> 404 Page Not Found: /index
ERROR - 2022-05-16 14:32:20 --> 404 Page Not Found: /index
ERROR - 2022-05-16 14:32:34 --> 404 Page Not Found: /index
ERROR - 2022-05-16 14:32:34 --> 404 Page Not Found: /index
ERROR - 2022-05-16 14:32:38 --> 404 Page Not Found: /index
ERROR - 2022-05-16 14:32:39 --> 404 Page Not Found: /index
ERROR - 2022-05-16 14:32:42 --> 404 Page Not Found: /index
ERROR - 2022-05-16 14:32:42 --> 404 Page Not Found: /index
ERROR - 2022-05-16 11:50:40 --> 404 Page Not Found: /index
ERROR - 2022-05-16 12:00:54 --> 404 Page Not Found: /index
ERROR - 2022-05-16 12:04:28 --> 404 Page Not Found: /index
ERROR - 2022-05-16 19:21:29 --> 404 Page Not Found: /index
ERROR - 2022-05-16 19:21:30 --> 404 Page Not Found: /index
ERROR - 2022-05-16 19:21:30 --> 404 Page Not Found: /index
ERROR - 2022-05-16 19:21:30 --> 404 Page Not Found: /index
ERROR - 2022-05-16 19:21:30 --> 404 Page Not Found: /index
ERROR - 2022-05-16 19:21:31 --> 404 Page Not Found: /index
ERROR - 2022-05-16 19:21:31 --> 404 Page Not Found: /index
ERROR - 2022-05-16 19:21:31 --> 404 Page Not Found: /index
ERROR - 2022-05-16 19:21:53 --> 404 Page Not Found: /index
ERROR - 2022-05-16 19:21:53 --> 404 Page Not Found: /index
ERROR - 2022-05-16 19:21:53 --> 404 Page Not Found: /index
ERROR - 2022-05-16 19:21:54 --> 404 Page Not Found: /index
ERROR - 2022-05-16 19:21:54 --> 404 Page Not Found: /index
ERROR - 2022-05-16 19:21:54 --> 404 Page Not Found: /index
ERROR - 2022-05-16 19:21:54 --> 404 Page Not Found: /index
ERROR - 2022-05-16 19:21:54 --> 404 Page Not Found: /index
