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
            <div class="col-md-7">
                <form class="well form-horizontal" action="{{route('update_deduction',$deduct->id)}}" method="POST">
                    @csrf
                    <div class="card ">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">{{ __('Edit Deduction') }}</h4>
                            <p class="card-category"></p>
                        </div>
                        <div class="card-body ">
                            <fieldset>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Employee</label>
                                    <div class="col-md-8">
                                        <div><select name="employee_id" data-size="5" class="form-control selectpicker"
                                                data-live-search="true">
                                                @foreach ($employees as $emp)
                                                <option {{ $emp->id == $deduct->employee_id ? 'selected':'' }}
                                                    value="{{$emp->id}}" data-tokens="{{$emp->full_name}}">
                                                    {{$emp->full_name}}</option>
                                                @endforeach
                                            </select></div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label">Medical</label>
                                    <div class="col-md-8">
                                        <div><input type="text" class="form-control" id="mded" name="medical"
                                                value="{{$deduct->medical}}"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Absentism</label>
                                    <div class="col-md-8">
                                        <div><input type="text" class="form-control" id="aded" name="absent"
                                                value="{{$deduct->absent}}"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">other Deduction</label>
                                    <div class="col-md-8">
                                        <div><input type="text" class="form-control" id="otded" name="other"
                                                value="{{$deduct->other}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Loan</label>
                                    <div class="col-md-8">
                                        <div><input type="text" class="form-control" id="lded" name="loan"
                                                value="{{$deduct->loan}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">PMA</label>
                                    <div class="col-md-8">
                                        <div><input type="text" class="form-control" id="lpma" name="pma"
                                                value="{{$deduct->pma}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Car Maintenance</label>
                                    <div class="col-md-8">
                                        <div><input type="text" class="form-control" id="lded" name="car"
                                                value="{{$deduct->car}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Exam Failed</label>
                                    <div class="col-md-8">
                                        <div><input type="text" class="form-control" id="lded" name="exam"
                                                value="{{$deduct->exam}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">LateCommers</label>
                                    <div class="col-md-8">
                                        <div><input type="text" class="form-control" id="llatecommer" name="latecommer"
                                                value="{{$deduct->latecommer}}">
                                        </div>
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
