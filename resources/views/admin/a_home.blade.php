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
            <div>Administrator Dashboard</div>
        </div>
    </div>
</div>    
<div class="tab-content">
    <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
        <div class="main-card mb-3 card">
            <div class="card-body">
                <h5 class="card-title">Recent Transactions
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
                                <th><small>Trans. no</small></th>
                                <th><small>Sender</small></th>
                                <th><small>Amount</small></th>
                                <th><small>Receive</small></th>
                                <th><small>Bill charge($)</small></th>
                                <th><small>Superior currency</small></th>
                                <th><small>Inferior currency</small></th>
                                <th><small>Market forex</small></th>
                                <th><small>Applied forex</small></th>
                                <th><small>Forex offset</small></th>
                                <th><small>Superior forex charge</small></th>
                                <th><small>Inferior forex charge</small></th>
                                <th><small>Brank ref</small></th>
                                <th><small>Mpesa ref</small></th>
                                <th><small>Status</small></th>
                                <th><small>Dated</small></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($recents))
                                @foreach( $recents as $r)
                                @php( $inff = explode('SD',$r['bill_charges']) )
                                <tr>
                                <td><a href="{{route('a_tran', ['id'=> $r['internal_ref']])}}">{{$r['internal_ref']}}</a></td>
                                <td style="min-width: 150px;">
                                {{\App\User::find($r['user'])->fname}}
                                {{\App\User::find($r['user'])->lname}}
                                </td>
                                <td>${{number_format($r['sup_amount'], 2)}}</td>
                                <td>Ksh.{{number_format($r['inf_amount'], 0)}}</td>
                                <td>${{number_format($inff[1], 2)}}</td>
                                <td>{{$r['sup_currency']}}</td>
                                <td>{{$r['inf_currency']}}</td>
                                <td>{{$r['market_rate']}}</td>
                                <td>{{$r['applied_rate']}}</td>
                                <td>{{$r['forex_offset']}}</td>
                                <td>{{$r['sup_forex_charges']}}</td>
                                <td>Ksh.{{number_format($r['inf_forex_charges'], 0)}}</td>
                                <td><a href="#">{{$r['bank_tran_ref']}}</a></td>
                                <td><a href="#">{{$r['mpesa_tran_ref']}}</a></td>
                                <td>{{$r['status']}}</td>
                                <td style="min-width: 150px;">{{date('M jS, Y', strtotime($r['updated_at']))}}</td>
                                </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
                <br>
                <a href="{{route('a_trans')}}" class="btn btn-lg btn-primary">More transactions</a>
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
