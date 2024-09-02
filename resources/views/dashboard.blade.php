@extends('layouts.app', ['pageSlug' => 'dashboard'])
@emp
@section('content')
<h3 style="justify-content: center;
text-align: center;font-weight:bolder;color:red">Please Contact System Adminstrator</h3>

@endsection
@else
@fin
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card card-chart">
            <div class="card-header ">
                <div class="row">
                    <div class="col-sm-6 text-left">
                        <h5 class="card-category">Total Payroll</h5>
                        <h2 class="card-title">Payroll</h2>
                    </div>
                    <div class="col-sm-6">
                        <div class="btn-group btn-group-toggle float-right" data-toggle="buttons">
                            <label class="btn btn-sm btn-primary btn-simple active" id="0">
                                <input type="radio" name="options" checked>
                                <span class="d-none d-sm-block d-md-block d-lg-block d-xl-block">Payroll</span>
                                <span class="d-block d-sm-none">
                                    <i class="tim-icons icon-single-02"></i>
                                </span>
                            </label>
                            <label class="btn btn-sm btn-primary btn-simple" id="1">
                                <input type="radio" class="d-none d-sm-none" name="options">
                                <span class="d-none d-sm-block d-md-block d-lg-block d-xl-block">Bonus</span>
                                <span class="d-block d-sm-none">
                                    <i class="tim-icons icon-gift-2"></i>
                                </span>
                            </label>
                            <label class="btn btn-sm btn-primary btn-simple" id="2">
                                <input type="radio" class="d-none" name="options">
                                <span class="d-none d-sm-block d-md-block d-lg-block d-xl-block">Deduction</span>
                                <span class="d-block d-sm-none">
                                    <i class="tim-icons icon-tap-02"></i>
                                </span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="chartBig1"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">

    <div class="col-lg-6 col-md-12">
        <div class="card ">
            <div class="card-header">
                <h4 class="card-title">Loan</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table tablesorter" id="">
                        <thead class=" text-primary">
                            <tr>
                                <th>
                                    Name
                                </th>
                                <th class="text-center">
                                    Upcomming Amount
                                </th>
                                <th>
                                    Remaining Amount
                                </th>
                                <th>
                                    Deduction Type
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($loan as $l)
                            <tr>
                                <td>
                                    {{$l->employee->full_name}}
                                </td>
                                <td class="text-center">
                                    ETB {{$l->current_amount}}
                                </td>
                                <td>
                                    ETB {{$l->remaining_amount}}
                                </td>
                                <td>
                                    {{$l->category->name}}
                                </td>

                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-12">
        <div class="card ">
            <div class="card-header">
                <h4 class="card-title">Warning</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table tablesorter" id="">
                        <thead class=" text-primary">
                            <tr>
                                <th>
                                    Name
                                </th>
                                <th>
                                    Offense level
                                </th>
                                <th>
                                    Disciplinary Measures
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($war as $w)
                            @if($w->employee)
                            <tr>
                                <td>
                                    {{$w->employee->full_name}}
                                </td>
                                <td>
                                    {{$w->warn}}
                                </td>
                                <td>
                                    {{$w->remark}}
                                </td>
                            </tr>
                            @endif

                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@endfin
@hr
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card card-chart">
            <div class="card-header ">
                <div class="row">
                    <div class="col-sm-6 text-left">
                        <h5 class="card-category">Total Payroll</h5>
                        <h2 class="card-title">Payroll</h2>
                    </div>
                    <div class="col-sm-6">
                        <div class="btn-group btn-group-toggle float-right" data-toggle="buttons">
                            <label class="btn btn-sm btn-primary btn-simple active" id="0">
                                <input type="radio" name="options" checked>
                                <span class="d-none d-sm-block d-md-block d-lg-block d-xl-block">Payroll</span>
                                <span class="d-block d-sm-none">
                                    <i class="tim-icons icon-single-02"></i>
                                </span>
                            </label>
                            <label class="btn btn-sm btn-primary btn-simple" id="1">
                                <input type="radio" class="d-none d-sm-none" name="options">
                                <span class="d-none d-sm-block d-md-block d-lg-block d-xl-block">Bonus</span>
                                <span class="d-block d-sm-none">
                                    <i class="tim-icons icon-gift-2"></i>
                                </span>
                            </label>
                            <label class="btn btn-sm btn-primary btn-simple" id="2">
                                <input type="radio" class="d-none" name="options">
                                <span class="d-none d-sm-block d-md-block d-lg-block d-xl-block">Deduction</span>
                                <span class="d-block d-sm-none">
                                    <i class="tim-icons icon-tap-02"></i>
                                </span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="chartBig1"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">

    <div class="col-lg-6 col-md-12">
        <div class="card ">
            <div class="card-header">
                <h4 class="card-title">Loan</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table tablesorter" id="">
                        <thead class=" text-primary">
                            <tr>
                                <th>
                                    Name
                                </th>
                                <th class="text-center">
                                    Upcomming Amount
                                </th>
                                <th>
                                    Remaining Amount
                                </th>
                                <th>
                                    Deduction Type
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($loan as $l)
                            <tr>
                                <td>
                                    {{$l->employee->full_name}}
                                </td>
                                <td class="text-center">
                                    ETB {{$l->current_amount}}
                                </td>
                                <td>
                                    ETB {{$l->remaining_amount}}
                                </td>
                                <td>
                                    {{$l->category->name}}
                                </td>

                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-12">
        <div class="card ">
            <div class="card-header">
                <h4 class="card-title">Warning</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table tablesorter" id="">
                        <thead class=" text-primary">
                            <tr>
                                <th>
                                    Name
                                </th>
                                <th>
                                    Offense level
                                </th>
                                <th>
                                    Disciplinary Measures
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($war as $w)
                            @if($w->employee)
                            <tr>
                                <td>
                                    {{$w->employee->full_name}}
                                </td>
                                <td>
                                    {{$w->warn}}
                                </td>
                                <td>
                                    {{$w->remark}}
                                </td>
                            </tr>
                            @endif

                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@endhr
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card card-chart">
            <div class="card-header ">
                <div class="row">
                    <div class="col-sm-6 text-left">
                        <h5 class="card-category">Total Payroll</h5>
                        <h2 class="card-title">Payroll</h2>
                    </div>
                    <div class="col-sm-6">
                        <div class="btn-group btn-group-toggle float-right" data-toggle="buttons">
                            <label class="btn btn-sm btn-primary btn-simple active" id="0">
                                <input type="radio" name="options" checked>
                                <span class="d-none d-sm-block d-md-block d-lg-block d-xl-block">Payroll</span>
                                <span class="d-block d-sm-none">
                                    <i class="tim-icons icon-single-02"></i>
                                </span>
                            </label>
                            <label class="btn btn-sm btn-primary btn-simple" id="1">
                                <input type="radio" class="d-none d-sm-none" name="options">
                                <span class="d-none d-sm-block d-md-block d-lg-block d-xl-block">Bonus</span>
                                <span class="d-block d-sm-none">
                                    <i class="tim-icons icon-gift-2"></i>
                                </span>
                            </label>
                            <label class="btn btn-sm btn-primary btn-simple" id="2">
                                <input type="radio" class="d-none" name="options">
                                <span class="d-none d-sm-block d-md-block d-lg-block d-xl-block">Deduction</span>
                                <span class="d-block d-sm-none">
                                    <i class="tim-icons icon-tap-02"></i>
                                </span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="chartBig1"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">

    <div class="col-lg-6 col-md-12">
        <div class="card ">
            <div class="card-header">
                <h4 class="card-title">Loan</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table tablesorter" id="">
                        <thead class=" text-primary">
                            <tr>
                                <th>
                                    Name
                                </th>
                                <th class="text-center">
                                    Upcomming Amount
                                </th>
                                <th>
                                    Remaining Amount
                                </th>
                                <th>
                                    Deduction Type
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($loan as $l)
                            <tr>
                                <td>
                                    {{$l->employee->full_name}}
                                </td>
                                <td class="text-center">
                                    ETB {{$l->current_amount}}
                                </td>
                                <td>
                                    ETB {{$l->remaining_amount}}
                                </td>
                                <td>
                                    {{$l->category->name}}
                                </td>

                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-12">
        <div class="card ">
            <div class="card-header">
                <h4 class="card-title">Warning</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table tablesorter" id="">
                        <thead class=" text-primary">
                            <tr>
                                <th>
                                    Name
                                </th>
                                <th>
                                    Offense level
                                </th>
                                <th>
                                    Disciplinary Measures
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($war as $w)
                            @if($w->employee)
                            <tr>
                                <td>
                                    {{$w->employee->full_name}}
                                </td>
                                <td>
                                    {{$w->warn}}
                                </td>
                                <td>
                                    {{$w->remark}}
                                </td>
                            </tr>
                            @endif

                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
@endemp

@push('js')
<script src="{{ asset('black') }}/js/plugins/chartjs.min.js"></script>
<script>
    $(document).ready(function() {
          demo.initDashboardPageCharts();
        });
</script>
@endpush
