@extends('layouts.app', ['page' => __('Webhr Data'), 'pageSlug' => 'webhr'])

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <ul style="float:right" class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('webhr.index')}}">User Data</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('webhr.absent')}}">Absent</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('webhr.sick')}}">Sick</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('webhr.late')}}">Latecommers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{route('webhr.travel')}}">Travel</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('webhr.leave')}}">Leave</a>
                </li>
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

                        <div class="form-group">
                            <label for="webhr_id">Import Webhr</label>
                            <input id="web_id" name="webhr" type="file">
                        </div>

                        <button class="btn btn-primary" type="submit">Submit</button>


                    </form>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table tablesorter " id="">
                                <thead class=" text-primary">
                                    <tr>
                                        <th>
                                            Webhr Id
                                        </th>
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
                                        <td>{{$w->webhr_id}}</td>
                                        <td>{{$w->full_name}}</td>
                                        <td>{{$w->user_name}}</td>
                                        <td>{{$w->email}}</td>
                                        <td>{{$w->acc_id}}</td>
                                        <td><a href="{{ route('webhr.updateindex',$w->id) }}"
                                                class="btn btn-info btn-sm">Edit</a></td>
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
