@extends('layouts.app', ['page' => __('export'), 'pageSlug' => 'Export'])
@section('styles')
<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css"
    rel="stylesheet">
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <ul style="float:right" class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('webhr.show')}}">Webhr Export</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{route('memo.index')}}">Memo Export</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('reprimand.show')}}">Reprimand Export</a>
                </li>
            </ul>
            <div class="card">
                <div class="card-header">Memo Export</div>

                <div class="card-body">
                    @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                    @endif

                    <form method="POST" action="{{route('memo.download')}}">
                        @csrf
                        <div class="form-group">
                            <label for="range">Date Range</label>
                            <input id="range" type="text" name="daterange" value="" required />
                        </div>
                        <div style="padding-left:1.5%;" class="row">
                            <div class="form-group">
                                <label for="pay">Send to Payroll</label>
                                <input id="pay" name="pay" type="checkbox" data-size="mini" data-toggle="toggle" data-on="Approved"
                                    data-off="Wait" data-onstyle="success" data-offstyle="danger">
                            </div>
                        </div>

                        <button class="btn btn-primary" type="submit">Export</button>

                    </form>

                </div>
            </div>
        </div>
    </div>

</div>
@endsection
@section('scripts')
<script>
    // $.noConflict();
    jQuery(document).ready(function ($) {
          $('input[name="daterange"]').daterangepicker({
            opens: 'left'
          }, function(start, end, label) {
            console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
          });
        });
</script>

@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
@endsection
