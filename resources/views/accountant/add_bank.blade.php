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
                                        <i class="pe-7s-safe text-success">
                                        </i>
                                    </div>
                                    <div>Bank</br>
                                    <small>Add a Bank to which the school operates and funds are publicy paid into the account</small>
                                    </div>
                                </div>
                                </div>
                        </div>            <ul class="body-tabs body-tabs-layout tabs-animated body-tabs-animated nav">
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
                               
                            </div>

                            <div class="row">
                            <div class="col-lg-12">
                                <div class="main-card mb-3 card">
                                    <div class="card-body"><h5 class="card-title">School Operating Banks</h5>
                                        <table class="mb-0 table table-bordered">
                                            <thead>
                                            @if (count($Banks) > 0)
                                            <tr>
                                                <th>#</th>
                                                <th>Banks:</th>
                                                <th>Status:</th>
                                                <th>Action:</th>
                                            </tr>
                                            </thead>
                                             <?php $number = 1; ?>
                                             <?php $Message; ?>
                                            <tbody>
                                                
                                                        @foreach ($Banks as $Banks )
                                                             <tr>
                                                                <td>{{$number++}}</td>
                                                                <td>{{$Banks->banks}}</td>
                                                                @if ($Banks->status == 0)
                                                                    <td>Deactivated</td>
                                                                    <td>
                                                                    <a class="btn btn-lg btn-primary" href="/Edit/Bank/{{$Banks->id}}">Edit  <i class="fa fa-edit"></i></a> 
                                                                    <a class="btn btn-lg btn-success" href="/Activate/Bank/{{$Banks->id}}">Activate  <i class="fa fa-check"></i></a>
                                                                    </td> 
                                                                @else
                                                                     <td>Activated</td>
                                                                     <td>
                                                                     <a class="btn btn-lg btn-primary" href="/Edit/Bank/{{$Banks->id}}">Edit  <i class="fa fa-edit"></i></a> 
                                                                     <a class="btn btn-lg btn-danger" href="/Deactivate/Bank/{{$Banks->id}}">Deactivate   <i class="fa fa-window-close"></i></a>
                                                                     </td> 
                                                                @endif
                                                                
                                                             </tr>
                                                        @endforeach
                                                @else
                                                    <h5>No Bank added! Please add Bank</h5>   
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