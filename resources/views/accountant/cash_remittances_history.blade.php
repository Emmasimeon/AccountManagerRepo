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
                                        <i class="pe-7s-graph3 text-success">
                                        </i>
                                    </div>
                                    <div>CASH REMITTANCES REPORT
                                    </div>
                                </div>
                            </div>
                        </div>            
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="main-card mb-3 card">
                                    <div class="card-body"><h5 class="card-title">Cash Remittances Report for { <i>{{$Start_Date}}</i> } to { <i>{{$End_Date}}</i> }</h5>
                                        <table class="mb-0 table table-bordered">
                                        <?php $number = 1; ?>
                                            <thead>
                                             @if (count($Report) > 0)
                                            <tr>
                                                <th>#</th>
                                                <th class="text-center">RECORDED DATE:</th>
                                                <th class="text-center">TRANSACTION DATE:</th>
                                                <th class="text-center">TRANSACTION BY:</th>
                                                <th class="text-center">AMOUNT(₦):</th>
                                                <th class="text-center">SOURCE:</th>
                                                <th class="text-center">RECEIVIED BY:</th>
                                                <th class="text-center">COMMENT:</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($Report as $Trx)
                                                    <tr>
                                                        <td>{{$number++}}</td>
                                                        <td class="text-center">{{date('d-m-Y', strtotime($Trx->created_at))}}</td>
                                                        <td class="text-center">{{date('d-m-Y', strtotime($Trx->date))}}</td>
                                                        <td><b>{{$Trx->user . ' ('.$Trx->office.')'}}</b></td>
                                                        <td>₦ {{number_format($Trx->amount ,2,".",",")}}</td>
                                                        <td>{{$Trx->source}}</td>
                                                        <td>{{$Trx->receiver }}</td>
                                                        <td>{{$Trx->comment }}</td>
                                                    </tr>
                                                @endforeach
                                                    <tr>
                                                        <td colspan="3"><b>TOTAL</b></td>
                                                        <td colspan="4"><b>₦ {{number_format($TOTAL ,2,".",",")}}</b></td>
                                                    </tr>
                                            @else
                                                <h4 class="danger">No Transactions Found!</h4>   
                                            @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        
                        </div>
                    </div>
                    </div>    
                </div>        
@endsection