@extends('layouts.app', ['page' => __('Calculate Raw'), 'pageSlug' => 'calculate'])

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card">
                <div class="card-header">Attendance Calculation</div>

                <div class="card-body">
                    @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                    @endif

                    <a style="float:right" href="{{route('raw.download')}}" class="btn btn-primary"> Attendance Download</a>
                    <form method="POST" action="{{route('calculate.all')}}">
                        @csrf
                        <div class="form-group">
                            <label for="range">Date Range</label>
                            <input id="range" type="text" name="daterange" value="" required />
                        </div>
                        <button class="btn btn-primary" type="submit">Calculate</button>

                    </form>

                    <calculated-component></calculated-component>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table tablesorter " id="">
                                <thead class=" text-primary">
                                    <tr>
                                        <th>
                                            Acc-No
                                        </th>
                                        <th>
                                            Name
                                        </th>
                                        <th>
                                            Morning Late
                                        </th>
                                        <th>
                                            Lunch Late
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($calculate as $c)
                                    <tr>
                                        <td>{{$c->acc_id}}</td>
                                        <td>{{$c->name}}</td>
                                        <td>{{floor($c->morning_late / 3600)}} : {{floor(($c->morning_late / 60) % 60)}} : {{$c->morning_late % 60}}</td>
                                        <td>{{floor($c->lunch_late / 3600)}} : {{floor(($c->lunch_late / 60) % 60)}} : {{$c->lunch_late % 60}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    {{$calculate->links()}}

                    <div style="margin-top: 2em;">
                        <h4>Morning Detail</h4>
                    </div>

                    <a href="{{route('morning.detail')}}" class="btn btn-primary">Calculate Morning Detail</a>

                    <div style="float:right;" class="btn-group" role="group" aria-label="Basic example">
                        <a href="{{route('all.offense')}}" type="button" class="btn btn-primary">Give Warning</a>
                    </div>


                    <table style="margin-top: 2em;" class="table">
                        <thead>
                            <tr style="background: grey; color:white">
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Total Late</th>
                                <th scope="col">Date</th>
                                <th scope="col">late</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $var = 0;
                            $renderedname = [];
                            @endphp
                            @foreach ($morning as $f)
                            <tr>
                                @if (!in_array($f->calculated_id, $renderedname))
                                @php
                                $var += 1;
                                $renderedname[] = $f->calculated_id;
                                @endphp
                                <td
                                    rowspan="{{ App\Morning::where(['calculated_id'=> $f->calculated_id,'active' => 1])->count()  }}">
                                    {{$var}}</td>
                                <td
                                    rowspan="{{ App\Morning::where(['calculated_id'=> $f->calculated_id,'active' => 1])->count()  }}">
                                    {{$f->calculated->name}}</td>
                                <td
                                    rowspan="{{ App\Morning::where(['calculated_id'=> $f->calculated_id,'active' => 1])->count()  }}">
                                    {{$f->calculated->morning_late/60}} min</td>

                                @endif
                                <td>{{$f->date}}</td>
                                <td>{{$f->late/60}} min</td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <a href="{{route('warning.offense',['id'=>$f->calculated->acc_id,'min'=>($f->late/60),'date'=>$f->date])}}"
                                            type="button" class="btn btn-primary">Give Warning</a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>






                </div>
            </div>
        </div>
    </div>

</div>
@endsection
@section('scripts')
<script>
    // $.noConflict();
    jQuery(document).ready(function ($) {
          $('input[name="daterange"]').daterangepicker({
            opens: 'left'
          }, function(start, end, label) {
            console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
          });
        });
</script>

@endsection
