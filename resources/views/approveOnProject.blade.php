@extends('layouts.app', ['page' => __('Approve Project'), 'pageSlug' => 'approve-onproject'])

@section('content')
<div class="container">
    <div class="col-md-11">
        <div class="card">
            <div class="card-header">Validate On-project</div>

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


                <table class="table" style="margin-top: 5em;">
                    <thead>
                        <tr style="background: grey; color:white">
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Date</th>
                            <th scope="col">Remark</th>
                            <th scope="col">Action</th>
                            <th scope="col">Created</th>
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
                            <td>{{$s->from}} - {{$s->to}}</td>
                            <td>{{$s->remark}}</td>
                            <td style="width:20em">
                                <input data-size="mini" data-id="{{$s->id}}" class="toggle-class" type="checkbox" data-onstyle="success"
                                    data-offstyle="danger" data-toggle="toggle" data-on="Approve" data-off="Reject"
                                    {{ $s->validated ? 'checked' : '' }}>
                            </td>
                            <td>{{ $s->created_at->diffForHumans() }}</td>

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
                url: '{{ route('leave.update.status') }}',
                data: {'status': status, 'user_id': userId},
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
