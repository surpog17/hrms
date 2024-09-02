@extends('layouts.app', ['page' => __('Webhr Data'), 'pageSlug' => 'webhr'])

@section('styles')
@section('styles')
<link href="https://fonts.googleapis.com/icon?family=Material+Icons"rel="stylesheet">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
     <link rel="stylesheet" type="text/css" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.0/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.0/css/jquery.dataTables_themeroller.css">
    @endsection
<style>
    .dropdown-menu {
        background: #2F3E64;
        color: whitesmoke;
    }
</style>
@endsection

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <ul style="float:right" class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('webhr.index')}}" style="color:#13c0d4;  font-weight: bold;">User Data</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('webhr.absent')}}" style="color:#13c0d4;  font-weight: bold;">Absent</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{route('webhr.new')}}" style="color:#13c0d4;  font-weight: bold;">New/Resigned</a>
                </li>
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

                    <form method="POST" action="{{route('webhr.newcreate')}}">
                        @csrf

                        <div class="card ">
                            <div class="card-header card-header-primary">
                                <h4 class="card-title">{{ __('Create New/Resigned Staff') }}</h4>
                                <p class="card-category"></p>
                            </div>
                            <div class="card-body ">
                                <fieldset>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Employee</label>
                                        <div class="col-sm-7">
                                <select class="form-control" style="height: 45px;" id="select_employee_type" name="employee_id" required focus>
                                    <option value="" disabled selected>Please Select employee</option>
                                    
                                    @foreach ($employees as $emp)
                                    <option value="{{$emp->id}}" data-tokens="{{$emp->full_name}}">
                                    {{$emp->full_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                                        
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Date</label>
                                        <div class="col-sm-7">
                                            <div><input type="date" class="form-control" id="mded" name="date">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Absentism</label>
                                        <div class="col-sm-7">
                                            <div>
                                                <select name="staff" data-size="5" style="height: 45px;" class="form-control"
                                                    data-live-search="true" required focus>
                                                    <option value="0" data-tokens="Resigned">Resigned</option>
                                                    <option value="1" data-tokens="New">New</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-4 col-md-offset-3">
                                            <div><input class="btn btn-ouline btn-primary" type="submit" value="Submit">
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>

                    </form>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="myTable" class="display" cellspacing="0" width="100%">
                                <thead >
                                    <tr>
                                        <th>
                                            Employee Name
                                        </th>
                                        <th>
                                            Date
                                        </th>
                                        <th>
                                            Remark
                                        </th>
                                        <th>
                                            Delete
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($news as $n)
                                    <tr>
                                        <td>{{$n->employee->full_name}}</td>
                                        <td>{{$n->date}}</td>
                                        <td>
                                            @if($n->remark)New Staff @else Resigned Staff @endif
                                        </td>
                                        <td>
                                            <a class="btn btn-danger btn-sm btn-link" href="{{route('webhr.newdelete',$n->id)}}">
                                               <i class="material-icons">delete</i>
                                            </a>
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
    </div>

</div>
@endsection
@section('scripts')
<script>
    $(function() {
      $('.toggle-class').change(function() {
          var status = $(this).prop('checked') == false ? 1 : 0;
          var user_id = $(this).data('id');
        //   console.log(status);

          $.ajax({
              type: "GET",
              dataType: "json",
              url: '/changeAbsent',
              data: {'status': status, 'user_id': user_id},
              success: function(data){
                console.log(data.success)
              }
          });
      })
    })
</script>


    <!-- <script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.7.1.min.js"></script>
    <script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.0/jquery.dataTables.min.js"></script> -->
<script type="text/javascript">
    $(document).ready(function() {
            $('#myTable').DataTable();
        });

</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
@endsection
