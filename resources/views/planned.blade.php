@extends('layouts.app', ['page' => __('Raw Data'), 'pageSlug' => 'raw'])

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card">
                <div class="card-header">Import</div>

                <div class="card-body">
                    @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                    @endif

                    <form method="POST" enctype="multipart/form-data" action="{{route('raw.import')}}">
                        @csrf

                        <div class="form-group">
                            <label for="planned_id">Import Planned Leave</label>
                            <input id="planned_id" name="planned" type="file">
                        </div>

                        <button class="btn btn-primary" type="submit">Submit</button>


                    </form>

                    <raw-component></raw-component>


                </div>
            </div>
        </div>
    </div>

</div>
@endsection

