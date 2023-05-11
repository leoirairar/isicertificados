<?php
use App\Course;
use App\Employee;
use Carbon\carbon;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('home');
// })->middleware('auth','checkConditions');



Auth::routes(['register' => false]);

Route::get('logout', 'Auth\LoginController@logout');
//home
Route::get('/home', 'HomeController@index');
Route::get('/', 'HomeController@index');
Route::get('/prueba', 'HomeController@auth');

Route::get('getAttendaceCertificateView', 'CourseCertificateController@getAttendaceCertificateView')->name('getAttendaceCertificateView');
Route::get('getEmployeeAttendaceCertificate/{identification}','CourseCertificateController@getEmployeeAttendaceCertificate')->name('getEmployeeAttendaceCertificate');

//company
Route::get('/getCompanies', 'CompanyController@index')->name('getCompanies')->middleware('checkConditions');
Route::get('/company', 'CompanyController@create');
Route::get('/editCompany/{id}', 'CompanyController@edit');
Route::post('/insertCompany', 'CompanyController@store')->name('insertCompany');
Route::put('/updateCompany/{id}', 'CompanyController@update')->name('updateCompany');
Route::get('/deleteCompany/{id}', 'CompanyController@destroy');
Route::get('/getCompanyInformation/{id}','CompanyController@getCompanyDetail')->name('getCompanyInformation');
Route::get('getCompanyInformation/getPreEnrolledEmployeesByCompany/{companyId}/{adminId}','EmployeeController@getPreEnrolledEmployeesByCompany');
Route::get('getCompanyInformation/getEnrolledEmployeesByCompany/{companyId}/{employeeId}','EmployeeController@getEnrolledEmployeesByCompany');
Route::get('/getCompanyConditions/{id}','CompanyController@getCompanyConditions')->name('getCompanyConditions');
Route::get('/getCompaniesData','CompanyController@getCompaniesData')->name('getCompaniesData');
Route::put('/updateCompanyCondition', 'CompanyController@updateCompanyTermsAndConditions')->name('updateCompanyCondition');
Route::get('getInsertCompanyView','CompanyController@getInsertCompanyView')->name('getInsertCompanyView');
Route::any('insertCompanyGuest','GuestCompanyController@insertCompanyGuest')->name('insertCompanyGuest');





//AdministratorSIS
Route::get('/getAdministrator', 'AdministratorController@index')->name('getAdministrator');
Route::get('/administratorisi', 'AdministratorController@create');
Route::get('/editAdministrator/{id}', 'AdministratorController@edit');
Route::post('/insertAdministrator', 'AdministratorController@store')->name('insertAdministrator');
Route::put('/updateAdministrator/{id}', 'AdministratorController@update')->name('updateAdministrator');
Route::delete('/deleteAdministrator/{id}', 'AdministratorController@destroy');

//Administrator
Route::get('/getCompanyAdministrator', 'CompanyAdministratorController@index')->name('getCompanyAdministrator');
Route::get('/administrator', 'CompanyAdministratorController@create');
Route::get('/editCompanyAdministrator/{id}', 'CompanyAdministratorController@edit');
Route::post('/insertCompanyAdministrator', 'CompanyAdministratorController@store')->name('insertCompanyAdministrator');
Route::any('/updateCompanyAdministrator/{id}', 'CompanyAdministratorController@update')->name('updateCompanyAdministrator');
Route::delete('/deleteCompanyAdministrator/{id}', 'CompanyAdministratorController@destroy');

//Employee
Route::get('/getEmployee', 'EmployeeController@index')->name('getEmployee')->middleware('checkConditions');
Route::get('/employee', 'EmployeeController@create')->middleware('checkConditions');
Route::get('/editEmployee/{id}', 'EmployeeController@edit');
Route::post('/insertEmployee', 'EmployeeController@store')->name('insertEmployee');
Route::put('/updateEmployee/{id}', 'EmployeeController@update')->name('updateEmployee');
Route::get('/deleteEmployee/{id}', 'EmployeeController@destroy');
Route::get('/getPreEnrolledEmployees','EmployeeController@getPreEnrolledEmployees')->name('getPreEnrolledEmployees');
Route::get('EnrolledEmployees','EmployeeController@enrolledEmployees')->name('EnrolledEmployees');
Route::get('getPreEnrolledEmployeesByCompany/{companyId}/{adminId}','EmployeeController@getPreEnrolledEmployeesByCompany');
Route::get('getPreEnrolledEmployeesByCompany','EmployeeController@getPreEnrolledEmployees');
Route::get('getCourseAssignment/checkEmployeeCourses/{id}','EmployeeController@checkEmployeeCourses')->name('checkEmployeeCourses');
Route::post('employeesCourseAttendance','EmployeeController@insertEmployeesCourseAttendance')->name('employeesCourseAttendance');
Route::any('getEmployeesByFinishedCoruse/{id}','EmployeeController@getEmployeesByFinishedCoruse');
Route::delete('/reporgramEmployee/{id}/{courseProgramingId}', 'EmployeeController@reprogramEmployee');
Route::any('getEmployeesByCompanyId/{id}','EmployeeController@getEmployeesByCompanyId');
Route::any('preEnrolledEmployeesView','EmployeeController@preEnrolledEmployeesView')->name('preEnrolledEmployeesView');
Route::get('/enrolledEmployessView', 'EmployeeController@enrolledEmployessView');
Route::get('getEnrolledEmployees','EmployeeController@getEnrolledEmployees');
Route::get('getEnrolledEmployeesByCompany/{id}/{employeeId}','EmployeeController@getEnrolledEmployeesByCompany');
Route::get('getMinistryEmployeesByFinishedCoruse/{id}','EmployeeController@getMinistryEmployeesByFinishedCoruse');
Route::get('/rescheduleEmployees', 'EmployeeController@getRescheduleEmployees');
Route::any('/reprogramEmployee/{employeeId}/{courseProgrammed}/{newCourseProgrammed}', 'EmployeeController@rescheduleEmployee');
Route::get('/showUserByIdentification', 'EmployeeController@showUserByIdentification');
Route::get('/getEmployeeInformationByIdentification/{identification}', 'EmployeeController@getEmployeeInformationByIdentification');
Route::get('/getEnrollmentEmployeeInformation/{employeeId}', 'EmployeeController@getEnrollmentEmployeeInformation')->name('getEnrollmentEmployeeInformation');
Route::get('/enrollmentHistory', 'CourseProgrammingController@getEnrollmentHistoryView');
Route::get('/getAllFinishedEmployeesCertificates', 'EmployeeController@getAllFinishedEmployeesCertificates');
Route::get('/getAllFinishedEmployeesCertificatesByDate/{date1}/{date2}', 'EmployeeController@getAllFinishedEmployeesCertificatesByDate');
Route::get('rescheduleEmployeeById/{id}','EmployeeController@getRescheduleEmployeesById');
Route::get('getEmployeesTableData/','EmployeeController@getEmployeesTableData')->name('getEmployeesTableData');
Route::delete('unsuscribe/{enrollmentId}','EmployeeController@unsuscribeEmployee');
Route::get('/checkEmployeeIdentification/{checkEmployeeIdentification}', 'EmployeeController@checkEmployeeIdentification');
Route::get('/getEmployeeCertificates', 'EmployeeController@getEmployeeCertificates');
Route::get('/getEnrollmentEmployeeInformationByIdentification/{identification}', 'EmployeeController@getEnrollmentEmployeeInformationByIdentification')->name('getEnrollmentEmployeeInformationByIdentification');

//Instructor
Route::get('/getInstructor', 'InstructorController@index')->name('getInstructor');
Route::get('/instructor', 'InstructorController@create');
Route::get('/editInstructor/{id}', 'InstructorController@edit');
Route::post('/insertInstructor', 'InstructorController@store')->name('insertInstructor');
Route::put('/updateInstructor/{id}', 'InstructorController@update')->name('updateInstructor');
Route::delete('/deleteInstructor/{id}', 'InstructorController@destroy');
Route::get('downloadSign/{name}','FilesController@downloadSign')->name('downloadSign');


//cursos
Route::get('/getCourses', 'CourseController@index')->name('getCourses')->middleware('checkConditions');
Route::get('/course', 'CourseController@create');
Route::get('/editCourse/{id}', 'CourseController@edit');
Route::post('/insertCourse', 'CourseController@store')->name('insertCourse');
Route::put('/updateCourse/{id}', 'CourseController@update')->name('updateCourse');
Route::delete('/deleteCourse/{id}', 'CourseController@destroy');


//course programming
Route::get('/getCourseProgramming', 'CourseProgrammingController@index')->name('getCourseProgramming');
Route::get('/courseProgramming', 'CourseProgrammingController@create');
Route::post('/insertCourseProgramming', 'CourseProgrammingController@store')->name('insertCourseProgramming');
Route::get('/editCourseProgramming/{id}', 'CourseProgrammingController@edit');
Route::put('/updateCourseProgramming/{id}', 'CourseProgrammingController@update')->name('updateCourseProgramming');
Route::any('/deleteCourseProgramming/{id}', 'CourseProgrammingController@destroy');
Route::get('/getViewCourseFinalization', 'CourseProgrammingController@getViewCourseFinalization');
Route::get('/getProgrammedCourses', 'CourseProgrammingController@getProgrammedCourses')->name('getProgrammedCourses');
Route::any('/getViewCourseFinalizationByDates','CourseProgrammingController@getViewCourseFinalizationByDates')->name('getViewCourseFinalizationByDates');
Route::any('/getFinishedCoursesBydates','CourseProgrammingController@getFinishedCoursesBydates')->name('getFinishedCoursesBydates');
Route::any('/getAttendanceListByCourse/{id}','CourseProgrammingController@getAttendanceListByCourse')->name('getAttendanceListByCourse');
Route::any('/getAttendanceProgrammedCoursesByDates','CourseProgrammingController@getAttendanceProgrammedCoursesByDates')->name('getAttendanceProgrammedCoursesByDates');
Route::get('/exportCourseProgamingAttendance/{id}','CourseProgrammingController@exportCourseProgamingAttendance')->name('exportCourseProgamingAttendance');
Route::post('/saveAttendanceCourse', 'CourseProgrammingController@saveAttendanceCourse')->name('saveAttendanceCourse');
Route::get('/getCourseProgrammingById/{id}', 'CourseProgrammingController@getCourseProgrammingById')->name('getCourseProgrammingById');
Route::get('/getCourseProgrammingJson', 'CourseProgrammingController@getCourseProgrammingJson');
Route::get('/checkEmployeeCourseInscription/{employee_id}/{courseProgramming_id}', 'CourseProgrammingController@checkEmployeeCourseInscription')->name('checkEmployeeCourseInscription');
Route::post('/checkCourseProgramming', 'CourseProgrammingController@checkCourseProgramming')->name('checkCourseProgramming');






//course assigment
Route::get('/getCourseAssignment/{id}', 'CourseAssignment@index')->name('getCourseAssignment');
Route::get('/getCourseAssignment', 'CourseAssignment@index')->name('getCourseAssignment');
Route::post('/insertCourseAssignment', 'CourseAssignment@store')->name('insertCourseAssignment');
Route::put('/updateCourseAssignmentFiles', 'CourseAssignment@update')->name('updateCourseAssignmentFiles');


//document type
Route::get('/getDocumentType', 'DocumentTypeController@index')->name('getDocumentType');
Route::get('/documentType', 'DocumentTypeController@create');
Route::post('/insertDocumentType', 'DocumentTypeController@store')->name('insertDocumentType');
Route::get('/editDocumentType/{id}', 'DocumentTypeController@edit');
Route::put('/updateDocumentoType/{id}', 'DocumentTypeController@update')->name('updateDocumentoType');
Route::delete('/deleteDocumentType/{id}', 'DocumentTypeController@destroy');
Route::any('getCourseAssignment/selectedDocumentsType/{id}',function($id){
    $course = Course::where('id',$id)->with('documentsType')->first();
    return  Response::json($course->documentsType);
});

//enrollment
Route::get('getEnrolledEmployess/getAttendancesEmployeesByDay/{course_day_id}', 'CourseProgrammingController@getAttendanceEmployees');
Route::get('attendance','CourseProgrammingController@getAttendanceView');




//Files
Route::get('getCourseFilesByEmployee/{id}/{course_id}','FilesController@getFilesByEmployee')->name('getCourseFilesByEmployee');
Route::get('getCompanyInformation/getEditablesFilesByEmployee/{id}/{course_id}/{company_id}/{courseProgramming_id}','FilesController@getEditablesFilesByEmployee')->name('getEditablesFilesByEmployee');
Route::get('getEditablesFilesByEmployee/{id}/{course_id}/{company_id}/{courseProgramming_id}','FilesController@getEditablesFilesByEmployee')->name('getEditablesFilesByEmployee');
Route::get('file/{id}','FilesController@download')->name('file');
Route::post('updateFilesState', 'FilesController@updateFilesState')->name('updateFilesState');
Route::get('showEditableFilesByEmployee/{employee}/{course}/{company}/{courseProgramin_id}','FilesController@showEditableFilesByEmployee')->name('showEditableFilesByEmployee')->middleware('auth');
Route::post('veryfyEmail','UserController@veryfyEmail')->name('veryfyEmail');
Route::any('getCourseFilesByEmployeeNotification/{id}/{course_id}/{coursePrograming_id}','FilesController@getCourseFilesByEmployeeNotification')->name('getCourseFilesByEmployeeNotification');
Route::get('fileJson/{id}','FilesController@downloadAjax')->name('fileJson');

//certificate
Route::post('insertCertificateGrade/', 'CourseCertificateController@store')->name('insertCertificateGrade');
Route::get('getCertificates/', 'CourseCertificateController@index')->name('getCertificates');
Route::get('getEmployeeCertificateByProgrammedCourse/{courseProgrammed}', 'CourseCertificateController@getEmployeesCertificateByProgrammedCourse')->name('getEmployeeCertificateByProgrammedCourse');
Route::get('getEmployeeCertificateByComapnyCourse/{company}/{courseProgrammed}', 'CourseCertificateController@getEmployeeCertificateByComapnyCourse')->name('getEmployeeCertificateByComapnyCourse');
Route::get('getEmployeeCertificateByComapny/{company}', 'CourseCertificateController@getEmployeeCertificateByComapny')->name('getEmployeeCertificateByComapny');
Route::get('viewCertificate/{id}', 'CourseCertificateController@viewCertificate')->name('viewCertificate');
Route::get('sendCertificates/{company}/{courseProgrammed}', 'CourseCertificateController@sendCertificates');
Route::get('viewAttedanceCertificate/{id}', 'CourseCertificateController@viewAttedanceCertificate')->name('viewAttedanceCertificate');
Route::get('viewAttedanceCertificateHistorical/{id}', 'CourseCertificateController@viewAttedanceCertificateHistorical')->name('viewAttedanceCertificateHistorical');

//bill
Route::post('insertBill/','BillController@store')->name('insertBill');
Route::get('employeeBill/','BillController@create')->name('employeeBill');
Route::get('getEmployeeBill/','BillController@index')->name('getEmployeeBill');
Route::get('editEmployeeBill/{id}','BillController@edit')->name('editEmployeeBill');
Route::any('updateBill/{id}','BillController@update')->name('updateBill');
Route::get('billsStatus/','BillController@billStatusView')->name('billStatus');
Route::get('getIndebtedEmployees/','BillController@getIndebtedEmployees')->name('getIndebtedEmployees');
Route::get('getDebtFreeEmployees/','BillController@getDebtFreeEmployees')->name('getDebtFreeEmployees');


//zip
Route::get('zip/{name}','FilesController@downloadZip')->name('zip');

//ministry Document
Route::get('ministryDocument','MinistryExcelController@index');
Route::get('getMinistryDocument/','MinistryExcelController@')->name('getMinistryDocument');
Route::get('createMinistryDocument/{id}','MinistryExcelController@create')->name('createMinistryDocument');

Route::get('createEnrollmentDocument','MinistryExcelController@createEnrollmentDocument')->name('createEnrollmentDocument');
Route::get('createEnrollmentDocumentByDates/{date1}/{date2}','MinistryExcelController@create')->name('createEnrollmentDocumentByDates');

//notifications
Route::get('notifications/','NotificationController@index');
Route::get('getNotifications/','NotificationController@getNotifications')->name('getNotifications');
Route::get('notificationRedirect/{param}','NotificationController@notificationRedirect')->name('notificationRedirect');


//charts
Route::get('statistics/','StatisticsController@index');
Route::any('getCertificateUsersBetweenDates/{date1}/{date2}/{companyId}/{courseId}', 'StatisticsController@getCertificateUsersBetweenDates');
Route::any('getCertificatesUsersVsUncertificate/{date1}/{date2}/{companyId}/{courseId}', 'StatisticsController@getCertificatesUsersVsUncertificate');
Route::any('getEnrolledEmployeesGroupByCurses/{date1}/{date2}/{companyId}/{courseId}', 'StatisticsController@getEnrolledEmployeesGroupByCurses');

Route::any('json','HolidaysController@store');

Route::get('attendanceExcel/{name}','FilesController@downloadAttendanceList')->name('attendanceExcel');

//
Route::get('banners','HomeController@show');
Route::post('insertBanner/','HomeController@store')->name('insertBanner');
Route::post('insertBureau/','ConfigutarionController@store')->name('insertBureau');

Route::get('/import', 'ProofAttendanceController@index');

Route::get('showtHistorical','CourseCertificateController@showtHistorical');
Route::get('getHistoricalTableData','CourseCertificateController@getHistorical');

Route::any('/showProof', 'ProofAttendanceController@show');
Route::any('/getAttendaceCertificateViewWeb', 'CourseCertificateController@getAttendaceCertificateViewWeb');

/*pruebas*/
// Route::any('/dates', function(){

// //28 DE NOVIEMBRE DE 2020

// //$cadena = "28 DE NOVIEMBRE DE 2020 ";
// $cadena = "10  DE JUNIO DE 2018";
// echo $cadena;
// $resultado = str_replace("DEL", "", $cadena);
// $resultado2 = str_replace("DE", "", $resultado);
// $pieces = explode(" ", $resultado2);
// $pieces = array_diff($pieces, array(''));
// $pieces  = array_values($pieces);
// var_dump($pieces);
// $month = 1;
//     $arrayMonths = array('ENERO','FEBRERO','MARZO','ABRIL','MAYO','JUNIO','JULIO','AGOSTO','SEPTIEMBRE','OCTUBRE','NOVIEMBRE','DICIEMBRE');
// if (($key = array_search($pieces[2],$arrayMonths)) !== false) {

//     $month = $key;
// }

//  $date = Carbon::create($pieces[4],$month+1, $pieces[0]);
//     return $date->toDateString();
// });
Route::get('/upload', 'FileController@uploadForm')->name('file.upload.form');
Route::post('/upload', 'FileController@upload')->name('file.upload');
Route::get('files/download/{id}', 'FileController@download')->name('files.download');
