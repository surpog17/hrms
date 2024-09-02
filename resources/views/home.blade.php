@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <a href="{{route('download')}}"> Download</a>
                <a href="{{route('raw.download')}}" class="btn btn-primary"> Attendance Download</a>

            </div>
        </div>
    </div>

</div>
@endsection
