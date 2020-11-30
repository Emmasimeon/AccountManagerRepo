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
                                    <div>TOTAL (<b>{{strtoupper($Payment_Name[0]['income_category'])}}</b>) RECEIVED FOR ({{$SESSION[0]['sessions']}}) - ACADEMIC SESSION
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
                                    <div class="card-body"><h5 class="card-title">Total <b>{{strtoupper($Payment_Name[0]['income_category'])}}</b> Receipts for <b><i>{{$SESSION[0]['sessions']}}</i></b> - Academic Session</h5>
                                                
                                            
                                                    <div class="form-row">
                                                        <table class="mb-0 table table-sm table-responsive">
                                                            <thead>
                                                                <tr class="table-info">
                                                                    <th></th>
                                                                    <th class="text-center">
                                                                       <b>{{strtoupper($Payment_Name[0]['income_category'])}}</b>
                                                                    </th>

                                                                </tr>
                                                            </thead>
                                                            
                                                            
                                                            <tbody>
                                                                    <tr class="table-warning"> 
                                                                        <td><b>NUMBER OF STUDENTS TRANSACTIONS</b></td>
                                                                        <td class="text-center">{{$COUNT}}</td>    
                                                                    </tr>
                                                                    
                                                                    <tr class="table-primary">
                                                                        <td><b>OUTSTANDING BALANCE (₦)</b></td>
                                                                        <td class="text-center"><b>{{number_format($BALANCE,2,".",",")}}</b></td>
                                                                    </tr>
                                                                    <tr class="table-warning">
                                                                        <td><b>TOTAL PAID (₦)</b></td>
                                                                        <td class="text-center"><b>{{number_format($TOTAL_PAID,2,".",",")}}</b></td>
                                                                    </tr>
                                                                    <tr><td><td></tr>

                                                                    <tr class="table-success">
                                                                        
                                                                        <td><b>GRAND TOTAL (₦)</b></td>
                                                                            <td class="text-center"><b>{{number_format($TOTAL,2,".",",")}}</b></td>
                                                                            
                                                                            
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