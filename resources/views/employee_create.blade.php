@extends('layouts.app', ['page' => __('Employee Management'), 'pageSlug' => 'employee-management'])

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form method="post" action="{{ route('employee.store') }}" autocomplete="off" class="form-horizontal">
                    @csrf
                    @method('post')

                    <div class="card ">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">{{ __('Add Employee') }}</h4>
                            <p class="card-category"></p>
                        </div>
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-md-12 text-right">
                                    <a href="{{ route('employee.index') }}"
                                        class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-2 col-form-label">{{ __('Acc_id') }}</label>
                                <div class="col-sm-7">
                                    <div class="form-group{{ $errors->has('acc_id') ? ' has-danger' : '' }}">
                                        <input class="form-control{{ $errors->has('acc_id') ? ' is-invalid' : '' }}"
                                            name="acc_id" id="input-acc_id" type="acc_id"
                                            placeholder="{{ __('Acc_id') }}" value="{{ old('acc_id') }}" required />
                                        @if ($errors->has('acc_id'))
                                        <span id="acc_id-error" class="error text-danger"
                                            for="input-acc_id">{{ $errors->first('acc_id') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-2 col-form-label">{{ __('Name') }}</label>
                                <div class="col-sm-7">
                                    <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                        <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                            name="name" id="input-name" type="text" placeholder="{{ __('Name') }}"
                                            value="{{ old('name') }}" required="true" aria-required="true" />
                                        @if ($errors->has('name'))
                                        <span id="name-error" class="error text-danger"
                                            for="input-name">{{ $errors->first('name') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-2 col-form-label">{{ __('Basic Salary') }}</label>
                                <div class="col-sm-7">
                                    <div class="form-group{{ $errors->has('basic_salary') ? ' has-danger' : '' }}">
                                        <input
                                            class="form-control{{ $errors->has('basic_salary') ? ' is-invalid' : '' }}"
                                            name="basic_salary" id="input-basic_salary" type="basic_salary"
                                            placeholder="{{ __('Basic Salary') }}" value="{{ old('basic_salary') }}"
                                            required />
                                        @if ($errors->has('basic_salary'))
                                        <span id="basic_salary-error" class="error text-danger"
                                            for="input-basic_salary">{{ $errors->first('basic_salary') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-2 col-form-label">{{ __('Probation') }}</label>
                                <div class="col-sm-7">
                                    <div class="form-group{{ $errors->has('probation') ? ' has-danger' : '' }}">
                                        <input id="probation" name="probation" data-width="125" data-height="40"
                                            class="toggle-class" type="checkbox" data-onstyle="success"
                                            data-offstyle="danger" data-toggle="toggle" data-on="Probation"
                                            data-off="permanent">

                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="card-footer ml-auto mr-auto">
                            <button type="submit" class="btn btn-primary">{{ __('Add Employee') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
