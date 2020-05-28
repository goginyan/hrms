@extends('layouts.dashboard')

@section('title','Payroll')

@section('content')
    <div class="row justify-content-center">
        <h4>Payroll for {{date('F Y', strtotime($month))}}</h4>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('payroll.store')}}" method="post" id="payroll-form">
                        @csrf
                        <input type="hidden" name="month" value="{{$month}}" id="month-input">
                        <div class="table-responsive">
                            <table class="table payroll-table">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Salary</th>
                                    @foreach($bonuses as $bonus)
                                        <th>{{$bonus->name}}</th>
                                    @endforeach
                                    <th>Total Bonuses</th>
                                    <th>Taxable Income</th>
                                    @foreach($taxes as $tax)
                                        <th>{{$tax->name}}</th>
                                    @endforeach
                                    <th>Total Taxes</th>
                                    @foreach($non_taxable_incomes as $non_taxable_income)
                                        <th>{{$non_taxable_income->name}}</th>
                                    @endforeach
                                    <th>Total NTI</th>
                                    <th>Income</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php($counter = 0)
                                @foreach($employees as $employee)
                                    <tr>
                                        <td>{{++$counter}}</td>
                                        <td>{{$employee->first_name . ' ' . $employee->last_name}}</td>
                                        <td><input type="number" title="Salary" min="0"
                                                   name="employee[{{$employee->id}}][salary]"
                                                   value="{{$employee->employeeSalaryByMonth($month)->salary}}"
                                                   class="employee-salary"></td>
                                        @php($total_bonuses = 0)
                                        @foreach($bonuses as $bonus)
                                            <td><input type="number" value="0" min="0"
                                                       name="employee[{{$employee->id}}][bonus][{{$bonus->id}}]"
                                                       title="{{$bonus->name}}" class="employee-bonus"></td>
                                        @endforeach
                                        <td class="employee-total-bonuses">{{$total_bonuses}}</td>
                                        <input type="hidden" name="employee[{{$employee->id}}][total_bonuses]"
                                               class="total-bonuses-input" value="{{$total_bonuses}}">
                                        <td class="employee-taxable-income">{{$employee->salary + $total_bonuses}}</td>
                                        <input type="hidden" name="employee[{{$employee->id}}][taxable_income]"
                                               class="taxable-income-input"
                                               value="{{$employee->salary + $total_bonuses}}">
                                        @php($total_taxes = 0)
                                        @foreach($taxes as $tax)
                                            {{--                                        <td>{{$amount = $tax->taxIntervals()->where('start', '<=', $employee->salary)->where('end', '>=', $employee->salary)->first()->rate * $employee->salary / 100}}</td>--}}
                                            <td class="employee-tax"
                                                data-id="{{$tax->id}}">{{$amount = $employee->calculateTaxDetails($tax)['amount']}}</td>
                                            <input type="hidden" name="employee[{{$employee->id}}][tax][{{$tax->id}}]"
                                                   class="tax-input-{{$tax->id}}" value="{{$amount}}">
                                            @php($total_taxes += $amount)
                                        @endforeach
                                        <td class="employee-total-taxes">{{$total_taxes}}</td>
                                        <input type="hidden" name="employee[{{$employee->id}}][total_taxes]"
                                               class="total-taxes-input" value="{{$total_taxes}}">
                                        @foreach($non_taxable_incomes as $non_taxable_income)
                                            <td><input type="number" value="0" min="0"
                                                       name="employee[{{$employee->id}}][non_taxable_income][{{$non_taxable_income->id}}]"
                                                       title="{{$bonus->name}}" class="employee-non-taxable-income">
                                            </td>
                                        @endforeach
                                        <td class="employee-total-non-taxable-incomes">0</td>
                                        <input type="hidden" name="employee[{{$employee->id}}][total_nti]"
                                               class="total-nti-input" value="0">
                                        <td class="employee-income">{{$employee->salary - $total_taxes}}</td>
                                        <input type="hidden" name="employee[{{$employee->id}}][income]"
                                               class="income-input" value="{{$employee->salary - $total_taxes}}">
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="text-right">
                            <button class="btn btn-primary" id="submit-btn">Confirm</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        $('.employee-salary').trigger('change');
        $(document).ready(function () {
            $('.employee-salary, .employee-bonus').change(function (e) {
                console.log('asdf');
                let salary = parseInt($(this).closest('tr').find('.employee-salary').val());
                let taxes = $(this).closest('tr').find('.employee-tax');
                let nti = $(this).closest('tr').find('.employee-non-taxable-income');
                let bonuses = $(this).closest('tr').find('.employee-bonus');
                let total_taxes = 0;
                let total_bonuses = 0;
                let total_nti = 0;

                bonuses.each(function () {
                    total_bonuses += parseInt($(this).val());
                });
                nti.each(function () {
                    total_nti += parseInt($(this).val());
                });
                let taxable_income = salary + total_bonuses;
                let complated_calls = 0;
                taxes.each(function (index, tax) {
                    $.get({
                        url: 'payroll/calculate_tax_details/{{$employee->id}}/' + $(tax).data('id') + '/' + taxable_income,
                        success: function (data) {
                            complated_calls++;
                            $(tax).html(data.amount);
                            $(tax).closest('tr').find('.tax-input-' + $(tax).data('id')).val(data.amount);
                            total_taxes += data.amount;

                            if (complated_calls === taxes.length) {
                                $(tax).closest('tr').find('.employee-total-taxes').html(total_taxes);
                                $(tax).closest('tr').find('.total-taxes-input').val(total_taxes);
                                $(tax).closest('tr').find('.employee-income').html(salary + total_bonuses - total_taxes + total_nti);
                                $(tax).closest('tr').find('.income-input').val(salary + total_bonuses - total_taxes + total_nti);
                            }
                        }
                    });
                });

                $(this).closest('tr').find('.employee-total-non-taxable-incomes').html(total_nti);
                $(this).closest('tr').find('.total-nti-input').val(total_nti);
                $(this).closest('tr').find('.employee-total-bonuses').html(total_bonuses);
                $(this).closest('tr').find('.total-bonuses-input').val(total_bonuses);
                $(this).closest('tr').find('.employee-taxable-income').html(salary + total_bonuses);
                $(this).closest('tr').find('.taxable-income-input').val(salary + total_bonuses);

                if (total_taxes > salary) {

                }
            });

            $('.employee-non-taxable-income').change(function () {
                let salary = parseInt($(this).closest('tr').find('.employee-salary').val());
                let nti = $(this).closest('tr').find('.employee-non-taxable-income');
                let total_taxes = parseInt($(this).closest('tr').find('.employee-total-taxes').html());
                let total_bonuses = parseInt($(this).closest('tr').find('.employee-total-bonuses').html());
                let total_nti = 0;

                nti.each(function () {
                    total_nti += parseInt($(this).val());
                });

                $(this).closest('tr').find('.employee-total-non-taxable-incomes').html(total_nti);
                $(this).closest('tr').find('.total-nti-input').val(total_nti);
                $(this).closest('tr').find('.employee-income').html(salary + total_bonuses + total_nti - total_taxes);
                $(this).closest('tr').find('.income-input').val(salary + total_bonuses + total_nti - total_taxes);
            });

            $('form input').keydown(function (e) {
                if (e.keyCode === 13) {
                    var inputs = $(this).parents("form").eq(0).find(":input");
                    if (inputs[inputs.index(this) + 1] != null) {
                        inputs[inputs.index(this) + 1].focus();
                    }
                    e.preventDefault();
                    return false;
                }
            });
        })
    </script>
@endpush
@push('style')
    <style>
        .table-responsive {
            max-height: 550px;
            margin-bottom: 20px;
            border-bottom: 1px solid #8d8d8d;
        }

        .employee-salary, .employee-tax, .employee-bonus, .employee-non-taxable-income {
            max-width: 100px;
        }

        input:focus {
            outline: none;
        }

        .payroll-table td {
            border-bottom: 1px solid #079ab6;
        }

        .payroll-table tr:last-child td {
            border-bottom: none;
        }

        .payroll-table th {
            border-bottom: 1px solid #8d8d8d !important;
        }

        td, th {
            white-space: nowrap;
            overflow: hidden;
            text-align: center;
        }
    </style>
@endpush