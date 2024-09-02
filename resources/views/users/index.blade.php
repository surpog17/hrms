@extends('layouts.app', ['page' => __('User Management'), 'pageSlug' => 'users'])
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
                        <h4 class="card-title ">{{ __('Users') }}</h4>
                        <p class="card-category"> {{ __('Here you can manage users') }}</p>
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
                                <a href="{{ route('user.create') }}"
                                    class="btn btn-sm btn-primary">{{ __('Add user') }}</a>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table id="myTable" class="display" cellspacing="0" width="100%">
                                <thead >
                                    <th>
                                        {{ __('Name') }}
                                    </th>
                                    <th>
                                        {{ __('Email') }}
                                    </th>
                                    <th>
                                        {{ __('HR') }}
                                    </th>
                                    <th>
                                        {{ __('Finance') }}
                                    </th>
                                    <th>
                                        {{ __('Creation date') }}
                                    </th>
                                    <th class="text-right">
                                        {{ __('Actions') }}
                                    </th>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                    
                                    <tr>
                                        <td>
                                            {{ $user->name }}
                                        </td>
                                        <td>

                                            {{ $user->email }}
                                        </td>
               
                                        <td>
                                            @if( $user->hr) HR @endif
                                        </td>
                                        <td>
                                            @if( $user->finance) Finance @endif
                                        </td>
                                        <td>
                                            {{ $user->created_at?$user->created_at->format('Y-m-d'):"" }}
                                        </td>
                                        <td class="td-actions text-right">
                                            @if ($user->id != auth()->id())
                                            <form action="{{ route('user.destroy', $user) }}" method="post">
                                                @csrf
                                                @method('delete')

                                                <a rel="tooltip" class="btn btn-success btn-link"
                                                    href="{{ route('user.edit', $user) }}" data-original-title=""
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
                                            @else
                                            <a rel="tooltip" class="btn btn-success btn-link"
                                                href="{{ route('profile.edit') }}" data-original-title="" title="">
                                                <i class="material-icons">edit</i>
                                                <div class="ripple-container"></div>
                                            </a>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $users->links() }}
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
            $('#myTable').DataTable();
        });

</script>
@endsection
