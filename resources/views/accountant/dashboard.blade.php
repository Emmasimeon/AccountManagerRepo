@extends('accountant.inc.layout')

@section('content')

            <div class="app-main__outer">
                    <div class="app-main__inner">
                        <div class="app-page-title">
                        {{-- Include the message notification bar here --}}
                            @include('accountant.inc.messages')
                            {{-- End the include here --}}
                            <div class="page-title-wrapper">
                                <div class="page-title-heading">
                                    <div class="page-title-icon">
                                        <i class="pe-7s-wallet text-success">
                                        </i>
                                    </div>
                                    <div>({{Auth::user()->user_category}}) Dashboard
                                        <div class="page-title-subheading">(<b>{{strtoupper ($Details[0]['school_name'])}}</b>) Account Manager Software
                                        </div>
                                    </div>
                                </div>
                                <div class="page-title-actions">


                                </div>    
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-xl-4">
                                <div class="card mb-3 widget-content bg-primary">
                                    <div class="widget-content-wrapper text-white">
                                        <div class="widget-content-left">
                                            <div class="widget-heading">Amount.</div>
                                            <div class="widget-subheading">Total School Fees Paid Today</div>
                                        </div>
                                        <div class="widget-content-right">
                                            <div class="widget-numbers text-white"><span>₦ {{number_format($SchFees_Paid_Today,2,".",",")}}</span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-xl-4">
                                <div class="card mb-3 widget-content bg-info">
                                    <div class="widget-content-wrapper text-white">
                                        <div class="widget-content-left">
                                            <div class="widget-heading">Amount</div>
                                            <div class="widget-subheading">Total Other Income Today</div>
                                        </div>
                                        <div class="widget-content-right">
                                            <div class="widget-numbers text-white"><span>₦ {{number_format($OthFees_Paid_Today,2,".",",")}}</span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-xl-4">
                                <div class="card mb-3 widget-content bg-heavy-rain">
                                    <div class="widget-content-wrapper text-black">
                                        <div class="widget-content-left">
                                            <div class="widget-heading">Total</div>
                                            <div class="widget-subheading">Total Expenses Today</div>
                                        </div>
                                        <div class="widget-content-right">
                                            <div class="widget-numbers text-black"><span>₦ {{number_format($Expense_Today,2,".",",")}}</span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        {{-- Student Count Section --}}
                        <div class="row">
                            <div class="col-md-6 col-xl-4">
                                <div class="card mb-3 widget-content bg-primary">
                                    <div class="widget-content-wrapper text-white">
                                        <div class="widget-content-left">
                                            <div class="widget-heading">Total</div>
                                            <div class="widget-subheading">No of Student in School</div>
                                        </div>
                                        <div class="widget-content-right">
                                            <div class="widget-numbers text-white"><span>{{$Total_Students}}</span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-xl-4">
                                <div class="card mb-3 widget-content bg-arielle-smile">
                                    <div class="widget-content-wrapper text-white">
                                        <div class="widget-content-left">
                                            <div class="widget-heading">Male</div>
                                            <div class="widget-subheading">No of Male</div>
                                        </div>
                                        <div class="widget-content-right">
                                            <div class="widget-numbers text-white"><span>{{$Total_Male}}</span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-xl-4">
                                <div class="card mb-3 widget-content bg-ripe-malin">
                                    <div class="widget-content-wrapper text-white">
                                        <div class="widget-content-left">
                                            <div class="widget-heading">Female</div>
                                            <div class="widget-subheading">No of Female</div>
                                        </div>
                                        <div class="widget-content-right">
                                            <div class="widget-numbers text-white"><span>{{$Total_Female}}</span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-xl-none d-lg-block col-md-6 col-xl-4">
                                <div class="card mb-3 widget-content bg-premium-dark">
                                    <div class="widget-content-wrapper text-white">
                                        <div class="widget-content-left">
                                            <div class="widget-heading">Products Sold</div>
                                            <div class="widget-subheading">Revenue streams</div>
                                        </div>
                                        <div class="widget-content-right">
                                            <div class="widget-numbers text-warning"><span>$14M</span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Expense Tracker Section --}}
                        
                         <div class="row">
                            <div class="col-md-12">
                                <div class="main-card mb-3 card">
                                    <div class="card-header">PAYMENT/PURCHASE RECORDS ENTERED TODAY
                                    </div>
                                    <div class="table-responsive">
                                        <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                                        <?php $number = 1; ?>
                                            <thead>
                                            @if (count($Today_Expense) > 0)
                                            
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th class="text-center">PAYMENT/PURCHASE DESCRIPTION</th>
                                                <th class="text-center">AMOUNT (₦)</th>
                                                <th class="text-center">SUBMITTED BY</th>
                                                <th class="text-center">COMMENT</th>
                                                <th class="text-center">STATUS</th>
                                            </tr>
                                            </thead>
                                            
                                            <tbody>
                                                   
                                                        @foreach ($Today_Expense as $today )
                                                         <tr>
                                                            <td class="text-center text-muted">{{$number++}}</td>
                                                            <td>
                                                                @foreach ($Expenses_Label as $Pay_Label)
                                                                    @if ($Pay_Label->id == $today->payment)
                                                                        <div class="text-center widget-heading"><b>{{$Pay_Label->expenditures}}</b></div>
                                                                    @endif
                                                                @endforeach
                                                            </td>
                                                            @if ($today->quantity < 1)
                                                                <td class="text-center">₦ {{number_format(1 * $today->amount,2,".",",")}}</td>
                                                            @else 
                                                                <td class="text-center">₦ {{number_format($today->quantity * $today->amount,2,".",",")}}</td>
                                                            @endif
                                                            <td class="text-center">{{$today->user}}</td>
                                                            <td class="text-center">{{$today->comment}}</td>
                                                            <td class="text-center">
                                                                <div class="badge badge-success">Approved</div>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    
                                            </tbody>
                                            @else 
                                                    <h5>NO RECORDED TRANSACTIONS FOR TODAY!!</h5>
                                            @endif
                                            
                                            
                                            
                                        </table>
                                    </div>
                                
                                </div>
                            </div>
                        </div>

                        
                        
                        <div class="row">
                            {{-- SCHOOL TRANSACTIONS CARD STARTS HERE!! --}}
                            <div class="col-md-5">
                                <div class="main-card mb-3 card">
                                    <div class="card-header">SCHOOL FEES TRANSACTIONS TODAY
                                    </div>
                                    <div class="table-responsive">
                                        <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                                            <thead>
                                            @if (count($Today_SchFees) > 0)
                                                <tr>
                                                    <th class="text-center">SAN</th>
                                                    <th class="text-center">Transaction History</th>
                                                    <th class="text-center">Amount Paid (₦)</th>
                                                    <th class="text-center">Balance (₦)</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($Today_SchFees as $today )
                                                        <tr>
                                                            <td class="text-center text-muted">{{$today->SAN_id}}</td>
                                                            <td class="text-center"> 
                                                                <a class="btn btn-success btn-sm" href="/SchFee_Payment_History/{{$today->SAN_id}}"> <i class="fa fa-list"></i> View History </a>
                                                            </td>
                                                            <td class="text-center">
                                                                <div class="badge badge-success">₦ {{number_format($today->trx_total_expected - $today->bal_total,2,".",",")}}</div>
                                                            </td>
                                                            <td class="text-center">
                                                                <div class="badge badge-warning">₦ {{number_format($today->bal_total,2,".",",")}}</div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                            </tbody>
                                            @else 
                                                <h5>NO RECORDED TRANSACTIONS FOR TODAY!!</h5>
                                            @endif
                                            
                                        </table>
                                    </div>
                                    
                                </div>
                            </div>

                            {{-- OTHER INCOME TRANSACTIONS CARD STARTS HERE!! --}}

                            <div class="col-md-7">
                                <div class="main-card mb-3 card">
                                    <div class="card-header">OTHER INCOME TRANSACTIONS TODAY
                                       
                                    </div>
                                    <div class="table-responsive">
                                        <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                                            <thead>
                                            @if (count($Today_OthFees) > 0)
                                                <tr>
                                                    <th class="text-center">SAN</th>
                                                    <th class="text-center">Payment/Purchase Description</th>
                                                    <th class="text-center">Amount Paid (₦)</th>
                                                    <th class="text-center">Balance (₦)</th>
                                                    <th class="text-center">Transaction History</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach ($Today_OthFees as $today )
                                                    <tr>
                                                        <td class="text-center text-muted">{{$today->SAN_id}}</td>
                                                        <td> 
                                                            @foreach ($PAYMENTS as $PAY)
                                                                    @if ($PAY->id == $today->payment)
                                                                        <div class="text-center widget-heading">{{$PAY->income_category}}</div>
                                                                    @endif
                                                            @endforeach         
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="badge badge-success">₦ {{number_format(decrypt($today->total_paid),2,".",",")}}</div>
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="badge badge-warning">₦ {{number_format(decrypt($today->balance),2,".",",")}}</div>
                                                        </td>
                                                        <td class="text-center"> 
                                                                <a class="btn btn-success btn-sm" href="/Other/Payment/History/{{$today->SAN_id}}"> <i class="fa fa-list"></i> View History </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            @else
                                                <h5>NO RECORDED TRANSACTIONS FOR TODAY!!</h5>
                                            @endif
                                            
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
@endsection