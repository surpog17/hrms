@extends('layouts.app', ['page' => __('Generate Warning'), 'pageSlug' => 'warning'])
@section('styles')
<link href="https://fonts.googleapis.com/icon?family=Material+Icons"rel="stylesheet">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
     <link rel="stylesheet" type="text/css" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.0/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.0/css/jquery.dataTables_themeroller.css">
    @endsection
@section('content')
<div class="container">
    <div class="col-md-11">
        <ul style="float:right" class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link" href="{{route('warning.index')}}" style="color:#13c0d4;  font-weight: bold;">warning record</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="{{route('warning.generate')}}" style="color:#13c0d4;  font-weight: bold;">send warning</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('excused.index')}}" style="color:#13c0d4;  font-weight: bold;">Excused warning</a>
            </li>
        </ul>
        <div class="card">
            <div class="card-header">Generate Employee Warning</div>

            <div class="card-body">
                @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
                @endif
                @if (session('danger'))
                <div class="alert alert-danger" role="alert">
                    {{ session('danger') }}
                </div>
                @endif

                <form style="float: right;" method="POST" action="{{route('send_warning_email')}}">
                        @csrf
                        <div class="form-group">
                            <label for="range">Date Range</label>
                            <input id="range" type="text" name="daterange" value="" required />
                        </div>

                        <button class="btn btn-primary btn-sm" type="submit">Send</button>

                    </form>
                    <!--</br>-->
                <!--<a style="float: right;" href="{{route('send_warning_email')}}" class="btn btn-info btn-sm">send</a>-->

                <div class="table-responsive">
                <table id="myTable" class="display" cellspacing="0" width="100%">
                    <thead>
                        <tr >
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Warning</th>
                            <th scope="col">Number</th>
                            <th scope="col">Date</th>
                            <th scope="col">Disciplinary Measure</th>
                            <th scope="col">Remark</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $val = 1
                        @endphp
                        @foreach ($warning as $war)
                        <tr>
                            <th scope="row">{{$val}}</th>
                            <td>{{$war->employee->full_name}}</td>
                            <td>{{$war->type->name}}</td>
                            <td>{{$war->warn}}</td>
                            <td>{{$war->date}}</td>
                            <td>{{$war->action}}</td>
                            <td>{{$war->remark}}</td>

                        </tr>
                        @php
                        $val +=1
                        @endphp

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

 <!-- <script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.7.1.min.js"></script>
    <script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.0/jquery.dataTables.min.js"></script> -->
<script type="text/javascript">
    $(document).ready(function() {
            $('#myTable').DataTable();
        });

</script>
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
