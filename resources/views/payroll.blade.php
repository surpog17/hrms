@extends('layouts.app', ['page' => __('Payroll'), 'pageSlug' => 'payroll'])
@section('styles')
<link href="https://fonts.googleapis.com/icon?family=Material+Icons"rel="stylesheet">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
     <link rel="stylesheet" type="text/css" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.0/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.0/css/jquery.dataTables_themeroller.css">
    @endsection

@section('content')
<div class="container">
    <a href="{{ route('export') }}" class="btn btn-info">Export Payroll</span></a>
    <a allign="right" href="{{ route('bank.export') }}" class="btn btn-primary btn-sm">Export Bank</a>
    <a class="btn btn-danger btn-sm" allign="right" href="{{route('send_email')}}">Send Email</a>
    <a class="btn btn-danger btn-sm" allign="right" href="{{route('bankletter.download')}}">Bank Letter</a>
    <div class="row">
        <div class="col-md-12">
            <br />
            <h3 allign="center">Payroll Data</h3>

            <br />
<table id="myTable" class="display" cellspacing="0" width="100%">
    <thead>

                <tr>
                    <th>Id</th>
                    <th>First Name</th>
                    <th>Basic Salary</th>
                    <th>Transport Allowance</th>
                    <th>Taxable Transport</th>
                    <th>Total Award</th>
                     <th>Gross Salary</th>
                     <th>Taxable Income</th>
                    <th>Tax</th>

                    <th>Employee Pension</th>
                    <th>Company Pension</th>

                    <th>Total Deduction</th>
                    <th>Gross Income</th>
                    <th>Net Income</th>
                    <th>Send</th>

                </tr>
                </thead>

                <tbody>

                @foreach($payroll as $pay)

                <tr>
                    <td>{{ $pay->employee_id }}</td>
                    <td>{{ $pay->employee->full_name }}</td>
                    <td>{{ $pay->employee->basic_salary }}</td>
                    <td>{{ $pay->trans_allowance }}</td>
                    <td>{{ $pay->tax_tran_allowance }}</td>
                     <td>{{ $pay->total_award }}</td>
                    <td>{{ $pay->gross_salary }}</td>


                    <td>{{ $pay->taxable_income }}</td>
                    <td>{{ $pay->tax }}</td>
                    <td>{{ $pay->emp_pension }}</td>
                    <td>{{ $pay->comp_pension }}</td>

                    <td>{{ $pay->total_deduction }}</td>
                    <td>{{ $pay->gross_income }}</td>
                    <td>{{ $pay->net_income }}</td>
                    <td><a  rel="tooltip" class="btn btn-success sendbtn"
                     href="{{ route('send_personal_payroll_email',$pay->id) }}"
                    type="button" class="btn btn-info btn-sm" >
                    <i class="material-icons">send</i>
                                                    <div class="ripple-container"></div></a>
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
