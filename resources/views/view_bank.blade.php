@extends('layouts.app', ['page' => __('Bank'), 'pageSlug' => 'bank'])

@section('content')
<div class="container">
	<a align="left" href="{{ route('export_bank') }}" class="btn btn-info btn-md"><span class="glyphicon glyphicon-export"></span> Export Bank</a>
	<div class="row">
		<div class="col-md-12">
			<br />
			<h3 align="center">Bank Data</h3>

			<br />
			<table class="table table-bordered">
				<tr>
					<th>Id</th>
					<th>Employee Name</th>
					<th>Bank Account Number</th>
					<th>Bank Account Type</th>
					<th>Branch Name</th>
					<th>Bank Name</th>
					<th>Net Pay</th>

				</tr>
				@foreach($payroll as $pay)

				<tr>
					@foreach($bank as $banks)
					@if ($banks->employee_id == $pay->employee_id)
					    <td>{{ $banks->employee_id }}</td>
					    <td>{{ $banks->employee_name }}</td>
					    <td>{{ $banks->bank_account_number }}</td>
					    <td>{{ $banks->bank_account_type }}</td>
					    <td>{{ $banks->branch_name }}</td>
					    <td>{{ $banks->bank_name }}</td>
						<td>{{ $pay->net_income }}</td>
					@endif
					@endforeach


				</tr>

				@endforeach
			</table>

		</div>
	</div>
</div>

@endsection
