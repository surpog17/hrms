@extends('layouts.app', ['page' => __('Raw Data'), 'pageSlug' => 'raw'])

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <ul style="float:right" class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('raw.view')}}">Raw Import</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{route('incentive.index')}}">Incentive Import</a>
                </li>
            </ul>
            <div class="card">
                <div class="card-header">Incentive Import</div>

                <div class="card-body">
                    @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                    @endif

                    <form method="POST" enctype="multipart/form-data" action="{{route('incentive.import')}}">
                        @csrf

                        <div>
                            <label for="incentive_id">Import Incentive</label></br>
                            <input id="incentive_id" name="incentive" type="file">
                        </div>

                        <button class="btn btn-primary" type="submit">Submit</button>

                    </form>
                    
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
