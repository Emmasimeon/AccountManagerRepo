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
                                    <div>PAYMENT MODE ANALYSIS FOR <b>({{$Selected_Term[0]['term']}})</b>
                                    </div>
                                </div>
                                </div>
                        </div>            
                        <ul class="body-tabs body-tabs-layout tabs-animated body-tabs-animated nav"></ul>
                        <div class="tab-content">
                            <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
                                
                                {{-- School Fee Payment Details Card --}}
                                <div class="main-card mb-3 card">
                                    <div class="card-body"><h5 class="card-title">School Fees payment Mode Analysis for <i>{{$Selected_Term[0]['term']}}</i> </h5>
                                                    <div class="form-row">
                                                        <table class="mb-0 table table-sm table-responsive table-bordered">
                                                        <tr>
                                                            <thead>
                                                                <tr class="table-primary"><th>SCHOOL FEES PAYMENT MODES ANALYSIS:</th></tr>
                                                                <tr class="table-info">
                                                                <th>PAYMENT MODES:</th>
                                                                    <td><b>{{strtoupper($Modes[0]['modes'])}}</b></td>
                                                                    <td><b>{{strtoupper($Modes[1]['modes'])}}</b></td>
                                                                    <td><b>{{strtoupper($Modes[2]['modes'])}}</b></td>
                                                                    <td><b>{{strtoupper($Modes[3]['modes'])}}</b></td>
                                                                    <td><b>{{strtoupper($Modes[4]['modes'])}}</b></td>
                                                                    <td><b>{{strtoupper($Modes[5]['modes'])}}</b></td>
                                                                    <td><b>{{strtoupper($Modes[6]['modes'])}}</b></td>
                                                                    <td><b>{{strtoupper($Modes[7]['modes'])}}</b></td>
                                                                    <td><b>{{strtoupper($Modes[8]['modes'])}}</b></td>
                                                                    <td><b>{{strtoupper($Modes[9]['modes'])}}</b></td>
                                                                <td><b>TOTAL</b></td>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr class="table-warning"> 
                                                                <td><b>TOTAL RECEIVED:</b></td>
                                                                    <td>₦ {{number_format($Mode_1_STotal,2,".",",")}}</td>
                                                                    <td>₦ {{number_format($Mode_2_STotal,2,".",",")}}</td>
                                                                    <td>₦ {{number_format($Mode_3_STotal,2,".",",")}}</td>
                                                                    <td>₦ {{number_format($Mode_4_STotal,2,".",",")}}</td>
                                                                    <td>₦ {{number_format($Mode_5_STotal,2,".",",")}}</td>
                                                                    <td>₦ {{number_format($Mode_6_STotal,2,".",",")}}</td>
                                                                    <td>₦ {{number_format($Mode_7_STotal,2,".",",")}}</td>
                                                                    <td>₦ {{number_format($Mode_8_STotal,2,".",",")}}</td>
                                                                    <td>₦ {{number_format($Mode_9_STotal,2,".",",")}}</td>
                                                                    <td>₦ {{number_format($Mode_10_STotal,2,".",",")}}</td>
                                                                    <td><b>₦ {{number_format($Mode_1_STotal + $Mode_2_STotal + $Mode_3_STotal + $Mode_4_STotal + $Mode_5_STotal + $Mode_6_STotal + $Mode_7_STotal + $Mode_8_STotal + $Mode_9_STotal + $Mode_10_STotal,2,".",",")}}</b></td>
                                                                       
                                                                </tr>
                                                                    <tr><td><td></tr>        
                                                            </tbody>
                                                        </tr>

                                                        <tr>
                                                            <thead>
                                                                <tr class="table-primary"><th>SCHOOL FEES BANK DISTRIBUTION:</th></tr>
                                                                <tr class="table-info">
                                                                <th>BANKS:</th>
                                                                    <td><b>{{strtoupper($Banks[0]['banks'])}}</b></td>
                                                                    <td><b>{{strtoupper($Banks[1]['banks'])}}</b></td>
                                                                    <td><b>{{strtoupper($Banks[2]['banks'])}}</b></td>
                                                                    <td><b>{{strtoupper($Banks[3]['banks'])}}</b></td>
                                                                    <td><b>{{strtoupper($Banks[4]['banks'])}}</b></td>
                                                                    <td><b>{{strtoupper($Banks[5]['banks'])}}</b></td>
                                                                    <td><b>{{strtoupper($Banks[6]['banks'])}}</b></td>
                                                                    <td><b>{{strtoupper($Banks[7]['banks'])}}</b></td>
                                                                    <td><b>{{strtoupper($Banks[8]['banks'])}}</b></td>
                                                                    <td><b>{{strtoupper($Banks[9]['banks'])}}</b></td>
                                                                <td><b>TOTAL</b></td>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr class="table-warning"> 
                                                                <td><b>TOTAL RECEIVED:</b></td>
                                                                    <td>₦ {{number_format($Bank_1_STotal,2,".",",")}}</td>
                                                                    <td>₦ {{number_format($Bank_2_STotal,2,".",",")}}</td>
                                                                    <td>₦ {{number_format($Bank_3_STotal,2,".",",")}}</td>
                                                                    <td>₦ {{number_format($Bank_4_STotal,2,".",",")}}</td>
                                                                    <td>₦ {{number_format($Bank_5_STotal,2,".",",")}}</td>
                                                                    <td>₦ {{number_format($Bank_6_STotal,2,".",",")}}</td>
                                                                    <td>₦ {{number_format($Bank_7_STotal,2,".",",")}}</td>
                                                                    <td>₦ {{number_format($Bank_8_STotal,2,".",",")}}</td>
                                                                    <td>₦ {{number_format($Bank_9_STotal,2,".",",")}}</td>
                                                                    <td>₦ {{number_format($Bank_10_STotal,2,".",",")}}</td>
                                                                    <td><b>₦ {{number_format($Bank_1_STotal + $Bank_2_STotal + $Bank_3_STotal + $Bank_4_STotal + $Bank_5_STotal + $Bank_6_STotal + $Bank_7_STotal + $Bank_8_STotal + $Bank_9_STotal + $Bank_10_STotal,2,".",",")}}</b></td>
                                                                      
                                                                </tr>
                                                                    <tr><td><td></tr>        
                                                            </tbody>
                                                        </tr>
                                                        </table>     
                                                    </div>
                                            
                                                
                                        
                                    </div>
                                </div>

                                {{-- Other Fee Payment Details Card --}}
                                <div class="main-card mb-3 card">
                                    <div class="card-body"><h5 class="card-title">Other fees payment Mode Analysis for <i>{{$Selected_Term[0]['term']}}</i> </h5>
                                                    <div class="form-row">
                                                      <table class="mb-0 table table-sm table-responsive table-bordered">
                                                        <tr>
                                                            <thead>
                                                                <tr class="table-primary"><th>OTHER FEES PAYMENT MODES ANALYSIS:</th></tr>
                                                                <tr class="table-info">
                                                                <th>PAYMENT MODES:</th>
                                                                    <td><b>{{strtoupper($Modes[0]['modes'])}}</b></td>
                                                                    <td><b>{{strtoupper($Modes[1]['modes'])}}</b></td>
                                                                    <td><b>{{strtoupper($Modes[2]['modes'])}}</b></td>
                                                                    <td><b>{{strtoupper($Modes[3]['modes'])}}</b></td>
                                                                    <td><b>{{strtoupper($Modes[4]['modes'])}}</b></td>
                                                                    <td><b>{{strtoupper($Modes[5]['modes'])}}</b></td>
                                                                    <td><b>{{strtoupper($Modes[6]['modes'])}}</b></td>
                                                                    <td><b>{{strtoupper($Modes[7]['modes'])}}</b></td>
                                                                    <td><b>{{strtoupper($Modes[8]['modes'])}}</b></td>
                                                                    <td><b>{{strtoupper($Modes[9]['modes'])}}</b></td>
                                                                <td><b>TOTAL</b></td>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr class="table-warning"> 
                                                                <td><b>TOTAL RECEIVED:</b></td>
                                                                    <td>₦ {{number_format($Mode_1_OTotal,2,".",",")}}</td>
                                                                    <td>₦ {{number_format($Mode_2_OTotal,2,".",",")}}</td>
                                                                    <td>₦ {{number_format($Mode_3_OTotal,2,".",",")}}</td>
                                                                    <td>₦ {{number_format($Mode_4_OTotal,2,".",",")}}</td>
                                                                    <td>₦ {{number_format($Mode_5_OTotal,2,".",",")}}</td>
                                                                    <td>₦ {{number_format($Mode_6_OTotal,2,".",",")}}</td>
                                                                    <td>₦ {{number_format($Mode_7_OTotal,2,".",",")}}</td>
                                                                    <td>₦ {{number_format($Mode_8_OTotal,2,".",",")}}</td>
                                                                    <td>₦ {{number_format($Mode_9_OTotal,2,".",",")}}</td>
                                                                    <td>₦ {{number_format($Mode_10_OTotal,2,".",",")}}</td>
                                                                    <td><b>₦ {{number_format($Mode_1_OTotal + $Mode_2_OTotal + $Mode_3_OTotal + $Mode_4_OTotal + $Mode_5_OTotal + $Mode_6_OTotal + $Mode_7_OTotal + $Mode_8_OTotal + $Mode_9_OTotal + $Mode_10_OTotal,2,".",",")}}</b></td>
                                                                </tr>
                                                                    <tr><td><td></tr>        
                                                            </tbody>
                                                        </tr>

                                                        <tr>
                                                            <thead>
                                                                <tr class="table-primary"><th>OTHER FEES PAYMENT RECEIVED BANK DISTRIBUTION:</th></tr>
                                                                <tr class="table-info">
                                                                <th>BANKS:</th>
                                                                    <td><b>{{strtoupper($Banks[0]['banks'])}}</b></td>
                                                                    <td><b>{{strtoupper($Banks[1]['banks'])}}</b></td>
                                                                    <td><b>{{strtoupper($Banks[2]['banks'])}}</b></td>
                                                                    <td><b>{{strtoupper($Banks[3]['banks'])}}</b></td>
                                                                    <td><b>{{strtoupper($Banks[4]['banks'])}}</b></td>
                                                                    <td><b>{{strtoupper($Banks[5]['banks'])}}</b></td>
                                                                    <td><b>{{strtoupper($Banks[6]['banks'])}}</b></td>
                                                                    <td><b>{{strtoupper($Banks[7]['banks'])}}</b></td>
                                                                    <td><b>{{strtoupper($Banks[8]['banks'])}}</b></td>
                                                                    <td><b>{{strtoupper($Banks[9]['banks'])}}</b></td>
                                                                <td><b>TOTAL</b></td>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr class="table-warning"> 
                                                                <td><b>TOTAL RECEIVED:</b></td>
                                                                    <td>₦ {{number_format($Bank_1_OTotal,2,".",",")}}</td>
                                                                    <td>₦ {{number_format($Bank_2_OTotal,2,".",",")}}</td>
                                                                    <td>₦ {{number_format($Bank_3_OTotal,2,".",",")}}</td>
                                                                    <td>₦ {{number_format($Bank_4_OTotal,2,".",",")}}</td>
                                                                    <td>₦ {{number_format($Bank_5_OTotal,2,".",",")}}</td>
                                                                    <td>₦ {{number_format($Bank_6_OTotal,2,".",",")}}</td>
                                                                    <td>₦ {{number_format($Bank_7_OTotal,2,".",",")}}</td>
                                                                    <td>₦ {{number_format($Bank_8_OTotal,2,".",",")}}</td>
                                                                    <td>₦ {{number_format($Bank_9_OTotal,2,".",",")}}</td>
                                                                    <td>₦ {{number_format($Bank_10_OTotal,2,".",",")}}</td>
                                                                    <td><b>₦ {{number_format($Bank_1_OTotal + $Bank_2_OTotal + $Bank_3_OTotal + $Bank_4_OTotal + $Bank_5_OTotal + $Bank_6_OTotal + $Bank_7_OTotal + $Bank_8_OTotal + $Bank_9_OTotal + $Bank_10_OTotal,2,".",",")}}</b></td>
                                                                </tr>
                                                                    <tr><td><td></tr>        
                                                            </tbody>
                                                        </tr>
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