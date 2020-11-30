<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Exceptions\Handler;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\stu_class;
use App\student;
use App\User;
use App\sch_session;
use App\Schfee_Field;
use App\income_category;
use App\sch_term;
use App\stu_class_and_fee;
use App\schfee_breakdown;
use App\payment_modes;
use App\banks;
use App\trx_schfee;
use App\trx_schfee_balance;
use App\trx_schfee_ledger;
use App\other_trx;
use App\other_ledger;
use App\Rem_Trx;
use App\Banking_Trx;
use App\Withdrawal_Trx;
use App\Expenditures;
use App\Payment_Records;
use App\Setup;
use App\Error_Deduction;




class AccountantController extends Controller
{
    public function __construct()
    {
    $this->middleware('auth');
    }

    public function dashboard () {
        $STUDENTS = student::all();
        $Male = $STUDENTS->where('sex', 'M');
        $Female = $STUDENTS->where('sex', 'F');

        $Total_Students = count($STUDENTS);
        $Total_Male = count($Male);
        $Total_Female = count($Female);

        $SchFees_Paid_Today = 0;
        $Today_SchFees = trx_schfee_ledger::whereDate('created_at', date("Y-m-d"))->get();
        foreach ($Today_SchFees as $today) {
            $SchFees_Paid_Today += $today->trx_total_expected - $today->bal_total;
        }

        $OthFees_Paid_Today = 0;
        $Today_OthFees = other_ledger::whereDate('created_at', date("Y-m-d"))->get();
        foreach ($Today_OthFees as $today) {
            $OthFees_Paid_Today += (decrypt($today->total_paid));
        }

        $Expense_Today = 0;
        $Unit_Total = 0;
        $Today_Expense = Payment_Records::whereDate('created_at', date("Y-m-d"))->get();
        foreach ($Today_Expense as $today) {
            if ($today->quantity < 1) {
                $Unit_Total = 1 * $today->amount;
            } else {
                $Unit_Total = $today->quantity * $today->amount;
            }
            $Expense_Today += $Unit_Total;
        }

        $PAYMENTS = income_category::all();

        $Expenses_Label = Expenditures::all();

        

        return view('accountant.dashboard')->with('Total_Students', $Total_Students)
                                           ->with('Total_Male', $Total_Male)
                                           ->with('Total_Female', $Total_Female)
                                           ->with('SchFees_Paid_Today', $SchFees_Paid_Today)
                                           ->with('OthFees_Paid_Today', $OthFees_Paid_Today)
                                           ->with('Expense_Today', $Expense_Today)
                                           ->with('Today_Expense', $Today_Expense)
                                           ->with('Today_SchFees', $Today_SchFees)
                                           ->with('Today_OthFees', $Today_OthFees)
                                           ->with('PAYMENTS', $PAYMENTS)
                                           ->with('Expenses_Label', $Expenses_Label);
    }


    /**
     * Show the form for adding a new class.
     *
     * @return \Illuminate\Http\Response
     */
    public function add_class () {
        $stu_class = stu_class::all();
        return view('accountant.add_class')->with('stu_class', $stu_class);
    }

    /**
     * Store a newly created class.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_class (Request $request)
    {
        $this->validate($request, [
            'Class_Name' => 'required',
            'Class_Status' => 'required'
        ]);

        //Add a New Class
        $Stu_Class = new stu_class;
        $Stu_Class->stu_class_name = $request->input('Class_Name');
        $Stu_Class->stu_class_status = $request->input('Class_Status');
        $Stu_Class->save();

        return redirect('/New_Class')->with('success', "Class added succesfully");

    }

    /**
     * Show the form for editing a class.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit_class($id)
    {
        $class = stu_class::where('id', $id)->get();
        return view('accountant.edit_class',COMPACT('class'));
    }

    /**
     * Update the editted class.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_class(Request $request, $id)
    {
        $this->validate($request, [
            'Class_Name' => 'required',
            'Class_Status' => 'required',
        ]);


        DB::table('stu_classes')
            ->where('id', $id)
            ->update(['stu_class_name' => $request->input('Class_Name'),
                      'stu_class_status' => $request->input('Class_Status'),]
        );

        return redirect('/New_Class')->with('success', "Class updated successfully !!");
    }

    /**
     * Show the form for setting up the system.
     *
     * @return \Illuminate\Http\Response
     */
    public function add_setup () {
        $Details = Setup::first();
        return view('accountant.sch_setup')->with('Details', $Details);
    }

    /**
     * Store the setup details.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_setup (Request $request)
    {
        $this->validate($request, [
            'Name' => 'required',
            'Address' => 'required',
            'Motto' => 'required'
        ]);

        $Setup = Setup::updateOrCreate(
            ['id' => '1',],
            ['school_name' => $request->input('Name'),
             'school_address' => $request->input('Address'),
             'school_motto' => $request->input('Motto'),]
        );

        return redirect('/Personalization')->with('success', "Details stored successfully !!");

    }


    /**
     * Show the form for adding a new school session.
     *
     * @return \Illuminate\Http\Response
     */
    public function add_session () {
        $sch_session = sch_session::all();
        return view('accountant.add_session')->with('sch_session', $sch_session);
    }

    /**
     * Store a newly created class.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_session (Request $request)
    {
        $this->validate($request, [
            'Session' => 'required'
        ]);

        //Add a New Class
        $Session = new sch_session;
        $Session->sessions = $request->input('Session');
        $Session->save();

        return redirect('/New_Session')->with('success', "Session added succesfully");

    }

    /**
     * Show the form for adding a new receipt.
     *
     * @return \Illuminate\Http\Response
     */
    public function add_receipts () {
        $income_category = income_category::all();
        return view('accountant.add_receipts')->with('income_category', $income_category);
    }

    /**
     * Store a newly created receipt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_receipts (Request $request)
    {
        $this->validate($request, [
            'Receipts' => 'required',
            'Amount' => 'required',
            'business' => 'required'
        ]);

        //Add a New Receipt
        $Receipts = new income_category;
        $Receipts->income_category = $request->input('Receipts');
        $Receipts->amount = $request->input('Amount');
        $Receipts->business = $request->input('business');
        $Receipts->save();

        return redirect('/New_Receipts')->with('success', "Receipts added succesfully");

    }

    /**
     * Show the form for editing a receipt.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit_receipt($id)
    {
        $receipt = income_category::where('id', $id)->get();
        return view('accountant.edit_receipts',COMPACT('receipt'));
    }

    /**
     * Update the editted receipt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_receipt(Request $request, $id)
    {
        $this->validate($request, [
            'Receipts' => 'required',
            'Amount' => 'required',
        ]);


        DB::table('income_categories')
            ->where('id', $id)
            ->update(['income_category' => $request->input('Receipts'),
                      'amount' => $request->input('Amount'),]
        );

        return redirect('/New_Receipts')->with('success', "Receipt/Income Head updated successfully !!");
    }

    /**
     * Show school fees field setup page.
     *
     * @return \Illuminate\Http\Response
     */
    public function add_schfee () {
        $Fields = Schfee_Field::all();
        //$Fields = Schfee_Field::where('name', '!=', '')->get();
        return view('accountant.add_schfee')->with('Fields', $Fields);
    }

    /**
     * Update school fees fields.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function store_schfee (Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
            'Label_Name' => 'required'
        ]);

        Schfee_Field::where('id', $request->input('id'))
                    ->update(['name' => $request->input('Label_Name')]);

        return redirect('/School/Fees/Setup')->with('success', "Field Updated Succesfully");

    }

    /**
     * Show the form for adding a new Payment or Expenditure category.
     *
     * @return \Illuminate\Http\Response
     */
    public function add_payment_expenditure () {
        $Payments = Expenditures::all();
        return view('accountant.add_payment_expenditure')->with('Payments', $Payments);
    }

    /**
     * Store a newly created payment or expenditure.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_payment_expenditure (Request $request)
    {
        $this->validate($request, [
            'Expenditure' => 'required',
            'access' => 'required',
        ]);

        //Add a New Payment or Expenditure Categories
        $Expense = new Expenditures;
        $Expense->expenditures = $request->input('Expenditure');
        $Expense->access = $request->input('access');
        $Expense->status = '0';
        $Expense->save();

        return redirect('/New_Payment/Expenditure')->with('success', "Added succesfully");

    }

    /**
     * 
     * Show the form for editting Payments/Expenditures Categories.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit_payment_expenditure ($id) {
        $Payments = Expenditures::where('id', $id)->get();
        return view('accountant.edit_payment_expenditure')->with('Payments', $Payments);
    }

    /**
     * Update Payments/Expenditures Categories 
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @param  int  $id
     */
    public function update_payment_expenditure (Request $request, $id)
    {
        $this->validate($request, [
            'Expenditure' => 'required',
            'access' => 'required'
        ]);

        Expenditures::where('id', $id)
                    ->update(['expenditures' => $request->input('Expenditure'),
                              'Access' => $request->input('access'),
                              'status' => 1
                    ]);

        return redirect('/New_Payment/Expenditure')->with('success', "updated succesfully");

    }

     /**
     * Activate Expenditure.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @param  int  $id
     */
    public function activate_expenditure (Request $request, $id)
    {

        Expenditures::where('id', $id)
                    ->update(['status' => 1]);

        return redirect('/New_Payment/Expenditure')->with('success', "Payments/Expenditures Activated");

    }

    /**
     * Deactivate Expenditure.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @param  int  $id
     */
    public function deactivate_expenditure (Request $request, $id)
    {

        Expenditures::where('id', $id)
                    ->update(['status' => 0]);

        return redirect('/New_Payment/Expenditure')->with('warning', "Payments/Expenditures Deactivated");

    }

    /**
     * Show the form for adding a new payment mode.
     *
     * @return \Illuminate\Http\Response
     */
    public function add_payment_mode () {
        $Mode = payment_modes::all();
        return view('accountant.add_payment_modes')->with('Mode', $Mode);
    }

    /**
     * 
     * Show the form for adding/editting a payment mode.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit_payment_mode ($id) {
        $Mode = payment_modes::where('id', $id)->get();
        return view('accountant.edit_payment_modes')->with('Mode', $Mode);
    }

    /**
     * Store a newly created payment mode.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @param  int  $id
     */
    public function store_payment_mode (Request $request, $id)
    {
        $this->validate($request, [
            'Mode' => 'required'
        ]);

        payment_modes::where('id', $id)
                    ->update(['modes' => $request->input('Mode'),
                              'status' => 1
                    ]);

        return redirect('/New_Payment_Mode')->with('success', "Payment Mode updated succesfully");

    }

    /**
     * Activate payment mode.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @param  int  $id
     */
    public function activate_payment_mode (Request $request, $id)
    {

        payment_modes::where('id', $id)
                    ->update(['status' => 1]);

        return redirect('/New_Payment_Mode')->with('success', "Payment Mode Activated");

    }

    /**
     * Deactivate payment mode.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @param  int  $id
     */
    public function deactivate_payment_mode (Request $request, $id)
    {

        payment_modes::where('id', $id)
                    ->update(['status' => 0]);

        return redirect('/New_Payment_Mode')->with('warning', "Payment Mode Deactivated");

    }

    /**
     * Show the form for adding a new Bank.
     *
     * @return \Illuminate\Http\Response
     */
    public function add_bank () {
        $Banks = banks::all();
        return view('accountant.add_bank')->with('Banks', $Banks);
    }

    /**
     * 
     * Show the form for adding/editting a bank.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit_bank ($id) {
        $Banks = banks::where('id', $id)->get();
        return view('accountant.edit_bank')->with('Banks', $Banks);
    }

    /**
     * Store a newly created Bank.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @param  int  $id
     */
    public function store_bank (Request $request, $id)
    {
        $this->validate($request, [
            'Bank' => 'required'
        ]);


        banks::where('id', $id)
                    ->update(['banks' => $request->input('Bank'),
                              'status' => 1
                    ]);

        return redirect('/New_Bank')->with('success', "Bank updated succesfully");

    }

    /**
     * Activate payment mode.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @param  int  $id
     */
    public function activate_bank (Request $request, $id)
    {

        banks::where('id', $id)
                    ->update(['status' => 1]);

        return redirect('/New_Bank')->with('success', "Bank Activated");

    }

    /**
     * Deactivate payment mode.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @param  int  $id
     */
    public function deactivate_bank (Request $request, $id)
    {

        banks::where('id', $id)
                    ->update(['status' => 0]);

        return redirect('/New_Bank')->with('warning', "Bank Deactivated");

    }


     /**
     * Show the form for adding a new term.
     *
     * @return \Illuminate\Http\Response
     */
    public function add_term () {
        $sch_term = sch_term::all();
        return view('accountant.add_term')->with('sch_term', $sch_term);
    }

    /**
     * Store a newly created term.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_term (Request $request)
    {
        $this->validate($request, [
            'term' => 'required',
            'start_date' => 'required',
            'end_date' => 'required'
        ]);

        $Term = new sch_term;
        $Term->term = $request->input('term');
        $Term->start_date = $request->input('start_date');
        $Term->end_date = $request->input('end_date');
        $Term->save();

        return redirect('/New_Term')->with('success', "Term added succesfully");

    }

    /**
     * Show the form for updating a particular term.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit_term($id)
    {
        $Term = sch_term::where('id', $id)->get();
        return view('accountant.edit_term')->with('Term', $Term);
    }

    /**
     * Update a particular term record.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_term(Request $request, $id)
    {
        {
            $this->validate($request, [
                'start_date' => 'required',
                'end_date' => 'required',
            ]);

            $Term = sch_term::find($id, '*');
    
            //Add a New Student to Database
            $Term->start_date = $request->input('start_date');
            $Term->end_date = $request->input('end_date');
            $Term->save();
            
    
            return redirect('/New_Term')->with('success', "Term dates updated succesfully");
        }
    }

    /**
     * Show the form for setting up amount for a particular fee.
     *
     * @return \Illuminate\Http\Response
     * @param  int  $id
     */
    public function add_amount($id) {
        $stu_class = stu_class::where('stu_class_status', 'Active School Class')->get();
        $Class_Fee = stu_class_and_fee::where('Field_id', $id)->get();

        /** 
         * I used a subquery here to query for all saved Class and approriate Fees and  
         * also subqueried for class name.
         */ 
        $ClassName = (stu_class_and_fee::addSelect(['class_name' => stu_class::select('stu_class_name')
                    ->whereColumn('stu_class_id', 'id')
                 ]))->where('Field_id', $id)
                ->get();

        // $ClassName = ClassName1::where('income_category_id', $id)->get();
        

        $Receipts = Schfee_Field::find($id);
        return view('accountant.setup_fee')->with('stu_class', $stu_class)
                                            ->with('Receipts', $Receipts)
                                            ->with('ClassName', $ClassName);
    }

    /**
     * Store the amount attached to a particular fee.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function store_amount (Request $request, $id)
    {
        $this->validate($request, [
            'Stu_Class' => 'required',
            'Amount' => 'required',
        ]);

        //Add/Update a Fee Amount
        $Amount = stu_class_and_fee::updateOrCreate(
            ['stu_class_id' => $request->input('Stu_Class'), 'Field_id' => $id],
            ['amount' => $request->input('Amount')]
        );

        return redirect('/Setup_Amount/'.$id)->with('success', "Amount added/updated succesfully");

    }
    
    
    /**
     * Show the form for adding a new student.
     *
     * @return \Illuminate\Http\Response
     */
    public function add_student () {

        $stu_class = stu_class::all();
        return view('accountant.add_student')->with('stu_class', $stu_class);
    }

    /**
     * Store a newly added student.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_student (Request $request)
    {
        $this->validate($request, [
            'Stu_Reg_No' => 'required',
            'Surname' => 'required',
            'FirstName' => 'required',
            'Sex' => 'required',
            'Stu_Class' => 'required',
            'PaymentFeeStatus' => 'required',
            'Accomodation' => 'required',
        ]);

        //Add a New Student to Database
        $Student = new student;
        $Student->regno = $request->input('Stu_Reg_No');
        $Student->surname = $request->input('Surname');
        $Student->middlename = $request->input('MiddleName');
        $Student->lastname = $request->input('FirstName');
        $Student->sex = $request->input('Sex');
        $Student->class = $request->input('Stu_Class');
        $Student->PaymentFeeStatus = $request->input('PaymentFeeStatus');
        $Student->accomodation = $request->input('Accomodation');
        $Student->save();

        return redirect('/New_Student')->with('success', "Student added succesfully");
    }

    /**
     * Show the form for editing a particular student record.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit_student($SAN_id)
    {

        /** 
         * I used a subquery here to query for a particular Students in selected class and  
         * also subqueried for class name.
         */ 
        $Student = (student::addSelect(['class_name' => stu_class::select('stu_class_name')
                    ->whereColumn('class', 'id')
                 ]))->where('SAN_id', $SAN_id)
                ->get();


        $stu_class = stu_class::all();
        return view('accountant.upd_student')->with('Student', $Student)
                                                ->with('stu_class', $stu_class);
    }

    /**
     * Update a particular student record.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_student(Request $request, $SAN_id)
    {
        {
            $this->validate($request, [
                'Stu_Reg_No' => 'required',
                'Surname' => 'required',
                'FirstName' => 'required',
                'Sex' => 'required',
                'Stu_Class' => 'required',
                'PaymentFeeStatus' => 'required',
                'Accomodation' => 'required',
            ]);

            $Student = student::find($SAN_id, '*');
    
            //Update a Student Record in Database
            $Student->regno = $request->input('Stu_Reg_No');
            $Student->surname = $request->input('Surname');
            $Student->middlename = $request->input('MiddleName');
            $Student->lastname = $request->input('FirstName');
            $Student->sex = $request->input('Sex');
            $Student->class = $request->input('Stu_Class');
            $Student->PaymentFeeStatus = $request->input('PaymentFeeStatus');
            $Student->accomodation = $request->input('Accomodation');
            $Student->save();
            
    
            return redirect('/Select_Class')->with('success', "Student updated succesfully");
        }
    }

    /**
     * Show the form for editing a particular student status.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit_student_status($SAN_id)
    {

        /** 
         * I used a subquery here to query for the particular Students in selected class and  
         * also subqueried for class name.
         */ 
        $Student = (student::addSelect(['class_name' => stu_class::select('stu_class_name')
                    ->whereColumn('class', 'id')
                 ]))->where('SAN_id', $SAN_id)
                ->get();

        return view('accountant.student_status')->with('Student', $Student);
    }

    /**
     * Update a particular student status.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_student_status(Request $request, $SAN_id)
    {
        {
            $this->validate($request, [
                'Status' => 'required',
                
            ]);

            $Student = student::find($SAN_id, '*');
    
            //Update Student status in Database
            $Student->status = $request->input('Status');
            $Student->save();
            
    
            return redirect('/Select_Class')->with('success', "Student status updated succesfully");
        }
    }


    /**
     * Form to accept class to which students should be displayed to setup up school fees payment.
     *
     * @return \Illuminate\Http\Response
     */
    public function setup_stu_pmt_1 () {
        $stu_class = stu_class::where('stu_class_status', 'Active School Class')->get();
        return view('accountant.setup_stu_pmt_1')->with('stu_class', $stu_class);
    }


    /**
     * Display students in a selected class to setup school fees payment.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function setup_stu_pmt_2 (Request $request) {

        $this->validate($request, [
            'Stu_Class' => 'required',
        ]);

        $Selected_Class = $request->input('Stu_Class');
        $Student = student::where([['class', $Selected_Class],['status', '101']])->get();
        $Stu_Class = stu_class::where('id', $Selected_Class)->get();
    
        return view('accountant.setup_stu_pmt_2')->with('Student', $Student)
                                            ->with('Stu_Class', $Stu_Class);
    }

    /**
     * Form to accept class to which students should be displayed.
     *
     * @return \Illuminate\Http\Response
     */
    public function view_stu_1 ()
    { 
        $stu_class = stu_class::all();
        return view('accountant.view_stu_1')->with('stu_class', $stu_class);
    }

    /**
     * Display students in a selected class.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function view_stu_in_class (Request  $request)
    {
        $this->validate($request, [
            'Stu_Class' => 'required',
        ]);

        $Selected_Class = $request->input('Stu_Class');
        $Student = student::where('class', $Selected_Class)->get();
        $Stu_Class = stu_class::where('id', $Selected_Class)->get();
    
        return view('accountant.view_stu_2')->with('Student', $Student)
                                            ->with('Stu_Class', $Stu_Class);
    }

    /**
     * Show the form for setting up a particular student school fees schedule.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function setup_schfee ($SAN_id)
    {

        /** 
         * I used a subquery here to query for the particular Students in selected class and  
         * also subqueried for class name.
         */ 
        $Student = (student::addSelect(['class_name' => stu_class::select('stu_class_name')
                    ->whereColumn('class', 'id')
                 ]))->where('SAN_id', $SAN_id)
                ->get();
        $SchFeeFields = Schfee_Field::where('name', '!=', '')->get();

        $SchFee = schfee_breakdown::where('SAN_id', $SAN_id)->get();

        $Name_1 = Schfee_Field::where('id', 1)->select('name')->get();
        $Name_2 = Schfee_Field::where('id', 2)->select('name')->get();
        $Name_3 = Schfee_Field::where('id', 3)->select('name')->get();
        $Name_4 = Schfee_Field::where('id', 4)->select('name')->get();
        $Name_5 = Schfee_Field::where('id', 5)->select('name')->get();
        $Name_6 = Schfee_Field::where('id', 6)->select('name')->get();
        $Name_7 = Schfee_Field::where('id', 7)->select('name')->get();
        $Name_8 = Schfee_Field::where('id', 8)->select('name')->get();
        $Name_9 = Schfee_Field::where('id', 9)->select('name')->get();
        $Name_10 = Schfee_Field::where('id', 10)->select('name')->get();
        $Name_11 = Schfee_Field::where('id', 11)->select('name')->get();
        $Name_12 = Schfee_Field::where('id', 12)->select('name')->get();
        $Name_13 = Schfee_Field::where('id', 13)->select('name')->get();
        $Name_14 = Schfee_Field::where('id', 14)->select('name')->get();
        $Name_15 = Schfee_Field::where('id', 15)->select('name')->get();

       

        return view('accountant.schfee_setup')->with('Student', $Student)
                                              ->with('SchFee', $SchFee)
                                              ->with('SchFeeFields', $SchFeeFields)
                                              ->with('Name_1', $Name_1)
                                              ->with('Name_2', $Name_2)
                                              ->with('Name_3', $Name_3)
                                              ->with('Name_4', $Name_4)
                                              ->with('Name_5', $Name_5)
                                              ->with('Name_6', $Name_6)
                                              ->with('Name_7', $Name_7)
                                              ->with('Name_8', $Name_8)
                                              ->with('Name_9', $Name_9)
                                              ->with('Name_10', $Name_10)
                                              ->with('Name_11', $Name_11)
                                              ->with('Name_12', $Name_12)
                                              ->with('Name_13', $Name_13)
                                              ->with('Name_14', $Name_14)
                                              ->with('Name_15', $Name_15);
    }

    /**
     * Update a particular student status.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function save_setup_schfee (Request $request, $SAN_id)
    {
        {
            // $this->validate($request, [
            //     'Field1' => 'required',
            //     'Field2' => 'required',   
            // ]);

            //Update or Create a new school fees breakdown for a student
            $SCHFEE = schfee_breakdown::updateOrCreate(
                ['SAN_id' => $SAN_id],
                ['Field_1' => $request->input('Field1'),
                'Field_2' => $request->input('Field2'),
                'Field_3' => $request->input('Field3'),
                'Field_4' => $request->input('Field4'),
                'Field_5' => $request->input('Field5'),
                'Field_6' => $request->input('Field6'),
                'Field_7' => $request->input('Field7'),
                'Field_8' => $request->input('Field8'),
                'Field_9' => $request->input('Field9'),
                'Field_10' => $request->input('Field10'),
                'Field_11' => $request->input('Field11'),
                'Field_12' => $request->input('Field12'),
                'Field_13' => $request->input('Field13'),
                'Field_14' => $request->input('Field14'),
                'Field_15' => $request->input('Field15'),]
            );
            
    
            return redirect('/SchoolFeesSetUp/'.$SAN_id)->with('success', "School Fees updated succesfully");
        }
    }

/******************************************************************************
                          *                                                   *
                          * //HANDLING SCHOOL FEES PAYMENTS/RECEIPTS SECTION//*
                          *                                                   *
*******************************************************************************/

    /**
     * Form to accept class for which a students school fee is to be paid.
     *
     * @return \Illuminate\Http\Response
     */
    public function new_schfee_1 ()
    { 
        $stu_class = stu_class::where('stu_class_status', 'Active School Class')->get();
        return view('accountant.schfee_1_class')->with('stu_class', $stu_class);
    }

    /**
     * Display students in a selected class.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function new_schfee_2 (Request  $request)
    {
        $this->validate($request, [
            'Stu_Class' => 'required',
        ]);

        $Selected_Class = $request->input('Stu_Class');
        $Student = student::where([['class', $Selected_Class],['status', '101']])->get();
        $Stu_Class = stu_class::where('id', $Selected_Class)->get();
    
        return view('accountant.schfee_2_student')->with('Student', $Student)
                                            ->with('Stu_Class', $Stu_Class);
    }

    /**
     * Show the form for school fees payment.
     * 
     *@param  int  $SAN_id
     *@return \Illuminate\Http\Response
     */
    public function new_schfee_payment ($SAN_id) {

        /** 
         * I used a subquery here to query for the particular Students in selected class and  
         * also subqueried for class name.
         */ 
        $Student = (student::addSelect(['class_name' => stu_class::select('stu_class_name')
                    ->whereColumn('class', 'id')
                 ]))->where('SAN_id', $SAN_id)
                ->get();

        $SchFee = schfee_breakdown::where('SAN_id', $SAN_id)->get();
        $Sessions = sch_session::all();
        $Terms = sch_term::all();
        $Stu_Class = stu_class::where('stu_class_status', 'Active School Class')->get();
        $Modes = payment_modes::where([['modes', '!=', ''],['status', 1]])->get();
        $Banks = banks::where([['banks', '!=', ''],['status', 1]])->get();

        $Name_1 = Schfee_Field::where('id', 1)->select('name')->get();
        $Name_2 = Schfee_Field::where('id', 2)->select('name')->get();
        $Name_3 = Schfee_Field::where('id', 3)->select('name')->get();
        $Name_4 = Schfee_Field::where('id', 4)->select('name')->get();
        $Name_5 = Schfee_Field::where('id', 5)->select('name')->get();
        $Name_6 = Schfee_Field::where('id', 6)->select('name')->get();
        $Name_7 = Schfee_Field::where('id', 7)->select('name')->get();
        $Name_8 = Schfee_Field::where('id', 8)->select('name')->get();
        $Name_9 = Schfee_Field::where('id', 9)->select('name')->get();
        $Name_10 = Schfee_Field::where('id', 10)->select('name')->get();
        $Name_11 = Schfee_Field::where('id', 11)->select('name')->get();
        $Name_12 = Schfee_Field::where('id', 12)->select('name')->get();
        $Name_13 = Schfee_Field::where('id', 13)->select('name')->get();
        $Name_14 = Schfee_Field::where('id', 14)->select('name')->get();
        $Name_15 = Schfee_Field::where('id', 15)->select('name')->get();

        return view('accountant.new_schfee_payment',COMPACT('Student','SchFee','Sessions','Terms','Modes','Banks','Stu_Class',
                                                            'Name_1','Name_2','Name_3','Name_4','Name_5','Name_6','Name_7','Name_8',
                                                            'Name_9','Name_10','Name_11','Name_12','Name_13','Name_14','Name_15'));
    }


    /**
     * Process a student school fees Payment and save to DB.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $SAN_id
     * @return \Illuminate\Http\Response
     */
    public function process_schfee (Request $request, $SAN_id)
    {

        $today = date("md");
        //$rand = strtoupper(substr(uniqid(sha1(time())),0,6));
        $rand = rand(00000,99999);
        $unique = $today . $rand;
		
        {
            $this->validate($request, [
                'session' => 'required',
                'term' => 'required',
                'class' => 'required',
                'mode' => 'required',
                
            ]);

            //check the transaction to be sure it's not an override transaction!
            $Check_Trx = trx_schfee_ledger::where([['SAN_id', $SAN_id],['session', $request->input('session')],['term', $request->input('term')],['stu_class_id', $request->input('class')]])->get();

            if($Check_Trx->isEmpty()) {

                    //Create a new school fees payment transaction for a student.
                    $SCHFEE_PMT = new trx_schfee;
                    $SCHFEE_PMT->Trx_id = $unique;
                    $SCHFEE_PMT->SAN_id = $SAN_id;
                    $SCHFEE_PMT->stu_class_id = $request->input('class');
                    $SCHFEE_PMT->payment_by =  Auth::user()->name;
                    $SCHFEE_PMT->session = $request->input('session');
                    $SCHFEE_PMT->term = $request->input('term');

                    $SCHFEE_PMT->Field_1_amount = $request->input('Field_1_amount');
                    $SCHFEE_PMT->Field_1_discount = $request->input('Field_1_discount');
                    $SCHFEE_PMT->Field_2_amount = $request->input('Field_2_amount');
                    $SCHFEE_PMT->Field_2_discount = $request->input('Field_2_discount');
                    $SCHFEE_PMT->Field_3_amount = $request->input('Field_3_amount');
                    $SCHFEE_PMT->Field_3_discount = $request->input('Field_3_discount');
                    $SCHFEE_PMT->Field_4_amount = $request->input('Field_4_amount');
                    $SCHFEE_PMT->Field_4_discount = $request->input('Field_4_discount');
                    $SCHFEE_PMT->Field_5_amount = $request->input('Field_5_amount');
                    $SCHFEE_PMT->Field_5_discount = $request->input('Field_5_discount');
                    $SCHFEE_PMT->Field_6_amount = $request->input('Field_6_amount');
                    $SCHFEE_PMT->Field_6_discount = $request->input('Field_6_discount');
                    $SCHFEE_PMT->Field_7_amount = $request->input('Field_7_amount');
                    $SCHFEE_PMT->Field_7_discount = $request->input('Field_7_discount');
                    $SCHFEE_PMT->Field_8_amount = $request->input('Field_8_amount');
                    $SCHFEE_PMT->Field_8_discount = $request->input('Field_8_discount');
                    $SCHFEE_PMT->Field_9_amount = $request->input('Field_9_amount');
                    $SCHFEE_PMT->Field_9_discount = $request->input('Field_9_discount');
                    $SCHFEE_PMT->Field_10_amount = $request->input('Field_10_amount');
                    $SCHFEE_PMT->Field_10_discount = $request->input('Field_10_discount');
                    $SCHFEE_PMT->Field_11_amount = $request->input('Field_11_amount');
                    $SCHFEE_PMT->Field_11_discount = $request->input('Field_11_discount');
                    $SCHFEE_PMT->Field_12_amount = $request->input('Field_12_amount');
                    $SCHFEE_PMT->Field_12_discount = $request->input('Field_12_discount');
                    $SCHFEE_PMT->Field_13_amount = $request->input('Field_13_amount');
                    $SCHFEE_PMT->Field_13_discount = $request->input('Field_13_discount');
                    $SCHFEE_PMT->Field_14_amount = $request->input('Field_14_amount');
                    $SCHFEE_PMT->Field_14_discount = $request->input('Field_14_discount');
                    $SCHFEE_PMT->Field_15_amount = $request->input('Field_15_amount');
                    $SCHFEE_PMT->Field_15_discount = $request->input('Field_15_discount');

                    $trx_total = $request->input('Field_1_amount') + $request->input('Field_2_amount') + $request->input('Field_3_amount') +
                                $request->input('Field_4_amount') + $request->input('Field_5_amount') + $request->input('Field_6_amount') +
                                $request->input('Field_7_amount') + $request->input('Field_8_amount') + $request->input('Field_9_amount') +
                                $request->input('Field_10_amount') + $request->input('Field_11_amount') + $request->input('Field_12_amount') +
                                $request->input('Field_13_amount') + $request->input('Field_14_amount') + $request->input('Field_15_amount');                       
                    $SCHFEE_PMT->trx_total = $trx_total;
                    $trx_dsc_total = $request->input('Field_1_discount') + $request->input('Field_2_discount') + $request->input('Field_3_discount') +
                                    $request->input('Field_4_discount') + $request->input('Field_5_discount') + $request->input('Field_6_discount') +
                                    $request->input('Field_7_discount') + $request->input('Field_8_discount') + $request->input('Field_9_discount') +
                                    $request->input('Field_10_discount') + $request->input('Field_11_discount') + $request->input('Field_12_discount') +
                                    $request->input('Field_13_discount') + $request->input('Field_14_discount') + $request->input('Field_15_discount');
                    $SCHFEE_PMT->trx_dsc_total = $trx_dsc_total;

                    $SCHFEE_PMT->bank = $request->input('bank');
                    $SCHFEE_PMT->payment_mode = $request->input('mode');
                    $SCHFEE_PMT->comment = $request->input('comment');   
                    $SCHFEE_PMT->save();

                    // Fetch the Transaction 
                    $Transaction = trx_schfee::where('Trx_id', $unique)->get();

                    // Fetch the Student School Fees Break down
                    $PaymentFields = schfee_breakdown::where('SAN_id', $SAN_id)->get();
                    
                    // Process Field 1 Input
                    if ($PaymentFields[0]['Field_1'] == 1) {
                        $Class_Field_Amount = stu_class_and_fee::where([['stu_class_id', $Transaction[0]['stu_class_id']],['Field_id', '1']])->get();
                        if ($Class_Field_Amount->isEmpty()) {
                            return redirect('/School_Fees/'.$SAN_id)->with('error', "CONTACT ACCOUNTANT!! - NO AMOUNT PAYABLE IN FIELD 1 FOR THE SELECTED PAYMENT CLASS - PLEASE ADD AMOUNT PAYABLE FOR STUDENT IN THAT CLASS"); 
                        } else {
                            $Total_Field_1_Expected = $Class_Field_Amount[0]['amount'] - $Transaction[0]['Field_1_discount'];
                            $Field_1_Balance = $Total_Field_1_Expected - $Transaction[0]['Field_1_amount'];
                        }
  
                    }  else {
                        $Total_Field_1_Expected = 0;
                        $Field_1_Balance = 0;
                    }

                    
                    // Process Field 2 Input
                    if ($PaymentFields[0]['Field_2'] == 1) {
                        $Class_Field_Amount = stu_class_and_fee::where([['stu_class_id', $Transaction[0]['stu_class_id']],['Field_id', '2']])->get();
                        if ($Class_Field_Amount->isEmpty()) {
                            return redirect('/School_Fees/'.$SAN_id)->with('error', "CONTACT ACCOUNTANT!! - NO AMOUNT PAYABLE IN FIELD 2 FOR THE SELECTED PAYMENT CLASS - PLEASE ADD AMOUNT PAYABLE FOR STUDENT IN THAT CLASS"); 
                        } else {
                            $Total_Field_2_Expected = $Class_Field_Amount[0]['amount'] - $Transaction[0]['Field_2_discount'];
                            $Field_2_Balance = $Total_Field_2_Expected - $Transaction[0]['Field_2_amount'];
                        }
                        
                    }  else {
                        $Total_Field_2_Expected = 0;
                        $Field_2_Balance = 0;
                    }

                    // Process Field 3 Input
                    if ($PaymentFields[0]['Field_3'] == 1) {
                        $Class_Field_Amount = stu_class_and_fee::where([['stu_class_id', $Transaction[0]['stu_class_id']],['Field_id', '3']])->get();
                        if ($Class_Field_Amount->isEmpty()) {
                            return redirect('/School_Fees/'.$SAN_id)->with('error', "CONTACT ACCOUNTANT!! - NO AMOUNT PAYABLE IN FIELD 3 FOR THE SELECTED PAYMENT CLASS - PLEASE ADD AMOUNT PAYABLE FOR STUDENT IN THAT CLASS"); 
                        } else {
                            $Total_Field_3_Expected = $Class_Field_Amount[0]['amount'] - $Transaction[0]['Field_3_discount'];
                            $Field_3_Balance = $Total_Field_3_Expected - $Transaction[0]['Field_3_amount'];
                        }
                    }  else {
                        $Total_Field_3_Expected = 0;
                        $Field_3_Balance = 0;
                    }


                    // Process Field 4 Input
                    if ($PaymentFields[0]['Field_4'] == 1) {
                        $Class_Field_Amount = stu_class_and_fee::where([['stu_class_id', $Transaction[0]['stu_class_id']],['Field_id', '4']])->get();
                        if ($Class_Field_Amount->isEmpty()) {
                            return redirect('/School_Fees/'.$SAN_id)->with('error', "CONTACT ACCOUNTANT!! - NO AMOUNT PAYABLE IN FIELD 4 FOR THE SELECTED PAYMENT CLASS - PLEASE ADD AMOUNT PAYABLE FOR STUDENT IN THAT CLASS"); 
                        } else {
                            $Total_Field_4_Expected = $Class_Field_Amount[0]['amount'] - $Transaction[0]['Field_4_discount'];
                            $Field_4_Balance = $Total_Field_4_Expected - $Transaction[0]['Field_4_amount'];
                        }
                    }  else {
                        $Total_Field_4_Expected = 0;
                        $Field_4_Balance = 0;
                    }

                    // Process Field 5 Input
                    if ($PaymentFields[0]['Field_5'] == 1) {
                        $Class_Field_Amount = stu_class_and_fee::where([['stu_class_id', $Transaction[0]['stu_class_id']],['Field_id', '5']])->get();
                        if ($Class_Field_Amount->isEmpty()) {
                            return redirect('/School_Fees/'.$SAN_id)->with('error', "CONTACT ACCOUNTANT!! - NO AMOUNT PAYABLE IN FIELD 5 FOR THE SELECTED PAYMENT CLASS - PLEASE ADD AMOUNT PAYABLE FOR STUDENT IN THAT CLASS"); 
                        } else {
                            $Total_Field_5_Expected = $Class_Field_Amount[0]['amount'] - $Transaction[0]['Field_5_discount'];
                            $Field_5_Balance = $Total_Field_5_Expected - $Transaction[0]['Field_5_amount'];
                        }
                    }  else {
                        $Total_Field_5_Expected = 0;
                        $Field_5_Balance = 0;
                    }

                    // Process Field 6 Input
                    if ($PaymentFields[0]['Field_6'] == 1) {
                        $Class_Field_Amount = stu_class_and_fee::where([['stu_class_id', $Transaction[0]['stu_class_id']],['Field_id', '6']])->get();
                        if ($Class_Field_Amount->isEmpty()) {
                            return redirect('/School_Fees/'.$SAN_id)->with('error', "CONTACT ACCOUNTANT!! - NO AMOUNT PAYABLE IN FIELD 6 FOR THE SELECTED PAYMENT CLASS - PLEASE ADD AMOUNT PAYABLE FOR STUDENT IN THAT CLASS"); 
                        } else {
                            $Total_Field_6_Expected = $Class_Field_Amount[0]['amount'] - $Transaction[0]['Field_6_discount'];
                            $Field_6_Balance = $Total_Field_6_Expected - $Transaction[0]['Field_6_amount'];
                        }
                    }  else {
                        $Total_Field_6_Expected = 0;
                        $Field_6_Balance = 0;
                    }

                    // Process Field 7 Input
                    if ($PaymentFields[0]['Field_7'] == 1) {
                        $Class_Field_Amount = stu_class_and_fee::where([['stu_class_id', $Transaction[0]['stu_class_id']],['Field_id', '7']])->get();
                        if ($Class_Field_Amount->isEmpty()) {
                            return redirect('/School_Fees/'.$SAN_id)->with('error', "CONTACT ACCOUNTANT!! - NO AMOUNT PAYABLE IN FIELD 7 FOR THE SELECTED PAYMENT CLASS - PLEASE ADD AMOUNT PAYABLE FOR STUDENT IN THAT CLASS"); 
                        } else {
                            $Total_Field_7_Expected = $Class_Field_Amount[0]['amount'] - $Transaction[0]['Field_7_discount'];
                            $Field_7_Balance = $Total_Field_7_Expected - $Transaction[0]['Field_7_amount'];
                        }
                    }  else {
                        $Total_Field_7_Expected = 0;
                        $Field_7_Balance = 0;
                    }

                    // Process Field 8 Input
                    if ($PaymentFields[0]['Field_8'] == 1) {
                        $Class_Field_Amount = stu_class_and_fee::where([['stu_class_id', $Transaction[0]['stu_class_id']],['Field_id', '8']])->get();
                        if ($Class_Field_Amount->isEmpty()) {
                            return redirect('/School_Fees/'.$SAN_id)->with('error', "CONTACT ACCOUNTANT!! - NO AMOUNT PAYABLE IN FIELD 8 FOR THE SELECTED PAYMENT CLASS - PLEASE ADD AMOUNT PAYABLE FOR STUDENT IN THAT CLASS"); 
                        } else {
                            $Total_Field_8_Expected = $Class_Field_Amount[0]['amount'] - $Transaction[0]['Field_8_discount'];
                            $Field_8_Balance = $Total_Field_8_Expected - $Transaction[0]['Field_8_amount'];
                        }
                    }  else {
                        $Total_Field_8_Expected = 0;
                        $Field_8_Balance = 0;
                    }

                    // Process Field 9 Input
                    if ($PaymentFields[0]['Field_9'] == 1) {
                        $Class_Field_Amount = stu_class_and_fee::where([['stu_class_id', $Transaction[0]['stu_class_id']],['Field_id', '9']])->get();
                        if ($Class_Field_Amount->isEmpty()) {
                            return redirect('/School_Fees/'.$SAN_id)->with('error', "CONTACT ACCOUNTANT!! - NO AMOUNT PAYABLE IN FIELD 9 FOR THE SELECTED PAYMENT CLASS - PLEASE ADD AMOUNT PAYABLE FOR STUDENT IN THAT CLASS"); 
                        } else {
                            $Total_Field_9_Expected = $Class_Field_Amount[0]['amount'] - $Transaction[0]['Field_9_discount'];
                            $Field_9_Balance = $Total_Field_9_Expected - $Transaction[0]['Field_9_amount'];
                        }
                    }  else {
                        $Total_Field_9_Expected = 0;
                        $Field_9_Balance = 0;
                    }

                    // Process Field 10 Input
                    if ($PaymentFields[0]['Field_10'] == 1) {
                        $Class_Field_Amount = stu_class_and_fee::where([['stu_class_id', $Transaction[0]['stu_class_id']],['Field_id', '10']])->get();
                        if ($Class_Field_Amount->isEmpty()) {
                            return redirect('/School_Fees/'.$SAN_id)->with('error', "CONTACT ACCOUNTANT!! - NO AMOUNT PAYABLE IN FIELD 10 FOR THE SELECTED PAYMENT CLASS - PLEASE ADD AMOUNT PAYABLE FOR STUDENT IN THAT CLASS"); 
                        } else {
                            $Total_Field_10_Expected = $Class_Field_Amount[0]['amount'] - $Transaction[0]['Field_10_discount'];
                            $Field_10_Balance = $Total_Field_10_Expected - $Transaction[0]['Field_10_amount'];
                        }
                    }  else {
                        $Total_Field_10_Expected = 0;
                        $Field_10_Balance = 0;
                    }

                    // Process Field 11 Input
                    if ($PaymentFields[0]['Field_11'] == 1) {
                        $Class_Field_Amount = stu_class_and_fee::where([['stu_class_id', $Transaction[0]['stu_class_id']],['Field_id', '11']])->get();
                        if ($Class_Field_Amount->isEmpty()) {
                            return redirect('/School_Fees/'.$SAN_id)->with('error', "CONTACT ACCOUNTANT!! - NO AMOUNT PAYABLE IN FIELD 11 FOR THE SELECTED PAYMENT CLASS - PLEASE ADD AMOUNT PAYABLE FOR STUDENT IN THAT CLASS"); 
                        } else {
                            $Total_Field_11_Expected = $Class_Field_Amount[0]['amount'] - $Transaction[0]['Field_11_discount'];
                            $Field_11_Balance = $Total_Field_11_Expected - $Transaction[0]['Field_11_amount'];
                        }
                    }  else {
                        $Total_Field_11_Expected = 0;
                        $Field_11_Balance = 0;
                    }

                    // Process Field 12 Input
                    if ($PaymentFields[0]['Field_12'] == 1) {
                        $Class_Field_Amount = stu_class_and_fee::where([['stu_class_id', $Transaction[0]['stu_class_id']],['Field_id', '12']])->get();
                        if ($Class_Field_Amount->isEmpty()) {
                            return redirect('/School_Fees/'.$SAN_id)->with('error', "CONTACT ACCOUNTANT!! - NO AMOUNT PAYABLE IN FIELD 12 FOR THE SELECTED PAYMENT CLASS - PLEASE ADD AMOUNT PAYABLE FOR STUDENT IN THAT CLASS"); 
                        } else {
                            $Total_Field_12_Expected = $Class_Field_Amount[0]['amount'] - $Transaction[0]['Field_12_discount'];
                            $Field_12_Balance = $Total_Field_12_Expected - $Transaction[0]['Field_12_amount'];
                        }  
                    }  else {
                        $Total_Field_12_Expected = 0;
                        $Field_12_Balance = 0;
                    }

                    // Process Field 13 Input
                    if ($PaymentFields[0]['Field_13'] == 1) {
                        $Class_Field_Amount = stu_class_and_fee::where([['stu_class_id', $Transaction[0]['stu_class_id']],['Field_id', '13']])->get();
                        if ($Class_Field_Amount->isEmpty()) {
                            return redirect('/School_Fees/'.$SAN_id)->with('error', "CONTACT ACCOUNTANT!! - NO AMOUNT PAYABLE IN FIELD 13 FOR THE SELECTED PAYMENT CLASS - PLEASE ADD AMOUNT PAYABLE FOR STUDENT IN THAT CLASS"); 
                        } else {
                            $Total_Field_13_Expected = $Class_Field_Amount[0]['amount'] - $Transaction[0]['Field_13_discount'];
                            $Field_13_Balance = $Total_Field_13_Expected - $Transaction[0]['Field_13_amount'];
                        }
                    }  else {
                        $Total_Field_13_Expected = 0;
                        $Field_13_Balance = 0;
                    }

                    // Process Field 14 Input
                    if ($PaymentFields[0]['Field_14'] == 1) {
                        $Class_Field_Amount = stu_class_and_fee::where([['stu_class_id', $Transaction[0]['stu_class_id']],['Field_id', '14']])->get();
                        if ($Class_Field_Amount->isEmpty()) {
                            return redirect('/School_Fees/'.$SAN_id)->with('error', "CONTACT ACCOUNTANT!! - NO AMOUNT PAYABLE IN FIELD 14 FOR THE SELECTED PAYMENT CLASS - PLEASE ADD AMOUNT PAYABLE FOR STUDENT IN THAT CLASS"); 
                        } else {
                            $Total_Field_14_Expected = $Class_Field_Amount[0]['amount'] - $Transaction[0]['Field_14_discount'];
                            $Field_14_Balance = $Total_Field_14_Expected - $Transaction[0]['Field_14_amount'];
                        }  
                    }  else {
                        $Total_Field_14_Expected = 0;
                        $Field_14_Balance = 0;
                    }

                    // Process Field 15 Input
                    if ($PaymentFields[0]['Field_15'] == 1) {
                        $Class_Field_Amount = stu_class_and_fee::where([['stu_class_id', $Transaction[0]['stu_class_id']],['Field_id', '15']])->get();
                        if ($Class_Field_Amount->isEmpty()) {
                            return redirect('/School_Fees/'.$SAN_id)->with('error', "CONTACT ACCOUNTANT!! - NO AMOUNT PAYABLE IN FIELD 15 FOR THE SELECTED PAYMENT CLASS - PLEASE ADD AMOUNT PAYABLE FOR STUDENT IN THAT CLASS"); 
                        } else {
                            $Total_Field_15_Expected = $Class_Field_Amount[0]['amount'] - $Transaction[0]['Field_15_discount'];
                            $Field_15_Balance = $Total_Field_15_Expected - $Transaction[0]['Field_15_amount'];
                        }
                    }  else {
                        $Total_Field_15_Expected = 0;
                        $Field_15_Balance = 0;
                    }

                    

                    $Balance = new trx_schfee_balance;
                    $Balance->Trx_id = $unique;
                    $Balance->SAN_id = $SAN_id;
                    $Balance->session = $request->input('session');
                    $Balance->term = $request->input('term');
                    $Balance->Field_1_balance = $Field_1_Balance;
                    $Balance->Field_2_balance = $Field_2_Balance;
                    $Balance->Field_3_balance = $Field_3_Balance;
                    $Balance->Field_4_balance = $Field_4_Balance;
                    $Balance->Field_5_balance = $Field_5_Balance;
                    $Balance->Field_6_balance = $Field_6_Balance;
                    $Balance->Field_7_balance = $Field_7_Balance;
                    $Balance->Field_8_balance = $Field_8_Balance;
                    $Balance->Field_9_balance = $Field_9_Balance;
                    $Balance->Field_10_balance = $Field_10_Balance;
                    $Balance->Field_11_balance = $Field_11_Balance;
                    $Balance->Field_12_balance = $Field_12_Balance;
                    $Balance->Field_13_balance = $Field_13_Balance;
                    $Balance->Field_14_balance = $Field_14_Balance;
                    $Balance->Field_15_balance = $Field_15_Balance;

                    $Balance->bal_total = $Field_1_Balance + $Field_2_Balance + $Field_3_Balance +
                                        $Field_4_Balance + $Field_5_Balance + $Field_6_Balance +
                                        $Field_7_Balance + $Field_8_Balance + $Field_9_Balance +
                                        $Field_10_Balance + $Field_11_Balance + $Field_12_Balance +
                                        $Field_13_Balance + $Field_14_Balance + $Field_15_Balance;

                    $Balance->trx_total_expected = $Total_Field_1_Expected + $Total_Field_2_Expected + $Total_Field_3_Expected +
                                                $Total_Field_4_Expected + $Total_Field_5_Expected + $Total_Field_6_Expected +
                                                $Total_Field_7_Expected + $Total_Field_8_Expected + $Total_Field_9_Expected +
                                                $Total_Field_10_Expected + $Total_Field_11_Expected + $Total_Field_12_Expected +
                                                $Total_Field_13_Expected + $Total_Field_14_Expected + $Total_Field_15_Expected;
                    $Balance->save();

                    return redirect('/SchoolFeeSummary/'.$SAN_id.'/'.$unique)->with('success', "SCHOOL FEES PAID SUCCESFULLY");
                
            } else {
                return redirect('/School_Fees/'.$SAN_id)->with('error', "DUPLICATE TRANSACTION!! - USE [OUTSTANDING PAYMENT] TO PAY");
            }
        }
    }

    /**
     * Show new school fees payment summary.
     *
     *@param  int  $SAN_id 
     *@param  int  $Trx_id
     *@return \Illuminate\Http\Response
     */
    public function new_schfee_summary ($SAN_id, $Trx_id) {

        /** 
         * I used a subquery here to query for the particular Students in selected class and  
         * also subqueried for class name.
         */ 
        $Student = (student::addSelect(['class_name' => stu_class::select('stu_class_name')
                    ->whereColumn('class', 'id')
                 ]))->where('SAN_id', $SAN_id)
                ->get();

        $PaymentFields = schfee_breakdown::where('SAN_id', $SAN_id)->get();

        $TRX = (trx_schfee::addSelect(['session' => sch_session::select('sessions')
                    ->whereColumn('session', 'id')
                    ]))->where('Trx_id', $Trx_id)
                    ->get();

        $TRX_TERM = (trx_schfee::addSelect(['term_name' => sch_term::select('term')
                    ->whereColumn('id', 'trx_schfees.term')
                    ]))->where('Trx_id', $Trx_id)
                    ->get();

        $TRX_CLASS = (trx_schfee::addSelect(['class' => stu_class::select('stu_class_name')
                    ->whereColumn('stu_class_id', 'id')
                    ]))->where('Trx_id', $Trx_id)
                    ->get();

        $TRX_MODE = (trx_schfee::addSelect(['modes' => payment_modes::select('modes')
                    ->whereColumn('payment_mode','id')
                    ]))->where('Trx_id', $Trx_id)
                    ->get();

        $TRX_BANK = (trx_schfee::addSelect(['bank' => banks::select('banks')
                    ->whereColumn('bank', 'id')
                    ]))->where('Trx_id', $Trx_id)
                    ->get();

        $TRX_BALANCE = trx_schfee_balance::where('Trx_id', $Trx_id)->get();

        $Name_1 = Schfee_Field::where('id', 1)->select('name')->get();
        $Name_2 = Schfee_Field::where('id', 2)->select('name')->get();
        $Name_3 = Schfee_Field::where('id', 3)->select('name')->get();
        $Name_4 = Schfee_Field::where('id', 4)->select('name')->get();
        $Name_5 = Schfee_Field::where('id', 5)->select('name')->get();
        $Name_6 = Schfee_Field::where('id', 6)->select('name')->get();
        $Name_7 = Schfee_Field::where('id', 7)->select('name')->get();
        $Name_8 = Schfee_Field::where('id', 8)->select('name')->get();
        $Name_9 = Schfee_Field::where('id', 9)->select('name')->get();
        $Name_10 = Schfee_Field::where('id', 10)->select('name')->get();
        $Name_11 = Schfee_Field::where('id', 11)->select('name')->get();
        $Name_12 = Schfee_Field::where('id', 12)->select('name')->get();
        $Name_13 = Schfee_Field::where('id', 13)->select('name')->get();
        $Name_14 = Schfee_Field::where('id', 14)->select('name')->get();
        $Name_15 = Schfee_Field::where('id', 15)->select('name')->get();
        
        return view('accountant.summary_new_schfee_payment',COMPACT('Student','PaymentFields','TRX','TRX_TERM','TRX_CLASS',
                                                                    'TRX_MODE','TRX_BANK','TRX_BALANCE','Name_1','Name_2',
                                                                    'Name_3','Name_4','Name_5','Name_6','Name_7','Name_8',
                                                                    'Name_9','Name_10','Name_11','Name_12','Name_13','Name_14','Name_15'));
    }

    /**
     * On clicking the confirm and print Receipt from School fees summary page
     * the transaction status is confirmed in the Database and Receipt Generated.
     *
     *@param  int  $SAN_id 
     *@param  int  $Trx_id
     *@return \Illuminate\Http\Response
     */
    public function confirm_schfee_payment ($SAN_id, $Trx_id) {

        $TRX = trx_schfee::where('Trx_id', $Trx_id)->get();

        $Check = trx_schfee_ledger::where([['SAN_id', $SAN_id],['session', $TRX[0]['session']],['term', $TRX[0]['term']],['stu_class_id', $TRX[0]['stu_class_id']]])->first();
        if ($Check === null) {

            $Trx_Status;
                
                $TRX_ = trx_schfee::where('Trx_id', $Trx_id)
                                    ->update(['Trx_Status' => "111"]);

                $TRX_BAL = trx_schfee_balance::where('Trx_id',$Trx_id)->get();
                

                if ($TRX_BAL[0]['bal_total'] > 0) {
                    $Trx_Status = 'D';
                } else {
                    $Trx_Status = 'C';
                }

                
                $ledger = trx_schfee_ledger::updateOrCreate(
                    ['SAN_id' => $SAN_id, 'session' => $TRX[0]['session'], 'term' => $TRX[0]['term'], 'stu_class_id' => $TRX[0]['stu_class_id']],
                    ['Field_1_paid' => $TRX[0]['Field_1_amount'],
                    'Field_1_discount' => $TRX[0]['Field_1_discount'],
                    'Field_1_balance' => $TRX_BAL[0]['Field_1_balance'],
                    'Field_2_paid' => $TRX[0]['Field_2_amount'],
                    'Field_2_discount' => $TRX[0]['Field_2_discount'],
                    'Field_2_balance' => $TRX_BAL[0]['Field_2_balance'],
                    'Field_3_paid' => $TRX[0]['Field_3_amount'],
                    'Field_3_discount' => $TRX[0]['Field_3_discount'],
                    'Field_3_balance' => $TRX_BAL[0]['Field_3_balance'],
                    'Field_4_paid' => $TRX[0]['Field_4_amount'],
                    'Field_4_discount' => $TRX[0]['Field_4_discount'],
                    'Field_4_balance' => $TRX_BAL[0]['Field_4_balance'],
                    'Field_5_paid' => $TRX[0]['Field_5_amount'],
                    'Field_5_discount' => $TRX[0]['Field_5_discount'],
                    'Field_5_balance' => $TRX_BAL[0]['Field_5_balance'],
                    'Field_6_paid' => $TRX[0]['Field_6_amount'],
                    'Field_6_discount' => $TRX[0]['Field_6_discount'],
                    'Field_6_balance' => $TRX_BAL[0]['Field_6_balance'],
                    'Field_7_paid' => $TRX[0]['Field_7_amount'],
                    'Field_7_discount' => $TRX[0]['Field_7_discount'],
                    'Field_7_balance' => $TRX_BAL[0]['Field_7_balance'],
                    'Field_8_paid' => $TRX[0]['Field_8_amount'],
                    'Field_8_discount' => $TRX[0]['Field_8_discount'],
                    'Field_8_balance' => $TRX_BAL[0]['Field_8_balance'],
                    'Field_9_paid' => $TRX[0]['Field_9_amount'],
                    'Field_9_discount' => $TRX[0]['Field_9_discount'],
                    'Field_9_balance' => $TRX_BAL[0]['Field_9_balance'],
                    'Field_10_paid' => $TRX[0]['Field_10_amount'],
                    'Field_10_discount' => $TRX[0]['Field_10_discount'],
                    'Field_10_balance' => $TRX_BAL[0]['Field_10_balance'],
                    'Field_11_paid' => $TRX[0]['Field_11_amount'],
                    'Field_11_discount' => $TRX[0]['Field_11_discount'],
                    'Field_11_balance' => $TRX_BAL[0]['Field_11_balance'],
                    'Field_12_paid' => $TRX[0]['Field_12_amount'],
                    'Field_12_discount' => $TRX[0]['Field_12_discount'],
                    'Field_12_balance' => $TRX_BAL[0]['Field_12_balance'],
                    'Field_13_paid' => $TRX[0]['Field_13_amount'],
                    'Field_13_discount' => $TRX[0]['Field_13_discount'],
                    'Field_13_balance' => $TRX_BAL[0]['Field_13_balance'],
                    'Field_14_paid' => $TRX[0]['Field_14_amount'],
                    'Field_14_discount' => $TRX[0]['Field_14_discount'],
                    'Field_14_balance' => $TRX_BAL[0]['Field_14_balance'],
                    'Field_15_paid' => $TRX[0]['Field_15_amount'],
                    'Field_15_discount' => $TRX[0]['Field_15_discount'],
                    'Field_15_balance' => $TRX_BAL[0]['Field_15_balance'],
                    'trx_total_expected' => $TRX_BAL[0]['trx_total_expected'],
                    'trx_dsc_total' => $TRX[0]['trx_dsc_total'],
                    'bal_total' => $TRX_BAL[0]['bal_total'],
                    'Trx_Status' => $Trx_Status,
                    ]
                    
                );
                //return view('accountant.modal');
            return redirect('/SchoolFeeSummary/'.$SAN_id.'/'.$Trx_id)->with('confirmed', "TRANSACTION CONFIRMED");
        
        } elseif ($Check->Trx_Status == "C") { 
            return redirect('/SchoolFeeSummary/'.$SAN_id.'/'.$Trx_id)->with('error', "DUPLICATE TRANSACTION/FEES CLEARED BY STUDENT ALREADY!!");
        } else {
            $Trx_Status;
                
                $TRX_ = trx_schfee::where('Trx_id', $Trx_id)
                                    ->update(['Trx_Status' => "111"]);

                $TRX_BAL = trx_schfee_balance::where('Trx_id',$Trx_id)->get();
                

                if ($TRX_BAL[0]['bal_total'] > 0) {
                    $Trx_Status = 'D';
                } else {
                    $Trx_Status = 'C';
                }

                
                $ledger = trx_schfee_ledger::updateOrCreate(
                    ['SAN_id' => $SAN_id, 'session' => $TRX[0]['session'], 'term' => $TRX[0]['term'], 'stu_class_id' => $TRX[0]['stu_class_id']],
                    ['Field_1_paid' => $TRX[0]['Field_1_amount'],
                    'Field_1_discount' => $TRX[0]['Field_1_discount'],
                    'Field_1_balance' => $TRX_BAL[0]['Field_1_balance'],
                    'Field_2_paid' => $TRX[0]['Field_2_amount'],
                    'Field_2_discount' => $TRX[0]['Field_2_discount'],
                    'Field_2_balance' => $TRX_BAL[0]['Field_2_balance'],
                    'Field_3_paid' => $TRX[0]['Field_3_amount'],
                    'Field_3_discount' => $TRX[0]['Field_3_discount'],
                    'Field_3_balance' => $TRX_BAL[0]['Field_3_balance'],
                    'Field_4_paid' => $TRX[0]['Field_4_amount'],
                    'Field_4_discount' => $TRX[0]['Field_4_discount'],
                    'Field_4_balance' => $TRX_BAL[0]['Field_4_balance'],
                    'Field_5_paid' => $TRX[0]['Field_5_amount'],
                    'Field_5_discount' => $TRX[0]['Field_5_discount'],
                    'Field_5_balance' => $TRX_BAL[0]['Field_5_balance'],
                    'Field_6_paid' => $TRX[0]['Field_6_amount'],
                    'Field_6_discount' => $TRX[0]['Field_6_discount'],
                    'Field_6_balance' => $TRX_BAL[0]['Field_6_balance'],
                    'Field_7_paid' => $TRX[0]['Field_7_amount'],
                    'Field_7_discount' => $TRX[0]['Field_7_discount'],
                    'Field_7_balance' => $TRX_BAL[0]['Field_7_balance'],
                    'Field_8_paid' => $TRX[0]['Field_8_amount'],
                    'Field_8_discount' => $TRX[0]['Field_8_discount'],
                    'Field_8_balance' => $TRX_BAL[0]['Field_8_balance'],
                    'Field_9_paid' => $TRX[0]['Field_9_amount'],
                    'Field_9_discount' => $TRX[0]['Field_9_discount'],
                    'Field_9_balance' => $TRX_BAL[0]['Field_9_balance'],
                    'Field_10_paid' => $TRX[0]['Field_10_amount'],
                    'Field_10_discount' => $TRX[0]['Field_10_discount'],
                    'Field_10_balance' => $TRX_BAL[0]['Field_10_balance'],
                    'Field_11_paid' => $TRX[0]['Field_11_amount'],
                    'Field_11_discount' => $TRX[0]['Field_11_discount'],
                    'Field_11_balance' => $TRX_BAL[0]['Field_11_balance'],
                    'Field_12_paid' => $TRX[0]['Field_12_amount'],
                    'Field_12_discount' => $TRX[0]['Field_12_discount'],
                    'Field_12_balance' => $TRX_BAL[0]['Field_12_balance'],
                    'Field_13_paid' => $TRX[0]['Field_13_amount'],
                    'Field_13_discount' => $TRX[0]['Field_13_discount'],
                    'Field_13_balance' => $TRX_BAL[0]['Field_13_balance'],
                    'Field_14_paid' => $TRX[0]['Field_14_amount'],
                    'Field_14_discount' => $TRX[0]['Field_14_discount'],
                    'Field_14_balance' => $TRX_BAL[0]['Field_14_balance'],
                    'Field_15_paid' => $TRX[0]['Field_15_amount'],
                    'Field_15_discount' => $TRX[0]['Field_15_discount'],
                    'Field_15_balance' => $TRX_BAL[0]['Field_15_balance'],
                    'trx_total_expected' => $TRX_BAL[0]['trx_total_expected'],
                    'trx_dsc_total' => $TRX[0]['trx_dsc_total'],
                    'bal_total' => $TRX_BAL[0]['bal_total'],
                    'Trx_Status' => $Trx_Status,
                    ]
                    
                );
                //return view('accountant.modal');
            return redirect('/SchoolFeeSummary/'.$SAN_id.'/'.$Trx_id)->with('confirmed', "TRANSACTION CONFIRMED");
        }

        
    }


    /**
     * Show a student school fees payment history.
     *
     *@param  int  $SAN_id 
     *@param  int  $Trx_id
     *@return \Illuminate\Http\Response
     */
    public function schfee_history ($SAN_id) {

        $Student = (student::addSelect(['class' => stu_class::select('stu_class_name')
                    ->whereColumn('class', 'id')
                    ]))->where('SAN_id', $SAN_id)
                    ->get();

        $TRX_JOIN = DB::table('trx_schfee_balances')
                ->join('trx_schfees', 'trx_schfees.Trx_id', '=', 'trx_schfee_balances.Trx_id')
                ->select('trx_schfees.*', 'trx_schfee_balances.*')
                ->where('Trx_Status', '111')
                ->get();
                

        $TRX = $TRX_JOIN->where('SAN_id', $SAN_id)
                        ->sortByDesc('created_at');


        $TRX_SESSION = sch_session::all();
        $TRX_TERM = sch_term::all();
        $TRX_CLASS = stu_class::all();

        //$SchFeeFields = Schfee_Field::where('name', '!=', '')->get();
        $SchFeeFields = Schfee_Field::all();
        
        
        return view('accountant.schfee_payment_history', COMPACT('TRX','Student','TRX_TERM','TRX_CLASS','TRX_SESSION','SchFeeFields'));
    }

    /**
     * Show the form for outstanding school fees payment. to fetch previous balance
     * 
     *@param  int  $SAN_id
     *@return \Illuminate\Http\Response
     */
    public function out_schfee_payment_fetch ($SAN_id) {

        /** 
         * I used a subquery here to query for the particular Students in selected class and  
         * also subqueried for class name.
         */ 
        $Student = (student::addSelect(['class_name' => stu_class::select('stu_class_name')
                    ->whereColumn('class', 'id')
                 ]))->where('SAN_id', $SAN_id)
                ->get();

        $Sessions = sch_session::all();
        $Terms = sch_term::all();
        $Stu_Class = stu_class::where('stu_class_status', 'Active School Class')->get();
        
        return view('accountant.outstanding_schfee_payment_fetch',COMPACT('Student','Sessions','Terms','Stu_Class',));
    }

    /**
     * Show the form for outstanding school fees payment.
     * 
     *@param  int  $SAN_id
     *@return \Illuminate\Http\Response
     */
    public function out_schfee_payment (Request $request, $SAN_id) {

        $this->validate($request, [
            'session' => 'required',
            'term' => 'required',
            'class' => 'required',  
        ]);

        $Selected_Class = $request->input('class');
        $Selected_Session = $request->input('session');
        $Selected_Term = $request->input('term');
        $P_Balance = trx_schfee_ledger::where([['SAN_id', $SAN_id],['stu_class_id', $Selected_Class],['session', $Selected_Session],['term', $Selected_Term]])->get();
        //dd($P_Balance);
        if($P_Balance->isEmpty()) {

            return redirect('/Balance/'.$SAN_id)->with('error', " NO PREVIOUS TRANSACTION");

        } elseif($P_Balance[0]['Trx_Status'] == "C"){

            return redirect('/Balance/'.$SAN_id)->with('error', " NO PENDING BALANCE TO PAY FOUND!");

        } else {

        /** 
         * I used a subquery here to query for the particular Students in selected class and  
         * also subqueried for class name.
         */
        $Student = (student::addSelect(['class_name' => stu_class::select('stu_class_name')
                ->whereColumn('class', 'id')
                ]))->where('SAN_id', $SAN_id)
                ->get();

                $SchFee = schfee_breakdown::where('SAN_id', $SAN_id)->get();
                $Sessions = sch_session::all();
                $Terms = sch_term::all();
                $Stu_Class = stu_class::where('stu_class_status', 'Active School Class')->get();
                $Modes = payment_modes::where([['modes', '!=', ''],['status', 1]])->get();
                $Banks = banks::where([['banks', '!=', ''],['status', 1]])->get();


                $Name_1 = Schfee_Field::where('id', 1)->select('name')->get();
                $Name_2 = Schfee_Field::where('id', 2)->select('name')->get();
                $Name_3 = Schfee_Field::where('id', 3)->select('name')->get();
                $Name_4 = Schfee_Field::where('id', 4)->select('name')->get();
                $Name_5 = Schfee_Field::where('id', 5)->select('name')->get();
                $Name_6 = Schfee_Field::where('id', 6)->select('name')->get();
                $Name_7 = Schfee_Field::where('id', 7)->select('name')->get();
                $Name_8 = Schfee_Field::where('id', 8)->select('name')->get();
                $Name_9 = Schfee_Field::where('id', 9)->select('name')->get();
                $Name_10 = Schfee_Field::where('id', 10)->select('name')->get();
                $Name_11 = Schfee_Field::where('id', 11)->select('name')->get();
                $Name_12 = Schfee_Field::where('id', 12)->select('name')->get();
                $Name_13 = Schfee_Field::where('id', 13)->select('name')->get();
                $Name_14 = Schfee_Field::where('id', 14)->select('name')->get();
                $Name_15 = Schfee_Field::where('id', 15)->select('name')->get();

                return view('accountant.outstanding_schfee_payment',COMPACT('Student','SchFee','Sessions','Terms','Modes','Banks','Stu_Class',
                                                                        'Name_1','Name_2','Name_3','Name_4','Name_5',
                                                                        'Name_6','Name_7','Name_8','Name_9','Name_10',
                                                                        'Name_11','Name_12','Name_13','Name_14','Name_15','P_Balance',
                                                                        'Selected_Class','Selected_Session','Selected_Term'));
        }

        
    }

    /**
     * Process a student outstanding school fees Payment and save to DB.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $SAN_id
     * @return \Illuminate\Http\Response
     */
    public function out_process_schfee (Request $request, $SAN_id)
    {
        $today = date("dm");
        //$rand = strtoupper(substr(uniqid(sha1(time())),0,6));
        $rand = rand(00000,99999);
        $unique = $rand . $today;
		

        {
            $this->validate($request, [
                'session' => 'required',
                'term' => 'required',
                'class' => 'required',
                'Trx_Ref' => 'required',
                'mode' => 'required',   
            ]);

            //check the previous/reference transaction id to be valid and for a the student 
            $Check_Ref = trx_schfee::where([['Trx_id', $request->input('Trx_Ref')],['SAN_id', $SAN_id]])->get();

            if($Check_Ref->isEmpty()) {
                return redirect('/Balance/'.$SAN_id)->with('error', "INVALID PREVIOUS TRANSACTION REF ID ENTERED!!! -  PLEASE CHECK");
            } else {
                
            //Create a new school fees payment transaction for a student.
            $SCHFEE_PMT = new trx_schfee;
            $SCHFEE_PMT->Trx_id = $unique;
            $SCHFEE_PMT->Ref_Trx_id = $request->input('Trx_Ref');
            $SCHFEE_PMT->SAN_id = $SAN_id;
            $SCHFEE_PMT->stu_class_id = $request->input('class');
            $SCHFEE_PMT->payment_by =  Auth::user()->name;
            $SCHFEE_PMT->session = $request->input('session');
            $SCHFEE_PMT->term = $request->input('term');

            $SCHFEE_PMT->Field_1_amount = $request->input('Field_1_amount');
            $SCHFEE_PMT->Field_2_amount = $request->input('Field_2_amount');
            $SCHFEE_PMT->Field_3_amount = $request->input('Field_3_amount');
            $SCHFEE_PMT->Field_4_amount = $request->input('Field_4_amount');
            $SCHFEE_PMT->Field_5_amount = $request->input('Field_5_amount');
            $SCHFEE_PMT->Field_6_amount = $request->input('Field_6_amount');
            $SCHFEE_PMT->Field_7_amount = $request->input('Field_7_amount');
            $SCHFEE_PMT->Field_8_amount = $request->input('Field_8_amount');
            $SCHFEE_PMT->Field_9_amount = $request->input('Field_9_amount');
            $SCHFEE_PMT->Field_10_amount = $request->input('Field_10_amount');
            $SCHFEE_PMT->Field_11_amount = $request->input('Field_11_amount');
            $SCHFEE_PMT->Field_12_amount = $request->input('Field_12_amount');
            $SCHFEE_PMT->Field_13_amount = $request->input('Field_13_amount');
            $SCHFEE_PMT->Field_14_amount = $request->input('Field_14_amount');
            $SCHFEE_PMT->Field_15_amount = $request->input('Field_15_amount');

            $trx_total = $request->input('Field_1_amount') + $request->input('Field_2_amount') + $request->input('Field_3_amount') +
                         $request->input('Field_4_amount') + $request->input('Field_5_amount') + $request->input('Field_6_amount') +
                         $request->input('Field_7_amount') + $request->input('Field_8_amount') + $request->input('Field_9_amount') +
                         $request->input('Field_10_amount') + $request->input('Field_11_amount') + $request->input('Field_12_amount') +
                         $request->input('Field_13_amount') + $request->input('Field_14_amount') + $request->input('Field_15_amount');                       
            $SCHFEE_PMT->trx_total = $trx_total;
            $SCHFEE_PMT->bank = $request->input('bank');
            $SCHFEE_PMT->payment_mode = $request->input('mode');
            $SCHFEE_PMT->comment = $request->input('comment');   
            $SCHFEE_PMT->save();
            
           
            // Fetch the Transaction 
            $Transaction = trx_schfee::where('Trx_id', $unique)->get();

            //Fetch the Ledger Record to access the Previous Balance
            $P_Balance = trx_schfee_ledger::where([['SAN_id', $SAN_id],['session', $Transaction[0]['session']],['term', $Transaction[0]['term']],['stu_class_id', $Transaction[0]['stu_class_id']]])->get();
            //dd($P_Balance);

            // Fetch the Student School Fees Break down
            $PaymentFields = schfee_breakdown::where('SAN_id', $SAN_id)->get();

            // Process Field 1 Input
            if ($PaymentFields[0]['Field_1'] == 1) {
                $Field_1_Balance = $P_Balance[0]['Field_1_balance'] - $Transaction[0]['Field_1_amount'];
            }  else {
                $Field_1_Balance = 0;
            }

            // Process Field 2 Input
            if ($PaymentFields[0]['Field_2'] == 1) {
                $Field_2_Balance = $P_Balance[0]['Field_2_balance'] - $Transaction[0]['Field_2_amount'];
            }  else {
                $Field_2_Balance = 0;
            }

            // Process Field 3 Input
            if ($PaymentFields[0]['Field_3'] == 1) {
                $Field_3_Balance = $P_Balance[0]['Field_3_balance'] - $Transaction[0]['Field_3_amount'];
            }  else {
                $Field_3_Balance = 0;
            }

            // Process Field 4 Input
            if ($PaymentFields[0]['Field_4'] == 1) {
                $Field_4_Balance = $P_Balance[0]['Field_4_balance'] - $Transaction[0]['Field_4_amount'];
            }  else {
                $Field_4_Balance = 0;
            }

            // Process Field 5 Input
            if ($PaymentFields[0]['Field_5'] == 1) {
                $Field_5_Balance = $P_Balance[0]['Field_5_balance'] - $Transaction[0]['Field_5_amount'];
            }  else {
                $Field_5_Balance = 0;
            }

            // Process Field 6 Input
            if ($PaymentFields[0]['Field_6'] == 1) {
                $Field_6_Balance = $P_Balance[0]['Field_6_balance'] - $Transaction[0]['Field_6_amount'];
            }  else {
                $Field_6_Balance = 0;
            }

            // Process Field 7 Input
            if ($PaymentFields[0]['Field_7'] == 1) {
                $Field_7_Balance = $P_Balance[0]['Field_7_balance'] - $Transaction[0]['Field_7_amount'];
            }  else {
                $Field_7_Balance = 0;
            }

            // Process Field 8 Input
            if ($PaymentFields[0]['Field_8'] == 1) {
                $Field_8_Balance = $P_Balance[0]['Field_8_balance'] - $Transaction[0]['Field_8_amount'];
            }  else {
                $Field_8_Balance = 0;
            }

            // Process Field 9 Input
            if ($PaymentFields[0]['Field_9'] == 1) {
                $Field_9_Balance = $P_Balance[0]['Field_9_balance'] - $Transaction[0]['Field_9_amount'];
            }  else {
                $Field_9_Balance = 0;
            }

            // Process Field 10 Input
            if ($PaymentFields[0]['Field_10'] == 1) {
                $Field_10_Balance = $P_Balance[0]['Field_10_balance'] - $Transaction[0]['Field_10_amount'];
            }  else {
                $Field_10_Balance = 0;
            }

            // Process Field 11 Input
            if ($PaymentFields[0]['Field_11'] == 1) {
                $Field_11_Balance = $P_Balance[0]['Field_11_balance'] - $Transaction[0]['Field_11_amount'];
            }  else {
                $Field_11_Balance = 0;
            }

            // Process Field 12 Input
            if ($PaymentFields[0]['Field_12'] == 1) {
                $Field_12_Balance = $P_Balance[0]['Field_12_balance'] - $Transaction[0]['Field_12_amount'];
            }  else {
                $Field_12_Balance = 0;
            }

            // Process Field 13 Input
            if ($PaymentFields[0]['Field_13'] == 1) {
                $Field_13_Balance = $P_Balance[0]['Field_13_balance'] - $Transaction[0]['Field_13_amount'];
            }  else {
                $Field_13_Balance = 0;
            }

            // Process Field 14 Input
            if ($PaymentFields[0]['Field_14'] == 1) {
                $Field_14_Balance = $P_Balance[0]['Field_14_balance'] - $Transaction[0]['Field_14_amount'];
            }  else {
                $Field_14_Balance = 0;
            }

            // Process Field 15 Input
            if ($PaymentFields[0]['Field_15'] == 1) {
                $Field_15_Balance = $P_Balance[0]['Field_15_balance'] - $Transaction[0]['Field_15_amount'];
            }  else {
                $Field_15_Balance = 0;
            }



            $Balance = new trx_schfee_balance;
            $Balance->Trx_id = $unique;
            $Balance->SAN_id = $SAN_id;
            $Balance->session = $request->input('session');
            $Balance->term = $request->input('term');
            $Balance->Field_1_balance = $Field_1_Balance;
            $Balance->Field_2_balance = $Field_2_Balance;
            $Balance->Field_3_balance = $Field_3_Balance;
            $Balance->Field_4_balance = $Field_4_Balance;
            $Balance->Field_5_balance = $Field_5_Balance;
            $Balance->Field_6_balance = $Field_6_Balance;
            $Balance->Field_7_balance = $Field_7_Balance;
            $Balance->Field_8_balance = $Field_8_Balance;
            $Balance->Field_9_balance = $Field_9_Balance;
            $Balance->Field_10_balance = $Field_10_Balance;
            $Balance->Field_11_balance = $Field_11_Balance;
            $Balance->Field_12_balance = $Field_12_Balance;
            $Balance->Field_13_balance = $Field_13_Balance;
            $Balance->Field_14_balance = $Field_14_Balance;
            $Balance->Field_15_balance = $Field_15_Balance;

            $Balance->bal_total = $Field_1_Balance + $Field_2_Balance + $Field_3_Balance +
                                  $Field_4_Balance + $Field_5_Balance + $Field_6_Balance +
                                  $Field_7_Balance + $Field_8_Balance + $Field_9_Balance +
                                  $Field_10_Balance + $Field_11_Balance + $Field_12_Balance +
                                  $Field_13_Balance + $Field_14_Balance + $Field_15_Balance;

            $Balance->trx_total_expected = $P_Balance[0]['bal_total'];
            $Balance->save();
            
            

            return redirect('/Balance/SchoolFeeSummary/'.$SAN_id.'/'.$unique)->with('success', "SCHOOL FEES PAID SUCCESFULLY");
        }

            }
    }

    /**
     * Show outstanding school fees payment summary.
     *
     *@param  int  $SAN_id 
     *@param  int  $Trx_id
     *@return \Illuminate\Http\Response
     */
    public function out_schfee_summary ($SAN_id, $Trx_id) {

        /** 
         * I used a subquery here to query for the particular Students in selected class and  
         * also subqueried for class name.
         */ 
        $Student = (student::addSelect(['class_name' => stu_class::select('stu_class_name')
                    ->whereColumn('class', 'id')
                 ]))->where('SAN_id', $SAN_id)
                ->get();

        $SchFee = schfee_breakdown::where('SAN_id', $SAN_id)->get();

        $TRX = (trx_schfee::addSelect(['session' => sch_session::select('sessions')
                    ->whereColumn('session', 'id')
                    ]))->where('Trx_id', $Trx_id)
                    ->get();

        $TRX_TERM = (trx_schfee::addSelect(['terms' => sch_term::select('term')
        ->whereColumn('trx_schfees.term', 'id')
        ]))->where('Trx_id', $Trx_id)
        ->get();

        $TRX_CLASS = (trx_schfee::addSelect(['class' => stu_class::select('stu_class_name')
        ->whereColumn('stu_class_id', 'id')
        ]))->where('Trx_id', $Trx_id)
        ->get();

        $TRX_MODE = (trx_schfee::addSelect(['modes' => payment_modes::select('modes')
        ->whereColumn('payment_mode','id')
        ]))->where('Trx_id', $Trx_id)
        ->get();

        $TRX_BANK = (trx_schfee::addSelect(['bank' => banks::select('banks')
        ->whereColumn('bank', 'id')
        ]))->where('Trx_id', $Trx_id)
        ->get();

        $TRX_BALANCE = trx_schfee_balance::where('Trx_id', $Trx_id)->get();

        $Name_1 = Schfee_Field::where('id', 1)->select('name')->get();
        $Name_2 = Schfee_Field::where('id', 2)->select('name')->get();
        $Name_3 = Schfee_Field::where('id', 3)->select('name')->get();
        $Name_4 = Schfee_Field::where('id', 4)->select('name')->get();
        $Name_5 = Schfee_Field::where('id', 5)->select('name')->get();
        $Name_6 = Schfee_Field::where('id', 6)->select('name')->get();
        $Name_7 = Schfee_Field::where('id', 7)->select('name')->get();
        $Name_8 = Schfee_Field::where('id', 8)->select('name')->get();
        $Name_9 = Schfee_Field::where('id', 9)->select('name')->get();
        $Name_10 = Schfee_Field::where('id', 10)->select('name')->get();
        $Name_11 = Schfee_Field::where('id', 11)->select('name')->get();
        $Name_12 = Schfee_Field::where('id', 12)->select('name')->get();
        $Name_13 = Schfee_Field::where('id', 13)->select('name')->get();
        $Name_14 = Schfee_Field::where('id', 14)->select('name')->get();
        $Name_15 = Schfee_Field::where('id', 15)->select('name')->get();
        
        return view('accountant.summary_out_schfee_payment',COMPACT('Student','SchFee','TRX','TRX_TERM','TRX_CLASS',
                                                                    'TRX_BANK','TRX_BALANCE','TRX_MODE',
                                                                    'Name_1','Name_2','Name_3','Name_4','Name_5',
                                                                    'Name_6','Name_7','Name_8','Name_9','Name_10',
                                                                    'Name_11','Name_12','Name_13','Name_14','Name_15',));
    }

    /**
     * On clicking the confirm and print Receipt from Outstanding School fees summary page
     * the transaction status is confirmed in the Database and Receipt Generated.
     *
     *@param  int  $SAN_id 
     *@param  int  $Trx_id
     *@return \Illuminate\Http\Response
     */
    public function confirm_out_schfee_payment ($SAN_id, $Trx_id) {

        // New Confirm Operation Starts Here!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

        $TRX = trx_schfee::where('Trx_id', $Trx_id)->get();

        $Check = trx_schfee_ledger::where([['SAN_id', $SAN_id],['session', $TRX[0]['session']],['term', $TRX[0]['term']],['stu_class_id', $TRX[0]['stu_class_id']]])->first();
        if ($Check->Trx_Status == "C") { 
            return redirect('/Balance/SchoolFeeSummary/'.$SAN_id.'/'.$Trx_id)->with('error', "DUPLICATE TRANSACTION (or) THE STUDENT HAS NO PENDING BALANCE TO PAY!!");
        } else {
                $Trx_Status;
                
                $TRX_ = trx_schfee::where('Trx_id', $Trx_id)
                                    ->update(['Trx_Status' => "111"]);

                $TRX_BAL = trx_schfee_balance::where('Trx_id',$Trx_id)->get();

                if ($TRX_BAL[0]['bal_total'] > 0) {
                    $Trx_Status = 'D';
                } else {
                    $Trx_Status = 'C';
                }
                
                // Accessing the previous transaction 
                $L_TRX = trx_schfee_ledger::where([['SAN_id', $SAN_id], ['session', $TRX[0]['session']], ['term', $TRX[0]['term']], ['stu_class_id', $TRX[0]['stu_class_id']]])->get();

                $ledger = trx_schfee_ledger::where([['SAN_id', $SAN_id], ['session', $TRX[0]['session']], ['term', $TRX[0]['term']], ['stu_class_id', $TRX[0]['stu_class_id']]])
                                            ->update(['Field_1_paid' => $L_TRX[0]['Field_1_paid'] + $TRX[0]['Field_1_amount'],
                                                    'Field_1_balance' => $TRX_BAL[0]['Field_1_balance'],
                                                    'Field_2_paid' => $L_TRX[0]['Field_2_paid'] +  $TRX[0]['Field_2_amount'],
                                                    'Field_2_balance' => $TRX_BAL[0]['Field_2_balance'],
                                                    'Field_3_paid' => $L_TRX[0]['Field_3_paid'] +  $TRX[0]['Field_3_amount'],
                                                    'Field_3_balance' => $TRX_BAL[0]['Field_3_balance'],
                                                    'Field_4_paid' => $L_TRX[0]['Field_4_paid'] +  $TRX[0]['Field_4_amount'],
                                                    'Field_4_balance' => $TRX_BAL[0]['Field_4_balance'],
                                                    'Field_5_paid' => $L_TRX[0]['Field_5_paid'] +  $TRX[0]['Field_5_amount'],
                                                    'Field_5_balance' => $TRX_BAL[0]['Field_5_balance'],
                                                    'Field_6_paid' => $L_TRX[0]['Field_6_paid'] +  $TRX[0]['Field_6_amount'],
                                                    'Field_6_balance' => $TRX_BAL[0]['Field_6_balance'],
                                                    'Field_7_paid' => $L_TRX[0]['Field_7_paid'] +  $TRX[0]['Field_7_amount'],
                                                    'Field_7_balance' => $TRX_BAL[0]['Field_7_balance'],
                                                    'Field_8_paid' => $L_TRX[0]['Field_8_paid'] +  $TRX[0]['Field_8_amount'],
                                                    'Field_8_balance' => $TRX_BAL[0]['Field_8_balance'],
                                                    'Field_9_paid' => $L_TRX[0]['Field_9_paid'] +  $TRX[0]['Field_9_amount'],
                                                    'Field_9_balance' => $TRX_BAL[0]['Field_9_balance'],
                                                    'Field_10_paid' => $L_TRX[0]['Field_10_paid'] +  $TRX[0]['Field_10_amount'],
                                                    'Field_10_balance' => $TRX_BAL[0]['Field_10_balance'],
                                                    'Field_11_paid' => $L_TRX[0]['Field_11_paid'] +  $TRX[0]['Field_11_amount'],
                                                    'Field_11_balance' => $TRX_BAL[0]['Field_11_balance'],
                                                    'Field_12_paid' => $L_TRX[0]['Field_12_paid'] +  $TRX[0]['Field_12_amount'],
                                                    'Field_12_balance' => $TRX_BAL[0]['Field_12_balance'],
                                                    'Field_13_paid' => $L_TRX[0]['Field_13_paid'] +  $TRX[0]['Field_13_amount'],
                                                    'Field_13_balance' => $TRX_BAL[0]['Field_13_balance'],
                                                    'Field_14_paid' => $L_TRX[0]['Field_14_paid'] +  $TRX[0]['Field_14_amount'],
                                                    'Field_14_balance' => $TRX_BAL[0]['Field_14_balance'],
                                                    'Field_15_paid' => $L_TRX[0]['Field_15_paid'] +  $TRX[0]['Field_15_amount'],
                                                    'Field_15_balance' => $TRX_BAL[0]['Field_15_balance'],
                                                    'bal_total' => $TRX_BAL[0]['bal_total'],
                                                    'Trx_Status' => $Trx_Status,
                                                    ]);

            return redirect('/Balance/SchoolFeeSummary/'.$SAN_id.'/'.$Trx_id)->with('confirmed', "TRANSACTION CONFIRMED");
        }

    }

    /**
     * Show the form for entering Transaction Reference No:
     *
     * @return \Illuminate\Http\Response
     */
    public function trx_details_1 ()
    {

        return view('accountant.trx_details_1');
    }    

    /**
     *Show Transaction Details.
     *
     *@param  int  $Trx_id
     *@param  Requset  $Request
     *@return \Illuminate\Http\Response
     */
    public function trx_details (Request $request) {

            $this->validate($request, [
                'Trx_id' => 'required',  
            ]);
        $Trx_id =  $request->input('Trx_id');

        $TRX = trx_schfee::where('Trx_id', $Trx_id)->get();
        if (count($TRX) > 0) {
            $TRX_SESSION = sch_session::all();
        $TRX_CLASS = stu_class::all();
        $TRX_TERM = sch_term::all();
        $STUDENT = student::where('SAN_id', $TRX[0]['SAN_id'])->get();
        $SchFee = schfee_breakdown::where('SAN_id', $TRX[0]['SAN_id'])->get();
        $TRX_BALANCE = trx_schfee_balance::where('Trx_id', $Trx_id)->get();

        $Name_1 = Schfee_Field::where('id', 1)->select('name')->get();
        $Name_2 = Schfee_Field::where('id', 2)->select('name')->get();
        $Name_3 = Schfee_Field::where('id', 3)->select('name')->get();
        $Name_4 = Schfee_Field::where('id', 4)->select('name')->get();
        $Name_5 = Schfee_Field::where('id', 5)->select('name')->get();
        $Name_6 = Schfee_Field::where('id', 6)->select('name')->get();
        $Name_7 = Schfee_Field::where('id', 7)->select('name')->get();
        $Name_8 = Schfee_Field::where('id', 8)->select('name')->get();
        $Name_9 = Schfee_Field::where('id', 9)->select('name')->get();
        $Name_10 = Schfee_Field::where('id', 10)->select('name')->get();
        $Name_11 = Schfee_Field::where('id', 11)->select('name')->get();
        $Name_12 = Schfee_Field::where('id', 12)->select('name')->get();
        $Name_13 = Schfee_Field::where('id', 13)->select('name')->get();
        $Name_14 = Schfee_Field::where('id', 14)->select('name')->get();
        $Name_15 = Schfee_Field::where('id', 15)->select('name')->get();
        
        return view('accountant.transaction_details',COMPACT('TRX','TRX_SESSION','TRX_CLASS','TRX_TERM','STUDENT','SchFee','TRX_BALANCE',
                                                             'Name_1','Name_2','Name_3','Name_4','Name_5',
                                                             'Name_6','Name_7','Name_8','Name_9','Name_10',
                                                             'Name_11','Name_12','Name_13','Name_14','Name_15',));
        } else {
            return redirect('/SchFee_Transaction')->with('warning', 'NO TRANSACTION FOUND!');
        }
    }

    /**
     *Show Transaction Details Linking.
     *
     *@param  int  $Trx_id
     *@param  Requset  $Request
     *@return \Illuminate\Http\Response
     */

    public function trx_details_link ($Trx_id) {


        $TRX = trx_schfee::where('Trx_id', $Trx_id)->get();
        $TRX_SESSION = sch_session::all();
        $TRX_CLASS = stu_class::all();
        $TRX_TERM = sch_term::all();
        $STUDENT = student::where('SAN_id', $TRX[0]['SAN_id'])->get();
        $SchFee = schfee_breakdown::where('SAN_id', $TRX[0]['SAN_id'])->get();
        $TRX_BALANCE = trx_schfee_balance::where('Trx_id', $Trx_id)->get();

        $Name_1 = Schfee_Field::where('id', 1)->select('name')->get();
        $Name_2 = Schfee_Field::where('id', 2)->select('name')->get();
        $Name_3 = Schfee_Field::where('id', 3)->select('name')->get();
        $Name_4 = Schfee_Field::where('id', 4)->select('name')->get();
        $Name_5 = Schfee_Field::where('id', 5)->select('name')->get();
        $Name_6 = Schfee_Field::where('id', 6)->select('name')->get();
        $Name_7 = Schfee_Field::where('id', 7)->select('name')->get();
        $Name_8 = Schfee_Field::where('id', 8)->select('name')->get();
        $Name_9 = Schfee_Field::where('id', 9)->select('name')->get();
        $Name_10 = Schfee_Field::where('id', 10)->select('name')->get();
        $Name_11 = Schfee_Field::where('id', 11)->select('name')->get();
        $Name_12 = Schfee_Field::where('id', 12)->select('name')->get();
        $Name_13 = Schfee_Field::where('id', 13)->select('name')->get();
        $Name_14 = Schfee_Field::where('id', 14)->select('name')->get();
        $Name_15 = Schfee_Field::where('id', 15)->select('name')->get();
        
        return view('accountant.transaction_details',COMPACT('TRX','TRX_SESSION','TRX_CLASS','TRX_TERM','STUDENT','SchFee','TRX_BALANCE',
                                                            'Name_1','Name_2','Name_3','Name_4','Name_5',
                                                            'Name_6','Name_7','Name_8','Name_9','Name_10',
                                                            'Name_11','Name_12','Name_13','Name_14','Name_15'));
}

/******************************************************************************
                                 *                                            *
                                 * //HANDLING SCHOOL FEES REPORTS OPERATIONS//*
                                 *                                            *
*******************************************************************************/

    /**
     * Form to accept [Class, Session and Term] for which cleared students school fee report is to be generated.
     *
     * @return \Illuminate\Http\Response
     */
    public function cleared_students_1 ()
    { 
        $stu_class = stu_class::where('stu_class_status', 'Active School Class')->get();
        $session = sch_session::all();
        $term = sch_term::all();
        return view('accountant.cleared_query_form')->with('stu_class', $stu_class)
                                                    ->with('session', $session)
                                                    ->with('term', $term);
    }

    /**
     * Display report.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function cleared_students (Request  $request)
    {
        $this->validate($request, [
            'Stu_Class' => 'required',
            'Stu_Session' => 'required',
            'Stu_Term' => 'required',
        ]);

        $Stu_Class = $request->input('Stu_Class');
        $Stu_Session = $request->input('Stu_Session');
        $Stu_Term = $request->input('Stu_Term');
 

        $C_STU = DB::table('students')
                ->join('trx_schfee_ledgers', 'trx_schfee_ledgers.SAN_id', '=', 'students.SAN_id')
                ->select('trx_schfee_ledgers.*', 'students.*')
                ->where([['stu_class_id', $Stu_Class], ['session', $Stu_Session], ['term', $Stu_Term],['Trx_Status', 'C']])
                ->get();
                
        if ($C_STU->isEmpty()) {
            return redirect('/Cleared_Students')->with('warning', "No record Found!");   
        } else {
            $Class_Name = stu_class::where('id', $request->input('Stu_Class'))->get();
            $Session = sch_session::where('id', $request->input('Stu_Session'))->get();
            $Term = sch_term::where('id', $request->input('Stu_Term'))->get();

            return view('accountant.cleared_students')->with('C_STU', $C_STU)
                                                      ->with('Class_Name', $Class_Name)
                                                      ->with('Session', $Session)
                                                      ->with('Term', $Term);
        }  

        
    }


    /**
     * Form to accept [Class, Session and Term] for which cleared students school fee report is to be generated.
     *
     * @return \Illuminate\Http\Response
     */
    public function default_students_1 ()
    { 
        $stu_class = stu_class::where('stu_class_status', 'Active School Class')->get();
        $session = sch_session::all();
        $term = sch_term::all();
        return view('accountant.default_query_form')->with('stu_class', $stu_class)
                                                    ->with('session', $session)
                                                    ->with('term', $term);
    }

    /**
     * Display report.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function defaulted_students (Request  $request)
    {
        $this->validate($request, [
            'Stu_Class' => 'required',
            'Stu_Session' => 'required',
            'Stu_Term' => 'required',
        ]);

        $Stu_Class = $request->input('Stu_Class');
        $Stu_Session = $request->input('Stu_Session');
        $Stu_Term = $request->input('Stu_Term');
 

        $C_STU = DB::table('students')
                ->join('trx_schfee_ledgers', 'trx_schfee_ledgers.SAN_id', '=', 'students.SAN_id')
                ->select('trx_schfee_ledgers.*', 'students.*')
                ->where([['stu_class_id', $Stu_Class], ['session', $Stu_Session], ['term', $Stu_Term],['Trx_Status', 'D']])
                ->get();
                
        if ($C_STU->isEmpty()) {
            return redirect('/Cleared_Students')->with('warning', "No record Found!");   
        } else {
            $Class_Name = stu_class::where('id', $request->input('Stu_Class'))->get();
            $Session = sch_session::where('id', $request->input('Stu_Session'))->get();
            $Term = sch_term::where('id', $request->input('Stu_Term'))->get();

            return view('accountant.defaulted_students')->with('C_STU', $C_STU)
                                                      ->with('Class_Name', $Class_Name)
                                                      ->with('Session', $Session)
                                                      ->with('Term', $Term);
        }  
    }

/******************************************************************************
                                 *                                            *
                                 * //HANDLING OTHER FEES PAYMENTS/RECEIPTS//  *
                                 *                                            *
*******************************************************************************/

    /**
     * Form to accept class for which a students other fee is to be paid.
     *
     * @return \Illuminate\Http\Response
     */
    public function new_fee_1 ()
    { 
        $stu_class = stu_class::all();
        return view('accountant.otherfees_1_class')->with('stu_class', $stu_class);
    }

    /**
     * Display students in a selected class.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function new_fee_2 (Request  $request)
    {
        $this->validate($request, [
            'Stu_Class' => 'required',
        ]);

        $Selected_Class = $request->input('Stu_Class');
        $Student = student::where([['class', $Selected_Class],['status', '101']])->get();
        $Stu_Class = stu_class::where('id', $Selected_Class)->get();
    
        return view('accountant.otherfees_2_student')->with('Student', $Student)
                                            ->with('Stu_Class', $Stu_Class);
    }

    /**
     * Show the form for selecting payment.
     * 
     *@param  int  $SAN_id
     *@return \Illuminate\Http\Response
     */
    public function otherfee_select_payment_form ($SAN_id) {

        /** 
         * I used a subquery here to query for the particular Students in selected class and  
         * also subqueried for class name.
         */ 
        $Student = (student::addSelect(['class_name' => stu_class::select('stu_class_name')
                    ->whereColumn('class', 'id')
                 ]))->where('SAN_id', $SAN_id)
                ->get();

        $Payments = income_category::where('business', 'BRIGHTER SCHOOL')->get();
        return view('accountant.otherfees_select_payment_form')->with('Student', $Student)
                                                               ->with('Payments', $Payments);
    }

    /**
     * Show the form for collecting other fees payment.
     * 
     *@param  int  $SAN_id
     *@return \Illuminate\Http\Response
     *@return \Illuminate\Http\Response
     */
    public function otherfee_payment_form (Request $request, $SAN_id) {

        $this->validate($request, [
            'Payment' => 'required',    
        ]);

        $Payment = income_category::where('id', $request->input('Payment'))->get();

        /** 
         * I used a subquery here to query for the particular Students in selected class and  
         * also subqueried for class name.
         */ 
        $Student = (student::addSelect(['class_name' => stu_class::select('stu_class_name')
                    ->whereColumn('class', 'id')
                 ]))->where('SAN_id', $SAN_id)
                ->get();

        $Sessions = sch_session::all();
        $Terms = sch_term::all();
        $Stu_Class = stu_class::all();
        $Modes = payment_modes::where([['modes', '!=', ''],['status', 1]])->get();
        $Banks = banks::where([['banks', '!=', ''],['status', 1]])->get();
        return view('accountant.otherfees_payment_form')->with('Student', $Student)
                                                        ->with('Sessions', $Sessions)
                                                        ->with('Terms', $Terms)
                                                        ->with('Modes', $Modes)
                                                        ->with('Banks', $Banks)
                                                        ->with('Stu_Class', $Stu_Class)
                                                        ->with('Payment', $Payment);
    }


    /**
     * Process other fees Payment and save to DB.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $SAN_id
     * @return \Illuminate\Http\Response
     */
    public function process_otherfee (Request $request, $SAN_id)
    {

        $today = date("md");
        //$rand = strtoupper(substr(uniqid(sha1(time())),0,6));
        $rand = rand(000,999);
        $Trx_id = $today . $rand;
		

        {
            $this->validate($request, [
                'session' => 'required',
                'term' => 'required',
                'class' => 'required',
                'mode' => 'required',
                'Payment' => 'required',
                'Amount_Expected' => 'required',
                'Amount_Paid' => 'required',
                
            ]);

            //check the transaction to be sure it's not an override transaction!
            $Check_Trx = other_ledger::where([['SAN_id', $SAN_id],['payment', $request->input('Payment')],['session', $request->input('session')],['term', $request->input('term')],['stu_class', $request->input('class')]])->get();

            if($Check_Trx->isEmpty()) {
                
                 //Create a new school fees payment transaction for a student.
                $O_TRX = new other_trx;
                $O_TRX->Trx_id = $Trx_id;
                $O_TRX->Ref_Trx_id = $request->input('Ref_Trx_id');
                $O_TRX->SAN_id = $SAN_id;
                $O_TRX->payment_by = Auth::user()->name;
                $O_TRX->session = $request->input('session');
                $O_TRX->class = $request->input('class');
                $O_TRX->term = $request->input('term');
                $O_TRX->payment = $request->input('Payment');
                $O_TRX->amount_expected = $request->input('Amount_Expected');
                $O_TRX->amount_paid = $request->input('Amount_Paid');
                $Balance = $request->input('Amount_Expected') - $request->input('Amount_Paid');
                $O_TRX->balance = $Balance;
                if ($Balance > 0 ) {
                    $O_TRX->Payment_Status = "D";
                } else {
                    $O_TRX->Payment_Status = "C";
                }
                $O_TRX->payment_mode = $request->input('mode');
                $O_TRX->bank = $request->input('bank');
                $O_TRX->comment = $request->input('comment');
                $O_TRX->save();
                
                return redirect('/Other/Fees/Summary/'.$SAN_id.'/'.$Trx_id)->with('success', "PAYMENT SUCCESFUL");

            } else { 
                return redirect('/Other/Fees/Select/Payment/'.$SAN_id)->with('error', "DUPLICATE TRANSACTION!! - PROCEED USING [OUTSTANDING PAYMENT] TO PAY");
            }

        }  
    }

    /**
     * Show new school fees payment summary.
     *
     *@param  int  $SAN_id 
     *@param  int  $Trx_id
     *@return \Illuminate\Http\Response
     */
    public function otherfee_summary ($SAN_id, $Trx_id) {

        /** 
         * I used a subquery here to query for the particular Students in selected class and  
         * also subqueried for class name.
         */ 
        $Student = (student::addSelect(['class_name' => stu_class::select('stu_class_name')
                    ->whereColumn('class', 'id')
                 ]))->where('SAN_id', $SAN_id)
                ->get();


        $TRX = (other_trx::addSelect(['session' => sch_session::select('sessions')
                    ->whereColumn('session', 'id')
                    ]))->where('Trx_id', $Trx_id)
                    ->get();

        $TRX_TERM = (other_trx::addSelect(['terms' => sch_term::select('term')
        ->whereColumn('term', 'id')
        ]))->where('Trx_id', $Trx_id)
        ->get();

        $TRX_CLASS = (other_trx::addSelect(['class' => stu_class::select('stu_class_name')
        ->whereColumn('class', 'id')
        ]))->where('Trx_id', $Trx_id)
        ->get();

        $TRX_MODE = (other_trx::addSelect(['modes' => payment_modes::select('modes')
        ->whereColumn('payment_mode','id')
        ]))->where('Trx_id', $Trx_id)
        ->get();

        $TRX_BANK = (other_trx::addSelect(['bank' => banks::select('banks')
        ->whereColumn('bank', 'id')
        ]))->where('Trx_id', $Trx_id)
        ->get();

        $PAYMENT = (other_trx::addSelect(['payment' => income_category::select('income_category')
        ->whereColumn('payment', 'id')
        ]))->where('Trx_id', $Trx_id)
        ->get();


        
        return view('accountant.summary_other_payment')->with('Student', $Student)
                                                    ->with('TRX', $TRX)
                                                    ->with('TRX_TERM', $TRX_TERM)
                                                    ->with('TRX_CLASS', $TRX_CLASS)
                                                    ->with('TRX_MODE', $TRX_MODE)
                                                    ->with('TRX_BANK', $TRX_BANK)
                                                    ->with('PAYMENT', $PAYMENT);
    }

    /**
     * On clicking the confirm transaction from School fees summary page
     * the transaction status is confirmed in the Database and Receipt Generated.
     *
     *@param  int  $SAN_id 
     *@param  int  $Trx_id
     *@return \Illuminate\Http\Response
     */
    public function confirm_otherfee_payment ($SAN_id, $Trx_id) {

        $TRX = other_trx::where('Trx_id', $Trx_id)->get();
        //check the transaction to be sure it's not an override transaction!
        $Check_Trx = other_ledger::where([['SAN_id', $SAN_id],['payment', $TRX[0]['payment']],['session', $TRX[0]['session']],['term', $TRX[0]['term']],['stu_class', $TRX[0]['class']]])->get();
        
        if($Check_Trx->isEmpty()) {

                $Payment_Status; 

                $TRX_Status = other_trx::where('Trx_id', $Trx_id)
                                    ->update(['Trx_Status' => "111"]);

                $TRX = other_trx::where('Trx_id',$Trx_id)->get();
                

                if ($TRX[0]['balance'] > 0) {
                    $Payment_Status = 'D';
                } else {
                    $Payment_Status = 'C';
                }

                // $TRX = other_trx::where('Trx_id', $Trx_id)->get();
                $ledger = other_ledger::updateOrCreate(
                    ['SAN_id' => $SAN_id, 'session' => $TRX[0]['session'], 'term' => $TRX[0]['term'], 'payment' => $TRX[0]['payment']],
                    ['stu_class' => $TRX[0]['class'], 
                    'total_expected' => encrypt($TRX[0]['amount_expected']),
                    'total_paid' => encrypt($TRX[0]['amount_paid']),
                    'balance' => encrypt($TRX[0]['balance']),
                    'payment_status' => $Payment_Status,
                    ]
                    
                );
                
                return redirect('/Other/Fees/Summary/'.$SAN_id.'/'.$Trx_id)->with('confirmed', "TRANSACTION CONFIRMED!");

        } else {
            return redirect('/Other/Fees/Summary/'.$SAN_id.'/'.$Trx_id)->with('error', "DUPLICATE TRANSACTION or TRANSACTION CONFIRMED ALREADY!! - IT WOULD OVERRIDE EXISTING PAYMENT");
        }

        
    }

    /////////////////////////

    /**
     * Show the form for selecting payment balance.
     * 
     *@param  int  $SAN_id
     *@return \Illuminate\Http\Response
     */
    public function otherfee_select_balance_form ($SAN_id) {

        /** 
         * I used a subquery here to query for the particular Students in selected class and  
         * also subqueried for class name.
         */ 
        $Student = (student::addSelect(['class_name' => stu_class::select('stu_class_name')
                    ->whereColumn('class', 'id')
                 ]))->where('SAN_id', $SAN_id)
                ->get();

        $Payments = income_category::where('business', 'BRIGHTER SCHOOL')->get();
        $Sessions = sch_session::all();
        $Terms = sch_term::all();
        $Stu_Class = stu_class::all();
        return view('accountant.otherfees_select_balance_form', COMPACT('Student','Payments','Sessions','Terms','Stu_Class'));
    }

    /**
     * Show the form for collecting other fees payment.
     * 
     *@param  int  $SAN_id
     *@return \Illuminate\Http\Response
     *@return \Illuminate\Http\Response
     */
    public function otherfee_balance_payment_form (Request $request, $SAN_id) {

        $this->validate($request, [
            'Payment' => 'required',
            'session' => 'required',
            'term' => 'required',
            'class' => 'required',    
        ]);

        $Selected_Class = $request->input('class');
        $Selected_Session = $request->input('session');
        $Selected_Term = $request->input('term');
        $Selected_Payment = $request->input('Payment');
        $P_Balance = other_ledger::where([['SAN_id', $SAN_id],['Payment', $Selected_Payment], ['stu_class', $Selected_Class],['session', $Selected_Session],['term', $Selected_Term],['payment_status', "D"]])->get();
        //dd($P_Balance);

        if($P_Balance->isEmpty()) {
            return redirect('/Other/Fees/Select/Balance/'.$SAN_id)->with('error', "NO PREVIOUS TRANSACTION!! or NO PENDING BALANCE PAYMENT!!");
        } else { 
            /** 
             * I used a subquery here to query for the particular Students in selected class and  
             * also subqueried for class name.
             */ 
            $Student = (student::addSelect(['class_name' => stu_class::select('stu_class_name')
                    ->whereColumn('class', 'id')
                ]))->where('SAN_id', $SAN_id)
                ->get();

            $Sessions = sch_session::all();
            $Terms = sch_term::all();
            $Stu_Class = stu_class::all();
            $Modes = payment_modes::where([['modes', '!=', ''],['status', 1]])->get();
            $Banks = banks::where([['banks', '!=', ''],['status', 1]])->get();
            $Payment = income_category::all();
            return view('accountant.otherfees_balance_payment_form',COMPACT('Student','Sessions','Terms','Modes','Banks','Stu_Class',
                                                                            'Selected_Class','Selected_Session','Selected_Term','Selected_Payment',
                                                                            'P_Balance','Payment'));

                }


        
    }


    /**
     * Process other fees Balance Payment and save to DB.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $SAN_id
     * @return \Illuminate\Http\Response
     */
    public function process_otherfee_balance (Request $request, $SAN_id)
    {

        $today = date("md");
        //$rand = strtoupper(substr(uniqid(sha1(time())),0,6));
        $rand = rand(000,999);
        $Trx_id = $today . $rand;
		
        {
            $this->validate($request, [
                'Ref_Trx_id' => 'required',
                'session' => 'required',
                'term' => 'required',
                'class' => 'required',
                'mode' => 'required',
                'Payment' => 'required',
                'Amount_Expected' => 'required',
                'Amount_Paid' => 'required',
                
            ]);

            //check the previous/reference transaction id to be valid and for a the student 
            $Check_Ref = other_trx::where([['Trx_id', $request->input('Ref_Trx_id')],['SAN_id', $SAN_id]])->get();

            if($Check_Ref->isEmpty()) {
                return redirect('/Other/Fees/Select/Balance/'.$SAN_id)->with('error', "INVALID PREVIOUS TRANSACTION REF ID ENTERED!!! -  PLEASE CHECK");
            } else { 
                //Create a new school fees payment transaction for a student.
                $O_TRX = new other_trx;
                $O_TRX->Trx_id = $Trx_id;
                $O_TRX->Ref_Trx_id = $request->input('Ref_Trx_id');
                $O_TRX->SAN_id = $SAN_id;
                $O_TRX->payment_by = Auth::user()->name;
                $O_TRX->session = $request->input('session');
                $O_TRX->class = $request->input('class');
                $O_TRX->term = $request->input('term');
                $O_TRX->payment = $request->input('Payment');
                $O_TRX->amount_expected = $request->input('Amount_Expected');
                $O_TRX->amount_paid = $request->input('Amount_Paid');
                $Balance = $request->input('Amount_Expected') - $request->input('Amount_Paid');
                $O_TRX->balance = $Balance;
                if ($Balance > 0 ) {
                    $O_TRX->Payment_Status = "D";
                } else {
                    $O_TRX->Payment_Status = "C";
                }
                $O_TRX->payment_mode = $request->input('mode');
                $O_TRX->bank = $request->input('bank');
                $O_TRX->comment = $request->input('comment');
                $O_TRX->save();

                return redirect('/Other/Fees/Balance/Summary/'.$SAN_id.'/'.$Trx_id)->with('success', "PAYMENT SUCCESFUL");
                }
        }    
    }

    /**
     * Show new school fees payment summary.
     *
     *@param  int  $SAN_id 
     *@param  int  $Trx_id
     *@return \Illuminate\Http\Response
     */
    public function otherfee_balance_summary ($SAN_id, $Trx_id) {

        /** 
         * I used a subquery here to query for the particular Students in selected class and  
         * also subqueried for class name.
         */ 
        $Student = (student::addSelect(['class_name' => stu_class::select('stu_class_name')
                    ->whereColumn('class', 'id')
                 ]))->where('SAN_id', $SAN_id)
                ->get();


        $TRX = (other_trx::addSelect(['session' => sch_session::select('sessions')
                    ->whereColumn('session', 'id')
                    ]))->where('Trx_id', $Trx_id)
                    ->get();

        $TRX_TERM = (other_trx::addSelect(['terms' => sch_term::select('term')
        ->whereColumn('term', 'id')
        ]))->where('Trx_id', $Trx_id)
        ->get();

        $TRX_CLASS = (other_trx::addSelect(['class' => stu_class::select('stu_class_name')
        ->whereColumn('class', 'id')
        ]))->where('Trx_id', $Trx_id)
        ->get();

        $TRX_MODE = (other_trx::addSelect(['modes' => payment_modes::select('modes')
        ->whereColumn('payment_mode','id')
        ]))->where('Trx_id', $Trx_id)
        ->get();

        $TRX_BANK = (other_trx::addSelect(['bank' => banks::select('banks')
        ->whereColumn('bank', 'id')
        ]))->where('Trx_id', $Trx_id)
        ->get();

        $PAYMENT = (other_trx::addSelect(['payment' => income_category::select('income_category')
        ->whereColumn('payment', 'id')
        ]))->where('Trx_id', $Trx_id)
        ->get();


        
        return view('accountant.summary_other_payment_balance')->with('Student', $Student)
                                                                ->with('TRX', $TRX)
                                                                ->with('TRX_TERM', $TRX_TERM)
                                                                ->with('TRX_CLASS', $TRX_CLASS)
                                                                ->with('TRX_MODE', $TRX_MODE)
                                                                ->with('TRX_BANK', $TRX_BANK)
                                                                ->with('PAYMENT', $PAYMENT);
    }

    /**
     * On clicking the confirm transaction from School fees summary page
     * the transaction status is confirmed in the Database and Receipt Generated.
     *
     *@param  int  $SAN_id 
     *@param  int  $Trx_id
     *@return \Illuminate\Http\Response
     */
    public function confirm_otherfee_balance_payment ($SAN_id, $Trx_id) {

        // New Confirm Operation Starts Here!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

        $TRX = other_trx::where('Trx_id', $Trx_id)->get();

        $Check = other_ledger::where([['SAN_id', $SAN_id],['session', $TRX[0]['session']],['term', $TRX[0]['term']],['stu_class', $TRX[0]['class']]])->first();
        if ($Check->payment_status == "C") { 
            return redirect('/Other/Fees/Balance/Summary/'.$SAN_id.'/'.$Trx_id)->with('error', "DUPLICATE TRANSACTION (or) THE STUDENT HAS NO PENDING BALANCE TO PAY!!");
        } else { 
                $Payment_Status; 

                $TRX_Status = other_trx::where('Trx_id', $Trx_id)
                                    ->update(['Trx_Status' => "111"]);

                $TRX = other_trx::where('Trx_id',$Trx_id)->get();
                $L_TRX = other_ledger::where([['SAN_id', $SAN_id], ['session', $TRX[0]['session']], ['term', $TRX[0]['term']], ['payment', $TRX[0]['payment']],['stu_class', $TRX[0]['class']]])->get();
                

                if ($TRX[0]['balance'] > 0) {
                    $Payment_Status = 'D';
                } else {
                    $Payment_Status = 'C';
                }

                $Total_Paid = decrypt($L_TRX[0]['total_paid']) + $TRX[0]['amount_paid'];
                $New_Balance = $TRX[0]['balance'];

                //dd($Total_Paid);

                $ledger = other_ledger::where([['SAN_id', $SAN_id], ['session', $TRX[0]['session']], ['term', $TRX[0]['term']], ['payment', $TRX[0]['payment']],['stu_class', $TRX[0]['class']]])
                ->update(['total_paid' => encrypt($Total_Paid),
                          'balance' => encrypt($New_Balance),
                          'payment_status' => $Payment_Status,
                        ]);
                
                return redirect('/Other/Fees/Balance/Summary/'.$SAN_id.'/'.$Trx_id)->with('confirmed', "TRANSACTION CONFIRMED!");
        }     
    }

    ////////////////////////

    /**
     * Show a student other fees payment history.
     *
     *@param  int  $SAN_id 
     *@param  int  $Trx_id
     *@return \Illuminate\Http\Response
     */
    public function otherfee_history ($SAN_id) {

        $Student = (student::addSelect(['class' => stu_class::select('stu_class_name')
                    ->whereColumn('class', 'id')
                    ]))->where('SAN_id', $SAN_id)
                    ->get();

        // $TRX_JOIN = DB::table('schfee_balances')
        //         ->join('schfee_trxes', 'schfee_trxes.Trx_id', '=', 'schfee_balances.Trx_id')
        //         ->select('schfee_trxes.*', 'schfee_balances.*')
        //         ->where('Trx_Status', '111')
        //         ->get();

        $TRX = other_trx::where([['SAN_id', $SAN_id],['Trx_Status', 111]])->get();

        //dd ($TRX);

        $TRX_SESSION = sch_session::all();
        $TRX_TERM = sch_term::all();
        $TRX_CLASS = stu_class::all();
        $PAYMENT = income_category::all();
        //dd ($TRX_SESSION);
        
        
        return view('accountant.otherfee_payment_history')->with('TRX', $TRX)
                                                        ->with('Student', $Student)
                                                        ->with('TRX_TERM', $TRX_TERM)
                                                        ->with('TRX_CLASS', $TRX_CLASS)
                                                        ->with('TRX_SESSION', $TRX_SESSION)
                                                        ->with('PAYMENT', $PAYMENT);
    }

    /**
     * Show the form for entering Other Transaction Reference No:
     *
     * @return \Illuminate\Http\Response
     */
        public function other_fee_trx_details_1 ()
        {

            return view('accountant.other_trx_details_1');
        }    

    /**
     *Show Transaction Details.
     *
     *@param  int  $Trx_id
     *@param  Requset  $Request
     *@return \Illuminate\Http\Response
     */
    public function other_fee_trx_details (Request $request) {

            $this->validate($request, [
                'Trx_id' => 'required',  
            ]);

            $Trx_id =  $request->input('Trx_id');

            $TRX = other_trx::where('Trx_id', $Trx_id)->get();

            if (count($TRX) > 0) {
                $TRX_SESSION = sch_session::all();
                $TRX_CLASS = stu_class::all();
                $TRX_TERM = sch_term::all();
                $STUDENT = student::where('SAN_id', $TRX[0]['SAN_id'])->get();
                $Payment_Name = income_category::where('id', $TRX[0]['payment'])->get();
            
            return view('accountant.other_transaction_details')->with('TRX', $TRX)
                                                        ->with('TRX_SESSION', $TRX_SESSION)
                                                        ->with('TRX_CLASS', $TRX_CLASS)
                                                        ->with('TRX_TERM', $TRX_TERM)
                                                        ->with('STUDENT', $STUDENT)
                                                        ->with('Payment_Name', $Payment_Name);
                                                        
            } else {
                return redirect('/Other/Transaction')->with('warning', 'NO TRANSACTION FOUND!');
            }
    }

    /**
     *Show Transaction Details Linking.
     *
     *@param  int  $Trx_id
     *@param  Requset  $Request
     *@return \Illuminate\Http\Response
     */
    public function other_fee_trx_details_link ($Trx_id) {


        $TRX = other_trx::where('Trx_id', $Trx_id)->get();

        if (count($TRX) > 0) {
            $TRX_SESSION = sch_session::all();
            $TRX_CLASS = stu_class::all();
            $TRX_TERM = sch_term::all();
            $STUDENT = student::where('SAN_id', $TRX[0]['SAN_id'])->get();
            $Payment_Name = income_category::where('id', $TRX[0]['payment'])->get();
        
        return view('accountant.other_transaction_details')->with('TRX', $TRX)
                                                    ->with('TRX_SESSION', $TRX_SESSION)
                                                    ->with('TRX_CLASS', $TRX_CLASS)
                                                    ->with('TRX_TERM', $TRX_TERM)
                                                    ->with('STUDENT', $STUDENT)
                                                    ->with('Payment_Name', $Payment_Name);
                                                    
        } else {
            return redirect('/Other/Transaction')->with('warning', 'NO TRANSACTION FOUND!');
        }
    }

/******************************************************************************
                                 *                                            *
                                 * //HANDLING OTHER FEES REPORTS OPERATIONS// *
                                 *                                            *
*******************************************************************************/

    /**
     * Form to accept [Payment, Class, Session and Term] for which cleared students payment report is to be generated.
     *
     * @return \Illuminate\Http\Response
     */
    public function o_cleared_students_1 ()
    { 
        $stu_class = stu_class::all();
        $session = sch_session::all();
        $term = sch_term::all();
        $Payments = income_category::where('business', 'BRIGHTER SCHOOL')->get();
        return view('accountant.op_cleared_query_form')->with('stu_class', $stu_class)
                                                       ->with('session', $session)
                                                       ->with('term', $term)
                                                       ->with('Payments', $Payments);
                                                      
    }

    /**
     * Display report.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function o_cleared_students (Request  $request)
    {
        $this->validate($request, [
            'Payment' => 'required',
            'Stu_Class' => 'required',
            'Stu_Session' => 'required',
            'Stu_Term' => 'required',
        ]);

        $Payment = $request->input('Payment');
        $Stu_Class = $request->input('Stu_Class');
        $Stu_Session = $request->input('Stu_Session');
        $Stu_Term = $request->input('Stu_Term');
 

        $C_STU = DB::table('students')
                ->join('other_ledgers', 'other_ledgers.SAN_id', '=', 'students.SAN_id')
                ->select('other_ledgers.*', 'students.*')
                ->where([['payment', $Payment], ['stu_class', $Stu_Class], ['session', $Stu_Session], ['term', $Stu_Term],['payment_status', 'C']])
                ->get();

        //dd ($C_STU);        
                
        if ($C_STU->isEmpty()) {
            return redirect('/Other/Cleared/Students')->with('warning', "No record Found!");   
        } else {
            $Class_Name = stu_class::where('id', $request->input('Stu_Class'))->get();
            $Payment_Name = income_category::where('id', $request->input('Payment'))->get();

            return view('accountant.op_cleared_students')->with('C_STU', $C_STU)
                                                      ->with('Class_Name', $Class_Name)
                                                      ->with('Payment_Name', $Payment_Name);
        }  

        
    }


    /**
     * Form to accept [Payment, Class, Session and Term] for which defaulting students payment report is to be generated.
     *
     * @return \Illuminate\Http\Response
     */
    public function o_default_students_1 ()
    { 
        $stu_class = stu_class::all();
        $session = sch_session::all();
        $term = sch_term::all();
        $Payments = income_category::where('business', 'BRIGHTER SCHOOL')->get();
        return view('accountant.op_default_query_form')->with('stu_class', $stu_class)
                                                       ->with('session', $session)
                                                       ->with('term', $term)
                                                       ->with('Payments', $Payments);
    }

    /**
     * Display report.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function o_defaulted_students (Request  $request)
    {
        $this->validate($request, [
            'Payment' => 'required',
            'Stu_Class' => 'required',
            'Stu_Session' => 'required',
            'Stu_Term' => 'required',
        ]);

        $Payment = $request->input('Payment');
        $Stu_Class = $request->input('Stu_Class');
        $Stu_Session = $request->input('Stu_Session');
        $Stu_Term = $request->input('Stu_Term');
 

        $C_STU = DB::table('students')
                ->join('other_ledgers', 'other_ledgers.SAN_id', '=', 'students.SAN_id')
                ->select('other_ledgers.*', 'students.*')
                ->where([['payment', $Payment], ['stu_class', $Stu_Class], ['session', $Stu_Session], ['term', $Stu_Term],['payment_status', 'D']])
                ->get();

        //dd ($C_STU);        
                
        if ($C_STU->isEmpty()) {
            return redirect('/Other/Defaulting/Students')->with('warning', "No record Found!");   
        } else {
            $Class_Name = stu_class::where('id', $request->input('Stu_Class'))->get();
            $Payment_Name = income_category::where('id', $request->input('Payment'))->get();

            return view('accountant.op_defaulted_students')->with('C_STU', $C_STU)
                                                      ->with('Class_Name', $Class_Name)
                                                      ->with('Payment_Name', $Payment_Name);
        }  
    }

/******************************************************************************
                                 *                                            *
                                 * //HANDLING ACCOUNTING OPERATIONS //        *
                                 *                                            *
*******************************************************************************/

    /**
     * Form to accept [Term] for which total school fees is to be generated.
     *
     * @return \Illuminate\Http\Response
     */
    public function total_schfee_term_trx_1 ()
    { 
       
        $term = sch_term::all();
        
        return view('accountant.total_schfee_term_query_form')->with('term', $term);
                                                      
    }

    /**
     * Display report.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function total_schfee_term_trx (Request  $request)
    {
        $this->validate($request, [
            'Stu_Term' => 'required',
        ]);

        $Stu_Term = $request->input('Stu_Term');

        $TRX = trx_schfee_ledger::where('term', $Stu_Term)->get();
        
        $TERM = sch_term::where('id', $Stu_Term)->get();

        $TOTAL = 0;
        $COUNT = count($TRX);
        $Field_1_TOTAL = 0;
        $Field_1_DISCOUNT = 0;
        $Field_1_BALANCE = 0;

        $Field_2_TOTAL = 0;
        $Field_2_DISCOUNT = 0;
        $Field_2_BALANCE = 0;

        $Field_3_TOTAL = 0;
        $Field_3_DISCOUNT = 0;
        $Field_3_BALANCE = 0;

        $Field_4_TOTAL = 0;
        $Field_4_DISCOUNT = 0;
        $Field_4_BALANCE = 0;

        $Field_5_TOTAL = 0;
        $Field_5_DISCOUNT = 0;
        $Field_5_BALANCE = 0;

        $Field_6_TOTAL = 0;
        $Field_6_DISCOUNT = 0;
        $Field_6_BALANCE = 0;

        $Field_7_TOTAL = 0;
        $Field_7_DISCOUNT = 0;
        $Field_7_BALANCE = 0;
        
        $Field_8_TOTAL = 0;
        $Field_8_DISCOUNT = 0;
        $Field_8_BALANCE = 0;

        $Field_9_TOTAL = 0;
        $Field_9_DISCOUNT = 0;
        $Field_9_BALANCE = 0;
        
        $Field_10_TOTAL = 0;
        $Field_10_DISCOUNT = 0;
        $Field_10_BALANCE = 0;

        $Field_11_TOTAL = 0;
        $Field_11_DISCOUNT = 0;
        $Field_11_BALANCE = 0;

        $Field_12_TOTAL = 0;
        $Field_12_DISCOUNT = 0;
        $Field_12_BALANCE = 0;

        $Field_13_TOTAL = 0;
        $Field_13_DISCOUNT = 0;
        $Field_13_BALANCE = 0;

        $Field_14_TOTAL = 0;
        $Field_14_DISCOUNT = 0;
        $Field_14_BALANCE = 0;

        $Field_15_TOTAL = 0;
        $Field_15_DISCOUNT = 0;
        $Field_15_BALANCE = 0;

        foreach($TRX as $trx) {
            $Field_1_TOTAL += $trx->Field_1_paid;
            $Field_1_DISCOUNT += $trx->Field_1_discount;
            $Field_1_BALANCE += $trx->Field_1_balance;

            $Field_2_TOTAL += $trx->Field_2_paid;
            $Field_2_DISCOUNT += $trx->Field_2_discount;
            $Field_2_BALANCE += $trx->Field_2_balance;

            $Field_3_TOTAL += $trx->Field_3_paid;
            $Field_3_DISCOUNT += $trx->Field_3_discount;
            $Field_3_BALANCE += $trx->Field_3_balance;

            $Field_4_TOTAL += $trx->Field_4_paid;
            $Field_4_DISCOUNT += $trx->Field_4_discount;
            $Field_4_BALANCE += $trx->Field_4_balance;

            $Field_5_TOTAL += $trx->Field_5_paid;
            $Field_5_DISCOUNT += $trx->Field_5_discount;
            $Field_5_BALANCE += $trx->Field_5_balance;

            $Field_6_TOTAL += $trx->Field_6_paid;
            $Field_6_DISCOUNT += $trx->Field_6_discount;
            $Field_6_BALANCE += $trx->Field_6_balance;

            $Field_7_TOTAL += $trx->Field_7_paid;
            $Field_7_DISCOUNT += $trx->Field_7_discount;
            $Field_7_BALANCE += $trx->Field_7_balance;

            $Field_8_TOTAL += $trx->Field_8_paid;
            $Field_8_DISCOUNT += $trx->Field_8_discount;
            $Field_8_BALANCE += $trx->Field_8_balance;

            $Field_9_TOTAL += $trx->Field_9_paid;
            $Field_9_DISCOUNT += $trx->Field_9_discount;
            $Field_9_BALANCE += $trx->Field_9_balance;

            $Field_10_TOTAL += $trx->Field_10_paid;
            $Field_10_DISCOUNT += $trx->Field_10_discount;
            $Field_10_BALANCE += $trx->Field_10_balance;

            $Field_11_TOTAL += $trx->Field_11_paid;
            $Field_11_DISCOUNT += $trx->Field_11_discount;
            $Field_11_BALANCE += $trx->Field_11_balance;
            
            $Field_12_TOTAL += $trx->Field_12_paid;
            $Field_12_DISCOUNT += $trx->Field_12_discount;
            $Field_12_BALANCE += $trx->Field_12_balance;

            $Field_13_TOTAL += $trx->Field_13_paid;
            $Field_13_DISCOUNT += $trx->Field_13_discount;
            $Field_13_BALANCE += $trx->Field_13_balance;

            $Field_14_TOTAL += $trx->Field_14_paid;
            $Field_14_DISCOUNT += $trx->Field_14_discount;
            $Field_14_BALANCE += $trx->Field_14_balance;

            $Field_15_TOTAL += $trx->Field_15_paid;
            $Field_15_DISCOUNT += $trx->Field_15_discount;
            $Field_15_BALANCE += $trx->Field_15_balance;
         }
         
        $Name_1 = Schfee_Field::where('id', 1)->select('name')->get();
        $Name_2 = Schfee_Field::where('id', 2)->select('name')->get();
        $Name_3 = Schfee_Field::where('id', 3)->select('name')->get();
        $Name_4 = Schfee_Field::where('id', 4)->select('name')->get();
        $Name_5 = Schfee_Field::where('id', 5)->select('name')->get();
        $Name_6 = Schfee_Field::where('id', 6)->select('name')->get();
        $Name_7 = Schfee_Field::where('id', 7)->select('name')->get();
        $Name_8 = Schfee_Field::where('id', 8)->select('name')->get();
        $Name_9 = Schfee_Field::where('id', 9)->select('name')->get();
        $Name_10 = Schfee_Field::where('id', 10)->select('name')->get();
        $Name_11 = Schfee_Field::where('id', 11)->select('name')->get();
        $Name_12 = Schfee_Field::where('id', 12)->select('name')->get();
        $Name_13 = Schfee_Field::where('id', 13)->select('name')->get();
        $Name_14 = Schfee_Field::where('id', 14)->select('name')->get();
        $Name_15 = Schfee_Field::where('id', 15)->select('name')->get();

            return view('accountant.schfee_analysis_term',compact('COUNT','TERM','Name_1','Name_2','Name_3','Name_4','Name_5','Name_6','Name_7','Name_8','Name_9','Name_10','Name_11','Name_12','Name_13','Name_14','Name_15',
                                                                  'Field_1_TOTAL','Field_1_DISCOUNT','Field_1_BALANCE','Field_2_TOTAL','Field_2_DISCOUNT','Field_2_BALANCE','Field_3_TOTAL','Field_3_DISCOUNT','Field_3_BALANCE',
                                                                  'Field_4_TOTAL','Field_4_DISCOUNT','Field_4_BALANCE','Field_5_TOTAL','Field_5_DISCOUNT','Field_5_BALANCE','Field_6_TOTAL','Field_6_DISCOUNT','Field_6_BALANCE',
                                                                  'Field_7_TOTAL','Field_7_DISCOUNT','Field_7_BALANCE','Field_8_TOTAL','Field_8_DISCOUNT','Field_8_BALANCE','Field_9_TOTAL','Field_9_DISCOUNT','Field_9_BALANCE',
                                                                  'Field_10_TOTAL','Field_10_DISCOUNT','Field_10_BALANCE','Field_11_TOTAL','Field_11_DISCOUNT','Field_11_BALANCE','Field_12_TOTAL','Field_12_DISCOUNT','Field_12_BALANCE',
                                                                  'Field_13_TOTAL','Field_13_DISCOUNT','Field_13_BALANCE','Field_14_TOTAL','Field_14_DISCOUNT','Field_14_BALANCE','Field_15_TOTAL','Field_15_DISCOUNT','Field_15_BALANCE',
                                                                    ));

        
    }

    /**
     * Form to accept [Session] for which total school fees is to be generated.
     *
     * @return \Illuminate\Http\Response
     */
    public function total_schfee_sess_trx_1 ()
    { 
       
        $session = sch_session::all();
        
        return view('accountant.total_schfee_sess_query_form')->with('session', $session);
                                                      
    }

    /**
     * Display report.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function total_schfee_sess_trx (Request  $request)
    {
        $this->validate($request, [
            'Stu_Session' => 'required',
        ]);

        $Stu_Session = $request->input('Stu_Session');

        $TRX = trx_schfee_ledger::where('session', $Stu_Session)->get();

        $SESSION = sch_session::where('id', $Stu_Session)->get();

        $TOTAL = 0;
        $COUNT = count($TRX);
        $Field_1_TOTAL = 0;
        $Field_1_DISCOUNT = 0;
        $Field_1_BALANCE = 0;

        $Field_2_TOTAL = 0;
        $Field_2_DISCOUNT = 0;
        $Field_2_BALANCE = 0;

        $Field_3_TOTAL = 0;
        $Field_3_DISCOUNT = 0;
        $Field_3_BALANCE = 0;

        $Field_4_TOTAL = 0;
        $Field_4_DISCOUNT = 0;
        $Field_4_BALANCE = 0;

        $Field_5_TOTAL = 0;
        $Field_5_DISCOUNT = 0;
        $Field_5_BALANCE = 0;

        $Field_6_TOTAL = 0;
        $Field_6_DISCOUNT = 0;
        $Field_6_BALANCE = 0;

        $Field_7_TOTAL = 0;
        $Field_7_DISCOUNT = 0;
        $Field_7_BALANCE = 0;
        
        $Field_8_TOTAL = 0;
        $Field_8_DISCOUNT = 0;
        $Field_8_BALANCE = 0;

        $Field_9_TOTAL = 0;
        $Field_9_DISCOUNT = 0;
        $Field_9_BALANCE = 0;
        
        $Field_10_TOTAL = 0;
        $Field_10_DISCOUNT = 0;
        $Field_10_BALANCE = 0;

        $Field_11_TOTAL = 0;
        $Field_11_DISCOUNT = 0;
        $Field_11_BALANCE = 0;

        $Field_12_TOTAL = 0;
        $Field_12_DISCOUNT = 0;
        $Field_12_BALANCE = 0;

        $Field_13_TOTAL = 0;
        $Field_13_DISCOUNT = 0;
        $Field_13_BALANCE = 0;

        $Field_14_TOTAL = 0;
        $Field_14_DISCOUNT = 0;
        $Field_14_BALANCE = 0;

        $Field_15_TOTAL = 0;
        $Field_15_DISCOUNT = 0;
        $Field_15_BALANCE = 0;

        foreach($TRX as $trx) {
            $Field_1_TOTAL += $trx->Field_1_paid;
            $Field_1_DISCOUNT += $trx->Field_1_discount;
            $Field_1_BALANCE += $trx->Field_1_balance;

            $Field_2_TOTAL += $trx->Field_2_paid;
            $Field_2_DISCOUNT += $trx->Field_2_discount;
            $Field_2_BALANCE += $trx->Field_2_balance;

            $Field_3_TOTAL += $trx->Field_3_paid;
            $Field_3_DISCOUNT += $trx->Field_3_discount;
            $Field_3_BALANCE += $trx->Field_3_balance;

            $Field_4_TOTAL += $trx->Field_4_paid;
            $Field_4_DISCOUNT += $trx->Field_4_discount;
            $Field_4_BALANCE += $trx->Field_4_balance;

            $Field_5_TOTAL += $trx->Field_5_paid;
            $Field_5_DISCOUNT += $trx->Field_5_discount;
            $Field_5_BALANCE += $trx->Field_5_balance;

            $Field_6_TOTAL += $trx->Field_6_paid;
            $Field_6_DISCOUNT += $trx->Field_6_discount;
            $Field_6_BALANCE += $trx->Field_6_balance;

            $Field_7_TOTAL += $trx->Field_7_paid;
            $Field_7_DISCOUNT += $trx->Field_7_discount;
            $Field_7_BALANCE += $trx->Field_7_balance;

            $Field_8_TOTAL += $trx->Field_8_paid;
            $Field_8_DISCOUNT += $trx->Field_8_discount;
            $Field_8_BALANCE += $trx->Field_8_balance;

            $Field_9_TOTAL += $trx->Field_9_paid;
            $Field_9_DISCOUNT += $trx->Field_9_discount;
            $Field_9_BALANCE += $trx->Field_9_balance;

            $Field_10_TOTAL += $trx->Field_10_paid;
            $Field_10_DISCOUNT += $trx->Field_10_discount;
            $Field_10_BALANCE += $trx->Field_10_balance;

            $Field_11_TOTAL += $trx->Field_11_paid;
            $Field_11_DISCOUNT += $trx->Field_11_discount;
            $Field_11_BALANCE += $trx->Field_11_balance;
            
            $Field_12_TOTAL += $trx->Field_12_paid;
            $Field_12_DISCOUNT += $trx->Field_12_discount;
            $Field_12_BALANCE += $trx->Field_12_balance;

            $Field_13_TOTAL += $trx->Field_13_paid;
            $Field_13_DISCOUNT += $trx->Field_13_discount;
            $Field_13_BALANCE += $trx->Field_13_balance;

            $Field_14_TOTAL += $trx->Field_14_paid;
            $Field_14_DISCOUNT += $trx->Field_14_discount;
            $Field_14_BALANCE += $trx->Field_14_balance;

            $Field_15_TOTAL += $trx->Field_15_paid;
            $Field_15_DISCOUNT += $trx->Field_15_discount;
            $Field_15_BALANCE += $trx->Field_15_balance;
         }
         
        $Name_1 = Schfee_Field::where('id', 1)->select('name')->get();
        $Name_2 = Schfee_Field::where('id', 2)->select('name')->get();
        $Name_3 = Schfee_Field::where('id', 3)->select('name')->get();
        $Name_4 = Schfee_Field::where('id', 4)->select('name')->get();
        $Name_5 = Schfee_Field::where('id', 5)->select('name')->get();
        $Name_6 = Schfee_Field::where('id', 6)->select('name')->get();
        $Name_7 = Schfee_Field::where('id', 7)->select('name')->get();
        $Name_8 = Schfee_Field::where('id', 8)->select('name')->get();
        $Name_9 = Schfee_Field::where('id', 9)->select('name')->get();
        $Name_10 = Schfee_Field::where('id', 10)->select('name')->get();
        $Name_11 = Schfee_Field::where('id', 11)->select('name')->get();
        $Name_12 = Schfee_Field::where('id', 12)->select('name')->get();
        $Name_13 = Schfee_Field::where('id', 13)->select('name')->get();
        $Name_14 = Schfee_Field::where('id', 14)->select('name')->get();
        $Name_15 = Schfee_Field::where('id', 15)->select('name')->get();


        return view('accountant.schfee_analysis_session',compact('COUNT','SESSION','Name_1','Name_2','Name_3','Name_4','Name_5','Name_6','Name_7','Name_8','Name_9','Name_10','Name_11','Name_12','Name_13','Name_14','Name_15',
                                                              'Field_1_TOTAL','Field_1_DISCOUNT','Field_1_BALANCE','Field_2_TOTAL','Field_2_DISCOUNT','Field_2_BALANCE','Field_3_TOTAL','Field_3_DISCOUNT','Field_3_BALANCE',
                                                              'Field_4_TOTAL','Field_4_DISCOUNT','Field_4_BALANCE','Field_5_TOTAL','Field_5_DISCOUNT','Field_5_BALANCE','Field_6_TOTAL','Field_6_DISCOUNT','Field_6_BALANCE',
                                                              'Field_7_TOTAL','Field_7_DISCOUNT','Field_7_BALANCE','Field_8_TOTAL','Field_8_DISCOUNT','Field_8_BALANCE','Field_9_TOTAL','Field_9_DISCOUNT','Field_9_BALANCE',
                                                              'Field_10_TOTAL','Field_10_DISCOUNT','Field_10_BALANCE','Field_11_TOTAL','Field_11_DISCOUNT','Field_11_BALANCE','Field_12_TOTAL','Field_12_DISCOUNT','Field_12_BALANCE',
                                                              'Field_13_TOTAL','Field_13_DISCOUNT','Field_13_BALANCE','Field_14_TOTAL','Field_14_DISCOUNT','Field_14_BALANCE','Field_15_TOTAL','Field_15_DISCOUNT','Field_15_BALANCE',
                                                            ));

        
    }

    /**
     * Form to accept [Term] for which total of other payments is to be generated.
     *
     * @return \Illuminate\Http\Response
     */
    public function total_otherfee_term_trx_1 ()
    { 
       
        $Payments = income_category::where('business', 'BRIGHTER SCHOOL')->get();
        $term = sch_term::all();
        
        return view('accountant.total_otherfee_term_query_form')->with('Payments', $Payments)
                                                           ->with('term', $term);
                                                      
    }

    /**
     * Display report.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function total_otherfee_term_trx (Request  $request)
    {
        $this->validate($request, [
            'Payment' => 'required',
            'Stu_Term' => 'required',
        ]);

        $Payment =  $request->input('Payment');
        $Stu_Term = $request->input('Stu_Term');
        
            
        $TRX = other_ledger::where([['payment', $Payment],['term', $Stu_Term]])->get();

        //dd(decrypt($TRX[0]['total_expected']));
        $TERM = sch_term::where('id', $Stu_Term)->get();
        $Payment_Name = income_category::where('id', $request->input('Payment'))->get();

        $TOTAL_PAID = 0;
        $BALANCE = 0;
        $COUNT = count($TRX);

        
        foreach($TRX as $trx) {
            $TOTAL_PAID += (decrypt($trx->total_paid));
            $BALANCE += (decrypt($trx->balance));
            
         }

         $TOTAL = $TOTAL_PAID + $BALANCE;
             

        return view('accountant.total_otherfee_term_receipts',compact('TOTAL_PAID', 
                                                                 'BALANCE',   
                                                                 'COUNT',   
                                                                 'TOTAL',   
                                                                 'TERM',
                                                                 'Payment_Name'));

        
    }

    /**
     * Form to accept [Term] for which total of other payments is to be generated.
     *
     * @return \Illuminate\Http\Response
     */
    public function total_otherfee_sess_trx_1 ()
    { 
       
        $Payments = income_category::where('business', 'BRIGHTER SCHOOL')->get();
        $session = sch_session::all();
        
        return view('accountant.total_otherfee_sess_query_form')->with('Payments', $Payments)
                                                           ->with('session', $session);
                                                      
    }

    /**
     * Display report.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function total_otherfee_sess_trx (Request  $request)
    {
        $this->validate($request, [
            'Payment' => 'required',
            'Stu_Session' => 'required',
        ]);

        $Payment =  $request->input('Payment');
        $Stu_Session = $request->input('Stu_Session');
        
            
        $TRX = other_ledger::where([['payment', $Payment],['session', $Stu_Session]])->get();

        //dd(decrypt($TRX[0]['total_expected']));
        $SESSION = sch_session::where('id', $Stu_Session)->get();
        $Payment_Name = income_category::where('id', $request->input('Payment'))->get();

        $TOTAL_PAID = 0;
        $BALANCE = 0;
        $COUNT = count($TRX);

        
        foreach($TRX as $trx) {
            $TOTAL_PAID += (decrypt($trx->total_paid));
            $BALANCE += (decrypt($trx->balance));
            
         }

         $TOTAL = $TOTAL_PAID + $BALANCE;
             

        return view('accountant.total_otherfee_sess_receipts',compact('TOTAL_PAID', 
                                                                 'BALANCE',   
                                                                 'COUNT',   
                                                                 'TOTAL',   
                                                                 'SESSION',
                                                                 'Payment_Name'));

        
    }

    /**
     * Form to accept [Term] for which payment mode analysis is to be generated.
     *
     * @return \Illuminate\Http\Response
     */
    public function payment_mode_1 ()
    { 
       
        $term = sch_term::all();
        
        return view('accountant.payment_analysis_query_form')->with('term', $term);
                                                      
    }

    /**
     * Display report.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function payment_mode (Request  $request)
    {
        $this->validate($request, [
            'Stu_Term' => 'required',
        ]);

        $Term = $request->input('Stu_Term');
        $Selected_Term = sch_term::where('id', $Term)->get();
        $Modes = payment_modes::all();
        $Banks = banks::all();

        
        // Payment Mode 1 and Bank 1 School Fees Analysis Starts Here
        $Mode_1_STrx = trx_schfee::where([['payment_mode', 1],['term', $Term],['Trx_Status', 111]])->get();
        $Bank_1_STrx = trx_schfee::where([['bank', 1],['term', $Term],['Trx_Status', 111]])->get();
        $Mode_1_STotal = 0;
        $Bank_1_STotal = 0;
        foreach ($Mode_1_STrx as $Mode ){
            $Mode_1_STotal += $Mode->trx_total;
        }
        foreach ($Bank_1_STrx as $Bank ){
            $Bank_1_STotal += $Bank->trx_total;
        }
        // Analysis 1 Ends Here!

         // Payment Mode 2 and Bank 2 School Fees Analysis Starts Here
         $Mode_2_STrx = trx_schfee::where([['payment_mode', 2],['term', $Term],['Trx_Status', 111]])->get();
         $Bank_2_STrx = trx_schfee::where([['bank', 2],['term', $Term],['Trx_Status', 111]])->get();
         $Mode_2_STotal = 0;
         $Bank_2_STotal = 0;
         foreach ($Mode_2_STrx as $Mode ){
             $Mode_2_STotal += $Mode->trx_total;
         }
         foreach ($Bank_2_STrx as $Bank ){
             $Bank_2_STotal += $Bank->trx_total;
         }
         // Analysis 2 Ends Here!

         // Payment Mode 3 and Bank 3 School Fees Analysis Starts Here
         $Mode_3_STrx = trx_schfee::where([['payment_mode', 3],['term', $Term],['Trx_Status', 111]])->get();
         $Bank_3_STrx = trx_schfee::where([['bank', 3],['term', $Term],['Trx_Status', 111]])->get();
         $Mode_3_STotal = 0;
         $Bank_3_STotal = 0;
         foreach ($Mode_3_STrx as $Mode ){
             $Mode_3_STotal += $Mode->trx_total;
         }
         foreach ($Bank_3_STrx as $Bank ){
             $Bank_3_STotal += $Bank->trx_total;
         }
         // Analysis 3 Ends Here!

         // Payment Mode 4 and Bank 4 School Fees Analysis Starts Here
         $Mode_4_STrx = trx_schfee::where([['payment_mode', 4],['term', $Term],['Trx_Status', 111]])->get();
         $Bank_4_STrx = trx_schfee::where([['bank', 4],['term', $Term],['Trx_Status', 111]])->get();
         $Mode_4_STotal = 0;
         $Bank_4_STotal = 0;
         foreach ($Mode_4_STrx as $Mode ){
             $Mode_4_STotal += $Mode->trx_total;
         }
         foreach ($Bank_4_STrx as $Bank ){
             $Bank_4_STotal += $Bank->trx_total;
         }
         // Analysis 4 Ends Here!

         // Payment Mode 5 and Bank 5 School Fees Analysis Starts Here
         $Mode_5_STrx = trx_schfee::where([['payment_mode', 5],['term', $Term],['Trx_Status', 111]])->get();
         $Bank_5_STrx = trx_schfee::where([['bank', 5],['term', $Term],['Trx_Status', 111]])->get();
         $Mode_5_STotal = 0;
         $Bank_5_STotal = 0;
         foreach ($Mode_5_STrx as $Mode ){
             $Mode_5_STotal += $Mode->trx_total;
         }
         foreach ($Bank_5_STrx as $Bank ){
             $Bank_5_STotal += $Bank->trx_total;
         }
         // Analysis 5 Ends Here!

         // Payment Mode 6 and Bank 6 School Fees Analysis Starts Here
         $Mode_6_STrx = trx_schfee::where([['payment_mode', 6],['term', $Term],['Trx_Status', 111]])->get();
         $Bank_6_STrx = trx_schfee::where([['bank', 6],['term', $Term],['Trx_Status', 111]])->get();
         $Mode_6_STotal = 0;
         $Bank_6_STotal = 0;
         foreach ($Mode_6_STrx as $Mode ){
             $Mode_6_STotal += $Mode->trx_total;
         }
         foreach ($Bank_6_STrx as $Bank ){
             $Bank_6_STotal += $Bank->trx_total;
         }
         // Analysis 6 Ends Here!

         // Payment Mode 7 and Bank 7 School Fees Analysis Starts Here
         $Mode_7_STrx = trx_schfee::where([['payment_mode', 7],['term', $Term],['Trx_Status', 111]])->get();
         $Bank_7_STrx = trx_schfee::where([['bank', 7],['term', $Term],['Trx_Status', 111]])->get();
         $Mode_7_STotal = 0;
         $Bank_7_STotal = 0;
         foreach ($Mode_7_STrx as $Mode ){
             $Mode_7_STotal += $Mode->trx_total;
         }
         foreach ($Bank_7_STrx as $Bank ){
             $Bank_7_STotal += $Bank->trx_total;
         }
         // Analysis 7 Ends Here!

         // Payment Mode 8 and Bank 8 School Fees Analysis Starts Here
         $Mode_8_STrx = trx_schfee::where([['payment_mode', 8],['term', $Term],['Trx_Status', 111]])->get();
         $Bank_8_STrx = trx_schfee::where([['bank', 8],['term', $Term],['Trx_Status', 111]])->get();
         $Mode_8_STotal = 0;
         $Bank_8_STotal = 0;
         foreach ($Mode_8_STrx as $Mode ){
             $Mode_8_STotal += $Mode->trx_total;
         }
         foreach ($Bank_8_STrx as $Bank ){
             $Bank_8_STotal += $Bank->trx_total;
         }
         // Analysis 8 Ends Here!

         // Payment Mode 9 and Bank 9 School Fees Analysis Starts Here
         $Mode_9_STrx = trx_schfee::where([['payment_mode', 9],['term', $Term],['Trx_Status', 111]])->get();
         $Bank_9_STrx = trx_schfee::where([['bank', 9],['term', $Term],['Trx_Status', 111]])->get();
         $Mode_9_STotal = 0;
         $Bank_9_STotal = 0;
         foreach ($Mode_9_STrx as $Mode ){
             $Mode_9_STotal += $Mode->trx_total;
         }
         foreach ($Bank_9_STrx as $Bank ){
             $Bank_9_STotal += $Bank->trx_total;
         }
         // Analysis 9 Ends Here!

         // Payment Mode 10 and Bank 10 School Fees Analysis Starts Here
         $Mode_10_STrx = trx_schfee::where([['payment_mode', 10],['term', $Term],['Trx_Status', 111]])->get();
         $Bank_10_STrx = trx_schfee::where([['bank', 10],['term', $Term],['Trx_Status', 111]])->get();
         $Mode_10_STotal = 0;
         $Bank_10_STotal = 0;
         foreach ($Mode_10_STrx as $Mode ){
             $Mode_10_STotal += $Mode->trx_total;
         }
         foreach ($Bank_10_STrx as $Bank ){
             $Bank_10_STotal += $Bank->trx_total;
         }
         // Analysis 10 Ends Here!

            // Payment Mode 1 and Bank 1 Other Fees Analysis Starts Here
            $Mode_1_OTrx = other_trx::where([['payment_mode', 1],['term', $Term],['Trx_Status', 111]])->get();
            $Bank_1_OTrx = other_trx::where([['bank', 1],['term', $Term],['Trx_Status', 111]])->get();
            $Mode_1_OTotal = 0;
            $Bank_1_OTotal = 0;
            foreach ($Mode_1_OTrx as $Mode ){
                $Mode_1_OTotal += $Mode->amount_paid;
            }
            foreach ($Bank_1_OTrx as $Bank ){
                $Bank_1_OTotal += $Bank->amount_paid;
            }
            // Analysis 1 Ends Here!

            // Payment Mode 2 and Bank 2 Other Fees Analysis Starts Here
            $Mode_2_OTrx = other_trx::where([['payment_mode', 2],['term', $Term],['Trx_Status', 111]])->get();
            $Bank_2_OTrx = other_trx::where([['bank', 2],['term', $Term],['Trx_Status', 111]])->get();
            $Mode_2_OTotal = 0;
            $Bank_2_OTotal = 0;
            foreach ($Mode_2_OTrx as $Mode ){
                $Mode_2_OTotal += $Mode->amount_paid;
            }
            foreach ($Bank_2_OTrx as $Bank ){
                $Bank_2_OTotal += $Bank->amount_paid;
            }
            // Analysis 2 Ends Here!

            // Payment Mode 3 and Bank 3 Other Fees Analysis Starts Here
            $Mode_3_OTrx = other_trx::where([['payment_mode', 3],['term', $Term],['Trx_Status', 111]])->get();
            $Bank_3_OTrx = other_trx::where([['bank', 3],['term', $Term],['Trx_Status', 111]])->get();
            $Mode_3_OTotal = 0;
            $Bank_3_OTotal = 0;
            foreach ($Mode_3_OTrx as $Mode ){
                $Mode_3_OTotal += $Mode->amount_paid;
            }
            foreach ($Bank_3_OTrx as $Bank ){
                $Bank_3_OTotal += $Bank->amount_paid;
            }
            // Analysis 3 Ends Here!

            // Payment Mode 4 and Bank 4 Other Fees Analysis Starts Here
            $Mode_4_OTrx = other_trx::where([['payment_mode', 4],['term', $Term],['Trx_Status', 111]])->get();
            $Bank_4_OTrx = other_trx::where([['bank', 4],['term', $Term],['Trx_Status', 111]])->get();
            $Mode_4_OTotal = 0;
            $Bank_4_OTotal = 0;
            foreach ($Mode_4_OTrx as $Mode ){
                $Mode_4_OTotal += $Mode->amount_paid;
            }
            foreach ($Bank_4_OTrx as $Bank ){
                $Bank_4_OTotal += $Bank->amount_paid;
            }
            // Analysis 4 Ends Here!

            // Payment Mode 5 and Bank 5 Other Fees Analysis Starts Here
            $Mode_5_OTrx = other_trx::where([['payment_mode', 5],['term', $Term],['Trx_Status', 111]])->get();
            $Bank_5_OTrx = other_trx::where([['bank', 5],['term', $Term],['Trx_Status', 111]])->get();
            $Mode_5_OTotal = 0;
            $Bank_5_OTotal = 0;
            foreach ($Mode_5_OTrx as $Mode ){
                $Mode_5_OTotal += $Mode->amount_paid;
            }
            foreach ($Bank_5_OTrx as $Bank ){
                $Bank_5_OTotal += $Bank->amount_paid;
            }
            // Analysis 5 Ends Here!

            // Payment Mode 6 and Bank 6 Other Fees Analysis Starts Here
            $Mode_6_OTrx = other_trx::where([['payment_mode', 6],['term', $Term],['Trx_Status', 111]])->get();
            $Bank_6_OTrx = other_trx::where([['bank', 6],['term', $Term],['Trx_Status', 111]])->get();
            $Mode_6_OTotal = 0;
            $Bank_6_OTotal = 0;
            foreach ($Mode_6_OTrx as $Mode ){
                $Mode_6_OTotal += $Mode->amount_paid;
            }
            foreach ($Bank_6_OTrx as $Bank ){
                $Bank_6_OTotal += $Bank->amount_paid;
            }
            // Analysis 6 Ends Here!

            // Payment Mode 7 and Bank 7 Other Fees Analysis Starts Here
            $Mode_7_OTrx = other_trx::where([['payment_mode', 7],['term', $Term],['Trx_Status', 111]])->get();
            $Bank_7_OTrx = other_trx::where([['bank', 7],['term', $Term],['Trx_Status', 111]])->get();
            $Mode_7_OTotal = 0;
            $Bank_7_OTotal = 0;
            foreach ($Mode_7_OTrx as $Mode ){
                $Mode_7_OTotal += $Mode->amount_paid;
            }
            foreach ($Bank_7_OTrx as $Bank ){
                $Bank_7_OTotal += $Bank->amount_paid;
            }
            // Analysis 7 Ends Here!

            // Payment Mode 8 and Bank 8 Other Fees Analysis Starts Here
            $Mode_8_OTrx = other_trx::where([['payment_mode', 8],['term', $Term],['Trx_Status', 111]])->get();
            $Bank_8_OTrx = other_trx::where([['bank', 8],['term', $Term],['Trx_Status', 111]])->get();
            $Mode_8_OTotal = 0;
            $Bank_8_OTotal = 0;
            foreach ($Mode_8_OTrx as $Mode ){
                $Mode_8_OTotal += $Mode->amount_paid;
            }
            foreach ($Bank_8_OTrx as $Bank ){
                $Bank_8_OTotal += $Bank->amount_paid;
            }
            // Analysis 8 Ends Here!

            // Payment Mode 9 and Bank 9 Other Fees Analysis Starts Here
            $Mode_9_OTrx = other_trx::where([['payment_mode', 9],['term', $Term],['Trx_Status', 111]])->get();
            $Bank_9_OTrx = other_trx::where([['bank', 9],['term', $Term],['Trx_Status', 111]])->get();
            $Mode_9_OTotal = 0;
            $Bank_9_OTotal = 0;
            foreach ($Mode_9_OTrx as $Mode ){
                $Mode_9_OTotal += $Mode->amount_paid;
            }
            foreach ($Bank_9_OTrx as $Bank ){
                $Bank_9_OTotal += $Bank->amount_paid;
            }
            // Analysis 9 Ends Here!

            // Payment Mode 10 and Bank 10 Other Fees Analysis Starts Here
            $Mode_10_OTrx = other_trx::where([['payment_mode', 10],['term', $Term],['Trx_Status', 111]])->get();
            $Bank_10_OTrx = other_trx::where([['bank', 10],['term', $Term],['Trx_Status', 111]])->get();
            $Mode_10_OTotal = 0;
            $Bank_10_OTotal = 0;
            foreach ($Mode_10_OTrx as $Mode ){
                $Mode_10_OTotal += $Mode->amount_paid;
            }
            foreach ($Bank_10_OTrx as $Bank ){
                $Bank_10_OTotal += $Bank->amount_paid;
            }
            // Analysis 10 Ends Here!


        

        return view('accountant.payment_analysis', compact('Mode_1_STotal','Bank_1_STotal','Mode_2_STotal','Bank_2_STotal','Mode_3_STotal','Bank_3_STotal','Mode_4_STotal','Bank_4_STotal','Mode_5_STotal','Bank_5_STotal',
        'Mode_6_STotal','Bank_6_STotal','Mode_7_STotal','Bank_7_STotal','Mode_8_STotal','Bank_8_STotal','Mode_9_STotal','Bank_9_STotal','Mode_10_STotal','Bank_10_STotal',
        'Mode_1_OTotal','Bank_1_OTotal','Mode_2_OTotal','Bank_2_OTotal','Mode_3_OTotal','Bank_3_OTotal','Mode_4_OTotal','Bank_4_OTotal','Mode_5_OTotal','Bank_5_OTotal',
        'Mode_6_OTotal','Bank_6_OTotal','Mode_7_OTotal','Bank_7_OTotal','Mode_8_OTotal','Bank_8_OTotal','Mode_9_OTotal','Bank_9_OTotal','Mode_10_OTotal','Bank_10_OTotal',
        'Modes','Banks','Term','Selected_Term')); 
        
    }

    /**
     * Form to accept [Term] for which pre term school fees payment is to be generated.
     *
     * @return \Illuminate\Http\Response
     */
    public function pre_term_trx_1 ()
    { 
       
        $term = sch_term::all();
        
        return view('accountant.pre_term_query_form')->with('term', $term);
                                                      
    }

    /**
     * Display report.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function pre_term_trx (Request  $request)
    {
        $this->validate($request, [
            'Stu_Term' => 'required',
        ]);

        $Stu_Term = $request->input('Stu_Term');
        $TERM = sch_term::where('id', $Stu_Term)->get();

        $TRX = trx_schfee_ledger::where([['term', $Stu_Term],['created_at', '<',  $TERM[0]['start_date']]])->get();
        $TRX_COUNT = trx_schfee::all();

        $TOTAL = 0;
        $COUNT = count($TRX);
        $Field_1_TOTAL = 0;
        $Field_1_DISCOUNT = 0;
        $Field_1_BALANCE = 0;

        $Field_2_TOTAL = 0;
        $Field_2_DISCOUNT = 0;
        $Field_2_BALANCE = 0;

        $Field_3_TOTAL = 0;
        $Field_3_DISCOUNT = 0;
        $Field_3_BALANCE = 0;

        $Field_4_TOTAL = 0;
        $Field_4_DISCOUNT = 0;
        $Field_4_BALANCE = 0;

        $Field_5_TOTAL = 0;
        $Field_5_DISCOUNT = 0;
        $Field_5_BALANCE = 0;

        $Field_6_TOTAL = 0;
        $Field_6_DISCOUNT = 0;
        $Field_6_BALANCE = 0;

        $Field_7_TOTAL = 0;
        $Field_7_DISCOUNT = 0;
        $Field_7_BALANCE = 0;
        
        $Field_8_TOTAL = 0;
        $Field_8_DISCOUNT = 0;
        $Field_8_BALANCE = 0;

        $Field_9_TOTAL = 0;
        $Field_9_DISCOUNT = 0;
        $Field_9_BALANCE = 0;
        
        $Field_10_TOTAL = 0;
        $Field_10_DISCOUNT = 0;
        $Field_10_BALANCE = 0;

        $Field_11_TOTAL = 0;
        $Field_11_DISCOUNT = 0;
        $Field_11_BALANCE = 0;

        $Field_12_TOTAL = 0;
        $Field_12_DISCOUNT = 0;
        $Field_12_BALANCE = 0;

        $Field_13_TOTAL = 0;
        $Field_13_DISCOUNT = 0;
        $Field_13_BALANCE = 0;

        $Field_14_TOTAL = 0;
        $Field_14_DISCOUNT = 0;
        $Field_14_BALANCE = 0;

        $Field_15_TOTAL = 0;
        $Field_15_DISCOUNT = 0;
        $Field_15_BALANCE = 0;
        
        foreach($TRX as $trx) {
            $Field_1_TOTAL += $trx->Field_1_paid;
            $Field_1_DISCOUNT += $trx->Field_1_discount;
            $Field_1_BALANCE += $trx->Field_1_balance;

            $Field_2_TOTAL += $trx->Field_2_paid;
            $Field_2_DISCOUNT += $trx->Field_2_discount;
            $Field_2_BALANCE += $trx->Field_2_balance;

            $Field_3_TOTAL += $trx->Field_3_paid;
            $Field_3_DISCOUNT += $trx->Field_3_discount;
            $Field_3_BALANCE += $trx->Field_3_balance;

            $Field_4_TOTAL += $trx->Field_4_paid;
            $Field_4_DISCOUNT += $trx->Field_4_discount;
            $Field_4_BALANCE += $trx->Field_4_balance;

            $Field_5_TOTAL += $trx->Field_5_paid;
            $Field_5_DISCOUNT += $trx->Field_5_discount;
            $Field_5_BALANCE += $trx->Field_5_balance;

            $Field_6_TOTAL += $trx->Field_6_paid;
            $Field_6_DISCOUNT += $trx->Field_6_discount;
            $Field_6_BALANCE += $trx->Field_6_balance;

            $Field_7_TOTAL += $trx->Field_7_paid;
            $Field_7_DISCOUNT += $trx->Field_7_discount;
            $Field_7_BALANCE += $trx->Field_7_balance;

            $Field_8_TOTAL += $trx->Field_8_paid;
            $Field_8_DISCOUNT += $trx->Field_8_discount;
            $Field_8_BALANCE += $trx->Field_8_balance;

            $Field_9_TOTAL += $trx->Field_9_paid;
            $Field_9_DISCOUNT += $trx->Field_9_discount;
            $Field_9_BALANCE += $trx->Field_9_balance;

            $Field_10_TOTAL += $trx->Field_10_paid;
            $Field_10_DISCOUNT += $trx->Field_10_discount;
            $Field_10_BALANCE += $trx->Field_10_balance;

            $Field_11_TOTAL += $trx->Field_11_paid;
            $Field_11_DISCOUNT += $trx->Field_11_discount;
            $Field_11_BALANCE += $trx->Field_11_balance;
            
            $Field_12_TOTAL += $trx->Field_12_paid;
            $Field_12_DISCOUNT += $trx->Field_12_discount;
            $Field_12_BALANCE += $trx->Field_12_balance;

            $Field_13_TOTAL += $trx->Field_13_paid;
            $Field_13_DISCOUNT += $trx->Field_13_discount;
            $Field_13_BALANCE += $trx->Field_13_balance;

            $Field_14_TOTAL += $trx->Field_14_paid;
            $Field_14_DISCOUNT += $trx->Field_14_discount;
            $Field_14_BALANCE += $trx->Field_14_balance;

            $Field_15_TOTAL += $trx->Field_15_paid;
            $Field_15_DISCOUNT += $trx->Field_15_discount;
            $Field_15_BALANCE += $trx->Field_15_balance;
         }

                $Name_1 = Schfee_Field::where('id', 1)->select('name')->get();
                $Name_2 = Schfee_Field::where('id', 2)->select('name')->get();
                $Name_3 = Schfee_Field::where('id', 3)->select('name')->get();
                $Name_4 = Schfee_Field::where('id', 4)->select('name')->get();
                $Name_5 = Schfee_Field::where('id', 5)->select('name')->get();
                $Name_6 = Schfee_Field::where('id', 6)->select('name')->get();
                $Name_7 = Schfee_Field::where('id', 7)->select('name')->get();
                $Name_8 = Schfee_Field::where('id', 8)->select('name')->get();
                $Name_9 = Schfee_Field::where('id', 9)->select('name')->get();
                $Name_10 = Schfee_Field::where('id', 10)->select('name')->get();
                $Name_11 = Schfee_Field::where('id', 11)->select('name')->get();
                $Name_12 = Schfee_Field::where('id', 12)->select('name')->get();
                $Name_13 = Schfee_Field::where('id', 13)->select('name')->get();
                $Name_14 = Schfee_Field::where('id', 14)->select('name')->get();
                $Name_15 = Schfee_Field::where('id', 15)->select('name')->get();

        return view('accountant.pre_term_schfee_analysis',compact('COUNT','TERM','Name_1','Name_2','Name_3','Name_4','Name_5','Name_6','Name_7','Name_8','Name_9','Name_10','Name_11','Name_12','Name_13','Name_14','Name_15',
                                                                'Field_1_TOTAL','Field_1_DISCOUNT','Field_1_BALANCE','Field_2_TOTAL','Field_2_DISCOUNT','Field_2_BALANCE','Field_3_TOTAL','Field_3_DISCOUNT','Field_3_BALANCE',
                                                                'Field_4_TOTAL','Field_4_DISCOUNT','Field_4_BALANCE','Field_5_TOTAL','Field_5_DISCOUNT','Field_5_BALANCE','Field_6_TOTAL','Field_6_DISCOUNT','Field_6_BALANCE',
                                                                'Field_7_TOTAL','Field_7_DISCOUNT','Field_7_BALANCE','Field_8_TOTAL','Field_8_DISCOUNT','Field_8_BALANCE','Field_9_TOTAL','Field_9_DISCOUNT','Field_9_BALANCE',
                                                                'Field_10_TOTAL','Field_10_DISCOUNT','Field_10_BALANCE','Field_11_TOTAL','Field_11_DISCOUNT','Field_11_BALANCE','Field_12_TOTAL','Field_12_DISCOUNT','Field_12_BALANCE',
                                                                'Field_13_TOTAL','Field_13_DISCOUNT','Field_13_BALANCE','Field_14_TOTAL','Field_14_DISCOUNT','Field_14_BALANCE','Field_15_TOTAL','Field_15_DISCOUNT','Field_15_BALANCE',
                                                                    ));

        
    }

    /**
     * Form to accept [Term] for which post term school fees payment is to be generated.
     *
     * @return \Illuminate\Http\Response
     */
    public function post_term_trx_1 ()
    { 
       
        $term = sch_term::all();
        
        return view('accountant.post_term_query_form')->with('term', $term);
                                                      
    }

    /**
     * Display report.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function post_term_trx (Request  $request)
    {
        $this->validate($request, [
            'Stu_Term' => 'required',
        ]);

        $Stu_Term = $request->input('Stu_Term');
        $TERM = sch_term::where('id', $Stu_Term)->get();

        $TRX = trx_schfee_ledger::where([['term', $Stu_Term],['created_at', '>',  $TERM[0]['end_date']]])->get();
        $TRX_COUNT = trx_schfee::all();

        $TOTAL = 0;
        $COUNT = count($TRX);
        $Field_1_TOTAL = 0;
        $Field_1_DISCOUNT = 0;
        $Field_1_BALANCE = 0;

        $Field_2_TOTAL = 0;
        $Field_2_DISCOUNT = 0;
        $Field_2_BALANCE = 0;

        $Field_3_TOTAL = 0;
        $Field_3_DISCOUNT = 0;
        $Field_3_BALANCE = 0;

        $Field_4_TOTAL = 0;
        $Field_4_DISCOUNT = 0;
        $Field_4_BALANCE = 0;

        $Field_5_TOTAL = 0;
        $Field_5_DISCOUNT = 0;
        $Field_5_BALANCE = 0;

        $Field_6_TOTAL = 0;
        $Field_6_DISCOUNT = 0;
        $Field_6_BALANCE = 0;

        $Field_7_TOTAL = 0;
        $Field_7_DISCOUNT = 0;
        $Field_7_BALANCE = 0;
        
        $Field_8_TOTAL = 0;
        $Field_8_DISCOUNT = 0;
        $Field_8_BALANCE = 0;

        $Field_9_TOTAL = 0;
        $Field_9_DISCOUNT = 0;
        $Field_9_BALANCE = 0;
        
        $Field_10_TOTAL = 0;
        $Field_10_DISCOUNT = 0;
        $Field_10_BALANCE = 0;

        $Field_11_TOTAL = 0;
        $Field_11_DISCOUNT = 0;
        $Field_11_BALANCE = 0;

        $Field_12_TOTAL = 0;
        $Field_12_DISCOUNT = 0;
        $Field_12_BALANCE = 0;

        $Field_13_TOTAL = 0;
        $Field_13_DISCOUNT = 0;
        $Field_13_BALANCE = 0;

        $Field_14_TOTAL = 0;
        $Field_14_DISCOUNT = 0;
        $Field_14_BALANCE = 0;

        $Field_15_TOTAL = 0;
        $Field_15_DISCOUNT = 0;
        $Field_15_BALANCE = 0;

        
        foreach($TRX as $trx) {
            $Field_1_TOTAL += $trx->Field_1_paid;
            $Field_1_DISCOUNT += $trx->Field_1_discount;
            $Field_1_BALANCE += $trx->Field_1_balance;

            $Field_2_TOTAL += $trx->Field_2_paid;
            $Field_2_DISCOUNT += $trx->Field_2_discount;
            $Field_2_BALANCE += $trx->Field_2_balance;

            $Field_3_TOTAL += $trx->Field_3_paid;
            $Field_3_DISCOUNT += $trx->Field_3_discount;
            $Field_3_BALANCE += $trx->Field_3_balance;

            $Field_4_TOTAL += $trx->Field_4_paid;
            $Field_4_DISCOUNT += $trx->Field_4_discount;
            $Field_4_BALANCE += $trx->Field_4_balance;

            $Field_5_TOTAL += $trx->Field_5_paid;
            $Field_5_DISCOUNT += $trx->Field_5_discount;
            $Field_5_BALANCE += $trx->Field_5_balance;

            $Field_6_TOTAL += $trx->Field_6_paid;
            $Field_6_DISCOUNT += $trx->Field_6_discount;
            $Field_6_BALANCE += $trx->Field_6_balance;

            $Field_7_TOTAL += $trx->Field_7_paid;
            $Field_7_DISCOUNT += $trx->Field_7_discount;
            $Field_7_BALANCE += $trx->Field_7_balance;

            $Field_8_TOTAL += $trx->Field_8_paid;
            $Field_8_DISCOUNT += $trx->Field_8_discount;
            $Field_8_BALANCE += $trx->Field_8_balance;

            $Field_9_TOTAL += $trx->Field_9_paid;
            $Field_9_DISCOUNT += $trx->Field_9_discount;
            $Field_9_BALANCE += $trx->Field_9_balance;

            $Field_10_TOTAL += $trx->Field_10_paid;
            $Field_10_DISCOUNT += $trx->Field_10_discount;
            $Field_10_BALANCE += $trx->Field_10_balance;

            $Field_11_TOTAL += $trx->Field_11_paid;
            $Field_11_DISCOUNT += $trx->Field_11_discount;
            $Field_11_BALANCE += $trx->Field_11_balance;
            
            $Field_12_TOTAL += $trx->Field_12_paid;
            $Field_12_DISCOUNT += $trx->Field_12_discount;
            $Field_12_BALANCE += $trx->Field_12_balance;

            $Field_13_TOTAL += $trx->Field_13_paid;
            $Field_13_DISCOUNT += $trx->Field_13_discount;
            $Field_13_BALANCE += $trx->Field_13_balance;

            $Field_14_TOTAL += $trx->Field_14_paid;
            $Field_14_DISCOUNT += $trx->Field_14_discount;
            $Field_14_BALANCE += $trx->Field_14_balance;

            $Field_15_TOTAL += $trx->Field_15_paid;
            $Field_15_DISCOUNT += $trx->Field_15_discount;
            $Field_15_BALANCE += $trx->Field_15_balance;

         }

                $Name_1 = Schfee_Field::where('id', 1)->select('name')->get();
                $Name_2 = Schfee_Field::where('id', 2)->select('name')->get();
                $Name_3 = Schfee_Field::where('id', 3)->select('name')->get();
                $Name_4 = Schfee_Field::where('id', 4)->select('name')->get();
                $Name_5 = Schfee_Field::where('id', 5)->select('name')->get();
                $Name_6 = Schfee_Field::where('id', 6)->select('name')->get();
                $Name_7 = Schfee_Field::where('id', 7)->select('name')->get();
                $Name_8 = Schfee_Field::where('id', 8)->select('name')->get();
                $Name_9 = Schfee_Field::where('id', 9)->select('name')->get();
                $Name_10 = Schfee_Field::where('id', 10)->select('name')->get();
                $Name_11 = Schfee_Field::where('id', 11)->select('name')->get();
                $Name_12 = Schfee_Field::where('id', 12)->select('name')->get();
                $Name_13 = Schfee_Field::where('id', 13)->select('name')->get();
                $Name_14 = Schfee_Field::where('id', 14)->select('name')->get();
                $Name_15 = Schfee_Field::where('id', 15)->select('name')->get();

            return view('accountant.post_term_schfee_analysis',compact('COUNT','TERM','Name_1','Name_2','Name_3','Name_4','Name_5','Name_6','Name_7','Name_8','Name_9','Name_10','Name_11','Name_12','Name_13','Name_14','Name_15',
                                                                        'Field_1_TOTAL','Field_1_DISCOUNT','Field_1_BALANCE','Field_2_TOTAL','Field_2_DISCOUNT','Field_2_BALANCE','Field_3_TOTAL','Field_3_DISCOUNT','Field_3_BALANCE',
                                                                        'Field_4_TOTAL','Field_4_DISCOUNT','Field_4_BALANCE','Field_5_TOTAL','Field_5_DISCOUNT','Field_5_BALANCE','Field_6_TOTAL','Field_6_DISCOUNT','Field_6_BALANCE',
                                                                        'Field_7_TOTAL','Field_7_DISCOUNT','Field_7_BALANCE','Field_8_TOTAL','Field_8_DISCOUNT','Field_8_BALANCE','Field_9_TOTAL','Field_9_DISCOUNT','Field_9_BALANCE',
                                                                        'Field_10_TOTAL','Field_10_DISCOUNT','Field_10_BALANCE','Field_11_TOTAL','Field_11_DISCOUNT','Field_11_BALANCE','Field_12_TOTAL','Field_12_DISCOUNT','Field_12_BALANCE',
                                                                        'Field_13_TOTAL','Field_13_DISCOUNT','Field_13_BALANCE','Field_14_TOTAL','Field_14_DISCOUNT','Field_14_BALANCE','Field_15_TOTAL','Field_15_DISCOUNT','Field_15_BALANCE',
                                                                            ));
    

        
    }

    /**
     * Form to accept [Term] for which total of other payments is to be generated.
     *
     * @return \Illuminate\Http\Response
     */
    public function total_expenditure_term_1 ()
    { 
       
        $Payments = Expenditures::where('status', 1)->get();
        $term = sch_term::all();
        
        return view('accountant.total_expenditure_term_query_form')->with('Payments', $Payments)
                                                                   ->with('term', $term);
                                                      
    }

    /**
     * Display report.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function total_expenditure_term_trx (Request  $request)
    {
        $this->validate($request, [
            'Payment' => 'required',
            'Stu_Term' => 'required',
        ]);


        $Term = sch_term::where('id', $request->input('Stu_Term'))->get();

        $Payments = Payment_Records::where('payment', $request->input('Payment'))
                                    ->whereBetween('date', [$Term[0]['start_date'], $Term[0]['end_date']])
                                    ->get();
        
        $Unit_Total = 0;
        $Grand_Total = 0;
        $Expenses = Expenditures::where('id', $request->input('Payment'))->get();

        foreach ($Payments as $Pay) {
            if ($Pay->quantity < 1) {
                $Unit_Total = 1 * $Pay->amount;
            } else {
                $Unit_Total = $Pay->quantity * $Pay->amount;
            }
            $Grand_Total += $Unit_Total;
        }

        return view('accountant.payment_expenditure_term_total',COMPACT('Payments','Grand_Total','Term','Expenses')); 
        
    }



/******************************************************************************
                                 *                                            *
                                 * //HANDLING CASH & BANK OPERATIONS //       *
                                 *                                            *
*******************************************************************************/

    /**
     * Show the form for lodging in a cash remittance transaction.
     *
     * @return \Illuminate\Http\Response
     */
    public function remittances () {
        $Users = User::where([['user_category', '!=', 'Super Admin'],['status', '1']])->get();
        $Last_Trx = Rem_Trx::where('user', Auth::user()->name )->latest()->limit(5)->get();
        return view('accountant.cash_remittances',COMPACT('Last_Trx','Users'));
    }

    /**
     * Store the lodged transaction.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_remittances (Request $request)
    {
        $this->validate($request, [
            'amount' => 'required',
            'source' => 'required',
            'receiver' => 'required',
        ]);

        //Lodged a New Cash Remittance Transaction
        $Remittance = new Rem_Trx;
        $Remittance->user = Auth::user()->name;
        $Remittance->office = Auth::user()->user_category;
        $Remittance->date = $request->input('date');
        $Remittance->amount = $request->input('amount');
        $Remittance->source = $request->input('source');
        $Remittance->comment = $request->input('comment');
        $Remittance->receiver = $request->input('receiver');
        $Remittance->save();

        return redirect('/Cash/Remittances')->with('success', "Cash Remittance Lodged Succesfully");

    }

    /**
     * Show the form for lodging in a cash banking transaction.
     *
     * @return \Illuminate\Http\Response
     */
    public function banking () {
        $Bank = banks::where([['banks', '!=', ''],['status', '1']])->get();
        $Last_Trx = Banking_Trx::where('user', Auth::user()->name)->latest()->limit(5)->get();
        return view('accountant.cash_banking', COMPACT('Bank',
                                                       'Last_Trx'
                                                                ));
    }

    /**
     * Store the lodged transaction
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_banking (Request $request)
    {
        $this->validate($request, [
            'Bank' => 'required',
            'Teller' => 'required',
            'Amount' => 'required'
        ]);

        //Add a New Class
        $Banking = new Banking_Trx;
        $Banking->user = Auth::user()->name;;
        $Banking->office = Auth::user()->user_category;
        $Banking->date = $request->input('date');
        $Banking->bank = $request->input('Bank');
        $Banking->amount = $request->input('Amount');
        $Banking->source = $request->input('Source');
        $Banking->teller = $request->input('Teller');
        $Banking->comment = $request->input('comment');
        $Banking->save();

        return redirect('/Cash/Banking')->with('success', "Banking Ledger Update was Successful");

    }

    /**
     * Show the form for lodging in a cash withdrawal transaction.
     *
     * @return \Illuminate\Http\Response
     */
    public function withdrawal () {
        $Bank = banks::where([['banks', '!=', ''],['status', '1']])->get();
        $Last_Trx = Withdrawal_Trx::where('user', Auth::user()->name )->latest()->limit(5)->get();
        return view('accountant.cash_withdrawals', COMPACT('Bank','Last_Trx'));
    }

    /**
     * Store the lodged transaction
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_withdrawal (Request $request)
    {
        $this->validate($request, [
            'Bank' => 'required',
            'Cheque' => 'required',
            'Amount' => 'required',
            'Authority' => 'required'
        ]);

        //Add a New Class
        $Withdrawal = new Withdrawal_Trx;
        $Withdrawal->user = Auth::user()->name;
        $Withdrawal->office = Auth::user()->user_category;
        $Withdrawal->date = $request->input('date');
        $Withdrawal->bank = $request->input('Bank');
        $Withdrawal->cheque = $request->input('Cheque');
        $Withdrawal->amount = $request->input('Amount');
        $Withdrawal->authority = $request->input('Authority');
        $Withdrawal->comment = $request->input('comment');
        $Withdrawal->save();

        return redirect('/Cash/Withdrawal')->with('success', "Cash Withdrawal Ledger Update was Successful");

    }

/******************************************************************************
                                 *                                            *
                                 //HANDLING CASH & BANK OPERATIONS REPORTING//*
                                 *                                            *
*******************************************************************************/

    /**
     * Show the form to accept date range to which transactions report is to be generated.
     *
     * @return \Illuminate\Http\Response
     */
    public function rem_history_1 () {
        return view('accountant.cash_rem_history');
    }

    /**
     * Generate report
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function rem_history (Request $request)
    {
        $this->validate($request, [
            'Start_Date' => 'required',
            'End_Date' => 'required',
        ]);

        $Start_Date = $request->input('Start_Date');
        $End_Date = $request->input('End_Date');

        $Report = Rem_Trx::whereBetween('date', [$Start_Date, $End_Date])->get();

        $TOTAL = 0;

        foreach ($Report as $Trx){
            $TOTAL += $Trx->amount;
        }


        return view('accountant.cash_remittances_history', COMPACT('Report','Start_Date','End_Date','TOTAL')); 

    }

    /**
     * Show the form to accept date range to which transactions report is to be generated.
     *
     * @return \Illuminate\Http\Response
     */
    public function banking_history_1 () {
        return view('accountant.cash_bank_history');
    }

    /**
     * Generate report
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function banking_history (Request $request)
    {
        $this->validate($request, [
            'Start_Date' => 'required',
            'End_Date' => 'required',
        ]);

        $Start_Date = $request->input('Start_Date');
        $End_Date = $request->input('End_Date');

        $Report = Banking_Trx::whereBetween('date', [$Start_Date, $End_Date])->get();
        
        $TOTAL = 0;

        foreach ($Report as $Trx){
            $TOTAL += $Trx->amount;
        }

        return view('accountant.cash_banking_history', COMPACT('Report','Start_Date','End_Date','TOTAL')); 

    }

    /**
     * Show the form to accept date range to which transactions report is to be generated.
     *
     * @return \Illuminate\Http\Response
     */
    public function withdrawal_history_1 () {
        return view('accountant.cash_with_history');
    }

    /**
     * Generate report
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function withdrawal_history (Request $request)
    {
        $this->validate($request, [
            'Start_Date' => 'required',
            'End_Date' => 'required',
        ]);

        $Start_Date = $request->input('Start_Date');
        $End_Date = $request->input('End_Date');

        $Report = Withdrawal_Trx::whereBetween('date', [$Start_Date, $End_Date])->get();
        
        $TOTAL = 0;

        foreach ($Report as $Trx){
            $TOTAL += $Trx->amount;
        }

        return view('accountant.cash_withdrawal_history', COMPACT('Report','Start_Date','End_Date','TOTAL')); 

    }

/******************************************************************************
                         *                                                    *
                         * //HANDLING PAYMENTS & VOUCHERS OPERATIONS //       *
                         *                                                    *
*******************************************************************************/
    
    /**
     * Show the form for adding a new Payment or Expenditure Record.
     *
     * @return \Illuminate\Http\Response
     */
    public function add_payment_record () {
        
        if (Auth::user()->user_category == 'Accountant' || Auth::user()->user_category == 'Director' || Auth::user()->user_category == 'Super Admin') {
            $Payments = Expenditures::where('status', 1)->get();
            $Records = Payment_Records::where('date', date("Y-m-d"))->get();
        } else {
            $Payments = Expenditures::where([['access', 0],['status', 1]])->get();
            $Records = Payment_Records::where('user', Auth::user()->name)->get();
        }

        $Expenses = Expenditures::all();
        
        return view('accountant.add_payment_record',COMPACT('Payments','Records','Expenses'));
    }

    /**
     * Store a newly created payment or expenditure.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_payment_record (Request $request)
    {
        $this->validate($request, [
            'Payment' => 'required',
            'Amount' => 'required',
            'Multiple_Quantity' => 'required'
        ]);
        

        if ($request->input('Multiple_Quantity')  == 1 ) {
            $Quantity = $request->input('Quantity');
        } else {
            $Quantity = 0;
        }

        //Add a New Payment or Expenditure Categories
        $Pay_Rec = new Payment_Records;
        $Pay_Rec->date = $request->input('date');
        $Pay_Rec->user = Auth::user()->name;
        $Pay_Rec->office = Auth::user()->user_category;
        $Pay_Rec->payment = $request->input('Payment');
        $Pay_Rec->quantity = $Quantity;
        $Pay_Rec->amount = $request->input('Amount');
        $Pay_Rec->comment = $request->input('comment');
        $Pay_Rec->save();

        return redirect('/New/Payment/Record')->with('success', "Record added succesfully");

    }

    /**
     * Show the form to accept date for which payment voucher is to be generated.
     *
     * @return \Illuminate\Http\Response
     */
    public function payment_vouchers_1 () {
        return view('accountant.payment_voucher_date');
    }

    /**
     * Function to generate payment voucher
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function payment_vouchers (Request $request)
    {
        $this->validate($request, [
            'Date' => 'required',
        ]);

        $Date = $request->input('Date');

        $Payments = Payment_Records::where('date', $Date)->get();
        $Unit_Total = 0;
        $Grand_Total = 0;

        $Expenses = Expenditures::all();

        foreach ($Payments as $Pay) {
            if ($Pay->quantity < 1) {
                $Unit_Total = 1 * $Pay->amount;
            } else {
                $Unit_Total = $Pay->quantity * $Pay->amount;
            }
            $Grand_Total += $Unit_Total;
        }


        return view('accountant.payment_voucher',COMPACT('Payments','Grand_Total','Date','Expenses')); 

    }

    /**
     * Show the form to accept term for which payment history is to be generated.
     *
     * @return \Illuminate\Http\Response
     */
    public function payment_history_1 () {
        $Terms = sch_term::all();
        $Expenses = Expenditures::all();
        return view('accountant.payment_history_term',COMPACT('Terms','Expenses'));
    }

    /**
     * Function to generate payment voucher
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function payment_history (Request $request)
    {
        $this->validate($request, [
            'Stu_Term' => 'required',
        ]);

        $Term = sch_term::where('id', $request->input('Stu_Term'))->get();

        $Payments = Payment_Records::whereBetween('date', [$Term[0]['start_date'], $Term[0]['end_date']])->get();
        $Unit_Total = 0;
        $Grand_Total = 0;
        $Expenses = Expenditures::all();

        foreach ($Payments as $Pay) {
            if ($Pay->quantity < 1) {
                $Unit_Total = 1 * $Pay->amount;
            } else {
                $Unit_Total = $Pay->quantity * $Pay->amount;
            }
            $Grand_Total += $Unit_Total;
        }

        return view('accountant.payment_voucher_history',COMPACT('Payments','Grand_Total','Term','Expenses')); 

    }

/******************************************************************************
                                 *                                            *
                                 * //ERROR DEDUCTION OPERATIONS// *
                                 *                                            *
*******************************************************************************/

    /**
     * Show the form for recording error deduction.
     *
     * @return \Illuminate\Http\Response
     */
    public function error_deduction () {
        
        $session = sch_session::all();
        $term = sch_term::all();
        $Error = Error_Deduction::latest()->limit('5')->get();
        //dd($Error);
        return view('accountant.error_deduction_form', COMPACT('session','term','Error'));
    }

    /**
     * Store error deduction entry.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_error_deduction (Request $request)
    {
        $this->validate($request, [
            'Ref_Trx_id' => 'required',
            'session' => 'required',
            'term' => 'required',
            'amount' => 'required',
            'comment' => 'required',
            'trx_type' => 'required',
        ]);
        
        $TRX = $request->input('trx_type');

        if($TRX == 0) {
            $Check = trx_schfee::where([['Trx_id', $request->input('Ref_Trx_id')],['session', $request->input('session')],['term', $request->input('term')] ])->get();
            
            if($Check->isEmpty()) {
                return redirect('/Error/Deduction')->with('error', "INVALID TRANSACTION - CHECK TRANSACTION REF NO, TYPE , SESSION AND TERM TO ENSURE THEY CORRESPOND TO A VALID TRANSACTION!!");
            } else {
                //Add a New Payment or Expenditure Categories
                $Error = new Error_Deduction;
                $Error->ref_trx_id = $request->input('Ref_Trx_id');
                $Error->transaction = $request->input('trx_type');
                $Error->session = $request->input('session');
                $Error->term = $request->input('term');
                $Error->amount = $request->input('amount');
                $Error->comment = $request->input('comment');
                $Error->save();

                return redirect('/Error/Deduction')->with('success', "Deduction recorded succesfully");
            }

        } else {
            $Check = other_trx::where([['Trx_id', $request->input('Ref_Trx_id')],['session', $request->input('session')],['term', $request->input('term')] ])->get();

            if($Check->isEmpty()) {
                return redirect('/Error/Deduction')->with('error', "INVALID TRANSACTION - CHECK TRANSACTION REF NO, TYPE , SESSION AND TERM TO ENSURE THEY CORRESPOND TO A VALID TRANSACTION!!");
            } else {
                //Add a New Payment or Expenditure Categories
                $Error = new Error_Deduction;
                $Error->ref_trx_id = $request->input('Ref_Trx_id');
                $Error->transaction = $request->input('trx_type');
                $Error->session = $request->input('session');
                $Error->term = $request->input('term');
                $Error->amount = $request->input('amount');
                $Error->comment = $request->input('comment');
                $Error->save();

                return redirect('/Error/Deduction')->with('success', "Deduction recorded succesfully");
            }
        }

        

    }

    /**
     * Show the form to accept term for which error deductions report is to be generated.
     *
     * @return \Illuminate\Http\Response
     */
    public function error_deduction_term_1 () {
        $Terms = sch_term::all();
        return view('accountant.error_deduction_term',COMPACT('Terms'));
    }

    /**
     * Function to generate error deduction report
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function error_deduction_term (Request $request)
    {
        $this->validate($request, [
            'Stu_Term' => 'required',
        ]);

        $Error = Error_Deduction::where('term', $request->input('Stu_Term'))->get();
        $Error_SchFee = Error_Deduction::where([['term', $request->input('Stu_Term')],['transaction', 0]])->get();
        $Error_OthFee = Error_Deduction::where([['term', $request->input('Stu_Term')],['transaction', 1]])->get();
        $session = sch_session::all();
        $term = sch_term::all();

        $Term_Name = sch_term::where('id', $request->input('Stu_Term'))->get();

        
        $SchFee_Total = 0;
        $OthFee_Total = 0;
        $Grand_Total = 0;
        
        foreach ($Error_SchFee as $SchFee) {
            $SchFee_Total += $SchFee->amount;
        }
        foreach ($Error_OthFee as $OthFee) {
            $OthFee_Total += $OthFee->amount;
        }
        foreach ($Error as $Err) {
            $Grand_Total += $Err->amount;
        }

        return view('accountant.error_deduction_report_term',COMPACT('Error','session','term','Term_Name','Grand_Total','SchFee_Total','OthFee_Total')); 

    }

    /**
     * Show the form to accept session for which error deductions report is to be generated.
     *
     * @return \Illuminate\Http\Response
     */
    public function error_deduction_session_1 () {
        $Sessions = sch_session::all();
        return view('accountant.error_deduction_session',COMPACT('Sessions'));
    }

    /**
     * Function to generate error deduction report
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function error_deduction_session (Request $request)
    {
        $this->validate($request, [
            'Stu_Session' => 'required',
        ]);

        $Error = Error_Deduction::where('session', $request->input('Stu_Session'))->get();
        $Error_SchFee = Error_Deduction::where([['session', $request->input('Stu_Session')],['transaction', 0]])->get();
        $Error_OthFee = Error_Deduction::where([['session', $request->input('Stu_Session')],['transaction', 1]])->get();
        $session = sch_session::all();
        $term = sch_term::all();

        $Session_Name = sch_session::where('id', $request->input('Stu_Session'))->get();

        
        $Grand_Total = 0;
        $SchFee_Total = 0;
        $OthFee_Total = 0;

        foreach ($Error_SchFee as $SchFee) {
            $SchFee_Total += $SchFee->amount;
        }
        foreach ($Error_OthFee as $OthFee) {
            $OthFee_Total += $OthFee->amount;
        }
        foreach ($Error as $Err) {
            $Grand_Total += $Err->amount;
        }

        return view('accountant.error_deduction_report_session',COMPACT('Error','session','term','Session_Name','Grand_Total','SchFee_Total','OthFee_Total')); 

    }

/******************************************************************************
                                 *                                            *
                                 * //USER PASSWORD OPERATIONS//               *
                                 *                                            *
*******************************************************************************/

    /**
     * Show the form for resetting .
     *
     * @return \Illuminate\Http\Response
     */
    public function password_reset_form () {
        
        return view('accountant.password_reset');
    }

    /**
     * Store error deduction entry.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function reset_password (Request $request)
    {
        $validator = $request->validate([
            'old_password' => ['required', new MatchOldPassword],
            'password' => ['required'],
            'password_confirmation' => ['same:password'],
        ]);

            User::find(auth()->user()->id)->update(['password'=> Hash::make($request->password)]);
            return redirect('/dashboard')->with('success', "Password reset successful");

    }

    /**
     * Show the form for resetting .
     *
     * @return \Illuminate\Http\Response
     */
    public function disable_user_list () {
        $Users = User::where('status', 1)->get();
        return view('accountant.user_disable')->with('Users', $Users);
    }

    /**
     * Store error deduction entry.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function disable_user (Request $request, $id)
    {

            $User = User::find($id);
            $User->status = '0';
            $User->save();

            return redirect('/User/Disable')->with('success', "User disabled successfully");

    }

    /**
     * Show the form for resetting .
     *
     * @return \Illuminate\Http\Response
     */
    public function enable_user_list () {
        $Users = User::where('status', 0)->get();
        return view('accountant.user_enable')->with('Users', $Users);
    }

    /**
     * Store error deduction entry.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function enable_user (Request $request, $id)
    {

            $User = User::find($id);
            $User->status = '1';
            $User->save();

            return redirect('/User/Enable')->with('success', "User enabled successfully");

    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

}

