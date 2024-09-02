@extends('layouts.app', ['page' => __('Shift Management'), 'pageSlug' => 'shift'])

@section('content')
<div class="container">
    <div class="col-md-11">
        <div class="card">
            <div class="card-header">Shift Management</div>
            <div class="row float-right">
                <div class="col-6">
                    
                </div>
                <div class="col-5">
                    <form class="form-inline" method="GET" action="{{route('employee')}}">
                        @csrf
                        <div class="form-group">
                            <select style="background: blue;" class="form-control" id="selectEmployee" name="employee_selected" required focus>
                            <option value="" disabled selected>Please select Employee</option> 
                            <option>All</option> 
                            @foreach($allemployees as $emp)
                                <option value="{{$emp->id}}">{{ $emp->full_name }}</option>
                            @endforeach
                            </select>
                        </div>
                        <button type="Submit" class="btn btn-primary">Filter</button>
                    </form>    
                </div>
            </div>

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

                <table class="table" style="margin-top: 5em;" id="shifttable" >
                    <thead>
                        <tr >
                            <th scope="col">#</th>
                            <th scope="col">Full Name</th>
                            <th scope="col">Active</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $val = 1
                        @endphp
                        @foreach ($employee as $emp)
                        <tr>
                            <th scope="row">{{$val}}</th>
                            <td>{{$emp->full_name}}</td>
                            <td>
                                <input  id="activity" data-width="90" data-height="40" data-id="{{$emp->id}}"
                                    class="toggle-class" type="checkbox" data-onstyle="success" data-offstyle="danger"
                                    data-toggle="toggle" data-on="Active" data-off="Dormant"
                                    {{ $emp->is_active ? 'checked' : '' }}>
                                {{-- @if ($emp->is_active)
                                @else
                                In-Active
                                @endif
                                <div class="btn-group" role="group">
                                    <a href="{{route('employee.active',['id'=>$emp->id,'active'=>1])}}"
                                class="btn btn-primary">active</a>
                                <a href="{{route('employee.active',['id'=>$emp->id,'active'=>0])}}"
                                    class="btn btn-danger">In-Active</a>
            </div> --}}

            </td>

            {{-- <td>
                <input data-size="mini" data-id="{{$emp->id}}" class="toggle-class2" type="checkbox"
            data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Manager"
            data-off="Staff" {{ $emp->is_manager ? 'checked' : '' }}>

            </td>
            <td>
                <input data-size="mini" data-id="{{$emp->id}}" class="toggle-class3" type="checkbox"
                    data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Facility"
                    data-off="Staff" {{ $emp->is_driver ? 'checked' : '' }}>

            </td> --}}
            </tr>
            </tbody>
            @php
            $val +=1
            @endphp

            @endforeach
            </table>
            {{$employee->links()}}

        </div>
    </div>
</div>
</div>
@endsection
@section('scripts')
<script>
    // $(".toggle-class").on("change",function(){alert($(this).is(":checked"));});
    // $(document).ready(function(){
    //     $('.toggle-class').change(function () {
    //         console.log('yeah');
    //         let status = $(this).prop('checked') === true ? 1 : 0;
    //         let userId = $(this).data('id');
    //         $.ajax({
    //             type: "GET",
    //             dataType: "json",
    //             url: '{{ route('leave.update.status') }}',
    //             data: {'status': status, 'user_id': userId},
    //             success: function (data) {
    //                 toastr.options.closeButton = true;
    //                 toastr.options.closeMethod = 'fadeOut';
    //                 toastr.options.closeDuration = 100;
    //                 toastr.success(data.message);
    //             }
    //         });
    //     });
    // });

    $(function() {
    $('.toggle-class').change(function() {
            console.log("yeah");
            let status = $(this).prop('checked') === true ? 1 : 0;
            let userId = $(this).data('id');
            $.ajax({
                type: "GET",
                dataType: "json",
                url: '{{ route('employee.active') }}',
                data: {'id': userId,'active': status},
                success: function (data) {
                    toastr.options.closeButton = true;
                    toastr.options.closeMethod = 'fadeOut';
                    toastr.options.closeDuration = 100;
                    toastr.success(data.message);
                }
            });
    });
    $('.toggle-class2').change(function() {
            console.log("yeah");
            let status = $(this).prop('checked') === true ? 1 : 0;
            let userId = $(this).data('id');
            $.ajax({
                type: "GET",
                dataType: "json",
                url: '{{ route('employee.management') }}',
                data: {'id': userId,'active': status},
                success: function (data) {
                    toastr.options.closeButton = true;
                    toastr.options.closeMethod = 'fadeOut';
                    toastr.options.closeDuration = 100;
                    toastr.success(data.message);
                }
            });
    });
    $('.toggle-class3').change(function() {
            console.log("yeah");
            let status = $(this).prop('checked') === true ? 1 : 0;
            let userId = $(this).data('id');
            $.ajax({
                type: "GET",
                dataType: "json",
                url: '{{ route('employee.driver') }}',
                data: {'id': userId,'active': status},
                success: function (data) {
                    toastr.options.closeButton = true;
                    toastr.options.closeMethod = 'fadeOut';
                    toastr.options.closeDuration = 100;
                    toastr.success(data.message);
                }
            });
    });});


</script>
@endsection
