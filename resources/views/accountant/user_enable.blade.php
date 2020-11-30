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
                                        <i class="pe-7s-less text-success">
                                        </i>
                                    </div>
                                    <div>Enable User Account
                                    </div>
                                </div>
                                </div>
                        </div>            <ul class="body-tabs body-tabs-layout tabs-animated body-tabs-animated nav">
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
                                <div class="main-card mb-3 card">
                                    <div class="card-body"><h5 class="card-title">Users List</h5>
                                        <form method="POST" action="/Disable" class="">
                                            {{ csrf_field()}}

                                            <table class="mb-0 table table-bordered">
                                            <thead>
                                            @if (count($Users) > 0)
                                                <tr>
                                                    <th>#</th>
                                                    <th>NAME:</th>
                                                    <th>EMAIL:</th>
                                                    <th>USER CATEGORY:</th>
                                                    <th>ACTION:</th>
                                                    
                                                </tr>
                                                </thead>
                                                <?php $number = 1; ?>
                                                <tbody>
                                                    @foreach ($Users as $User )
                                                        <tr>
                                                            <td>{{$number++}}</td>
                                                            <td>{{$User->name}}</td>
                                                            <td>{{$User->email}}</td>
                                                            <td>{{$User->user_category}}</td>
                                                            <td><a class="btn btn-info" href="/Enable/{{$User->id}}"><i class="fa fa-user"></i>  Enable</a></td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            @else
                                                <h5>Users list empty</h5>    
                                            @endif
                                        </table>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            
                            
                        </div>
                        </div>
                    </div>
@endsection