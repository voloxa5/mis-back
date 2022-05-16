<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('/inventory_items', 'InventoryItemController', ['except' => ['edit', 'create']]);
Route::resource('/time_sheets', 'TimeSheetController', ['except' => ['edit', 'create']]);
Route::resource('/tasks', 'TaskController', ['except' => ['edit', 'create']]);
Route::resource('/supervisions', 'SupervisionController', ['except' => ['edit', 'create']]);
Route::resource('/shifts', 'ShiftController', ['except' => ['edit', 'create']]);
Route::resource('/employees2', 'ActualEmployeeController', ['except' => ['edit', 'create']]);
Route::resource('/employees', 'EmployeeController', ['except' => ['edit', 'create']]);
Route::resource('/assignment_ranks', 'AssignmentRankController', ['except' => ['edit', 'create']]);
Route::resource('/assignment_posts', 'AssignmentPostController', ['except' => ['edit', 'create']]);
Route::resource('/dict_posts', 'DictPostController', ['except' => ['edit', 'create']]);
Route::resource('/dict_ranks', 'DictRankController', ['except' => ['edit', 'create']]);
Route::resource('/dict_yes_nos', 'DictYesNoController', ['except' => ['edit', 'create']]);
Route::resource('/dict_sexes', 'DictSexController', ['except' => ['edit', 'create']]);
Route::resource('/dict_secrecy_degrees', 'DictSecrecyDegreeController', ['except' => ['edit', 'create']]);
Route::resource('/dict_task_human_roles', 'DictTaskHumanRoleController', ['except' => ['edit', 'create']]);
Route::resource('/shift_instructions', 'ShiftInstructionController', ['except' => ['edit', 'create']]);
Route::resource('/forms', 'FormController', ['except' => ['edit', 'create']]);
Route::resource('/domains', 'DomainController', ['except' => ['edit', 'create']]);
Route::resource('/templates', 'TemplateController', ['except' => ['edit', 'create']]);
Route::resource('/documents', 'DocumentController', ['except' => ['edit', 'create']]);
Route::resource('/moving_documents_log', 'MovingDocumentsLogController', ['except' => ['edit', 'create', 'update', 'destroy']]);
Route::resource('/groups', 'GroupController', ['except' => ['edit', 'create']]);
Route::resource('/group_groups', 'GroupGroupController', ['except' => ['edit', 'create']]);
Route::resource('/group_programs', 'GroupProgramController', ['except' => ['edit', 'create']]);
Route::resource('/group_document_definitions', 'GroupDocumentDefinitionController', ['except' => ['edit', 'create']]);
Route::resource('/group_documents', 'GroupDocumentController', ['except' => ['edit', 'create']]);
Route::resource('/warehouses', 'WarehouseController', ['except' => ['edit', 'create']]);
Route::resource('/humans', 'HumanController', ['except' => ['edit', 'create']]);
Route::resource('/photos', 'PhotoController', ['except' => ['edit', 'create']]);
Route::resource('/missions', 'MissionController', ['except' => ['edit', 'create']]);
Route::resource('/employees_units', 'EmployeesUnitController', ['except' => ['edit', 'create']]);
Route::resource('/general_domains', 'GeneralDomainController', ['except' => ['edit', 'create']]);
Route::resource('/dict_work_directions', 'DictWorkDirectionController', ['except' => ['edit', 'create']]);
Route::resource('/nonworking_orders', 'NonworkingOrderController', ['except' => ['edit', 'create']]);
Route::resource('/json_domains', 'JsonDomainController', ['except' => ['edit', 'create']]);
Route::resource('/document_locks', 'DocumentLockController', ['only' => ['store', 'destroy']]);

Route::post('export_pdf', 'PdfController@exportPdf2');
Route::post('creator', 'CreatorController@exec');

Route::post('universal', 'UniversalController@exec');
Route::post('find', 'SearchController@find');

Route::post('resource_del', 'ResourceController@del');
Route::post('resource_add', 'ResourceController@add');

Route::get('create_report', 'ReportController@createReport');
Route::get('create_reportHTML', 'ReportController@createReportHTML');
Route::get('create_html_report', 'ReportController@createHTMLReport');

Route::get('transact', 'TransactionsController@beginTransaction');
Route::get('rollback', 'TransactionsController@rollBack');
Route::get('commit', 'TransactionsController@commit');

Route::get('update_pwds', 'UserController@updatePwds');
Route::get('lock/{id}', 'UserController@lock');
Route::get('unlock/{id}', 'UserController@unlock');
Route::put('users/{id}', 'UserController@update');

Route::get('set_activity', 'UserController@setActivity');
Route::post('login', 'UserController@login');
Route::post('re_login', 'UserController@reLogin');
Route::post('logout', 'UserController@logout');
Route::post('register', 'UserController@register');
Route::post('reset_password', 'UserController@resetPassword');
Route::post('change_password', 'UserController@changePassword');

Route::post('exec_sql', 'UniversalController@execSql');
Route::post('save_user_settings', 'UserController@saveUserSettings');

Route::post('get_reg_number_and_log_number', 'VoluntaryController@getRegNumberAndLogNumber');
Route::post('get_reg_log_numbers', 'VoluntaryController@getRegLogNumbers');
Route::post('document_info', 'VoluntaryController@documentInfo');
Route::get('has_signature', 'VoluntaryController@hasSignature');
Route::get('program_start', 'VoluntaryController@programStart');
Route::get('program_exit', 'VoluntaryController@programExit');
Route::get('clear_log', 'VoluntaryController@clearLog');
Route::post('get_rank_employee', 'VoluntaryController@getRankEmployee');
Route::post('get_post_employee', 'VoluntaryController@getPostEmployee');
Route::post('get_surname_employee', 'VoluntaryController@getSurnameEmployee');
Route::post('get_working_employee', 'VoluntaryController@getWorkingEmployee');

Route::get('generate', 'PasswordController@generate');
Route::get('generate_list', 'PasswordController@generateList');

Route::get('get_constants', 'UniversalController@getConstants');
Route::get('update_tasks', 'UpdateController@updateTasks');
Route::get('update_tasks_data', 'UpdateController@updateTasksData');
Route::get('update_paper_case', 'UpdateController@updatePaperCase');
Route::get('update_pwd', 'UpdateController@updatePwd');
Route::get('null_pwd', 'UpdateController@nullPwd');
Route::get('update_users', 'UpdateController@updateUsers');

Route::group(['middleware' => 'auth:api'], function () {
    Route::resource('/document_definitions', 'DocumentDefinitionController', ['except' => ['edit', 'create']]);
    Route::resource('/programs', 'ProgramController', ['except' => ['edit', 'create']]);
    Route::resource('/roles', 'RoleController', ['only' => ['index']]);
    Route::post('details', 'UserController@details');
});
