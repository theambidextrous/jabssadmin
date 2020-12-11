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
.dataTables_info{
    display:none!important;
}
.dataTables_paginate{
    display:none!important;
}
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
            <div><a href="{{route('a_home')}}">Administrator Dashboard</a> > <a href="{{route('a_mps')}}">Mpesa</a> > Single item</div>
        </div>
    </div>
</div>    
<div class="tab-content">
    <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
        <div class="main-card mb-3 card">
            <div class="card-body">
                <h5 class="card-title">Entry metadata
                    <!-- <span class="pull-right"> 
                        <button type="button" class="btn mr-2 mb-2 btn-danger fundsmodal" data-toggle="modal" data-target="#fundsmodal"> <i class="pe-7s-plus text-white">
                </i> Delete</button>
                    </span> -->
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
                        <h5>Mpesa entry</h5>
                        <table class="mb-0 table table-sm">
                            <thead>
                                <tr>
                                    <th><small></small></th>
                                    <th><small></small></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Mpesa internal ref</td>
                                    <td><b>{{$r['internal_ref']}}</b></td>
                                </tr>
                                <tr>
                                    <td>Mpesa confirmation code</td>
                                    <td>{{$r['external_ref']}}</td>
                                </tr>
                                <tr>
                                    <td>Confirmation date</td>
                                    <td>{{date('M jS, Y H:i:s', strtotime($r['updated_at']))}}</td>
                                </tr>
                                <tr>
                                    <td>Mpesa amount</td>
                                    <td>Ksh.{{number_format($r['amount'], 0)}}</td>
                                </tr>
                                <tr>
                                    <td>Receiver</td>
                                    <td>{{$r['receiver']}}</td>
                                </tr>
                                <tr>
                                    <td>Receiver name(as registered by Mpesa)</td>
                                    <td>{{$r['receiver_name']}}</td>
                                </tr>
                                <tr>
                                    <td>Bill account number</td>
                                    <td>{{$r['account']}}</td>
                                </tr>
                                <tr>
                                    <td>Mpesa transaction type</td>
                                    <td>{{$r['send_type'] == 1 ? 'Send to Mpesa' : 'Send to Till or Paybill'}}</td>
                                </tr>
                                <tr>
                                    <td>Notes</td>
                                    <td>{{$r['note']}}</td>
                                </tr>
                            </tbody>
                        </table>
                        <br>
                        <h5>Related bank entry</h5>
                        <table class="mb-0 table table-sm">
                            <thead>
                                <tr>
                                    <th><small></small></th>
                                    <th><small></small></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php( $b = \App\Bank::where('internal_ref', $r['bank_ref'])->first() )
                                @if( is_null($b) )
                                    @php( $b = [] )
                                @else 
                                    @php( $b = $b->toArray())
                                @endif
                                <tr>
                                    <td>Bank internal ref</td>
                                    <td><b>{{$b['internal_ref']}}</b></td>
                                </tr>
                                <tr>
                                    <td>Bank confirmation reference</td>
                                    <td>{{$b['external_ref']}}</td>
                                </tr>
                                <tr>
                                    <td>Debit date</td>
                                    <td>{{date('M jS, Y H:i:s', strtotime($b['updated_at']))}}</td>
                                </tr>
                                <tr>
                                    <td>Debit amount</td>
                                    <td>${{number_format($b['amount'], 2)}}</td>
                                </tr>
                                <tr>
                                    <td>Bill charges</td>
                                    <td>${{number_format($b['bill_charges'], 2)}}</td>
                                </tr>
                                <tr>
                                    <td>Debit currency</td>
                                    <td>{{$b['currency']}}</td>
                                </tr>
                                <tr>
                                    <td>Market forex rate</td>
                                    <td>{{$b['market_rate']}}</td>
                                </tr>
                                <tr>
                                    <td>Applied forex rate</td>
                                    <td>{{$b['applied_rate']}}</td>
                                </tr>
                                <tr>
                                    <td>Forex offset</td>
                                    <td>{{$b['forex_offset']}}</td>
                                </tr>
                            </tbody>
                        </table>
                        <!-- {{print_r($b)}} -->
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
                <h5 class="modal-title text-white" id="exampleModalLabel">Delete Entry</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('a_deltran', ['id' => $r['id']])}}" method="POST" id="newcourse">
                    @csrf
                    <div class="form-row">
                        <div class="col-md-12">
                            <div class="position-relative form-group">
                                <div class="input-group">
                                    <p class="alert alert-danger">
                                    You are about to <b>PERMANENTLY</b> delete this transaction entry including any related entries such as Mpesa and Bank.
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
                    <button type="submit" class="mt-2 btn btn-danger">Delete entry</button>
                </form>
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button> -->
            </div>
        </div>
    </div>
</div>
