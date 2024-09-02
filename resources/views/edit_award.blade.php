@extends('layouts.app', ['page' => __('Award'), 'pageSlug' => 'award'])
@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
<style>
    .dropdown-menu {
        background: #2F3E64;
        color: whitesmoke;
    }
</style>
@endsection
@section('content')
<div class="container">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-7">
                <form class="well form-horizontal" action="{{ route('update_award',$award->id) }}" method="POST">
                    @csrf
                    <div class="card ">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">{{ __('Create Bonus') }}</h4>
                            <p class="card-category"></p>
                        </div>
                        <div class="card-body ">
                            <fieldset>
                                <div class="form-group">
                                    <label class="col-md-8 control-label">Employee</label>
                                    <div class="col-md-8 ">
                                        <select name="employee_id" data-size="5" class="form-control selectpicker"
                                            data-live-search="true">
                                            @foreach ($employees as $emp)
                                            <option {{ $emp->id == $award->employee_id ? 'selected':'' }}
                                                value="{{$emp->id}}" data-tokens="{{$emp->full_name}}">
                                                {{$emp->full_name}}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-8 control-label">Allowance</label>
                                    <div class="col-md-8 ">
                                        <div><input type="text" class="form-control" id="eallowance" name="exam_allowance"
                                                value="{{$award->allowance}}"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-8 control-label">Exam Bonus</label>
                                    <div class="col-md-8 ">
                                        <div><input type="text" class="form-control" id="ebonus" name="exam_bonus"
                                                value="{{$award->exam_bonus}}"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-8 control-label">Bonus</label>
                                    <div class="col-md-8 ">
                                        <div><input type="text" class="form-control" id="bbonus" name="bonus"
                                                value="{{$award->bonus}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-8 control-label">Implementation Effectiveness Bonus</label>
                                    <div class="col-md-8 ">
                                        <div><input type="text" class="form-control" id="bieb" name="ieb"
                                                value="{{$award->ieb}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-8 control-label">Effective Order and Delivery Bonus</label>
                                    <div class="col-md-8 ">
                                        <div><input type="text" class="form-control" id="beodb" name="eodb"
                                                value="{{$award->eodb}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-8 control-label">Closed Deals Bonus</label>
                                    <div class="col-md-8 ">
                                        <div><input type="text" class="form-control" id="bcdb" name="cdb"
                                                value="{{$award->cdb}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-8 control-label">Management Performance Evaluation Quarterly Bonus</label>
                                    <div class="col-md-8 ">
                                        <div><input type="text" class="form-control" id="bmpeqb" name="mpeqb"
                                                value="{{$award->mpeqb}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-8 control-label">Staff Performance Evaluation Quarterly Bonus</label>
                                    <div class="col-md-8 ">
                                        <div><input type="text" class="form-control" id="bspeqb" name="speqb"
                                                value="{{$award->speqb}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-8 control-label">Timely VAT Collection Quarterly Bonus</label>
                                    <div class="col-md-8 ">
                                        <div><input type="text" class="form-control" id="btvcqb" name="tvcqb"
                                                value="{{$award->tvcqb}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-8 control-label">Timely Payment Collection Quarterly Bonus</label>
                                    <div class="col-md-8 ">
                                        <div><input type="text" class="form-control" id="btpcqb" name="tpcqb"
                                                value="{{$award->tpcqb}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-8 control-label">Best Employees Productivity and Engagement Quarterly Bonus</label>
                                    <div class="col-md-8 ">
                                        <div><input type="text" class="form-control" id="bbepeqb" name="bepeqb"
                                                value="{{$award->bepeqb}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-8 control-label">Facilities High Availability Quarterly Bonus</label>
                                    <div class="col-md-8 ">
                                        <div><input type="text" class="form-control" id="bfhaqb" name="fhaqb"
                                                value="{{$award->fhaqb}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-8 col-md-offset-3 ">
                                        <div><input class="btn btn-ouline btn-primary" type="submit" value="Submit">
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>

                </form>

            </div>
        </div>

    </div>

</div>

@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
@endsection
