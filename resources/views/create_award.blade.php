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
                                <div class="col-md-12 text-right">
                                    <a href="{{ route('award') }}"
                                        class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                                </div>
                            </div>
        <div class="row">
            <div class="col-md-7">

                <form class="well form-horizontal" action="{{route('store_award')}}" method="POST">
                    @csrf
                    <div class="card ">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">{{ __('Create Bonus') }}</h4>
                            <p class="card-category"></p>
                        </div>
                        <div class="card-body ">

                            <fieldset>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Employee</label>
                                    <div class="col-md-8">
                                        <div>

                                            <select name="employee_id" data-size="5" class="form-control selectpicker"
                                                data-live-search="true">
                                                @foreach ($employees as $emp)
                                                <option value="{{$emp->id}}" data-tokens="{{$emp->full_name}}">
                                                    {{$emp->full_name}}</option>
                                                @endforeach
                                            </select>


                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Allowance</label>
                                    <div class="col-md-8 ">
                                        <div><input type="text" class="form-control" id="eallowance" name="allowance"
                                                placeholder="Allowance">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Exam bonus</label>
                                    <div class="col-md-8 ">
                                        <div><input type="text" class="form-control" id="ebonus" name="exam_bonus"
                                                placeholder="Exam Bonus">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Bonus</label>
                                    <div class="col-md-8 ">
                                        <div><input type="text" class="form-control" id="bbonus" name="bonus"
                                                placeholder="Bonus">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Implementation Effectiveness Bonus</label>
                                    <div class="col-md-8 ">
                                        <div><input type="text" class="form-control" id="bieb" name="ieb"
                                                placeholder="Implementation Effectiveness Bonus">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Effective Order and Delivery Bonus</label>
                                    <div class="col-md-8 ">
                                        <div><input type="text" class="form-control" id="beodb" name="eodb"
                                                placeholder="Effective Order and Delivery Bonus">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Closed Deals Bonus</label>
                                    <div class="col-md-8 ">
                                        <div><input type="text" class="form-control" id="bcdb" name="cdb"
                                                placeholder="Closed Deals Bonus">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Management Performance Evaluation Quarterly Bonus</label>
                                    <div class="col-md-8 ">
                                        <div><input type="text" class="form-control" id="bmpeqb" name="mpeqb"
                                                placeholder="Management Performance Evaluation Quarterly Bonus">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Staff Performance Evaluation Quarterly Bonus</label>
                                    <div class="col-md-8 ">
                                        <div><input type="text" class="form-control" id="bspeqb" name="speqb"
                                                placeholder="Staff Performance Evaluation Quarterly Bonus">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Timely VAT Collection Quarterly Bonus</label>
                                    <div class="col-md-8 ">
                                        <div><input type="text" class="form-control" id="btvcqb" name="tvcqb"
                                                placeholder="Timely VAT Collection Quarterly Bonus">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Timely Payment Collection Quarterly Bonus</label>
                                    <div class="col-md-8 ">
                                        <div><input type="text" class="form-control" id="btpcqb" name="tpcqb"
                                                placeholder="Timely Payment Collection Quarterly Bonus">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Best Employees Productivity and Engagement Quarterly Bonus</label>
                                    <div class="col-md-8 ">
                                        <div><input type="text" class="form-control" id="bbepeqb" name="bepeqb"
                                                placeholder="Best Employees Productivity and Engagement Quarterly Bonus">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Facilities High Availability Quarterly Bonus</label>
                                    <div class="col-md-8 ">
                                        <div><input type="text" class="form-control" id="bfhaqb" name="fhaqb"
                                                placeholder="Facilities High Availability Quarterly Bonus">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-4 col-md-offset-3 ">
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
