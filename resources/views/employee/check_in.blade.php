@extends('layouts.app', ['page' => __('Forget Checkins'), 'pageSlug' => 'forget-request'])

@section('content')
<div class="container">
    <div class="col-md-11">
        <div class="card">
            <div class="card-header">Forget Checkins</div>

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
                <button type="submit" class="btn btn-primary" data-toggle="modal" data-backdrop="static"
                    data-keyboard="false" data-target="#myModalHorizontal">Add Forget Checkins</button>


                <table class="table" style="margin-top: 5em;">
                    <thead>
                        <tr style="background: grey; color:white">
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Date</th>
                            <th scope="col">Remark</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $val = 1
                        @endphp
                        @foreach ($registered as $s)
                        <tr>
                            <th scope="row">{{$val}}</th>
                            <td>{{$s->employee->first_name}} {{$s->employee->last_name}}</td>
                            <td>{{$s->date}}</td>
                            <td>{{$s->remark}}
                            </td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <form method="POST" action="{{route('leave.destroy',$s->id)}}">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-danger">Delete</button>

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
    <div class="modal fade" id="myModalHorizontal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header" style="height:4em;background: orange">
                    <h4 class="modal-title" id="myModalLabel" style="color: whitesmoke;">Forget Check_in </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">close</button>

                </div> <!-- Modal Body -->
                <div class="modal-body" style="background-color: burlywood;">
                    <form method="POST" action="{{route('check_in.save')}}">
                        @csrf
                        <div class="form-group row">

                            <label for="selectEmployee"
                                class="col-sm-2 col-form-label col-form-label-sm">Employee</label>
                            <div class="col-sm-8">
                                <select style="color: black;" class="form-control" id="selectEmployee" name="employee" required focus>
                                    <option value="" disabled selected>Please select Employee</option>
                                    @foreach($employees as $employee)
                                    <option value="{{$employee->id}}">
                                        {{ $employee->first_name }} {{ $employee->last_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="datetimepicker1" class="col-sm-2 col-form-label col-form-label-sm">From</label>
                            <div class="col-sm-8">
                                <input name="checkin_date" class="date form-control" type="date">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="remark" class="col-sm-2 col-form-label col-form-label-sm">Remark</label>
                            <div class="col-sm-8">
                                <select class="form-control" id="selectRemark" name="remark" required focus>
                                    <option value="" disabled selected>Please select Check-ins</option>

                                    <option value="Morning">
                                        Morning</option>
                                    <option value="Morning">
                                        Lunch</option>
                                    <option value="Morning">
                                        Afternoon</option>
                                </select>
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
                <div class="modal-header" style="background: orange">
                    <h4 class="modal-title" id="myModalLabel" style="color: whitesmoke;">Add
                        Sick Leave</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">close</button>

                </div> <!-- Modal Body -->
                <div class="modal-body">

                    <form method="POST" action="#">
                        @method('PUT')
                        @csrf
                        <input type="hidden" name="holiday_id" value="">
                        <div class="form-group row">

                            <label for="selectEmployee"
                                class="col-sm-2 col-form-label col-form-label-sm">Employee</label>
                            <div class="col-sm-8">
                                <select class="form-control" id="selectEmployee" name="employee" required focus>
                                    <option value="" disabled selected>Please select Employee</option>
                                    @foreach($employees as $employee)
                                    <option value="{{$employee->id}}">
                                        {{ $employee->first_name }} {{ $employee->last_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="holiday_date_picker"
                                class="col-sm-2 col-form-label col-form-label-sm">Date</label>
                            <div class="col-sm-8">
                                <input id="holiday_date_picker" name="holiday_date" class="date form-control" value=""
                                    type="date" required>
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

<script type="text/javascript">
    jQuery(document).ready(function(){
        $('#editModalHorizontal').on('shown.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            var name = button.data('name');
            var date = button.data('date');
            var id = button.data('id')

            var modal = $(this)
            modal.find('.modal-body #name').val(name);
            modal.find('.modal-body #holiday_date_picker').val(date);
            modal.find('.modal-body #id').val(id);
        })
    })

</script>

@endsection
