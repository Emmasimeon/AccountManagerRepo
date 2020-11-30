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
                                        <i class="pe-7s-study text-success">
                                        </i>
                                    </div>
                                    <div>SCHOOL FEES RECEIVED ANALYSIS FOR ({{$TERM[0]['term']}}) - SESSION
                                    </div>
                                </div>
                                </div>
                        </div>            
                        <ul class="body-tabs body-tabs-layout tabs-animated body-tabs-animated nav"></ul>
                        <div class="tab-content">
                            <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
                                
                                {{-- Student Details Card --}}

                                 <div class="main-card mb-3 card">
                                
                                </div>
                                
                                {{-- Payment Details Card --}}

                                <div class="main-card mb-3 card">
                                    <div class="card-body"><h5 class="card-title">ANALYSIS OF SCHOOL FEES TRANSACTION FOR <b><i>{{$TERM[0]['term']}}</i></b></h5>
                                                
                                            
                                                    <div class="form-row">
                                                        <table class="mb-0 table table-sm table-responsive">
                                                            <thead>
                                                                <tr class="table-info">
                                                                    <th></th>
                                                                    <th class="text-center">
                                                                        {{strtoupper("Tuition Fee")}}
                                                                    </th>
                                                                    <th>
                                                                        {{strtoupper("I.C.T")}}
                                                                    </th>
                                                                    <th>
                                                                        {{strtoupper("P.T.A")}}
                                                                    </th>
                                                                    <th>
                                                                        {{strtoupper("Boarding Fee")}}
                                                                    </th>
                                                                    <th>
                                                                        {{strtoupper("Utility Fee")}}
                                                                    </th>
                                                                    <th>
                                                                        {{strtoupper("Development Levy")}}
                                                                    </th>
                                                                    <th>
                                                                        {{strtoupper("Books (Pre-KG to JSS)")}}
                                                                    </th>
                                                                    <th>  
                                                                        {{strtoupper("Uniform and Wears (General)")}}
                                                                    </th>
                                                                    <th>  
                                                                        {{strtoupper("TOTAL")}}
                                                                    </th>

                                                                </tr>
                                                            </thead>
                                                            
                                                            
                                                            <tbody>
                                                                    <tr class="table-warning">
                                                                        <td><b>TOTAL NUMBER OF TRANSACTIONS</b></td>
                                                                        <td class="text-center">{{$COUNT}}</td>    
                                                                        <td class="text-center">{{$COUNT}}</td>    
                                                                        <td class="text-center">{{$COUNT}}</td>    
                                                                        <td class="text-center">{{$COUNT}}</td>    
                                                                        <td class="text-center">{{$COUNT}}</td>    
                                                                        <td class="text-center">{{$COUNT}}</td>    
                                                                        <td class="text-center">{{$COUNT}}</td>    
                                                                        <td class="text-center">{{$COUNT}}</td>    
                                                                        <td class="text-center">{{$COUNT}}</td>    
                                                                    </tr>
                                                                    
                                                                    <tr class="table-primary">
                                                                        <td><b>TOTAL DISCOUNT GIVEN (₦)</b></td>
                                                                        <td class="text-center"><b>{{number_format($TUITION_DISCOUNT,2,".",",")}}</b></td>
                                                                        <td class="text-center"><b>{{number_format($ICT_DISCOUNT,2,".",",")}}</b></td>
                                                                        <td class="text-center"><b>{{number_format($PTA_DISCOUNT,2,".",",")}}</b></td>
                                                                        <td class="text-center"><b>{{number_format($BOARDING_DISCOUNT,2,".",",")}}</b></td>
                                                                        <td class="text-center"><b>{{number_format($UTILITY_DISCOUNT,2,".",",")}}</b></td>
                                                                        <td class="text-center"><b>{{number_format($DEV_DISCOUNT,2,".",",")}}</b></td>
                                                                        <td class="text-center"><b>{{number_format($BOOK_DISCOUNT,2,".",",")}}</b></td>
                                                                        <td class="text-center"><b>{{number_format($UNIFORM_DISCOUNT,2,".",",")}}</b></td>
                                                                        <td class="text-center"><b>{{number_format($TOTAL_DISCOUNT = $TUITION_DISCOUNT + $ICT_DISCOUNT + $PTA_DISCOUNT + $BOARDING_DISCOUNT + $UTILITY_DISCOUNT + $DEV_DISCOUNT + $BOOK_DISCOUNT + $UNIFORM_DISCOUNT,2,".",",")}}</b></td>
       
                                                                    </tr>
                                                                    <tr class="table-warning">
                                                                        <td><b>OUTSTANDING BALANCE (₦)</b></td>
                                                                        <td class="text-center"><b>{{number_format($TUITION_BALANCE,2,".",",")}}</b></td>
                                                                        <td class="text-center"><b>{{number_format($ICT_BALANCE,2,".",",")}}</b></td>
                                                                        <td class="text-center"><b>{{number_format($PTA_BALANCE,2,".",",")}}</b></td>
                                                                        <td class="text-center"><b>{{number_format($BOARDING_BALANCE,2,".",",")}}</b></td>
                                                                        <td class="text-center"><b>{{number_format($UTILITY_BALANCE,2,".",",")}}</b></td>
                                                                        <td class="text-center"><b>{{number_format($DEV_BALANCE,2,".",",")}}</b></td>
                                                                        <td class="text-center"><b>{{number_format($BOOK_BALANCE,2,".",",")}}</b></td>
                                                                        <td class="text-center"><b>{{number_format($UNIFORM_BALANCE,2,".",",")}}</b></td>
                                                                        <td class="text-center"><b>{{number_format($TOTAL_BALANCE = $TUITION_BALANCE + $ICT_BALANCE + $PTA_BALANCE + $BOARDING_BALANCE + $UTILITY_BALANCE + $DEV_BALANCE + $BOOK_BALANCE + $UNIFORM_BALANCE,2,".",",")}}</b></td>
       
                                                                    </tr>
                                                                    <tr class="table-primary">
                                                                        <td><b>TOTAL PAID(₦)</b></td>
                                                                        <td class="text-center"><b>{{number_format($TUITION_TOTAL,2,".",",")}}</b></td>
                                                                        <td class="text-center"><b>{{number_format($ICT_TOTAL,2,".",",")}}</b></td>
                                                                        <td class="text-center"><b>{{number_format($PTA_TOTAL,2,".",",")}}</b></td>
                                                                        <td class="text-center"><b>{{number_format($BOARDING_TOTAL,2,".",",")}}</b></td>
                                                                        <td class="text-center"><b>{{number_format($UTILITY_TOTAL,2,".",",")}}</b></td>
                                                                        <td class="text-center"><b>{{number_format($DEV_TOTAL,2,".",",")}}</b></td>
                                                                        <td class="text-center"><b>{{number_format($BOOK_TOTAL,2,".",",")}}</b></td>
                                                                        <td class="text-center"><b>{{number_format($UNIFORM_TOTAL,2,".",",")}}</b></td>
                                                                        <td class="text-center"><b>{{number_format($TOTAL_PAID = $TUITION_TOTAL + $ICT_TOTAL + $PTA_TOTAL + $BOARDING_TOTAL + $UTILITY_TOTAL + $DEV_TOTAL + $BOOK_TOTAL + $UNIFORM_TOTAL,2,".",",")}}</b></td>
       
                                                                    </tr>
                                                                    <tr><td><td></tr>

                                                                    <tr class="table-success">
                                                                        
                                                                        <td><b>OVERALL ACCUMULATED TOTAL (₦)</b></td>
                                                                            <td class="text-center"><b>{{number_format($TUITION_DISCOUNT + $TUITION_BALANCE + $TUITION_TOTAL,2,".",",")}}</b></td>
                                                                            <td class="text-center"><b>{{number_format($ICT_DISCOUNT + $ICT_BALANCE + $ICT_TOTAL,2,".",",")}}</b></td>
                                                                            <td class="text-center"><b>{{number_format($PTA_DISCOUNT + $PTA_BALANCE + $PTA_TOTAL,2,".",",")}}</b></td>
                                                                            <td class="text-center"><b>{{number_format($BOARDING_DISCOUNT + $BOARDING_BALANCE + $BOARDING_TOTAL,2,".",",")}}</b></td>
                                                                            <td class="text-center"><b>{{number_format($UTILITY_DISCOUNT + $UTILITY_BALANCE + $UTILITY_TOTAL,2,".",",")}}</b></td>
                                                                            <td class="text-center"><b>{{number_format($DEV_DISCOUNT + $DEV_BALANCE + $DEV_TOTAL,2,".",",")}}</b></td>
                                                                            <td class="text-center"><b>{{number_format($BOOK_DISCOUNT + $BOOK_BALANCE + $BOOK_TOTAL,2,".",",")}}</b></td>
                                                                            <td class="text-center"><b>{{number_format($UNIFORM_DISCOUNT + $UNIFORM_BALANCE + $UNIFORM_TOTAL,2,".",",")}}</b></td>
                                                                            <td class="text-center"><b>{{number_format($TOTAL_DISCOUNT + $TOTAL_BALANCE + $TOTAL_PAID,2,".",",")}}</b></td>
                                                                            
                                                                            
                                                                    </tr>
                                                            </tbody>
                                                                
                                                        </table>     
                                                    </div>
                                            
                                                
                                        
                                    </div>
                                </div>

                            </div>
                            </div>
                        </div>
                        </div>
                    </div>
@endsection