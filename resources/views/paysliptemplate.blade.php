<head>
    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
            font-size: 12px;
        }

        td,
        th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }
    </style>
</head>

<div class="container">
    <div class="row">
        <div style="">
            <div class="row">
                <address>
                    <strong>IE Networks</strong>
                    <br>
                    Festival 22,7th floor
                    <br>
                    Ethiopia, Addis Ababa
                    <br>
                </address>
            </div>
            <div style="float: right; margin-top: -150px;">
                <p>
                    <!--<em>Date: 1/10/2021 </em>-->
                    <em>Date: {{ date("Y-m-d") }}</em>
                </p>
            </div>
        </div>
        <div class="row" style="padding: 70px;">
            <div>
                <h1 style="font-family: times new roman;font-size: 15;">{{$webhr->full_name}} Payslip</h1>
            </div>
            </span>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th style="padding: 10px;">Type</th>
                        <th style="float: left;">Earning</th>
                        <th style="float: left;">Deduction</th>

                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="padding: 3px;"><em>Basic Salary</em></h4>
                        </td>
                        <td style="float: left;">ETB {{$employee->basic_salary}}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td style="padding: 3px;"><em>Transport Allowance</em></h4>
                        </td>
                        <td style="float: left;">ETB {{$pay->trans_allowance}}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td style="padding: 3px;"><strong>Gross Salary</strong></h4>
                        </td>
                        <td style="float: left;">ETB {{$pay->gross_salary}}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td style="padding: 3px;"><strong>Bonus</strong></h4>
                        </td>
                        <td style="float: left;"> </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td style="padding: 3px;"><em>Variable Pay</em></h4>
                        </td>
                        @if($award == Null)
                        <td style="float: left;">ETB 0.00</td>
                        @else
                        @if($award->allowance)<td style="float: left;">ETB {{$award->allowance}}</td>@else<td style="float: left;">ETB 0.00</td>@endif
                        @endif
                        <td></td>
                    </tr>
                    <tr>
                        <td style="padding: 3px;"><em>Exam Bonus</em></h4>
                        </td>
                        @if($award == Null)
                        <td style="float: left;">ETB 0.00</td>
                        @else
                        @if($award->exam_bonus)<td style="float: left;">ETB 0.00</td>@else<td style="float: left;">ETB {{$award->exam_bonus}}</td>@endif
                        @endif
                        <td></td>
                    </tr>
                    <tr>
                        <td style="padding: 3px;"><em>Implementation Effectiveness Bonus</em></h4>
                        </td>
                        @if($award == Null)
                        <td style="float: left;">ETB 0.00</td>
                        @else
                        <td style="float: left;">ETB {{$award->ieb}}</td>
                        @endif
                        <td></td>

                    </tr>
                    <tr>
                        <td style="padding: 3px;"><em>Effective Order and Delivery Bonus</em></h4>
                        </td>
                        @if($award == Null)
                        <td style="float: left;">ETB 0.00</td>
                        @else
                        <td style="float: left;">ETB {{$award->eodb}}</td>
                        @endif
                        <td></td>

                    </tr>
                    <tr>
                        <td style="padding: 3px;"><em>Closed Deals Bonus</em></h4>
                        </td>
                        @if($award == Null)
                        <td style="float: left;">ETB 0.00</td>
                        @else
                        <td style="float: left;">ETB {{$award->cdb}}</td>
                        @endif
                        <td></td>
                    </tr>
                    <tr>
                        <td style="padding: 3px;"><em>Management Performance Evaluation Quarterly Bonus</em></h4>
                        </td>
                        @if($award == Null)
                        <td style="float: left;">ETB 0.00</td>
                        @else
                        <td style="float: left;">ETB {{$award->mpeqb}}</td>
                        @endif
                        <td></td>

                    </tr>
                    <tr>
                        <td style="padding: 3px;"><em>Staff Performance Evaluation Quarterly Bonus</em></h4>
                        </td>
                        @if($award == Null)
                        <td style="float: left;">ETB 0.00</td>
                        @else
                        <td style="float: left;">ETB {{$award->speqb}}</td>
                        @endif
                        <td></td>

                    </tr>
                    <tr>
                        <td style="padding: 3px;"><em>Timely VAT Collection Quarterly Bonus</em></h4>
                        </td>
                        @if($award == Null)
                        <td style="float: left;">ETB 0.00</td>
                        @else
                        <td style="float: left;">ETB {{$award->tvcqb}}</td>
                        @endif
                        <td></td>

                    </tr>
                    <tr>
                        <td style="padding: 3px;"><em>Timely Payment Collection Quarterly Bonus</em></h4>
                        </td>
                        @if($award == Null)
                        <td style="float: left;">ETB 0.00</td>
                        @else
                        <td style="float: left;">ETB {{$award->tpcqb}}</td>
                        @endif
                        <td></td>

                    </tr>
                    <tr>
                        <td style="padding: 3px;"><em>Best Employees Productivity and Engagement Quarterly Bonus</em>
                            </h4>
                        </td>
                        @if($award == Null)
                        <td style="float: left;">ETB 0.00</td>
                        @else
                        <td style="float: left;">ETB {{$award->bepeqb}}</td>
                        @endif
                        <td></td>

                    </tr>
                    <tr>
                        <td style="padding: 3px;"><em>Facilities High Availability Quarterly Bonus</em></h4>
                        </td>
                        @if($award == Null)
                        <td style="float: left;">ETB 0.00</td>
                        @else
                        <td style="float: left;">ETB {{$award->fhaqb}}</td>
                        @endif
                        <td></td>

                    </tr>
                    <tr>
                        <td style="padding: 3px;"><em>Bonus</em></h4>
                        </td>
                        @if($award == Null)
                        <td style="float: left;">ETB 0.00</td>
                        @else
                        <td style="float: left;">ETB {{$award->bonus}}</td>
                        @endif
                        <td></td>

                    </tr>

                    <tr>
                        <td style="padding: 3px;"><em>Total Bonus</em></h4>
                        </td>
                        <td style="float: left;">ETB {{$pay->total_award}}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td style="padding: 3px;"><strong>Deductions</strong></h4>
                        </td>
                        <td style="float: left;"> </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td style="padding: 3px;"><em>Tax</em></h4>
                        </td>
                        <td></td>
                        <td style="float: left;">ETB {{$pay->tax}}</td>
                    </tr>
                    <tr>
                        <td style="padding: 3px;"><em>Employee Pension</em></h4>
                        </td>
                        <td></td>
                        <td style="float: left;">ETB {{$pay->emp_pension}}</td>
                    </tr>
                    <tr>
                        <td style="padding: 3px;"><em>Medical</em></h4>
                        </td>
                        <td></td>
                        @if($ded == Null)
                        <td style="float: left;">ETB 0.00</td>
                        @else
                        <td style="float: left;">ETB {{$ded->medical}}</td>
                        @endif
                    </tr>
                    <tr>
                        <td style="padding: 3px;"><em>Absentism</em></h4>
                        </td>
                        <td></td>
                        @if($ded == Null)
                        <td style="float: left;">ETB 0.00</td>
                        @else
                        <td style="float: left;">ETB {{$ded->absent}}</td>
                        @endif

                    </tr>
                    <tr>
                        <td style="padding: 3px;"><em>PMA</em></h4>
                        </td>
                        <td></td>
                        @if($ded == Null)
                        <td style="float: left;">ETB 0.00</td>
                        @else
                        <td style="float: left;">ETB {{$ded->pma}}</td>
                        @endif

                    </tr>
                    <tr>
                        <td style="padding: 3px;"><em>Car Maintenance</em></h4>
                        </td>
                        <td></td>
                        @if($ded == Null)
                        <td style="float: left;">ETB 0.00</td>
                        @else
                        <td style="float: left;">ETB {{$ded->car}}</td>
                        @endif

                    </tr>
                    <tr>
                        <td style="padding: 3px;"><em>Exam Failed</em></h4>
                        </td>
                        <td></td>
                        @if($ded == Null)
                        <td style="float: left;">ETB 0.00</td>
                        @else
                        <td style="float: left;">ETB {{$ded->exam}}</td>
                        @endif

                    </tr>
                    <tr>
                        <td style="padding: 3px;"><em>LateCommers</em></h4>
                        </td>
                        <td></td>
                        @if($ded == Null)
                        <td style="float: left;">ETB 0.00</td>
                        @else
                        <td style="float: left;">ETB {{$ded->latecommer}}</td>
                        @endif

                    </tr>
                    <tr>
                        <td style="padding: 3px;"><em>Other Deduction</em></h4>
                        </td>
                        <td></td>
                        @if($ded == Null)
                        <td style="float: left;">ETB 0.00</td>
                        @else
                        <td style="float: left;">ETB {{$ded->other}}</td>
                        @endif

                    </tr>
                    <tr>
                        <td style="padding: 3px;"><em>Loan</em></h4>
                        </td>
                        <td></td>
                        @if($ded == Null)
                        <td style="float: left;">ETB 0.00</td>
                        @else
                        <td style="float: left;">ETB {{$ded->loan}}</td>
                        @endif

                    </tr>
                    <tr>
                        <td style="padding: 3px;"><strong>Total Deduction</strong></h4>
                        </td>
                        <td></td>
                        <td style="float: left;">ETB {{$pay->total_deduction}}</td>
                    </tr>

                    <tr>
                        <td style="padding: 3px;"><strong>Gross Income</strong></h4>
                        </td>

                        <td style="float: left;">ETB {{$pay->gross_income}}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td style="padding: 3px;"><strong>Net Pay</strong></h4>
                        </td>

                        <td style="float: left;">ETB {{$pay->net_income}}</td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
            <img src="Stamp.png" alt="ie-logo" style="padding-left: 15em;height: 10em; weight: 10em;">

        </div>
    </div>
</div>
</div>
