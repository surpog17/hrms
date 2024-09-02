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
        <ul style="float:right" class="nav nav-tabs" style="color:#32bfcf;">
            <li class="nav-item">
                <a class="nav-link active" href="{{route('warning.index')}}" style="color:#13c0d4;  font-weight: bold;">warning record</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('warning.generate')}}" style="color:#13c0d4;  font-weight: bold;">send warning</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('excused.index')}}" style="color:#13c0d4;  font-weight: bold;">Excused warning</a>
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
                <div class="row float-right">
                <div class="col-6">

                </div>
                <!-- new added feture for filttering by warning type -->

                <div class="col-12">
                <div class="col-12">
                    <!-- <form class="form-inline" method="GET" action="{{route('warning.index')}}">
                        @csrf
                        <div class="form-group">
                            <select style="height: 45px;" class="form-control" id="selectEmployee" name="type_selected" required focus>
                            <option value="" disabled selected>Select Warning Type</option>
                            <option>All</option>
                            @foreach($warning as $user)
                                <option value="{{$user->id}}">{{ $user->name }}</option>
                            @endforeach
                            </select>
                            <button type="Submit" class="btn btn-primary btn-sm">Filter</button>
                        </div>

                    </form> -->
                </div>
                <!------------------------------end -->

                <!-- new added feature for multiple email sending -->
                <div class="col-12">
                    <!-- <form class="form-inline" method="GET" action="{{route('warning.index')}}">
                        @csrf
                        <div class="form-group">
                            <select style="height: 45px;" class="form-control" id="selectEmployee" name="employee_selected" required focus>
                            <option value="" disabled selected>Send warning for</option>
                            <option>All</option>
                            @foreach($warning as $user)
                                <option value="{{$user->id}}">
                                    <a href="{{ route('send_personal_email',$user->id) }}" type="button" class="btn btn-info btn-sm" >
                                    {{ $user->name}}
                                    </a>
                                </option>
                            @endforeach
                            </select>
                            <button type="Submit" class="btn btn-primary btn-sm">Filter</button>
                        </div>

                    </form> -->
                </div>

                <!-- -----------------------------end -->

            </div>
            </div>


                <button type="submit" class="btn btn-primary btn-sm" data-toggle="modal" data-backdrop="static"
                    data-keyboard="false" data-target="#myModalHorizontal">Add Warning</button>

                <a style="float: right;" href="{{route('generate.webhr.warning')}}" class="btn btn-info btn-sm">Generate
                    Warning</a>
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
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $val = 1

                        @endphp

                        @foreach ($warning as $war)
                        <tr>
                            <th @if($war->excuse) style="background-color: green;color: white" @endif scope="row">{{$val}}</th>
                            <td>@if($war->employee){{$war->employee->full_name}}@endif</td>
                            <td>{{$war->type->name}}</td>
                            <td>{{$war->warn}}</td>
                            <td>{{$war->date}}</td>
                            <td>{{$war->action}}</td>
                            <td>{{$war->remark}}</td>
                            <td>
                             <div class="btn-group" role="group" >

                               @if($war->employee)
                                    <button rel="tooltip" class="btn btn-success btn-link" data-toggle="modal" data-backdrop="static"
                                        data-keyboard="false" data-id="{{$war->id}}" data-name="{{$war->employee->id}}"
                                        data-warn="{{$war->warn}}" data-type="{{$war->type->id}}"
                                        data-date="{{$war->date}}" data-remark="{{$war->remark}}"
                                        data-disciplinary="{{$war->action}}"
                                        data-target="#editModalHorizontal">
                                        <i class="material-icons">edit</i>
                                                <div class="ripple-container">

                                                </div></button>
                                        @endif



                                        <div>
                                                <a rel="tooltip" class="btn btn-success sendbtn"
                                                href="{{ route('send_personal_email',$war->id) }}" data-original-title=""
                                                    title="">
                                                    <i class="material-icons">send</i>
                                                    <div class="ripple-container"></div>
                                                </a>
                                         </div>
                                           <form action="{{route('warning.delete',$war->id)}}" method="post">
                                                @csrf
                                                @method('delete')


                                                <button type="button" class="btn btn-danger btn-link"
                                                    data-original-title="" title=""
                                                    onclick="confirm('{{ __("Are you sure you want to delete this user?") }}') ? this.parentElement.submit() : ''">
                                                    <i class="material-icons">delete</i>
                                                    <div class="ripple-container"></div>
                                                </button>


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
                {{ $warning->links() }}
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="myModalHorizontal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header" style="height:4em;background: #13c0d4">
                    <h4 class="modal-title" id="myModalLabel" style="color: whitesmoke;">Add Warning</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">close</button>

                </div> <!-- Modal Body -->
                <div class="modal-body" style="background-color: #fffff;">
                    <form method="POST" action="{{route('warning.store')}}">
                        @csrf
                        <div class="form-group row">

                            <label for="selectEmployee"
                                class="col-sm-2 col-form-label col-form-label-sm" style="color: white">Employee</label>
                            <div class="col-sm-8">
                                <select style="height: 45px;" class="form-control" id="selectEmployee" name="employee"
                                    required focus>
                                    <option value="" disabled selected>Please select Employee</option>
                                    @foreach($employees as $employee)
                                    <option value="{{$employee->id}}">
                                        {{ $employee->full_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">

                            <label for="selectType" class="col-sm-2 col-form-label col-form-label-sm" style="color: white">Warning
                                Type</label>
                            <div class="col-sm-8">
                                <select style="height: 45px;" class="form-control" id="selectType" name="type" required
                                    focus>
                                    <option value="" disabled selected>Please select Type</option>
                                    @foreach($types as $type)
                                    <option value="{{$type->id}}">
                                        {{ $type->name}} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="warn" class="col-sm-2 col-form-label col-form-label-sm" style="color: white">Warning</label>
                            <div class="col-sm-8">
                                <input class="form-control form-control-sm" id="warn" type="text"
                                    name="warning_number" style="color: #0d0d0b" value="" required />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="datetimepicker1" class="col-sm-2 col-form-label col-form-label-sm" style="color: white">Date</label>
                            <div class="col-sm-8">
                                <input style="color:#0d0d0b;" name="date" class="date form-control" type="date">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="remark" class="col-sm-2 col-form-label col-form-label-sm" style="color: white">Remark</label>
                            <div class="col-sm-8">
                                <input id="remark" name="remark" class="form-control" type="text" style="color: black">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="disciplinary" class="col-sm-2 col-form-label col-form-label-sm" style="color: white">Disciplinary
                                Measure</label>
                            <div class="col-sm-8">
                                <input id="disciplinary" name="disciplinary" class="form-control" type="text" style="color: black">
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">Submit</button>

                    </form>
                </div>
            </div>
        </div>

    </div>

    <div class="modal fade" id="editModalHorizontal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header" style="height:4em;background: #13c0d4">
                    <h4 class="modal-title" id="myModalLabel" style="color: white">Edit
                        Warning</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">close</button>

                </div> <!-- Modal Body -->
                <div class="modal-body" style="background-color: #fffff;">

                    <form method="POST" action="{{route('warning.update')}}">
                        @method('Put')
                        @csrf

                        <input id="warning_id" type="hidden" name="warning_id" value="">
                        <div class="form-group row">

                            <label for="selectEmployee" style="color: white"
                                class="col-sm-2 col-form-label col-form-label-sm">Employee</label>
                            <div class="col-sm-8">
                                <select style="height: 45px;" class="form-control" id="selectEmployee" name="employee"
                                    required focus>
                                    <option value="" disabled selected>Please select Employee</option>
                                    @foreach($employees as $employee)
                                    <option value="{{$employee->id}}">
                                        {{ $employee->full_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">

                            <label for="selectType" style="color: white" class="col-sm-2 col-form-label col-form-label-sm">Warning
                                Type</label>
                            <div class="col-sm-8">
                                <select style="height: 45px;" class="form-control" id="selectType" name="type" required
                                    focus>
                                    <option value="" disabled selected>Please select Type</option>
                                    @foreach($types as $type)
                                    <option value="{{$type->id}}">
                                        {{ $type->name}} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="warn" style="color: white" class="col-sm-2 col-form-label col-form-label-sm">Warning</label>
                            <div class="col-sm-8">
                                <input class="form-control form-control-sm" style="color: white" id="warn" type="text"
                                    name="warning_number" value=0 required />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="datetimepicker1" style="color: white" class="col-sm-2 col-form-label col-form-label-sm">Date</label>
                            <div class="col-sm-8">
                                <input style="color:#0d0d0b;" id="date" name="date" class="date form-control" type="date">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="remark" style="color: white" class="col-sm-2 col-form-label col-form-label-sm">Remark</label>
                            <div class="col-sm-8">
                                <input id="remark" style="color: black" name="remark" class="form-control" type="text">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="disciplinary" style="color: white" class="col-sm-2 col-form-label col-form-label-sm">Disciplinary
                                Measure</label>
                            <div class="col-sm-8">
                                <input id="disciplinary" name="disciplinary" style="color: white" class="form-control" type="text">
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">Submit</button>

                    </form>
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

<script type="text/javascript">
    jQuery(document).ready(function(){
        $('#editModalHorizontal').on('shown.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            var name = button.data('name');
            var type = button.data('type');
            var remark = button.data('remark');
            var date = button.data('date');
            var warn = button.data('warn');
            var disciplinary = button.data('disciplinary');
            var id = button.data('id')

            var modal = $(this)
            modal.find('.modal-body #selectEmployee').val(name);
            modal.find('.modal-body #selectType').val(type);
            modal.find('.modal-body #warn').val(warn);
            modal.find('.modal-body #date').val(date);
            modal.find('.modal-body #remark').val(remark);
            modal.find('.modal-body #disciplinary').val(disciplinary);
            modal.find('.modal-body #warning_id').val(id);
        })
    })

</script>

@endsection
