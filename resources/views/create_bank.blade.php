@extends('layouts.app', ['page' => __('Bank'), 'pageSlug' => 'bank'])
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
                                    <a href="{{ route('bank') }}"
                                        class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                                </div>
                            </div>
        <div class="row">
            <div class="col-md-7">
                <form class="well form-horizontal" action="{{route('store_bank')}}" method="POST">
                    @csrf
                    <div class="card ">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">{{ __('Create Bank') }}</h4>
                            <p class="card-category"></p>
                        </div>
                        <div class="card-body ">
                            <fieldset>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Employe ID</label>
                                    <div class="col-md-8">
                                        <div><select name="employee_id" data-size="5" class="form-control selectpicker"
                                                data-live-search="true">
                                                @foreach ($employees as $emp)
                                                <option value="{{$emp->id}}" data-tokens="{{$emp->full_name}}">
                                                    {{$emp->first_name . " ". $emp->last_name }}</option>
                                                @endforeach
                                            </select></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Bank Account Number</label>
                                    <div class="col-md-8">
                                        <div><input type="text" class="form-control" id="anbank" name="account_number"
                                                placeholder="Bank Account Number"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Bank Account Type</label>
                                    <div class="col-md-8">
                                        <div><input type="text" class="form-control" id="atbank" name="account_type"
                                                placeholder="Bank Account Type"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Branch Name</label>
                                    <div class="col-md-8">
                                        <div><input type="text" class="form-control" id="bbname" name="branch_name"
                                                placeholder="Bank Branch Name"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Bank Name</label>
                                    <div class="col-md-8">
                                        <div><input type="text" class="form-control" id="bname" name="bank_name"
                                                placeholder="Employee Bank Name"></div>
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
