@extends('layouts.app', ['page' => __('Bank'), 'pageSlug' => 'bank'])
@section('styles')
<link href="https://fonts.googleapis.com/icon?family=Material+Icons"rel="stylesheet">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
     <link rel="stylesheet" type="text/css" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.0/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.0/css/jquery.dataTables_themeroller.css">
    @endsection
@section('content')
<div class="container">
    <a allign="left" href="{{ route('create_bank') }}" class="btn btn-info btn-md"><span
            class="glyphicon glyphicon-plus"></span>Create Bank</a>
    <div class="row">
        <div class="col-md-12">
            <br />
            <h3 allign="center">Bank Data</h3>

            <br />
            <table id="myTable" class="display" cellspacing="0" width="100%">
            <thead>

            <tr>
                    <th>Employee Name</th>
                    <th>Employee Bank Account Number</th>
                    <th>Employee Account Type</th>
                    <th>Employee branch name</th>
                    <th>Employee bank name</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
</thead>
<tbody>

                @foreach($banks as $bank)
                <tr>
                    <td>@if($bank->employee){{  App\Employee::find($bank->employee_id)->full_name}}@endif</td>
                    <td>{{ $bank->bank_account_number }}</td>
                    <td>{{ $bank->bank_account_type }}</td>
                    <td>{{ $bank->branch_name }}</td>
                    <td>{{ $bank->bank_name }}</td>
                    <td>
                        <!-- <a href="{{ route('edit_bank',$bank->id)}}" class="btn btn-info btn-sm">Edit</a> -->

                        <a rel="tooltip" class="btn btn-success btn-link"
                                                    href="{{ route('edit_bank',$bank->id)}}" data-original-title=""
                                                    title="">
                                                    <i class="material-icons">edit</i>
                                                    <div class="ripple-container"></div>
                                                </a>
                                                </td>
                        <td>
                        <!-- <a href="{{ route('delete_bank',$bank->id) }}"
                    class="btn btn-danger btn-sm">Trash</a> -->

                    <form method="POST" action="{{ route('delete_bank',$bank->id) }}" >
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
                </td>
                </tr>
                @endforeach
</tbody>
            </table>

        </div>
    </div>
</div>
<script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.7.1.min.js"></script>
    <script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.0/jquery.dataTables.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
            $('#myTable').DataTable();
        });

</script>
@endsection
