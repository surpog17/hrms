@extends('layouts.app', ['page' => __('Employee Management'), 'pageSlug' => 'Employee-management'])

@section('styles')
<link href="https://fonts.googleapis.com/icon?family=Material+Icons"rel="stylesheet">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
     <link rel="stylesheet" type="text/css" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.0/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.0/css/jquery.dataTables_themeroller.css">
    @endsection

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title ">{{ __('Employees') }}</h4>
                        <p class="card-category"> {{ __('Here you can manage Employee') }}</p>
                    </div>
                    <div class="card-body">
                        @if (session('status'))
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="alert alert-success">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <i class="material-icons">close</i>
                                    </button>
                                    <span>{{ session('status') }}</span>
                                </div>
                            </div>
                        </div>
                        @endif

                        <div class="row">
                            <div class="col-12 text-right">
                                <a href="{{ route('employee.create') }}"
                                    class="btn btn-sm btn-primary">{{ __('Add Employee') }}</a>
                            </div>
                        </div>
                        <table id="myTable" class="display" cellspacing="0" width="100%">
                            <thead >
                                <tr>

                                <th >
                                    {{ __('#') }}
                                </th>

                                <th >
                                    {{ __('Name') }}
                                </th>
                                <th >
                                    {{ __('Basic Salary') }}
                                </th>
                                <th >
                                    {{ __('Probation') }}
                                </th>
                               
                                <th >
                                    {{ __('Action') }}
                                </th>
                           </tr>
                            </thead>
                            <tbody>

                                           @php
                                        $val = 1

                                         @endphp
                                @foreach($users as $user)
                                <tr>
                                    <td>
                                      {{ $val }}
                                    </td>
                                    <td>
                                        {{ $user->full_name }}
                                    </td>
                                    <td>
                                        {{ $user->basic_salary }}
                                    </td>
                                  
                                    <td>
                                        @if($user->probation) Probation @else Permanent @endif
                                    </td>
                                    <td>

                                        <form action="{{ route('employee.destroy', $user->id) }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <a rel="tooltip" class="btn btn-success btn-link"
                                                href="{{ route('employee.edit',$user->id) }}" data-original-title=""
                                                title="">
                                                <i class="material-icons">edit</i>
                                                <div class="ripple-container"></div>
                                            </a>
                                            <button type="button" class="btn btn-danger btn-link"
                                                data-original-title="" title=""
                                                onclick="confirm('{{ __("Are you sure you want to delete this user?") }}') ? this.parentElement.submit() : ''">
                                                <i class="material-icons">delete</i>
                                                <div class="ripple-container"></div>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                                  @php
                        $val +=1
                        @endphp
                                @endforeach
                            </tbody>
                        </table>


                        <div class="table-responsive">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.7.1.min.js"></script>
    <script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.0/jquery.dataTables.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
            $('#myTable').DataTable( {
        "lengthMenu": [[5,10, 25, 50, -1], [5,10, 25, 50, "All"]]
    });
        });

</script>
@endsection
