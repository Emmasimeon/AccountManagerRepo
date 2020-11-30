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
                                        <i class="pe-7s-menu text-success">
                                        </i>
                                    </div>
                                    <div>Payment Modes</br>
                                    <small>Add payment modes or medium to which parents could pay the school</small>
                                    </div>
                                </div>
                                </div>
                        </div>            <ul class="body-tabs body-tabs-layout tabs-animated body-tabs-animated nav">
                        </ul>
                        <div class="tab-content">
                            

                            <div class="row">
                            <div class="col-lg-12">
                                <div class="main-card mb-3 card">
                                    <div class="card-body"><h5 class="card-title">Available Payment Modes</h5>
                                        <table class="mb-0 table table-bordered">
                                            <thead>
                                            @if (count($Mode) > 0)
                                            <tr>
                                                <th>#</th>
                                                <th>Payment Modes:</th>
                                                <th>Status:</th>
                                                <th>Action:</th>
                                            </tr>
                                            </thead>
                                             <?php $number = 1; ?>
                                             <?php $Message; ?>
                                            <tbody>
                                                
                                                        @foreach ($Mode as $Mode )
                                                            <tr>
                                                                <td>{{$number++}}</td>
                                                                <td>{{$Mode->modes}}</td>
                                                                @if ($Mode->status == 0)
                                                                    <td>Deactivated</td>
                                                                    <td>
                                                                    <a class="btn btn-lg btn-primary" href="/Edit/Payment_Mode/{{$Mode->id}}">Edit  <i class="fa fa-edit"></i></a> 
                                                                    <a class="btn btn-lg btn-success" href="/Activate/Payment_Mode/{{$Mode->id}}">Activate  <i class="fa fa-check"></i></a>
                                                                    </td> 
                                                                @else
                                                                     <td>Activated</td>
                                                                     <td>
                                                                     <a class="btn btn-lg btn-primary" href="/Edit/Payment_Mode/{{$Mode->id}}">Edit  <i class="fa fa-edit"></i></a> 
                                                                     <a class="btn btn-lg btn-danger" href="/Deactivate/Payment_Mode/{{$Mode->id}}">Deactivate   <i class="fa fa-window-close"></i></a>
                                                                     </td> 
                                                                @endif
                                                                
                                                             </tr>
                                                        @endforeach
                                                @else
                                                    <h5>No available Payment Modes to display! Please add Payment Modes</h5>   
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