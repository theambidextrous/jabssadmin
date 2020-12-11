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
            <div><a href="{{route('a_home')}}">Administrator Dashboard</a> > Admin users </div>
        </div>
    </div>
</div>    
<div class="tab-content">
    <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
        <div class="main-card mb-3 card">
            <div class="card-body">
                <h5 class="card-title">List of admin users
                    <span class="pull-right"> 
                        <button type="button" class="btn mr-2 mb-2 btn-primary fundsmodal" data-toggle="modal" data-target="#fundsmodal"> <i class="pe-7s-plus text-white"></i> Add admin user</button>
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
                    <div class="col-md-12">
                    <div class="table-responsive">
                    <table class="mb-0 table table-sm reportable">
                        <thead>
                            <tr>
                                <th><small>Internal ID</small></th>
                                <th><small>First name</small></th>
                                <th><small>Last name</small></th>
                                <!-- <th><small>Default address</small></th>
                                <th><small>City</small></th>
                                <th><small>State</small></th>
                                <th><small>Zip code</small></th> -->
                                <th><small>Email</small></th>
                                <th><small>Phone</small></th>
                                <th><small>Date created</small></th>
                                <th><small>Delete</small></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($recents))
                                @foreach( $recents as $r)
                                @if(Auth::user()->id != $r['id'])
                                    @php( $p = \App\User::format_us_number($r['phone']) )
                                    <tr>
                                    <td><a href="#">{{$r['id']}}</a></td>
                                    <td>{{$r['fname']}}</td>
                                    <td>{{$r['lname']}}</td>
                                    <td>{{$r['email']}}</td>
                                    <td style="min-width: 150px;">{{$p}}</td>
                                    <td style="min-width: 150px;">{{date('M jS, Y', strtotime($r['created_at']))}}</td>
                                    <td><a class="btn btn-danger" href="{{route('a_deladmin', ['id'=> $r['id']])}}">Delete</a></td>
                                    </tr>
                                @endif
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
                <h5 class="modal-title text-white" id="exampleModalLabel">Add admin user</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('a_add')}}" method="POST" id="newcourse">
                    @csrf
                    <div class="form-row">
                        <div class="col-md-12">
                            <div class="position-relative form-group">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="fname" id="fname" placeholder="First name" aria-describedby="inputGroupPrepend" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="position-relative form-group">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="lname" id="lname" placeholder="Last name" aria-describedby="inputGroupPrepend" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="position-relative form-group">
                                <div class="input-group">
                                    <input type="email" class="form-control" name="email" id="email" placeholder="Email address" aria-describedby="inputGroupPrepend" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="position-relative form-group">
                                <div class="input-group">
                                    <input type="number" class="form-control" name="phone" id="phone" placeholder="Phone" aria-describedby="inputGroupPrepend" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="position-relative form-group">
                                <div class="input-group">
                                    <input type="password" class="form-control" name="password" id="password" placeholder="Set password" aria-describedby="inputGroupPrepend" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="position-relative form-group">
                                <div class="input-group">
                                    <input type="password" class="form-control" name="cpassword" id="cpassword" placeholder="Confirm password" aria-describedby="inputGroupPrepend" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="mt-2 btn btn-danger">Add admin user</button>
                </form>
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button> -->
            </div>
        </div>
    </div>
</div>
