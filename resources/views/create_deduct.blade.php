@extends('layouts.app', ['page' => __('Deduct'), 'pageSlug' => 'deduct'])

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
                                    <a href="{{ route('deduction') }}"
                                        class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                                </div>
                            </div>
        <div class="row">
            <div class="col-md-7">

                <form class="well form-horizontal" action="{{route('store_deduction')}}" method="POST">
                    @csrf
                    <div class="card ">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">{{ __('Create Deduction') }}</h4>
                            <p class="card-category"></p>
                        </div>
                        <div class="card-body ">
                            <fieldset>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Employee Name</label>
                                    <div class="col-md-8">
                                        <div><select name="employee_id" data-size="5" class="form-control selectpicker"
                                                data-live-search="true">
                                                @foreach ($employees as $emp)
                                                <option value="{{$emp->id}}" data-tokens="{{$emp->full_name}}">
                                                    {{$emp->full_name}}</option>
                                                @endforeach
                                            </select></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Medical</label>
                                    <div class="col-md-8">
                                        <div><input type="text" class="form-control" id="mded" name="medical"
                                                placeholder="Medical">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Absentism</label>
                                    <div class="col-md-8">
                                        <div><input type="text" class="form-control" id="aded" name="absent"
                                                placeholder="Absentism">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">other Deduction</label>
                                    <div class="col-md-8">
                                        <div><input type="text" class="form-control" id="otded" name="other"
                                                placeholder="Other Deduction"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Loan</label>
                                    <div class="col-md-8">
                                        <div><input type="text" class="form-control" id="lded" name="loan"
                                                placeholder="Loan"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Car</label>
                                    <div class="col-md-8">
                                        <div><input type="text" class="form-control" id="lded" name="car"
                                                placeholder="Car"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">PMA</label>
                                    <div class="col-md-8">
                                        <div><input type="text" class="form-control" id="lded" name="pma"
                                                placeholder="PMA"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Exam Failed</label>
                                    <div class="col-md-8">
                                        <div><input type="text" class="form-control" id="lded" name="exam"
                                                placeholder="exam"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">LateCommers</label>
                                    <div class="col-md-8">
                                        <div><input type="text" class="form-control" id="llatecommer" name="latecommer"
                                                placeholder="Latecommer"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-4 col-md-offset-3">
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
