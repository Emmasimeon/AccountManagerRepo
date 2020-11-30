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
                                    <div>PRE TERM SCHOOL FEES ANALYSIS FOR ({{$TERM[0]['term']}})</br>
                                    <small>SCHOOL FEES PAID FOR <u><b>{{$TERM[0]['term']}}</b></u> BEFORE THE COMMENCEMENT OF THE TERM</small>
                                    </div>
                                </div>
                                </div>
                        </div>            
                        <ul class="body-tabs body-tabs-layout tabs-animated body-tabs-animated nav"></ul>
                        <div class="tab-content">
                            <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
                                
                                
                                {{-- Payment Details Card --}}

                                <div class="main-card mb-3 card">
                                    <div class="card-body"><h5 class="card-title">ANALYSIS OF PRE-TERM SCHOOL FEES TRANSACTION FOR <b><i>{{$TERM[0]['term']}}</i></b></h5>
                                                
                                            
                                                    <div class="form-row">
                                                        <table class="mb-0 table table-sm table-responsive">
                                                            <thead>
                                                                <tr class="table-info">
                                                                    <th></th>
                                                                    <th class="text-center">
                                                                        {{strtoupper($Name_1[0]['name'])}}
                                                                    </th>
                                                                    <th>
                                                                        {{strtoupper($Name_2[0]['name'])}}
                                                                    </th>
                                                                    <th>
                                                                        {{strtoupper($Name_3[0]['name'])}}
                                                                    </th>
                                                                    <th>
                                                                        {{strtoupper($Name_4[0]['name'])}}
                                                                    </th>
                                                                    <th>
                                                                        {{strtoupper($Name_5[0]['name'])}}
                                                                    </th>
                                                                    <th>
                                                                        {{strtoupper($Name_6[0]['name'])}}
                                                                    </th>
                                                                    <th>
                                                                        {{strtoupper($Name_7[0]['name'])}}
                                                                    </th>
                                                                    <th>  
                                                                        {{strtoupper($Name_8[0]['name'])}}
                                                                    </th>
                                                                    <th>  
                                                                        {{strtoupper($Name_9[0]['name'])}}
                                                                    </th>
                                                                    <th>  
                                                                        {{strtoupper($Name_10[0]['name'])}}
                                                                    </th>
                                                                    <th>  
                                                                        {{strtoupper($Name_11[0]['name'])}}
                                                                    </th>
                                                                    <th>  
                                                                        {{strtoupper($Name_12[0]['name'])}}
                                                                    </th>
                                                                    <th>  
                                                                        {{strtoupper($Name_13[0]['name'])}}
                                                                    </th>
                                                                    <th>  
                                                                        {{strtoupper($Name_14[0]['name'])}}
                                                                    </th>
                                                                    <th>  
                                                                        {{strtoupper($Name_15[0]['name'])}}
                                                                    </th>
                                                                    <th>  
                                                                        {{strtoupper("TOTAL")}}
                                                                    </th>

                                                                </tr>
                                                            </thead>
                                                            
                                                            
                                                            <tbody>
                                                                    <tr class="table-warning">
                                                                        <td><b>NUMBER OF STUDENTS TRANSACTIONS</b></td>
                                                                        <td class="text-center">{{$COUNT}}</td>    
                                                                        <td class="text-center">{{$COUNT}}</td>    
                                                                        <td class="text-center">{{$COUNT}}</td>    
                                                                        <td class="text-center">{{$COUNT}}</td>    
                                                                        <td class="text-center">{{$COUNT}}</td>    
                                                                        <td class="text-center">{{$COUNT}}</td>    
                                                                        <td class="text-center">{{$COUNT}}</td>    
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
                                                                        <td class="text-center"><b>{{number_format($Field_1_DISCOUNT,2,".",",")}}</b></td>
                                                                        <td class="text-center"><b>{{number_format($Field_2_DISCOUNT,2,".",",")}}</b></td>
                                                                        <td class="text-center"><b>{{number_format($Field_3_DISCOUNT,2,".",",")}}</b></td>
                                                                        <td class="text-center"><b>{{number_format($Field_4_DISCOUNT,2,".",",")}}</b></td>
                                                                        <td class="text-center"><b>{{number_format($Field_5_DISCOUNT,2,".",",")}}</b></td>
                                                                        <td class="text-center"><b>{{number_format($Field_6_DISCOUNT,2,".",",")}}</b></td>
                                                                        <td class="text-center"><b>{{number_format($Field_7_DISCOUNT,2,".",",")}}</b></td>
                                                                        <td class="text-center"><b>{{number_format($Field_8_DISCOUNT,2,".",",")}}</b></td>
                                                                        <td class="text-center"><b>{{number_format($Field_9_DISCOUNT,2,".",",")}}</b></td>
                                                                        <td class="text-center"><b>{{number_format($Field_10_DISCOUNT,2,".",",")}}</b></td>
                                                                        <td class="text-center"><b>{{number_format($Field_11_DISCOUNT,2,".",",")}}</b></td>
                                                                        <td class="text-center"><b>{{number_format($Field_12_DISCOUNT,2,".",",")}}</b></td>
                                                                        <td class="text-center"><b>{{number_format($Field_13_DISCOUNT,2,".",",")}}</b></td>
                                                                        <td class="text-center"><b>{{number_format($Field_14_DISCOUNT,2,".",",")}}</b></td>
                                                                        <td class="text-center"><b>{{number_format($Field_15_DISCOUNT,2,".",",")}}</b></td>
                                                                        <td class="text-center"><b>{{number_format($TOTAL_DISCOUNT = $Field_1_DISCOUNT + $Field_2_DISCOUNT + $Field_3_DISCOUNT + $Field_4_DISCOUNT + $Field_5_DISCOUNT + $Field_6_DISCOUNT + $Field_7_DISCOUNT + $Field_8_DISCOUNT + $Field_9_DISCOUNT + $Field_10_DISCOUNT + $Field_11_DISCOUNT + $Field_12_DISCOUNT + $Field_13_DISCOUNT + $Field_14_DISCOUNT + $Field_15_DISCOUNT,2,".",",")}}</b></td>
       
                                                                    </tr>
                                                                    <tr class="table-warning">
                                                                        <td><b>OUTSTANDING BALANCE (₦)</b></td>
                                                                        <td class="text-center"><b>{{number_format($Field_1_BALANCE,2,".",",")}}</b></td>
                                                                        <td class="text-center"><b>{{number_format($Field_2_BALANCE,2,".",",")}}</b></td>
                                                                        <td class="text-center"><b>{{number_format($Field_3_BALANCE,2,".",",")}}</b></td>
                                                                        <td class="text-center"><b>{{number_format($Field_4_BALANCE,2,".",",")}}</b></td>
                                                                        <td class="text-center"><b>{{number_format($Field_5_BALANCE,2,".",",")}}</b></td>
                                                                        <td class="text-center"><b>{{number_format($Field_6_BALANCE,2,".",",")}}</b></td>
                                                                        <td class="text-center"><b>{{number_format($Field_7_BALANCE,2,".",",")}}</b></td>
                                                                        <td class="text-center"><b>{{number_format($Field_8_BALANCE,2,".",",")}}</b></td>
                                                                        <td class="text-center"><b>{{number_format($Field_9_BALANCE,2,".",",")}}</b></td>
                                                                        <td class="text-center"><b>{{number_format($Field_10_BALANCE,2,".",",")}}</b></td>
                                                                        <td class="text-center"><b>{{number_format($Field_11_BALANCE,2,".",",")}}</b></td>
                                                                        <td class="text-center"><b>{{number_format($Field_12_BALANCE,2,".",",")}}</b></td>
                                                                        <td class="text-center"><b>{{number_format($Field_13_BALANCE,2,".",",")}}</b></td>
                                                                        <td class="text-center"><b>{{number_format($Field_14_BALANCE,2,".",",")}}</b></td>
                                                                        <td class="text-center"><b>{{number_format($Field_15_BALANCE,2,".",",")}}</b></td>
                                                                        <td class="text-center"><b>{{number_format($TOTAL_BALANCE = $Field_1_BALANCE + $Field_2_BALANCE + $Field_3_BALANCE + $Field_4_BALANCE + $Field_5_BALANCE + $Field_6_BALANCE + $Field_7_BALANCE + $Field_8_BALANCE + $Field_9_BALANCE + $Field_10_BALANCE + $Field_11_BALANCE + $Field_12_BALANCE + $Field_13_BALANCE + $Field_14_BALANCE + $Field_15_BALANCE,2,".",",")}}</b></td>
       
                                                                    </tr>
                                                                    <tr class="table-primary">
                                                                        <td><b>TOTAL PAID(₦)</b></td>
                                                                        <td class="text-center"><b>{{number_format($Field_1_TOTAL,2,".",",")}}</b></td>
                                                                        <td class="text-center"><b>{{number_format($Field_2_TOTAL,2,".",",")}}</b></td>
                                                                        <td class="text-center"><b>{{number_format($Field_3_TOTAL,2,".",",")}}</b></td>
                                                                        <td class="text-center"><b>{{number_format($Field_4_TOTAL,2,".",",")}}</b></td>
                                                                        <td class="text-center"><b>{{number_format($Field_5_TOTAL,2,".",",")}}</b></td>
                                                                        <td class="text-center"><b>{{number_format($Field_6_TOTAL,2,".",",")}}</b></td>
                                                                        <td class="text-center"><b>{{number_format($Field_7_TOTAL,2,".",",")}}</b></td>
                                                                        <td class="text-center"><b>{{number_format($Field_8_TOTAL,2,".",",")}}</b></td>
                                                                        <td class="text-center"><b>{{number_format($Field_9_TOTAL,2,".",",")}}</b></td>
                                                                        <td class="text-center"><b>{{number_format($Field_10_TOTAL,2,".",",")}}</b></td>
                                                                        <td class="text-center"><b>{{number_format($Field_11_TOTAL,2,".",",")}}</b></td>
                                                                        <td class="text-center"><b>{{number_format($Field_12_TOTAL,2,".",",")}}</b></td>
                                                                        <td class="text-center"><b>{{number_format($Field_13_TOTAL,2,".",",")}}</b></td>
                                                                        <td class="text-center"><b>{{number_format($Field_14_TOTAL,2,".",",")}}</b></td>
                                                                        <td class="text-center"><b>{{number_format($Field_15_TOTAL,2,".",",")}}</b></td>
                                                                        <td class="text-center"><b>{{number_format($TOTAL_PAID = $Field_1_TOTAL + $Field_2_TOTAL + $Field_3_TOTAL + $Field_4_TOTAL + $Field_5_TOTAL + $Field_6_TOTAL + $Field_7_TOTAL + $Field_8_TOTAL + $Field_9_TOTAL + $Field_10_TOTAL + $Field_11_TOTAL + $Field_12_TOTAL + $Field_13_TOTAL + $Field_14_TOTAL + $Field_15_TOTAL,2,".",",")}}</b></td>
       
                                                                    </tr>
                                                                    <tr><td><td></tr>

                                                                    <tr class="table-success">
                                                                        
                                                                        <td><b>OVERALL ACCUMULATED TOTAL (₦)</b></td>
                                                                            <td class="text-center"><b>{{number_format($Field_1_DISCOUNT + $Field_1_BALANCE + $Field_1_TOTAL,2,".",",")}}</b></td>
                                                                            <td class="text-center"><b>{{number_format($Field_2_DISCOUNT + $Field_2_BALANCE + $Field_2_TOTAL,2,".",",")}}</b></td>
                                                                            <td class="text-center"><b>{{number_format($Field_3_DISCOUNT + $Field_3_BALANCE + $Field_3_TOTAL,2,".",",")}}</b></td>
                                                                            <td class="text-center"><b>{{number_format($Field_4_DISCOUNT + $Field_4_BALANCE + $Field_4_TOTAL,2,".",",")}}</b></td>
                                                                            <td class="text-center"><b>{{number_format($Field_5_DISCOUNT + $Field_5_BALANCE + $Field_5_TOTAL,2,".",",")}}</b></td>
                                                                            <td class="text-center"><b>{{number_format($Field_6_DISCOUNT + $Field_6_BALANCE + $Field_6_TOTAL,2,".",",")}}</b></td>
                                                                            <td class="text-center"><b>{{number_format($Field_7_DISCOUNT + $Field_7_BALANCE + $Field_7_TOTAL,2,".",",")}}</b></td>
                                                                            <td class="text-center"><b>{{number_format($Field_8_DISCOUNT + $Field_8_BALANCE + $Field_8_TOTAL,2,".",",")}}</b></td>
                                                                            <td class="text-center"><b>{{number_format($Field_9_DISCOUNT + $Field_9_BALANCE + $Field_9_TOTAL,2,".",",")}}</b></td>
                                                                            <td class="text-center"><b>{{number_format($Field_10_DISCOUNT + $Field_10_BALANCE + $Field_10_TOTAL,2,".",",")}}</b></td>
                                                                            <td class="text-center"><b>{{number_format($Field_11_DISCOUNT + $Field_11_BALANCE + $Field_11_TOTAL,2,".",",")}}</b></td>
                                                                            <td class="text-center"><b>{{number_format($Field_12_DISCOUNT + $Field_12_BALANCE + $Field_12_TOTAL,2,".",",")}}</b></td>
                                                                            <td class="text-center"><b>{{number_format($Field_13_DISCOUNT + $Field_13_BALANCE + $Field_13_TOTAL,2,".",",")}}</b></td>
                                                                            <td class="text-center"><b>{{number_format($Field_14_DISCOUNT + $Field_14_BALANCE + $Field_14_TOTAL,2,".",",")}}</b></td>
                                                                            <td class="text-center"><b>{{number_format($Field_15_DISCOUNT + $Field_15_BALANCE + $Field_15_TOTAL,2,".",",")}}</b></td>
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