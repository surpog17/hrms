<?php

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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/home');
    } else {
        return view('welcome');
    }
});

Route::get('/clear-cache', 'RawController@clearCache');



Auth::routes(['register' => false]);

Route::get('/redirect', 'Auth\LoginController@redirectToProvider')->name('google');
Route::get('/callback', 'Auth\LoginController@handleProviderCallback');

Route::get('/microsoft_redirect', 'Auth\LoginController@redirectToMicrosoftProvider')->name('microsoft');
Route::get('/o365callback', 'Auth\LoginController@handleMicrosoftProviderCallback');
Route::group(array('middleware' => 'auth'), function () {
    Route::get('leave_request', 'EmployeeController@leave')->name('leave.request');
    Route::get('employeeloan', 'LoanController@employeeloan');

    Route::delete('leave_request/{id}', 'EmployeeController@destroy')->name('leave.destroy');
    Route::post('leave_request', 'EmployeeController@store')->name('leave.save');
    Route::get('approve_leave', 'EmployeeController@approveLeave')->name('approve.leave');
    Route::get('update_approve_leave', 'EmployeeController@updateLeave')->name('leave.update.status');

    Route::get('fills', 'WordController@fill');

    Route::get('leave_download/{id}', 'EmployeeController@download')->name('leave.download');
    Route::get('on_project', 'EmployeeController@onProject')->name('onproject.request');
    Route::post('on_project', 'EmployeeController@storeOnProject')->name('onproject.save');
    Route::get('approve_onproject', 'EmployeeController@approveOnProject')->name('approve.onproject');

    Route::get('check_in', 'EmployeeController@check_in')->name('check_in.request');
    Route::post('check_in', 'EmployeeController@storeCheck_in')->name('check_in.save');
    Route::get('approve_checkin', 'EmployeeController@approveForgetCheckin')->name('approve.checkin');


    Route::get('/home', 'HomeController@index')->name('home');
    Route::post('raw_import', 'RawController@import')->name('raw.import');

    Route::post('webhr_import', 'RawController@webhrImport')->name('webhr.import');
    Route::post('webhr_late_import', 'RawController@webhrLateImport')->name('webhr_late.import');
    Route::post('webhr_break_importt', 'RawController@webhrLunchImport')->name('webhr_break.import');
    Route::post('webhr_absent_importt', 'RawController@webhrAbsentImport')->name('webhr_absent.import');

    Route::get('attexp', 'EmployeeController@attexp')->name('attexp');
    Route::get('ptrexp', 'EmployeeController@ptrexp')->name('ptrexp');
    Route::get('employeexport', 'EmployeeController@empexport')->name('employeexport');
    Route::post('importmerit', 'MeritController@importmerit')->name('importmerit');



    Route::get('morning_late', 'CalculatedController@CalculateMorningLate')->name('late.morning');
    Route::get('afternoon_early', 'CalculatedController@CalculateAfternoonEarly')->name('early.afternoon');
    Route::get('afternoon_overtime', 'CalculatedController@CalculateAfternoonOvertime')->name('overtime.afternoon');
    Route::get('morning_overtime', 'CalculatedController@CalculateMorningOvertime')->name('overtime.morning');
    Route::get('weekend_overtime', 'CalculatedController@CalculateWeekendOvertime')->name('overtime.weekend');
    Route::get('lunch_late', 'CalculatedController@Calculatelunchlate')->name('late.lunch');
    Route::get('calculate', 'CalculatedController@index')->name('calculate.index');
    Route::post('calculate', 'CalculatedController@AllCalculation')->name('calculate.all');
    Route::get('raw_import', 'RawController@index')->name('raw.view');
    Route::get('raw', 'RawController@show')->name('raw.index');

    Route::get('incentive', 'RawController@incentive')->name('incentive.index');
    Route::post('incentive_import', 'RawController@incentiveImport')->name('incentive.import');


    Route::get('webhr', 'RawController@webhrIndex')->name('webhr.index');
    Route::get('webhr_absent', 'RawController@webhrAbsent')->name('webhr.absent');
    Route::get('webhr_sick', 'RawController@webhrSick')->name('webhr.sick');
    Route::get('webhr_newww', 'RawController@webhrNew')->name('webhr.new');
    Route::post('webhr_new_create', 'RawController@savestaff')->name('webhr.newcreate');
    Route::get('webhr_new_delete/{id}', 'RawController@deletestaff')->name('webhr.newdelete');

    Route::get('webhr_travel', 'RawController@webhrTravel')->name('webhr.travel');
    Route::get('webhr_leave', 'RawController@webhrLeave')->name('webhr.leave');
    Route::get('webhr_late', 'RawController@webhrLate')->name('webhr.late');
    Route::get('webhr_breakk', 'RawController@breakLate')->name('webhr.break');


    Route::get('webhrupdate/{id}', 'RawController@webhrUpdateIndex')->name('webhr.updateindex');
    Route::put('webhrupdate/{id}', 'RawController@webhrUpdate')->name('webhr.update');
    Route::get('calculate_import', 'CalculatedController@show')->name('calculate.show');

    Route::get('updateUserList', 'RawController@updateFromWebHr');

    Route::get('webhr_export', 'RawController@webhrShow')->name('webhr.show');
    Route::post('webhr_export', 'RawController@webhrExport')->name('webhr.export');

    Route::get('reprimand_export', 'RawController@reprimandShow')->name('reprimand.show');
    Route::post('reprimand_export', 'RawController@reprimandExport')->name('reprimand.export');

    Route::get('morning_detail', 'CalculatedController@morning_detail')->name('morning.detail');

    Route::get('absent', 'AbsentController@index')->name('absent.index');
    Route::post('absent', 'AbsentController@full')->name('absent.full');
    Route::get('absent_show', 'AbsentController@show')->name('absent.show');
    Route::get('planned', 'AbsentController@planned')->name('absent.planned');
    Route::get('un_planned', 'AbsentController@un_planned')->name('absent.un_planned');
    Route::get('absent_on_project', 'AbsentController@on_project')->name('absent.on_project');
    Route::get('sick', 'AbsentController@sick')->name('absent.sick');
    Route::get('absent_a', 'AbsentController@absent')->name('absent.absent');
    Route::get('non-sick', 'AbsentController@non_sick')->name('absent.non_sick');


    Route::get('holiday', 'HolidayController@index')->name('holiday.index');
    Route::post('holiday', 'HolidayController@store')->name('holiday.store');
    Route::delete('holiday/{id}', 'HolidayController@delete')->name('holiday.delete');
    Route::put('holiday', 'HolidayController@update')->name('holiday.update');
    Route::get('working', 'WorkingController@index')->name('work.index');
    Route::post('working/{id}', 'WorkingController@work')->name('work');
    Route::post('non_work/{id}', 'WorkingController@non_work')->name('non.work');

    Route::get('type', 'TypeController@index')->name('type.index');
    Route::post('type', 'TypeController@store')->name('type.store');
    Route::delete('type/{id}', 'TypeController@delete')->name('type.delete');
    Route::put('type', 'TypeController@update')->name('type.update');

    Route::get('warning', 'WarningController@index')->name('warning.index');
    Route::post('warning', 'WarningController@store')->name('warning.store');
    Route::delete('warning/{id}', 'WarningController@delete')->name('warning.delete');
    Route::put('warning', 'WarningController@update')->name('warning.update');
    Route::get('warning_generate', 'WarningController@generate')->name('warning.generate');
    Route::get('warning_process', 'WordController@wordwarning')->name('warning.process');
    Route::get('warning_excused', 'WarningController@excusedindex')->name('excused.index');
    Route::get('excused', 'WarningController@excused')->name('excused.active');


    Route::get('offense/{id}/{min}/{date}', 'WarningController@offense')->name('warning.offense');
    Route::get('offense', 'WarningController@all_warning')->name('all.offense');
    Route::get('offense_absent', 'WarningController@absent')->name('warning.absent');

    Route::get('category', 'CategoryController@index')->name('category.index');
    Route::post('category', 'CategoryController@store')->name('category.store');
    Route::delete('category/{id}', 'CategoryController@delete')->name('category.delete');
    Route::put('category', 'CategoryController@update')->name('category.update');

    Route::get('loan', 'LoanController@index')->name('loan.index');
    Route::post('loan', 'LoanController@store')->name('loan.store');
    Route::delete('loan/{id}', 'LoanController@delete')->name('loan.delete');
    Route::put('loan', 'LoanController@update')->name('loan.update');

    Route::get('download', 'WordController@createWordDocx')->name('download');
    Route::post('memo_download', 'WordController@downloadWordDocx')->name('memo.download');
    Route::get('bankletter_download', 'WordController@downloadbank')->name('bankletter.download');
    Route::get('memo_download', 'WordController@memoindex')->name('memo.index');


    Route::get('employee_index', 'EmployeeController@employeeindex')->name('employee.index');
    Route::get('employee_create', 'EmployeeController@employeecreate')->name('employee.create');
    Route::post('employee_create', 'EmployeeController@employeestore')->name('employee.store');
    Route::get('employee_edit/{id}', 'EmployeeController@employeeedit')->name('employee.edit');
    Route::put('employee_edit/{id}', 'EmployeeController@employeeupdate')->name('employee.update');
    Route::delete('employee_edit/{id}', 'EmployeeController@employeedestroy')->name('employee.destroy');


    Route::get('employee', 'EmployeeController@index')->name('employee');
    Route::get('employee_active', 'EmployeeController@active')->name('employee.active');
    Route::get('employee_manager', 'EmployeeController@management')->name('employee.management');
    Route::get('employee_driver', 'EmployeeController@driver')->name('employee.driver');

    Route::get('raws/export/', 'RawController@export')->name('raw.download');

    Route::get('merit_type', 'MeritTypeController@index')->name('merit.type');
    Route::post('merit_type', 'MeritTypeController@store')->name('merit_type.store');
    Route::put('merit_type', 'MeritTypeController@update')->name('merit_type.update');
    Route::delete('merit_type/{id}', 'MeritTypeController@delete')->name('merit_type.delete');

    Route::get('merit', 'MeritController@index')->name('merit.index');
    Route::post('merit', 'MeritController@store')->name('merit.store');
    Route::put('merit', 'MeritController@update')->name('merit.update');
    Route::delete('merit/{id}', 'MeritController@delete')->name('merit.delete');

    //payroll

    Route::get('/award', 'AwardController@index')->name('award');
    Route::get('/award/create', 'AwardController@create')->name('create_award');
    Route::post('/award/store', 'AwardController@store')->name('store_award');
    Route::get('/award/{id}/edit', 'AwardController@edit')->name('edit_award');
    Route::post('/award/{id}', 'AwardController@update')->name('update_award');
    Route::get('/award/{id}/destroy', 'AwardController@destroy')->name('delete_award');

    Route::get('/deduction', 'DeductController@index')->name('deduction');
    Route::get('/deduction/create', 'DeductController@create')->name('create_deduction');
    Route::post('/deduction/store', 'DeductController@store')->name('store_deduction');
    Route::get('/deduction/{id}/edit', 'DeductController@edit')->name('edit_deduction');
    Route::post('/deduction/{id}', 'DeductController@update')->name('update_deduction');
    Route::get('/deduction/{id}/destroy', 'DeductController@destroy')->name('delete_deduction');

    Route::get('/bank', 'BankController@index')->name('bank');
    Route::get('/bank/create', 'BankController@create')->name('create_bank');
    Route::post('/bank/store', 'BankController@store')->name('store_bank');
    Route::get('/bank/{id}/edit', 'BankController@edit')->name('edit_bank');
    Route::post('/bank/{id}', 'BankController@update')->name('update_bank');
    Route::get('/bank/{id}/destroy', 'BankController@destroy')->name('delete_bank');

    Route::get('/payroll', 'PayrollController@index')->name('payroll');
    Route::get('/export', 'PayrollController@export_excel')->name('export');
    Route::get('/bank_export', 'PayrollController@export_bank')->name('bank.export');

    Route::get('/bank_view', 'PayrollController@bank_view')->name('bank_view');
    Route::get('/export_bank', 'PayrollController@export_bank')->name('export_bank');

    Route::get('changeAbsent', 'RawController@changeAbsent');
    Route::get('changeLate', 'RawController@changeLate');

    Route::get('/email', 'PayrollController@email')->name('send_email');
    Route::get('/personalpayrollemail/{id}', 'PayrollController@personalemail')->name('send_personal_payroll_email');
    Route::get('/personalemail/{id}', 'WarningController@personalemail')->name('send_personal_email');
    Route::post('/payrollemail', 'WarningController@email')->name('send_warning_email');

    // Route::get('webhr_warning','WorkingController@webhrWarning')->name('generate.webhr.warning');
    Route::get('webhr_warning', 'WarningController@webhrWarning')->name('generate.webhr.warning');
    Route::get('webhr_warning_test', 'WarningController@webhrWarning_test')->name('webhr_warning_test');
});

Auth::routes(['register' => false]);

Route::get('/home', 'HomeController@index')->name('home');
Auth::routes(['register' => false]);

Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');

Route::group(['middleware' => 'auth'], function () {
    Route::get('icons', ['as' => 'pages.icons', 'uses' => 'PageController@icons']);
    Route::get('maps', ['as' => 'pages.maps', 'uses' => 'PageController@maps']);
    Route::get('notifications', ['as' => 'pages.notifications', 'uses' => 'PageController@notifications']);
    Route::get('rtl', ['as' => 'pages.rtl', 'uses' => 'PageController@rtl']);
    Route::get('tables', ['as' => 'pages.tables', 'uses' => 'PageController@tables']);
    Route::get('typography', ['as' => 'pages.typography', 'uses' => 'PageController@typography']);
    Route::get('upgrade', ['as' => 'pages.upgrade', 'uses' => 'PageController@upgrade']);
});

Route::group(['middleware' => 'auth'], function () {
    Route::resource('user', 'UserController', ['except' => ['show']]);
    Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
    Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
    Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
});
// trying to export data for hrms

// Route::get('/export-employees', [EmployeeController::class, 'exportEmployees'])->name('export.employees');
Route::get('/export-employees', 'EmployeeController@exportEmployees')->name('exportEmployees');

Route::get('/emailCheck', 'PayrollController@emailCheck')->name('find_email');
