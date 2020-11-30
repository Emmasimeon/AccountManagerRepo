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
                                        <i class="pe-7s-tools text-success">
                                        </i>
                                    </div>
                                    <div>PERSONALIZATION - ACCOUNT MANAGER SETUP 
                                    </div>
                                </div>
                                </div>
                        </div>            <ul class="body-tabs body-tabs-layout tabs-animated body-tabs-animated nav">
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
                                <div class="main-card mb-3 card">
                                    <div class="card-body"><h5 class="card-title">SCHOOL DETAILS</h5>
                                        <form method="POST" action="/Store/Personalization" class="">
                                            {{ csrf_field()}}

                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group"><label for="School Name" class="">SCHOOL NAME</label><input name="Name" id="Name" placeholder="i.e Zion International School" type="text" class="form-control"></div>
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group"><label for="School Address" class="">SCHOOL ADDRESS</label><input name="Address" id="Address" placeholder="i.e No. 15 Aminu Kano, Wuse 2 - Abuja" type="text" class="form-control"></div>
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group"><label for="School Motto" class="">MOTTO</label><input name="Motto" id="Motto" placeholder="i.e Knowledge is Power" type="text" class="form-control"></div>
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group"><label for="School Logo" class="">SCHOOL LOGO</label><input type="file" name="Logo" id="Logo" class="form-control"></div>
                                                </div>
                                            </div>

                                            </div>
                                            <button class="mt-2 btn btn-primary">Update</button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                            <div class="col-lg-12">
                                <div class="main-card mb-3 card">
                                    <div class="card-body"><h5 class="card-title">DETAILS</h5>
                                        <table class="mb-0 table table-bordered">
                                            <thead>
                                            <tr>
                                                <th>Personalization Details</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                               <tr><td>SCHOOL NAME:  <b>{{$Details->school_name}}</b></td></tr>
                                               <tr><td>SCHOOL ADDRESS: <b>{{$Details->school_address}}</b></td></tr>
                                               <tr><td>SCHOOL MOTTO: <b>{{$Details->school_motto}}</b></td></tr>
                                               <tr><td>SCHOOL LOGO: </td></tr>
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