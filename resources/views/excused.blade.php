@extends('layouts.app', ['page' => __('Warning'), 'pageSlug' => 'warning'])
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
                <a class="nav-link" href="{{route('warning.generate')}}" style="color:#13c0d4;  font-weight: bold;">send warning</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="{{route('excused.index')}}" style="color:#13c0d4;  font-weight: bold;">Excused warning</a>
            </li>
        </ul>
        <div class="card">
            <div class="card-header">Employee Warning</div>

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
                <div class="table-responsive">
                 <table id="myTable" class="display" cellspacing="0" width="100%">
                    <thead>
                        <tr >
                            <th >#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Warning</th>
                            <th scope="col">Number</th>
                            <th scope="col">Date</th>
                            <th scope="col">Disciplinary Measure</th>
                            <th scope="col">Remark</th>
                            <th scope="col">Excused</th>
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
                            <td><input data-id="{{$war->id}}" id="pay" name="pay" type="checkbox" data-size="mini"
                                    data-toggle="toggle" data-on="Excused" data-off="Condemn" data-onstyle="success"
                                    data-offstyle="danger" {{ $war->excuse ? 'checked' : '' }}></td>


                        </tr>
                        @php
                        $val +=1
                        @endphp

                        @endforeach

                    </tbody>
                </table>
                {{ $warning->links() }}

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
    $(function() {
    $(document).on('change', '#pay', function(e) {
    // $('#pay').change(function() {
            console.log("yeah");
            let status = $(this).prop('checked') === true ? 1 : 0;
            let userId = $(this).data('id');
            console.log(userId);
            $.ajax({
                type: "GET",
                dataType: "json",
                url: '{{ route('excused.active') }}',
                data: {'id': userId,'active': status},
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
@section('scripts')
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
@endsection
