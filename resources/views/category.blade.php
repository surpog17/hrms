@extends('layouts.app', ['page' => __('Deduction Type'), 'pageSlug' => 'deduction-type'])

@section('styles')
<link href="https://fonts.googleapis.com/icon?family=Material+Icons"rel="stylesheet">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
     <link rel="stylesheet" type="text/css" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.0/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.0/css/jquery.dataTables_themeroller.css">
    @endsection
@section('content')
<div class="container">
    <div class="col-md-11">
        <div class="card">
            <div class="card-header">Category</div>

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
                    data-keyboard="false" data-target="#myModalHorizontal">Add Category</button>

                    <div class="table-responsive">
               <table id="myTable" class="display" cellspacing="0" width="100%">
                    <thead>
                        <tr >
                            <th scope="col">#</th>
                            <th scope="col">Category</th>
                            <th scope="col">Duration</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $val = 1
                        @endphp
                        @foreach ($categories as $category)
                        <tr>
                            <th scope="row">{{$val}}</th>
                            <td>{{$category->name}}</td>
                            <td>{{$category->duration}}</td>
                            <td >
                                <div class="btn-group" >
                                    <button class="btn btn-success btn-link" data-toggle="modal" data-backdrop="static"
                                        data-keyboard="false" data-id="{{$category->id}}" data-duration="{{$category->duration}}"
                                        data-name="{{$category->name}}" data-target="#editModalHorizontal">
                                        <i class="material-icons">edit</i>
                                                    <div class="ripple-container"></div>
                                    </button>
                                    <form method="POST" action="{{route('category.delete',$category->id)}}">
                                    @csrf
                                                @method('delete')


                                                <button type="button" class="btn btn-danger btn-link"
                                                    data-original-title="" title=""
                                                    onclick="confirm('{{ __("Are you sure you want to delete this user?") }}') ? this.parentElement.submit() : ''">
                                                    <i class="material-icons">delete</i>
                                                    <div class="ripple-container"></div>
                                                </button>
                                        <!-- <button type="submit" class="btn btn-danger">Delete</button> -->

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
    </div>
    <div class="modal fade" id="myModalHorizontal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header" style="height:4em;background:  #13c0d4">
                    <h4 class="modal-title" id="myModalLabel" style="color: whitesmoke;">Add Loan Category</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: red">close</button>

                </div> <!-- Modal Body -->
                <div class="modal-body" style="background-color:#fffff;">
                    <form method="POST" action="{{route('category.store')}}">
                        @csrf
                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label col-form-label-sm" style="color: white">Name</label>
                            <div class="col-sm-8">
                                <input class="form-control form-control-sm" id="name" type="text"  style="color: black" name="type" value=""
                                    placeholder="Loan Type" required />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="duration" class="col-sm-2 col-form-label col-form-label-sm" style="color: white">Duration</label>
                            <div class="col-sm-8">
                                <input style="color:black;" class="form-control form-control-sm" id="duration" type="text" name="duration"
                                    value="" placeholder="Duration in month" required />
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
                    <h4 class="modal-title" id="myModalLabel" style="color: whitesmoke;">Edit
                        Loan Category</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: red">close</button>

                </div> <!-- Modal Body -->
                <div class="modal-body" style="background-color:  #fffff;">

                    <form method="POST" action="{{route('category.update')}}">
                        @method('PUT')
                        @csrf
                        <input type="hidden" id="type_id" name="type_id" value="">
                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label col-form-label-sm" style="color: white">Name</label>
                            <div class="col-sm-8">
                                <input class="form-control form-control-sm" id="name" type="text" style="color: black" name="type" value=""
                                    placeholder="Warning Type" required />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="duration" class="col-sm-2 col-form-label col-form-label-sm" style="color: white">Duration</label>
                            <div class="col-sm-8">
                                <input style="color:black" class="form-control form-control-sm" id="duration" style="color: black" type="text" name="duration"
                                    value="" placeholder="Duration in month" required />
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
            var duration = button.data('duration');
            var id = button.data('id');

            var modal = $(this)
            modal.find('.modal-body #name').val(name);
            modal.find('.modal-body #duration').val(duration);
            modal.find('.modal-body #type_id').val(id);
        })
    })

</script>

@endsection
