@extends('layouts.app', ['page' => __('Employee Management'), 'pageSlug' => 'Employee-management'])
@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title ">Employee Data Export</h4>
                        <p class="card-category">Export Employee data</p>
                    </div>
                    <div class="card-body">
                        @if (session('status'))
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="alert alert-success">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <i class="material-icons">close</i>
                                    </button>
                                    <span>{{ session('status') }}</span>
                                </div>
                            </div>
                        </div>
                        @endif
                        <div class="container ">
                            <div class="row">
                                <div class="col-md-3">
                                    <a type="button" href="{{route('attexp')}}" class="btn btn-success text-white">Export for ZKTeco</a>
                                </div>
                                <div class="col-md-3">
                                    <a type="button" href="{{route('ptrexp')}}" class="btn btn-warning text-white">Export for Printer</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
