@extends('layouts.app', ['page' => __('Raw Data'), 'pageSlug' => 'raw'])


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
                    <a class="nav-link active" href="{{route('raw.view')}}"  style="color:#13c0d4;  font-weight: bold;">Raw Import</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('incentive.index')}}"  style="color:#13c0d4;  font-weight: bold;">Incentive Import</a>
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

                    <form method="POST" enctype="multipart/form-data" action="{{route('raw.import')}}">
                        @csrf

                        <div>
                            <label for="raw_id">Import Raw</label></br>
                            <input id="raw_id" name="raw" type="file">
                        </div>

                        <button class="btn btn-primary" type="submit">Submit</button>


                    </form>

                    <raw-component></raw-component>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="myTable" class="display" cellspacing="0" width="100%">
                                <thead >
                                    <tr>
                                        <th>
                                            Acc-No
                                        </th>
                                        <th>
                                            Name
                                        </th>
                                        <th>
                                            Date
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($raws as $raw)
                                    <tr>
                                        <td>{{$raw->acc_id}}</td>
                                        <td>{{$raw->name}}</td>
                                        <td>{{$raw->date}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    {{$raws->links()}}



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
