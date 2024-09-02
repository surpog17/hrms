@extends('layouts.app', ['page' => __('Working Day'), 'pageSlug' => 'working'])

@section('content')
<div class="container">
    <div class="col-md-11">
        <div class="card">
            <div class="card-header">Working Day</div>

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

                <table class="table" style="margin-top: 3em;">
                    <thead>
                        <tr style="background: grey; color:white">
                            <th scope="col">#</th>
                            <th scope="col">Day</th>
                            <th scope="col">Working Day</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $val = 1
                        @endphp
                        @foreach ($working as $work)
                        <tr>
                            <th scope="row">{{$val}}</th>
                            <td>{{$work->name}}</td>
                            <td>@if ($work->working)
                                Yes
                                @else
                                No
                                @endif</td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                <form method="POST" action="{{route('work',$work->id)}}">
                                        @csrf
                                        <button type="submit" class="btn btn-primary">Working Day</button>

                                    </form>

                                    <form method="POST" action="{{route('non.work',$work->id)}}">
                                        @csrf
                                        <button type="submit" class="btn btn-danger">Non-Working Day</button>

                                    </form>
                                </div>
                            </td>

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
@endsection
