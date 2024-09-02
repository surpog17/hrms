@extends('layouts.app', ['page' => __('Webhr Data'), 'pageSlug' => 'webhr'])
@section('styles')
<link href="https://fonts.googleapis.com/icon?family=Material+Icons"rel="stylesheet">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
     <link rel="stylesheet" type="text/css" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.0/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.0/css/jquery.dataTables_themeroller.css">
    @endsection
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <ul style="float:right" class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active" href="{{route('webhr.index')}}" style="color:#13c0d4;  font-weight: bold;">User Data</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('webhr.absent')}}" style="color:#13c0d4;  font-weight: bold;">Absent</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('webhr.new')}}" style="color:#13c0d4;  font-weight: bold;">New/Resigned</a>
                </li>
                {{-- <li class="nav-item">
                    <a class="nav-link" href="{{route('webhr.sick')}}" style="color:#13c0d4;  font-weight: bold;">Sick</a>
                </li> --}}
                <li class="nav-item">
                    <a class="nav-link" href="{{route('webhr.late')}}" style="color:#13c0d4;  font-weight: bold;">Latecommers</a>
                </li>
                 <li class="nav-item">
                    <a class="nav-link" href="{{route('webhr.break')}}" style="color:#13c0d4;  font-weight: bold;">Late Break</a>
                </li>
                {{-- <li class="nav-item">
                    <a class="nav-link" href="{{route('webhr.travel')}}">Travel</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('webhr.leave')}}">Leave</a>
                </li> --}}
            </ul>
            <div class="card">
                <div class="card-header">Import</div>

                <div class="card-body">
                    @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                    @endif

                    <form method="POST" enctype="multipart/form-data" action="{{route('webhr.import')}}">
                        @csrf

                        <div>
                            <label for="webhr_id">Import Webhr</label></br>
                            <input id="web_id" name="webhr" type="file">
                        </div>

                        <button class="btn btn-primary" type="submit">Submit</button>


                    </form>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="myTable" class="display" cellspacing="0" width="100%">
                                <thead >
                                    <tr>

                                        <th>
                                            Name
                                        </th>
                                        <th>
                                            Webhr User Name
                                        </th>
                                        <th>
                                            email
                                        </th>
                                        <th>
                                            Designation
                                        </th>
                                        <th>
                                            Employement Type
                                        </th>
                                        <th>
                                            Attendance Id
                                        </th>
                                        <th>
                                            Edit
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($webhr as $w)
                                    <tr>
                                        <td>{{$w->full_name}}</td>
                                        <td>{{$w->user_name}}</td>
                                        <td>{{$w->email}}</td>
                                        <td>{{$w->designation}}</td>
                                        <td>{{$w->type}}</td>
                                        <td>{{$w->acc_id}}</td>
                                        <td>
                                         <a rel="tooltip" class="btn btn-success btn-link"
                                                href="{{ route('webhr.updateindex',$w->id) }}" data-original-title=""
                                                title="">
                                                <i class="material-icons">edit</i>
                                                <div class="ripple-container"></div>
                                            </a>

                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    {{$webhr->links()}}



                </div>
            </div>
        </div>
    </div>

</div>
@endsection
<script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.7.1.min.js"></script>
    <script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.0/jquery.dataTables.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
            $('#myTable').DataTable();
        });

</script>
