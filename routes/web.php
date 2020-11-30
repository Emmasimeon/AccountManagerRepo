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

Route::get('/', function () {
    // return view('welcome');
    return redirect('/login');    
});


Route::get('/dashboard', 'AccountantController@dashboard')->name('dashboard');
Route::get('/Personalization', 'AccountantController@add_setup')->name('System Setup');
Route::POST('/Store/Personalization', 'AccountantController@store_setup');
Route::get('/New_Class', 'AccountantController@add_class')->name('New Class');
Route::POST('/Save_Class', 'AccountantController@store_class');
Route::get('/Edit/Class/{id}', 'AccountantController@edit_class')->name('Edit Class');
Route::POST('/Update/Class/{id}', 'AccountantController@Update_class');
Route::get('/New_Session', 'AccountantController@add_session')->name('New Session');
Route::get('/New_Receipts', 'AccountantController@add_receipts')->name('New Receipts');
Route::get('/School/Fees/Setup', 'AccountantController@add_schfee')->name('Add School Fees Field');
Route::POST('/School/Fee/Field/Update', 'AccountantController@store_schfee');
Route::get('/New_Payment/Expenditure', 'AccountantController@add_payment_expenditure')->name('New Payment/Expenditure');
Route::POST('/Save_Expenditure', 'AccountantController@store_payment_expenditure');
Route::get('/Edit/Expenditure/{id}', 'AccountantController@edit_payment_expenditure')->name('Edit Expenditure');
Route::POST('/Update/Expenditure/{id}', 'AccountantController@update_payment_expenditure');
Route::get('/Activate/Expenditure/{id}', 'AccountantController@activate_expenditure');
Route::get('/Deactivate/Expenditure/{id}', 'AccountantController@deactivate_expenditure');
Route::get('/New_Payment_Mode', 'AccountantController@add_payment_mode')->name('New Payment Mode');
Route::POST('/Save_Payment_Mode/{id}', 'AccountantController@store_payment_mode');
Route::get('/Edit/Payment_Mode/{id}', 'AccountantController@edit_payment_mode')->name('Edit Payment Mode');
Route::get('/Activate/Payment_Mode/{id}', 'AccountantController@activate_payment_mode');
Route::get('/Deactivate/Payment_Mode/{id}', 'AccountantController@deactivate_payment_mode');
Route::get('/New_Bank', 'AccountantController@add_bank')->name('New Bank');
Route::get('/Edit/Bank/{id}', 'AccountantController@edit_bank')->name('Edit Bank');
Route::POST('/Save_Bank/{id}', 'AccountantController@store_bank');
Route::get('/Activate/Bank/{id}', 'AccountantController@activate_bank');
Route::get('/Deactivate/Bank/{id}', 'AccountantController@deactivate_bank');
Route::get('/New_Term', 'AccountantController@add_term')->name('New Term');
Route::POST('/Save_Session', 'AccountantController@store_session');
Route::POST('/Save_Receipts', 'AccountantController@store_receipts');
Route::get('/Edit/Receipt/{id}', 'AccountantController@edit_receipt')->name('Edit Receipt');
Route::POST('/Update/Receipt/{id}', 'AccountantController@Update_receipt');
Route::POST('/Save_Term', 'AccountantController@store_term');
Route::get('/New_Student', 'AccountantController@add_student')->name('New Student');
Route::POST('/Save_Student', 'AccountantController@store_student');
Route::get('/Update_Student/{SAN_id}', 'AccountantController@edit_student')->name('Update Student');
Route::get('/Update_Status/{SAN_id}', 'AccountantController@edit_student_status')->name('Update Status');
Route::get('/SchoolFeesSetUp/{SAN_id}', 'AccountantController@setup_schfee')->name('Set Up SchoolFee');
Route::POST('/SaveSchoolFeesSetUp/{SAN_id}', 'AccountantController@save_setup_schfee');
Route::get('/Update_Term/{id}', 'AccountantController@edit_term')->name('Update Term');
Route::POST('/Save_Student_Update/{SAN_id}', 'AccountantController@update_student');
Route::POST('/Update_Student_Status/{SAN_id}', 'AccountantController@update_student_status');
Route::POST('/Save_Updated_Term/{id}', 'AccountantController@update_term');
Route::get('/Setup_Student_Payment', 'AccountantController@setup_stu_pmt_1');
Route::POST('/Students_List', 'AccountantController@setup_stu_pmt_2');
Route::get('/Select_Class', 'AccountantController@view_stu_1');
Route::POST('/Students', 'AccountantController@view_stu_in_class');
Route::get('/Setup_Amount/{id}', 'AccountantController@add_amount');
Route::POST('/Store_Amount/{id}', 'AccountantController@store_amount');

/*
|--------------------------------------------------------------------------
| Web Routes for School Fees Payment Handling
|--------------------------------------------------------------------------
|
*/

Route::get('/School_Fees_1', 'AccountantController@new_schfee_1');
Route::POST('/School_Fees_2', 'AccountantController@new_schfee_2');
Route::get('/School_Fees/{id}', 'AccountantController@new_schfee_payment')->name('New School Fees');
Route::POST('/Process/{id}', 'AccountantController@process_schfee');
Route::get('/SchoolFeeSummary/{id}/{Trx_id}', 'AccountantController@new_schfee_summary')->name('School Fees Summary');
Route::get('/Receipt/{id}/{Trx_id}', 'AccountantController@confirm_schfee_payment')->name('Confirm School Fees');
Route::get('/SchFee_Payment_History/{id}/', 'AccountantController@schfee_history')->name('Payment History');
Route::get('/Balance/{id}', 'AccountantController@out_schfee_payment_fetch')->name('Outstanding School Fees Fetch');
Route::GET('/Balance/School_Fees/{id}', 'AccountantController@out_schfee_payment')->name('Outstanding School Fees');
Route::POST('/Process/Balance/{id}', 'AccountantController@out_process_schfee');
Route::get('/Balance/SchoolFeeSummary/{id}/{Trx_id}', 'AccountantController@out_schfee_summary')->name('Outstanding School Fees Summary');
Route::get('/Outstanding/Receipt/{id}/{Trx_id}', 'AccountantController@confirm_out_schfee_payment')->name('Confirm Outstanding School Fees');

Route::get('/SchFee_Transaction', 'AccountantController@trx_details_1')->name('School Fees Query Form');
Route::POST('/Transaction', 'AccountantController@trx_details')->name('Transaction Details');
Route::get('/Transaction/{Trx_id}', 'AccountantController@trx_details_link')->name('View Linked Transaction Details');

//Error Deduction

Route::get('/Error/Deduction', 'AccountantController@error_deduction')->name('Error Deduction');
Route::POST('/Store/Error/Deduction', 'AccountantController@store_error_deduction');

/*
|--------------------------------------------------------------------------
| Web Routes for School Fees Reports Handling
|--------------------------------------------------------------------------
|
*/

Route::get('/Cleared_Students', 'AccountantController@cleared_students_1')->name('Cleared Student Report');
Route::POST('/Cleared_Students/list', 'AccountantController@cleared_students');
Route::get('/Defaulting_Students', 'AccountantController@default_students_1')->name('Defaulted Student Report');
Route::POST('/Defaulting_Students/list', 'AccountantController@defaulted_students');

/*
|--------------------------------------------------------------------------
| Web Routes for Other Payment Handling
|--------------------------------------------------------------------------
|
*/

Route::get('/Other/Fees', 'AccountantController@new_fee_1');
Route::POST('/Other/Fees/Students', 'AccountantController@new_fee_2');
Route::get('/Other/Fees/Select/Payment/{SAN_id}', 'AccountantController@otherfee_select_payment_form')->name('Other Fees Select Payment Form');
Route::get('/Other/Fees/Payment/{SAN_id}', 'AccountantController@otherfee_payment_form')->name('Other Fees Payment Form');
Route::POST('/Other/Fees/Process/{SAN_id}', 'AccountantController@process_otherfee');

Route::get('/Other/Fees/Select/Balance/{SAN_id}', 'AccountantController@otherfee_select_balance_form')->name('Other Fees Select Balance Form');
Route::get('/Other/Fees/Balance/{SAN_id}', 'AccountantController@otherfee_balance_payment_form')->name('Other Fees Balance Payment Form');
Route::POST('/Other/Fees/Process/Balance/{SAN_id}', 'AccountantController@process_otherfee_balance');
Route::get('/Other/Fees/Balance/Summary/{SAN_id}/{Trx_id}', 'AccountantController@otherfee_balance_summary')->name('Other Fees Balance Summary');
Route::get('/Other/Receipt/Balance/{id}/{Trx_id}', 'AccountantController@confirm_otherfee_balance_payment')->name('Confirm Other Fee Balance Payment');

Route::get('/Other/Fees/Summary/{SAN_id}/{Trx_id}', 'AccountantController@otherfee_summary')->name('Other Fees Summary');
Route::get('/Other/Receipt/{id}/{Trx_id}', 'AccountantController@confirm_otherfee_payment')->name('Confirm Other Fee Payment');
Route::get('/Other/Payment/History/{SAN_id}', 'AccountantController@otherfee_history')->name('Other Payments History');

// Transaction Details
Route::get('/Other/Transaction', 'AccountantController@other_fee_trx_details_1')->name('Other Transactions Query Form');
Route::POST('/Other/Payment/Transactions', 'AccountantController@other_fee_trx_details')->name('Transaction Details');
Route::get('/Other/Transaction/{Trx_id}', 'AccountantController@other_fee_trx_details_link')->name('View Linked Transaction Details');

/*
|--------------------------------------------------------------------------
| Web Routes for Other Payments Reports Handling
|--------------------------------------------------------------------------
|
*/

Route::get('/Other/Cleared/Students', 'AccountantController@o_cleared_students_1')->name('Cleared Student Report');
Route::POST('Other/Cleared/Students/list', 'AccountantController@o_cleared_students');
Route::get('Other/Defaulting/Students', 'AccountantController@o_default_students_1')->name('Defaulted Student Report');
Route::POST('Other/Defaulting/Students/list', 'AccountantController@o_defaulted_students');

/*
|--------------------------------------------------------------------------
| Web Routes for Accounting Operations Handling
|--------------------------------------------------------------------------
|
*/

Route::get('/School/Fee/Total/Term', 'AccountantController@total_schfee_term_trx_1')->name('Total School Fees Receipt/Term');
Route::POST('/School/Fee/Total/Term/Transactions', 'AccountantController@total_schfee_term_trx');
Route::get('/School/Fee/Total/Session', 'AccountantController@total_schfee_sess_trx_1')->name('Total School Fees Receipt/Session');
Route::POST('/School/Fee/Total/Session/Transactions', 'AccountantController@total_schfee_sess_trx');
Route::get('/Other/Fee/Total/Term', 'AccountantController@total_otherfee_term_trx_1')->name('Total Other Fees Receipt/Term');
Route::POST('/Other/Fee/Total/Term/Transactions', 'AccountantController@total_otherfee_term_trx');
Route::get('/Other/Fee/Total/Session', 'AccountantController@total_otherfee_sess_trx_1')->name('Total Other Fees Receipt/Session');
Route::POST('/Other/Fee/Total/Session/Transactions', 'AccountantController@total_otherfee_sess_trx');
Route::get('/Pre/Term/Query', 'AccountantController@pre_term_trx_1')->name('Pre Term Receipt/Term');
Route::POST('/Pre/Term', 'AccountantController@pre_term_trx');
Route::get('/Post/Term/Query', 'AccountantController@post_term_trx_1')->name('Post Term Receipt/Term');
Route::POST('/Post/Term', 'AccountantController@post_term_trx');

Route::get('/Payment/Modes', 'AccountantController@payment_mode_1')->name('Payment Mode Analysis /Term');
Route::POST('/Payment/Mode/Analysis', 'AccountantController@payment_mode');

Route::get('/Error/Deductions/Term', 'AccountantController@error_deduction_term_1')->name('Error Deductions Report/Term');
Route::POST('/Error/Deductions/Term/Report', 'AccountantController@error_deduction_term');
Route::get('/Error/Deductions/Session', 'AccountantController@error_deduction_session_1')->name('Error Deductions Report/Term');
Route::POST('/Error/Deductions/Session/Report', 'AccountantController@error_deduction_session');

Route::get('/Expenditures/Total/Term', 'AccountantController@total_expenditure_term_1')->name('Total Expenditures/Term');
Route::POST('/Expenditures/Total/Transactions', 'AccountantController@total_expenditure_term_trx');

/*
|--------------------------------------------------------------------------
| Web Routes for Cash & Bank Operations Handling
|--------------------------------------------------------------------------
|
*/
Route::get('/Cash/Remittances', 'AccountantController@remittances')->name('Cash Remittances');
Route::POST('/Cash/Remittances/Process', 'AccountantController@store_remittances');
Route::get('/Cash/Banking', 'AccountantController@banking')->name('Cash Banking');
Route::POST('/Cash/Banking/Process', 'AccountantController@store_banking');
Route::get('/Cash/Withdrawal', 'AccountantController@withdrawal')->name('Cash Withdrawal');
Route::POST('/Cash/Withdrawal/Process', 'AccountantController@store_withdrawal');
/*
|--------------------------------------------------------------------------
| Web Routes for Cash & Bank Operations Reports Handling
|--------------------------------------------------------------------------
|
*/
Route::get('/Cash/Rem/History', 'AccountantController@rem_history_1')->name('Cash Remittances History');
Route::POST('/Cash/Remittances/History', 'AccountantController@rem_history');
Route::get('/Cash/Bank/History', 'AccountantController@banking_history_1')->name('Cash Banking History');
Route::POST('/Cash/Banking/History', 'AccountantController@banking_history');
Route::get('/Cash/With/History', 'AccountantController@withdrawal_history_1')->name('Cash Withdrawal History');
Route::POST('/Cash/Withdrawal/History', 'AccountantController@withdrawal_history');

/*
|--------------------------------------------------------------------------
| Web Routes for Payment and Vouchers Operations Handling
|--------------------------------------------------------------------------
|
*/
Route::get('/New/Payment/Record', 'AccountantController@add_payment_record')->name('New Payment/Expenditure Record');
Route::POST('/Save/Payment/Record', 'AccountantController@store_payment_record');
Route::get('/Generate/Payment/Vouchers', 'AccountantController@payment_vouchers_1')->name('Payment Vouchers');
Route::POST('/Payment/Vouchers/', 'AccountantController@payment_vouchers');
Route::get('/Generate/Payment/History', 'AccountantController@payment_history_1')->name('Payment Vouchers');
Route::POST('/Payment/History', 'AccountantController@payment_history');


/*
|--------------------------------------------------------------------------
| System Defined Web Routes 
|--------------------------------------------------------------------------
|
*/
Auth::routes();
Route::get('/Change/Password', 'AccountantController@password_reset_form')->name('Password Reset');
Route::POST('/Submit/New/Password', 'AccountantController@reset_password');

Route::get('/User/Disable', 'AccountantController@disable_user_list')->name('Disable User account');
Route::get('/Disable/{id}', 'AccountantController@disable_user');

Route::get('/User/Enable', 'AccountantController@enable_user_list')->name('Enable User account');
Route::get('/Enable/{id}', 'AccountantController@enable_user');

Route::get('/home', 'HomeController@index')->name('home');


