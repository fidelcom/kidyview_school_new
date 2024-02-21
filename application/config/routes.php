<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'schoolLogin';
$route['404_override'] = '';
$route['translate_uri_dashes'] = TRUE;

$route['api/(:any)'] = 'api/auth/$1';

/*================== Start For New Admin (14-12-2018) ======================*/
$route['administrator'] = 'administratorLogin';
$route['administrator/(:any)'] = 'administratorLogin/$1';
$route['schoollogin'] = 'schoolLogin';
$route['schoollogin/(:any)'] = 'schoolLogin/$1';
$route['school-view/(:any)'] = 'owner/schoolView/$1';
$route['edit-school/(:any)'] = 'owner/editSchool/$1';
/*=========================================================================*/
$route['event-detail/(:any)'] = 'schooluser/eventView/$1';
$route['edit-event/(:any)'] = 'schooluser/editEvent/$1';
/*=========================================================================*/
$route['parent-detail/(:any)'] = 'schooluser/parentView/$1';
$route['edit-parent/(:any)'] = 'schooluser/editParent/$1';
$route['edit-child/(:any)'] = 'schooluser/editChild/$1';
/*=========================================================================*/
$route['driver-detail/(:any)'] = 'schooluser/driverView/$1';
$route['edit-driver/(:any)'] = 'schooluser/editDriver/$1';
/*=========================================================================*/
$route['edit-session/(:any)'] = 'schooluser/editSession/$1';
$route['edit-class/(:any)'] = 'schooluser/editClass/$1';
$route['edit-subject/(:any)'] = 'schooluser/editSubject/$1';
/*=========================================================================*/
$route['teacher-detail/(:any)'] = 'schooluser/teacherView/$1';
$route['edit-teacher/(:any)'] = 'schooluser/editTeacher/$1';
/*=========================================================================*/
$route['student-detail/(:any)'] = 'schooluser/studentView/$1';
/*=========================================================================*/
$route['edit-article/(:any)'] = 'schooluser/editArticle/$1';
$route['article-detail/(:any)'] = 'schooluser/articleView/$1';
/*=========================================================================*/
$route['album-detail/(:any)'] = 'schooluser/albumView/$1';
$route['apiApp/teacher/teacherapp/getClass/(:num)'] ='apiApp/teacher/teacherapp/getClassList/$1';
$route['apiApp/teacher/teacherapp/getSubject/(:num)'] ='apiApp/teacher/teacherapp/getSubjectList/$1';
$route['apiApp/teacher/teacherapp/getAlbumList/(:num)/(:num)'] ='apiApp/teacher/teacherapp/getAlbumDataList/$1/$2';
$route['apiApp/teacher/teacherapp/getAttachmentByAlbum/(:num)'] ='apiApp/teacher/teacherapp/getAttachmentByAlbumId/$1';
$route['edit-holiday/(:any)'] = 'schooluser/editHoliday/$1';
$route['edit-role/(:any)'] = 'schooluser/editRole/$1';
$route['edit-privilege/(:any)'] = 'schooluser/editPrivilege/$1';
$route['studentlogin'] = 'studentLogin';
$route['teacherlogin'] = 'teacherLogin';
$route['school/subscription'] = 'schoolLogin/subscription';
$route['uploadStudentCsv'] = 'schooluser/uploadStudentCsvData';