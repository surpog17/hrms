@extends('layouts.app', ['page' => __('Deduct'), 'pageSlug' => 'deduct'])

@section('styles')
<link href="https://fonts.googleapis.com/icon?family=Material+Icons"rel="stylesheet">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
     <link rel="stylesheet" type="text/css" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.0/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.0/css/jquery.dataTables_themeroller.css">
    @endsection
@section('content')
<div class="container">
	<a allign="left" href="{{ route('create_deduction') }}" class="btn btn-info btn-md"><span class="glyphicon glyphicon-plus"></span>Create Deduction</a>

	<div class="row">
		<div class="col-md-12">
			<br />
			<h3 allign="center">Deduction</h3>

			<br />
			<table id="myTable" class="display" cellspacing="0" width="100%">

			<thead>
			<tr>

					<th>Employee Name</th>
					<th>Employee Medical</th>
					<th>Employee Absentism</th>
					<th>Employee Other Deduction</th>
                    <th>Employee Loan</th>
                    <th>Employee Car Maintenance</th>
                    <th>Employee PMA</th>
                    <th>Employee Exam Failed</th>
                    <th>Employee Late</th>
					<th>Edit</th>
					<th>Delete</th>
				</tr>
				</thead>
				<tbody>
				@foreach($deducts as $deduct)

				<tr>
					<td>@if($deduct->employee){{ $deduct->employee->full_name }}@endif</td>
					<td>{{ $deduct->medical }}</td>
					<td>{{ $deduct->absent }}</td>
					<td>{{ $deduct->other }}</td>
                    <td>{{ $deduct->loan }}</td>
                    <td>{{ $deduct->car }}</td>
                    <td>{{ $deduct->pma }}</td>
                    <td>{{ $deduct->exam }}</td>
                    <td>{{ $deduct->latecommer }}</td>
					<td>
					  <a rel="tooltip" class="btn btn-success btn-link"
                                                    href="{{ route('edit_deduction',$deduct->id)}}"  data-original-title=""
                                                    title="">
                                                    <i class="material-icons">edit</i>
                                                    <div class="ripple-container"></div>
                                                </a>
					</td>
					<td>
						<form action="{{ route('delete_deduction',$deduct->id)}}"  >

					       <button type="button" class="btn btn-danger btn-link"
                                                    data-original-title="" title=""
                                                    onclick="confirm('{{ __("Are you sure you want to delete this user?") }}') ? this.parentElement.submit() : ''">
                                                    <i class="material-icons">delete</i>
                                                    <div class="ripple-container"></div>
                                                </button>
                                            </form>
						<!-- <a href="{{ route('delete_deduction',$deduct->id)}}" class="btn btn-danger btn-sm">Trash</a>
					 -->
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
