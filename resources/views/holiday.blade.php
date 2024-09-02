@extends('layouts.app', ['page' => __('Holiday Management'), 'pageSlug' => 'holiday'])
@section('content')
<div class="container">
    <div class="col-md-11">
        <div class="card">
            <div class="card-header">Holiday</div>

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
                    data-keyboard="false" data-target="#myModalHorizontal">Add Holiday</button>


                <table class="table" style="margin-top: 5em;">
                    <thead>
                        <tr style="background: grey; color:white">
                            <th scope="col">#</th>
                            <th scope="col">Holiday</th>
                            <th scope="col">Date</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $val = 1
                        @endphp
                        @foreach ($holiday as $holi)
                        <tr>
                            <th scope="row">{{$val}}</th>
                            <td>{{$holi->name}}</td>
                            <td>{{$holi->date}}</td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <button class="btn btn-primary" data-toggle="modal" data-backdrop="static"
                                        data-keyboard="false" data-id="{{$holi->id}}" data-name="{{$holi->name}}"
                                        data-date="{{$holi->date}}" data-target="#editModalHorizontal">Edit</button>
                                    <form method="POST" action="{{route('holiday.delete', $holi->id)}}">
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
                    <h4 class="modal-title" id="myModalLabel" style="color: whitesmoke;">Add Holiday</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">close</button>

                </div> <!-- Modal Body -->
                <div class="modal-body" style="background-color: burlywood;">
                    <form method="POST" action="{{route('holiday.store')}}">
                        @csrf
                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label col-form-label-sm">Name</label>
                            <div class="col-sm-8">
                                <input class="form-control form-control-sm" id="name" type="text" name="holiday"
                                    value="" placeholder="Holiday Name" required />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="datetimepicker1" class="col-sm-2 col-form-label col-form-label-sm">Date</label>
                            <div class="col-sm-8">
                                <input name="holiday_date" class="date form-control" type="date">
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
                <div class="modal-header" style="height:4em;background: orange">
                    <h4 class="modal-title" id="myModalLabel" style="color: whitesmoke;">Add
                        Holiday</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">close</button>

                </div> <!-- Modal Body -->
                <div class="modal-body" style="background-color: burlywood;">

                    <form method="POST" action="{{route('holiday.update')}}">
                        @method('PUT')
                        @csrf
                        <input type="hidden" id="holiday_id" name="holiday_id" value="">
                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label col-form-label-sm">Name</label>
                            <div class="col-sm-8">
                                <input class="form-control form-control-sm" id="name" type="text" name="holiday"
                                    value="" placeholder="Holiday Name" required />
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
            modal.find('.modal-body #holiday_id').val(id);
        })
    })

</script>

@endsection
