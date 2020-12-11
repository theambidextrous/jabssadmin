@extends('layouts.inner')


@section('topnav')
    @include('commons/topnav')
@endsection


@section('sidenav')
    @include('commons/sidenav_admin')
@endsection


@section('content')
<style>
.modal-header, .modal-footer {
    background: #4267b4!important;
}
.modal-header {
    border-bottom: 1px solid #4267b4!important;
}
.input-group-text-custom {
    display: flex;
    align-items: center;
    padding: .375rem .75rem;
    margin-bottom: 0;
    font-size: .88rem;
    font-weight: 400;
    line-height: 1.5;
    color: #ffffff;
    text-align: center;
    white-space: nowrap;
    background-color: #4267b4;
    border: 1px solid #4267b4;
    border-radius: .25rem;
}
.bdg{
    padding:6px;
    border-radius:6px;
}
/* .dataTables_info{
    display:none!important;
}
.dataTables_paginate{
    display:none!important;
} */
.dataTables_filter{
    display:none!important;
}
.app-main {
    display: block!important;
}
.form-control {
    border: solid 0px;
    border-bottom: 1px solid #ced4da;
    border-radius: .2rem;
}
</style>
<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="pe-7s-home text-info">
                </i>
            </div>
            <div><a href="{{route('a_home')}}">Administrator Dashboard</a> > <a href="{{route('a_users')}}">Jabss users</a> > {{$r['fname']}} {{$r['lname']}}</div>
        </div>
    </div>
</div>    
<div class="tab-content">
    <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
        <div class="main-card mb-3 card">
            <div class="card-body">
                <h5 class="card-title">User information
                    <span class="pull-right"> 
                        <button type="button" class="btn mr-2 mb-2 btn-danger fundsmodal" data-toggle="modal" data-target="#fundsmodal"> <i class="pe-7s-plus text-white">
                </i> Delete</button>
                    </span>
                </h5>
                <br>
                <!-- messges -->
                @if(Session::get('status') && Session::get('status') == 200)
                <!-- hp( $courses = Session::get('courses')) -->
                <div class="alert alert-success">{{Session::get('message')}}</div>
                @endif
                @if(Session::get('status') && Session::get('status') == 201)
                <!-- pp( $courses = Session::get('courses')) -->
                <div class="alert alert-danger">{{Session::get('message')}}</div>
                @endif
                <!-- recents -->
                <div class="row">
                    <div class="col-md-8">
                        <div class="table-responsive">
                        <h5>Personal information</h5>
                        <table class="mb-0 table table-sm">
                            <thead>
                                <tr>
                                    <th><small></small></th>
                                    <th><small></small></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php( $ppp = \App\User::format_us_number($r['phone']) )
                                <tr>
                                    <td>Full name</td>
                                    <td>{{$r['fname']}} {{$r['lname']}}</td>
                                </tr>
                                <tr>
                                    <td>Address</td>
                                    <td>{{$r['address']}}</td>
                                </tr>
                                <tr>
                                    <td>City</td>
                                    <td>{{$r['city']}}</td>
                                </tr>
                                <tr>
                                    <td>State</td>
                                    <td>{{$r['state']}}</td>
                                </tr>
                                <tr>
                                    <td>Zip code</td>
                                    <td>{{$r['zip']}}</td>
                                </tr>
                                <tr>
                                    <td>Email address</td>
                                    <td>{{$r['email']}}</td>
                                </tr>
                                <tr>
                                    <td>Phone number</td>
                                    <td>{{$ppp}}</td>
                                </tr>
                                <tr>
                                    <td>Date subscribed</td>
                                    <td>{{date('M jS, Y H:i:s', strtotime($r['created_at']))}}</td>
                                </tr>
                            </tbody>
                        </table>
                        <br>
                        <h5>Additional addresses</h5>
                        <table class="mb-0 table table-sm reportable">
                            <thead>
                                <tr>
                                    <th><small>Address</small></th>
                                    <th><small>City</small></th>
                                    <th><small>State</small></th>
                                    <th><small>Zip code</small></th>
                                </tr>
                            </thead>
                            <tbody>
                            @if(count($add))
                                @foreach( $add as $a)
                                <tr>
                                    <td>{{$a['address']}}</td>
                                    <td>{{$a['city']}}</td>
                                    <td>{{$a['state']}}</td>
                                    <td>{{$a['zip']}}</td>
                                </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                        <br>
                        <h5>Card information</h5>
                        <table class="mb-0 table table-sm reportable">
                            <thead>
                                <tr>
                                    <th><small>Mask</small></th>
                                    <th><small>Type</small></th>
                                    <th><small>Default</small></th>
                                </tr>
                            </thead>
                            <tbody>
                            @if(count($pan))
                                @foreach( $pan as $p)
                                <tr>
                                    <td>{{$p['mask']}}</td>
                                    <td>{{$p['cardtype']}}</td>
                                    <td>{{$p['isdefault'] == 1 ? 'Yes':'No'}}</td>
                                </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
                <!-- end recents -->
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')
    @include('commons/footer')
@endsection

<div class="modal fade" id="fundsmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-white" id="exampleModalLabel">Delete record</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('a_deluser', ['id' => $r['id']])}}" method="POST" id="newcourse">
                    @csrf
                    <div class="form-row">
                        <div class="col-md-12">
                            <div class="position-relative form-group">
                                <div class="input-group">
                                    <p class="alert alert-danger">
                                    You are about to <b>PERMANENTLY</b> delete this user record.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="col-md-12">
                            <div class="position-relative form-group">
                                <div class="input-group">
                                    <textarea class="form-control" name="description" id="description" placeholder="enter course description" aria-describedby="inputGroupPrepend" required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="position-relative form-group">
                                <div class="input-group">
                                    <input type="number" class="form-control" name="duration" id="duration" placeholder="enter course duration in months" aria-describedby="inputGroupPrepend" required>
                                </div>
                            </div>
                        </div> -->
                    </div>
                    <button type="submit" class="mt-2 btn btn-danger">Delete record</button>
                </form>
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button> -->
            </div>
        </div>
    </div>
</div>
