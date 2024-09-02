@extends('layouts.app', ['page' => __('Deduction'), 'pageSlug' => 'deduction-record'])

@section('content')
<div class="container">
    <div class="col-md-11">
        <div class="card">
            <div class="card-header">Employee Loan</div>
            <div class="row float-right">
                <div class="col-6">
                    
                </div>
                <div class="col-5">
                    <form class="form-inline" method="GET" action="{{route('loan.index')}}">
                        @csrf
                        <div class="form-group">
                            <select style="background: blue;" class="form-control" id="selectEmployee" name="employee_selected" required focus>
                            <option value="all" disabled selected>Please select Employee</option> 
                            <option>All</option> 
                            @foreach($users as $emp)
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
                <button type="submit" class="btn btn-primary" data-toggle="modal" data-backdrop="static"
                    data-keyboard="false" data-target="#myModalHorizontal">Add Loan</button>


                <table class="table" style="margin-top: 5em;">
                    <thead>
                        <tr style="background: grey; color:white">
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Category</th>
                            <th scope="col">Date</th>
                            <th scope="col">Total Amount</th>
                            <th scope="col">Remaining</th>
                            <th scope="col">Current Amount</th>
                            <th scope="col">Paid Amount</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $val = 1
                        @endphp
                        @foreach ($loans as $loan)
                        <tr>
                            <th scope="row">{{$val}}</th>
                            <td>@if($loan->employee){{$loan->employee->full_name}}@endif</td>
                            <td>{{$loan->category->name}}</td>
                            <td>{{$loan->date}}</td>
                            <td>{{$loan->total_amount}}</td>
                            <td>{{$loan->remaining_amount}}</td>
                            <td>{{$loan->current_amount}}</td>
                            <td>{{$loan->paid_amount}}</td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    @if($loan->employee)
                                    <button class="btn btn-primary" data-toggle="modal" data-backdrop="static"
                                        data-keyboard="false" data-id="{{$loan->id}}"
                                        data-name="{{$loan->employee->id}}" data-category="{{$loan->category->id}}"
                                        data-total_amount="{{$loan->total_amount}}" data-date="{{$loan->date}}"
                                        data-current_amount="{{$loan->current_amount}}"
                                        data-paid_amount="{{$loan->paid_amount}}"
                                        data-remaining_amount="{{$loan->remaining_amount}}"
                                        data-target="#editModalHorizontal">Edit</button>
                                        @endif
                                    <form method="POST" action="{{route('loan.delete',$loan->id)}}">
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

                {{$loans->links()}}

            </div>
        </div>
    </div>
    <div class="modal fade" id="myModalHorizontal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header" style="height:4em;background: orange">
                    <h4 class="modal-title" id="myModalLabel" style="color: whitesmoke;">Add Loan</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">close</button>

                </div> <!-- Modal Body -->
                <div class="modal-body" style="background-color: burlywood;">
                    <form method="POST" action="{{route('loan.store')}}">
                        @csrf
                        <div class="form-group row">
                            <label for="selectEmployee"
                                class="col-sm-2 col-form-label col-form-label-sm">Employee</label>
                            <div class="col-sm-8">
                                <select style="color:black" class="form-control" id="selectEmployee" name="employee" required onclick ="selectedEmployee(this)">
                                    <option value="" disabled selected>Please select Employee</option>
                                    @foreach($employees as $employee)
                                    
                                
                                
                                   
                                    <option value="{{$employee->id}}" data-jdate="{{$employee->joining_date}}">
                                        {{ $employee->full_name }}</option>
                                        
                                    @endforeach
                                </select>
                            </div>
                         
                        </div>
                        <div class="form-group row">

                            <label for="selectCategory" class="col-sm-2 col-form-label col-form-label-sm">Loan
                                Category</label>
                            <div class="col-sm-8">
                                <select style="color:black" class="form-control" id="selectCategory" name="category" required focus onclick ="enableInsurance(this)" disabled>
                                    <option value="" disabled selected>Please select Category</option>
                                    @foreach($categories as $category)
                                    <option value="{{$category->id}}">
                                        {{ $category->name}} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row" style="display: none;" id="insuranceblock">

                            <label for="selectinsurance" class="col-sm-2 col-form-label col-form-label-sm">Medical
                                Insurance Type</label>
                            <div class="col-sm-8">
                                <select style="color:black" class="form-control" id="selectinsurance" name="insurance" >
                                    @foreach($medicalinsurances  as $mi)

                                    <option value="{{$mi->id}}">{{$mi->name}}</option>
                                     @endforeach
                                    
                                </select>
                            </div>
                        </div>
                        <div class="form-group row" style="display: none;" id="durationblock">

                            <label for="duration_amount" class="col-sm-2 col-form-label col-form-label-sm">
                                Duration</label>
                            <div class="col-sm-8">
                                <input class="form-control form-control-sm" id="duration_amount" type="Number"
                                    name="duration_amount" value=1 required />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="total_amount" class="col-sm-2 col-form-label col-form-label-sm">Total
                                Amount</label>
                            <div class="col-sm-8">
                                <input class="form-control form-control-sm" id="total_amount" type="Number"
                                    name="total_amount" value=0 required disabled/>
                            </div>
                        </div>
                        {{-- <div class="form-group row">
                            <label for="current_amount" class="col-sm-2 col-form-label col-form-label-sm">Current
                                Amount</label>
                            <div class="col-sm-8">
                                <input class="form-control form-control-sm" id="current_amount" type="Number"
                                    name="current_amount" value=0 required />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="remaining" class="col-sm-2 col-form-label col-form-label-sm">Remaining</label>
                            <div class="col-sm-8">
                                <input class="form-control form-control-sm" id="remaining" type="Number"
                                    name="remaining" value=0 required />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="paid_amount" class="col-sm-2 col-form-label col-form-label-sm">Paid
                                Amount</label>
                            <div class="col-sm-8">
                                <input class="form-control form-control-sm" id="paid_amount" type="Number"
                                    name="paid_amount" value=0 required />
                            </div>
                        </div> --}}
                        <div class="form-group row">
                            <label for="date" class="col-sm-2 col-form-label col-form-label-sm">Date</label>
                            <div class="col-sm-8">
                                <input id="date" name="date" class="date form-control" type="date" required disabled>
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
                    <h4 class="modal-title" id="myModalLabel" style="color: whitesmoke;">Edit
                        Loan</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">close</button>

                </div> <!-- Modal Body -->
                <div class="modal-body" style="background-color: burlywood;">

                    <form method="POST" action="{{route('loan.update')}}">
                        @method('PUT')
                        @csrf
                        <input id="loan_id" type="hidden" name="loan_id" value="">
                        <div class="form-group row">

                            <label for="selectEmployee"
                                class="col-sm-2 col-form-label col-form-label-sm">Employee</label>
                            <div class="col-sm-8">
                                <select style="color:black" class="form-control" id="selectEmployee" name="employee" required focus>
                                    <option value="" disabled selected>Please select Employee</option>
                                    @foreach($employees as $employee)
                                    <option value="{{$employee->id}}">
                                        {{ $employee->full_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">

                            <label for="selectCategory" class="col-sm-2 col-form-label col-form-label-sm">Loan
                                Type</label>
                            <div class="col-sm-8">
                                <select style="color:black" class="form-control" id="selectCategory" name="category" required focus>
                                    <option value="" disabled selected>Please select Category</option>
                                    @foreach($categories as $category)
                                    <option value="{{$category->id}}">
                                        {{ $category->name}} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="total_amount" class="col-sm-2 col-form-label col-form-label-sm">Total
                                Amount</label>
                            <div class="col-sm-8">
                                <input class="form-control form-control-sm" id="total_amount" type="Number"
                                    name="total_amount" value=0 required />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="current_amount" class="col-sm-2 col-form-label col-form-label-sm">Current
                                Amount</label>
                            <div class="col-sm-8">
                                <input class="form-control form-control-sm" id="current_amount" type="Number"
                                    name="current_amount" value=0 required />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="remaining" class="col-sm-2 col-form-label col-form-label-sm">Remaining</label>
                            <div class="col-sm-8">
                                <input class="form-control form-control-sm" id="remaining" type="Number"
                                    name="remaining" value=0 required />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="paid_amount" class="col-sm-2 col-form-label col-form-label-sm">Paid
                                Amount</label>
                            <div class="col-sm-8">
                                <input class="form-control form-control-sm" id="paid_amount" type="Number"
                                    name="paid_amount" value=0 required />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="datetimepicker1" class="col-sm-2 col-form-label col-form-label-sm">Date</label>
                            <div class="col-sm-8">
                                <input id="date" name="date" class="date form-control" type="date">
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
            var category = button.data('category');
            var total_amount = button.data('total_amount');
            var date = button.data('date');
            var current_amount = button.data('current_amount');
            var paid_amount = button.data('paid_amount');
            var remaining_amount = button.data('remaining_amount');
            var id = button.data('id')

            var modal = $(this)
            modal.find('.modal-body #selectEmployee').val(name);
            modal.find('.modal-body #selectCategory').val(category);
            modal.find('.modal-body #total_amount').val(total_amount);
            modal.find('.modal-body #current_amount').val(current_amount);
            modal.find('.modal-body #remaining').val(remaining_amount);
            modal.find('.modal-body #paid_amount').val(paid_amount);
            modal.find('.modal-body #date').val(date);
            modal.find('.modal-body #loan_id').val(id);
        })
    });
  
    function enableInsurance(e){
       
      
       var sel = document.getElementById('selectEmployee')
       var selected = e.options[e.selectedIndex]
       var employee =  sel.options[sel.selectedIndex]
     
       if(selected.value == 5){
           document.getElementById("insuranceblock").style.display = ""
           document.getElementById("durationblock").style.display = ""
           
            
       }
       else{
           document.getElementById("insuranceblock").style.display = "none"
            document.getElementById("durationblock").style.display = "none"
       }
       
       
    }
   function getYearsDiff(startDate, endDate) {
    if (startDate > endDate) [startDate, endDate] = [endDate, startDate];

    let yearB4End = new Date(
        endDate.getFullYear() - 1,
        endDate.getMonth(),
        endDate.getDate()
    );
    let year = 0;
    year = yearB4End > startDate
        ? yearB4End.getFullYear() - startDate.getFullYear()
        : 0;
    let yearsAfterStart = new Date(
        startDate.getFullYear() + year + 1,
        startDate.getMonth(),
        startDate.getDate()
    );
    
    if (endDate >= yearsAfterStart) year++;
    
    return year;
}
  function selectedEmployee(e){
          var sel = document.getElementById('selectEmployee')
       var selected = e.options[e.selectedIndex]
       document.getElementById('selectCategory').removeAttribute('disabled');
        document.getElementById('total_amount').removeAttribute('disabled');
         document.getElementById('date').removeAttribute('disabled');
         
               var baseurl = window.location.protocol + "//" + window.location.host + '/payroll/';
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
        });
        
        formData = {
                employee_id:selected.value ,
                
            };
    
        var type = "GET";

        var ajaxurl = baseurl + "employeeloan";

        $.ajax({
            type: type,
            url: ajaxurl,
            data: formData,
            dataType: "json",
            success: function (data) {
                if(data != 0){
                      var selo = document.getElementById('selectinsurance')
                    
                 selo.value= data;
                
                  
                }
          
                
            },
            error: function (data) {
                console.log("Error:", data.responseText);
            },
        });
       
       
       
    
    }

</script>

@endsection
