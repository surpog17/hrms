@extends('layouts.app', ['page' => __('Absent'), 'pageSlug' => 'absent'])

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card">
                <div class="card-header">Absent Calculation</div>

                <div class="card-body">
                    @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                    @endif


                    <form method="POST" action="{{route('absent.full')}}">
                        @csrf
                        <div class="form-group">
                            <label for="range">Date Range</label>
                            <input id="range" type="text" name="daterange" value="" required />
                        </div>
                        <button class="btn btn-primary" type="submit">Calculate</button>

                    </form>

                    <h2 style="margin-top:3em;">Absent</h2>
                    <table style="margin-top: 2em;" class="table">
                        <thead>
                            <tr style="background: grey; color:white">
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Date</th>
                                <th scope="col">Remark</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $renderedname = [];
                            @endphp
                            @foreach ($full as $f)
                            <tr>
                                @if (!in_array($f->acc_id, $renderedname))
                                @php
                                $renderedname[] = $f->acc_id;
                                @endphp

                                <td rowspan="{{ App\Absent::where(['acc_id'=> $f->acc_id,'for' => 1])->count()  }}">
                                    {{$f->acc_id}}</td>
                                <td rowspan="{{ App\Absent::where(['acc_id' => $f->acc_id,'for' => 1])->count()  }}">
                                    {{$f->name}}</td>
                                @endif
                                <td>{{$f->date}}</td>
                                <td>@if($f->remark){{$f->remark}}@endif</td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <a data-id="{{$f->id}}" type="button"
                                            class="btn btn-primary btn-sm planned">plan</a>
                                        <a data-id="{{$f->id}}" type="button"
                                            class="btn btn-danger btn-sm unplanned">un-plan</a>
                                        <a data-id="{{$f->id}}" type="button"
                                            class="btn btn-primary btn-sm project">project</a>
                                        <a data-id="{{$f->id}}" type="button"
                                            class="btn btn-danger btn-sm sick">sick</a>
                                        <a data-id="{{$f->id}}" type="button"
                                            class="btn btn-secondary btn-sm nonsick">non-sick</a>
                                        <a data-id="{{$f->id}}" type="button"
                                            class="btn btn-primary btn-sm ignore">Ignore</a>
                                        <a data-id="{{$f->acc_id}}" data-date="{{$f->date}}" type="button"
                                            class="btn btn-danger btn-sm warning">warning</a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>

                    <h2>Morning Absent</h2>

                    <table style="margin-top: 2em;" class="table">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Date</th>
                                <th scope="col">Remark</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $renderedname = [];
                            @endphp
                            @foreach ($morning as $f)
                            <tr>
                                @if (!in_array($f->acc_id, $renderedname))
                                @php
                                $renderedname[] = $f->acc_id;
                                @endphp

                                <td rowspan="{{ App\Absent::where(['acc_id'=> $f->acc_id,'for' => 2])->count()  }}">
                                    {{$f->acc_id}}</td>
                                <td rowspan="{{ App\Absent::where(['acc_id' => $f->acc_id,'for' => 2])->count()  }}">
                                    {{$f->name}}</td>
                                @endif
                                <td>{{$f->date}}</td>
                                <td>@if($f->remark){{$f->remark}}@endif</td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <a data-id="{{$f->id}}" type="button"
                                            class="btn btn-primary btn-sm planned">plan</a>
                                        <a data-id="{{$f->id}}" type="button"
                                            class="btn btn-danger btn-sm unplanned">un-plan</a>
                                        <a data-id="{{$f->id}}" type="button"
                                            class="btn btn-primary btn-sm project">project</a>
                                        <a data-id="{{$f->id}}" type="button"
                                            class="btn btn-danger btn-sm sick">sick</a>
                                        <a data-id="{{$f->id}}" type="button"
                                            class="btn btn-secondary btn-sm nonsick">Non-sick</a>
                                        <a data-id="{{$f->id}}" type="button"
                                            class="btn btn-primary btn-sm ignore">Ignore</a>
                                        <a data-id="{{$f->acc_id}}" data-date="{{$f->date}}" type="button"
                                            class="btn btn-danger btn-sm warning">warning</a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>



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
        $(function() {
    $(".planned").click(function() {
            console.log("yeah");
            // let status = $(this).prop('checked') === true ? 1 : 0;
            let userId = $(this).data('id');
            $.ajax({
                type: "GET",
                dataType: "json",
                url: '{{ route('absent.planned') }}',
                data: {'id': userId},
                success: function (data) {
                    toastr.options.closeButton = true;
                    toastr.options.closeMethod = 'fadeOut';
                    toastr.options.closeDuration = 100;
                    toastr.success(data.message);
                }
            });
    });
    $(".unplanned").click(function() {
            console.log("yeah");
            // let status = $(this).prop('checked') === true ? 1 : 0;
            let userId = $(this).data('id');
            $.ajax({
                type: "GET",
                dataType: "json",
                url: '{{ route('absent.un_planned') }}',
                data: {'id': userId},
                success: function (data) {
                    toastr.options.closeButton = true;
                    toastr.options.closeMethod = 'fadeOut';
                    toastr.options.closeDuration = 100;
                    toastr.success(data.message);
                }
            });
    });
    $(".sick").click(function() {
            console.log("yeah");
            // let status = $(this).prop('checked') === true ? 1 : 0;
            let userId = $(this).data('id');
            $.ajax({
                type: "GET",
                dataType: "json",
                url: '{{ route('absent.sick') }}',
                data: {'id': userId},
                success: function (data) {
                    toastr.options.closeButton = true;
                    toastr.options.closeMethod = 'fadeOut';
                    toastr.options.closeDuration = 100;
                    toastr.success(data.message);
                }
            });
    });
    $(".nonsick").click(function() {
            console.log("yeah");
            // let status = $(this).prop('checked') === true ? 1 : 0;
            let userId = $(this).data('id');
            $.ajax({
                type: "GET",
                dataType: "json",
                url: '{{ route('absent.non_sick') }}',
                data: {'id': userId},
                success: function (data) {
                    toastr.options.closeButton = true;
                    toastr.options.closeMethod = 'fadeOut';
                    toastr.options.closeDuration = 100;
                    toastr.success(data.message);
                }
            });
    });
    $(".project").click(function() {
            console.log("yeah");
            // let status = $(this).prop('checked') === true ? 1 : 0;
            let userId = $(this).data('id');
            $.ajax({
                type: "GET",
                dataType: "json",
                url: '{{ route('absent.on_project') }}',
                data: {'id': userId},
                success: function (data) {
                    toastr.options.closeButton = true;
                    toastr.options.closeMethod = 'fadeOut';
                    toastr.options.closeDuration = 100;
                    toastr.success(data.message);
                }
            });
    });
    $(".ignore").click(function() {
            console.log("yeah");
            // let status = $(this).prop('checked') === true ? 1 : 0;
            let userId = $(this).data('id');
            $.ajax({
                type: "GET",
                dataType: "json",
                url: '{{ route('absent.absent') }}',
                data: {'id': userId},
                success: function (data) {
                    toastr.options.closeButton = true;
                    toastr.options.closeMethod = 'fadeOut';
                    toastr.options.closeDuration = 100;
                    toastr.success(data.message);
                }
            });
    });
    $(".warning").click(function() {
            console.log("yeah");
            // let status = $(this).prop('checked') === true ? 1 : 0;
            let userId = $(this).data('id');
            let date = $(this).data('date');
            console.log(date);
            $.ajax({
                type: "GET",
                dataType: "json",
                url: '{{ route('warning.absent') }}',
                data: {'id': userId,'date':date},
                success: function (data) {
                    toastr.options.closeButton = true;
                    toastr.options.closeMethod = 'fadeOut';
                    toastr.options.closeDuration = 100;
                    toastr.success(data.message);
                }
            });
    });
});
</script>

@endsection
