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
            <div><a href="{{route('a_home')}}">Administrator Dashboard</a> > Bank </div>
        </div>
    </div>
</div>    
<div class="tab-content">
    <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
        <div class="main-card mb-3 card">
            <div class="card-body">
                <h5 class="card-title">Bank entries
                    <span class="pull-right"> 
                        <!-- <button type="button" class="btn mr-2 mb-2 btn-primary fundsmodal" data-toggle="modal" data-target="#fundsmodal"> <i class="pe-7s-plus text-white">
                </i> Add Course</button> -->
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
                                <th><small>Internal reference</small></th>
                                <th><small>Sender</small></th>
                                <th><small>Amount</small></th>
                                <th><small>Bill charges</small></th>
                                <th><small>Currency</small></th>
                                <th><small>Market forex rate</small></th>
                                <th><small>Applied forex rate</small></th>
                                <th><small>Forex offset</small></th>
                                <th><small>Bank reference</small></th>
                                <th><small>Mpesa ref</small></th>
                                <th><small>Status</small></th>
                                <th><small>Dated</small></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($recents))
                                @foreach( $recents as $r)
                                <tr>
                                <td><a href="{{route('a_bnk', ['id'=> $r['internal_ref']])}}">{{$r['internal_ref']}}</a></td>
                                <td style="min-width: 150px;">
                                {{\App\User::find($r['user'])->fname}}
                                {{\App\User::find($r['user'])->lname}}
                                </td>
                                <td>${{number_format($r['amount'], 2)}}</td>
                                <td>${{number_format($r['bill_charges'], 2)}}</td>
                                <td>{{$r['currency']}}</td>
                                <td>{{$r['market_rate']}}</td>
                                <td>{{$r['applied_rate']}}</td>
                                <td>{{$r['forex_offset']}}</td>
                                <td>{{$r['external_ref']}}</td>
                                <td><a target="_blank" href="{{route('a_mp', ['id'=> $r['mpesa_ref']])}}">{{$r['mpesa_ref']}}</a></td>
                                <td>{{$r['status']}}</td>
                                <td style="min-width: 150px;">{{date('M jS, Y', strtotime($r['updated_at']))}}</td>
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
