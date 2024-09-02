@extends('layouts.app', ['page' => __('Award'), 'pageSlug' => 'award'])
@section('styles')
<link href="https://fonts.googleapis.com/icon?family=Material+Icons"rel="stylesheet">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
     <link rel="stylesheet" type="text/css" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.0/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.0/css/jquery.dataTables_themeroller.css">
    @endsection
@section('content')

<div class="container">
<div class="container-fluid">
    <div class="row">
                            <div class="col-12 text-right">
                                <a href="{{ route('create_award') }}"
                                    class="btn btn-sm btn-primary">{{ __('Create Bonus') }}</a>
                            </div>
                        </div>
   
    <div class="row">
        <div class="col-md-12">


            <h3 allign="center">Bonus Data</h3>


             <table id="myTable" class="display" cellspacing="0" width="100%">
              <thead>
             <tr >
                    <th>#</th>
                    <th>Employee Name</th>
                    <th>Allowance</th>
                    <th>Exam Bonus</th>
                    <th>Implementation Effectiveness Bonus</th>
                    <th>Effective Order and Delivery Bonus</th>
                    <th>Closed Deals Bonus</th>
                    <th>Management Performance Evaluation Quarterly Bonus</th>
                    <th>Staff Performance Evaluation Quarterly Bonus</th>
                    <th>Timely VAT Collection Quarterly Bonus</th>
                    <th>Timely Payment Collection Quarterly Bonus</th>
                    <th>Best Employees Productivity and Engagement Quarterly Bonus</th>
                    <th>Facilities High Availability Quarterly Bonus</th>
                    <th>Bonus</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
                 </thead>
                 <tbody>
                @foreach($awards as $award)

                <tr>
                    <td>{{ $award->id }}</td>
                    <td>{{ $award->employee->full_name }}</td>
                    <td>{{ $award->allowance }}</td>
                    <td>{{ $award->exam_bonus }}</td>
                    <td>{{ $award->ieb }}</td>
                    <td>{{ $award->eodb }}</td>
                    <td>{{ $award->cdb }}</td>
                    <td>{{ $award->mpeqb }}</td>
                    <td>{{ $award->speqb }}</td>
                    <td>{{ $award->tvcqb }}</td>
                    <td>{{ $award->tpcqb }}</td>
                    <td>{{ $award->bepeqb }}</td>
                    <td>{{ $award->fhaqb }}</td>
                    <td>{{ $award->bonus }}</td>
                    <td>
                        <a href="{{ route('edit_award',$award->id) }}" rel="tooltip" class="btn btn-success btn-link">
                       <i class="material-icons">edit</i>
                                                    <div class="ripple-container"></div>
                       </a>
                </td>
                    <td>
                        <form action="{{ route('delete_award',$award->id)}}" method="post">
                                                @csrf
                                                @method('delete')
                         <button type="button" class="btn btn-danger btn-link"
                                                    data-original-title="" title=""
                                                    onclick="confirm('{{ __("Are you sure you want to delete this department?") }}') ? this.parentElement.submit() : ''">
                                                    <i class="material-icons">delete</i>
                                                    <div class="ripple-container"></div>
                                                </button>
                                                 </form>
                        <!-- <a href="{{ route('delete_award',$award->id)}}" class="btn btn-danger btn-sm">Trash</a> -->
                    </td>


                </tr>

                @endforeach
                 </tbody>
            </table>

        </div>
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
