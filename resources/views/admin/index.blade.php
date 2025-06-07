@extends('layouts.admin')
@section('content')
<div class="main-content-inner">

    <div class="main-content-wrap">
        <div class="tf-section-2 mb-30">
         @php
    function formatCurrencyShort($number) {
        if ($number >= 1000000) {
            return number_format($number / 1000000, 2) . 'M';
        } elseif ($number >= 1000) {
            return number_format($number / 1000, 2) . 'K';
        }
        return number_format($number, 0);
    }
@endphp

<div class="flex gap20 flex-wrap-mobile">
    <div class="w-half">

        <div class="wg-chart-default mb-20">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap14">
                    <div class="image ic-bg">
                        <i class="icon-shopping-bag"></i>
                    </div>
                    <div>
                        <div class="body-text mb-2">Total Orders</div>
                        <h4>{{ $dashboardDatas[0]->Total }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="wg-chart-default mb-20">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap14">
                    <div class="image ic-bg">
                        <i class="icon-dollar-sign"></i>
                    </div>
                    <div>
                        <div class="body-text mb-2">Total Amount</div>
                        <h4>{{ formatCurrencyShort($dashboardDatas[0]->TotalAmount) }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="wg-chart-default mb-20">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap14">
                    <div class="image ic-bg">
                        <i class="icon-shopping-bag"></i>
                    </div>
                    <div>
                        <div class="body-text mb-2">Pending Orders</div>
                        <h4>{{ $dashboardDatas[0]->TotalOrdered }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="wg-chart-default">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap14">
                    <div class="image ic-bg">
                        <i class="icon-dollar-sign"></i>
                    </div>
                    <div>
                        <div class="body-text mb-2">Pending Orders Amount</div>
                        <h4>{{ formatCurrencyShort($dashboardDatas[0]->TotalOrderedAmount) }}</h4>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="w-half">

        <div class="wg-chart-default mb-20">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap14">
                    <div class="image ic-bg">
                        <i class="icon-shopping-bag"></i>
                    </div>
                    <div>
                        <div class="body-text mb-2">Delivered Orders</div>
                        <h4>{{ $dashboardDatas[0]->TotalDelivered }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="wg-chart-default mb-20">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap14">
                    <div class="image ic-bg">
                        <i class="icon-dollar-sign"></i>
                    </div>
                    <div>
                        <div class="body-text mb-2">Delivered Orders Amount</div>
                        <h4>{{ formatCurrencyShort($dashboardDatas[0]->TotalDeliveredAmount) }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="wg-chart-default mb-20">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap14">
                    <div class="image ic-bg">
                        <i class="icon-shopping-bag"></i>
                    </div>
                    <div>
                        <div class="body-text mb-2">Canceled Orders</div>
                        <h4>{{ $dashboardDatas[0]->TotalCanceled }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="wg-chart-default">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap14">
                    <div class="image ic-bg">
                        <i class="icon-dollar-sign"></i>
                    </div>
                    <div>
                        <div class="body-text mb-2">Canceled Orders Amount</div>
                        <h4>{{ formatCurrencyShort($dashboardDatas[0]->TotalCanceledAmount) }}</h4>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>


            <div class="wg-box">
                <div class="flex items-center justify-between">
                    <h5>Monthly revenue</h5>
                </div>
                <div class="flex flex-wrap gap40">
                    <div>
                        <div class="mb-2">
                            <div class="block-legend">
                                <div class="dot t1"></div>
                                <div class="text-tiny">Total</div>
                            </div>
                        </div>
                        <div class="flex items-center gap10">
                            <h4>{{ formatCurrencyShort($TotalAmount) }}</h4>

                        </div>
                    </div>
                    <div>
                        <div class="mb-2">
                            <div class="block-legend">
                                <div class="dot t2"></div>
                                <div class="text-tiny">Pending</div>
                            </div>
                        </div>
                        <div class="flex items-center gap10">
                           <h4>{{ formatCurrencyShort($TotalOrderedAmount) }}</h4>)
                        </div>
                    </div>
                    <div>
                        <div class="mb-2">
                            <div class="block-legend">
                                <div class="dot t2"></div>
                                <div class="text-tiny">Delivered</div>
                            </div>
                        </div>
                        <div class="flex items-center gap10">
                           <h4>{{ formatCurrencyShort($TotalDeliveredAmount) }}</h4>
                        </div>
                    </div>
                    <div>
                        <div class="mb-2">
                            <div class="block-legend">
                                <div class="dot t2"></div>
                                <div class="text-tiny">Canceled</div>
                            </div>
                        </div>
                        <div class="flex items-center gap10">
                           <h4>{{ formatCurrencyShort($TotalCanceledAmount) }}</h4>
                        </div>
                    </div>
                </div>
                <div id="line-chart-8"></div>
            </div>

        </div>
        <div class="tf-section mb-30">

            <div class="wg-box">
                <div class="flex items-center justify-between">
                    <h5>Recent orders</h5>
                    <div class="dropdown default">
                        <a class="btn btn-secondary dropdown-toggle" href="{{ route('admin.orders') }}">
                            <span class="view-all">View all</span>
                        </a>
                    </div>
                </div>
                <div class="wg-table table-all-user">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
         <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center" style="width:70px">ID</th>
                                <th class="text-center">Name</th>
                                <th class="text-center">Phone</th>
                                <th class="text-center">Subtotal</th>
                                <th class="text-center">Tax</th>
                                <th class="text-center">Total</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Order Date</th>
                                <th class="text-center">Total Items</th>
                                <th class="text-center">Delivered On</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                            <tr>
                                <td class="text-center">{{$order->id}}</td>
                                <td class="text-center">{{$order->name}}</td>
                                <td class="text-center">{{$order->phone}}</td>
                                <td class="text-center">${{$order->subtotal}}</td>
                                <td class="text-center">${{$order->tax}}</td>
                                <td class="text-center">${{$order->total}}</td>
                                <td class="text-center">
                                    @if($order->status == 'delivered')
                                    <span class="badge bg-success">Delivered</span>
                                @elseif($order->status == 'canceled')
                                    <span class="badge bg-danger">Canceled</span>
                                @else
                                    <span class="badge bg-warning">Ordered</span>
                                @endif
                                </td>
                                <td class="text-center">{{$order->created_at}}</td>
                                <td class="text-center">{{$order->orderItems->count()}}</td>
                                <td class="text-center">{{$order->delivered_date}}</td>
                                <td class="text-center">
                                    <a href="{{route('admin.order.details', ['order_id'=>$order->id])}}">
                                        <div class="list-icon-function view-icon">
                                            <div class="item eye"><i class="icon-eye"></i></div>
                                        </div>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                            <tbody>
                                <tr>
                                    <td class="text-center">1</td>
                                    <td class="text-center">Divyansh Kumar</td>
                                    <td class="text-center">1234567891</td>
                                    <td class="text-center">$172.00</td>
                                    <td class="text-center">$36.12</td>
                                    <td class="text-center">$208.12</td>

                                    <td class="text-center">ordered</td>
                                    <td class="text-center">2024-07-11 00:54:14</td>
                                    <td class="text-center">2</td>
                                    <td></td>
                                    <td class="text-center">
                                        <a href="#">
                                            <div class="list-icon-function view-icon">
                                                <div class="item eye">
                                                    <i class="icon-eye"></i>
                                                </div>
                                            </div>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>
@endsection

@push('scripts')
        <script>
            (function ($) {

                var tfLineChart = (function () {

                    var chartBar = function () {

                        var options = {
                            series: [{
                                name: 'Total',
                                data: [{{ $AmountM }}]
                            }, {
                                name: 'Pending',
                                data: [{{ $OrderedAmountM }}]
                            },
                            {
                                name: 'Delivered',
                                data: [{{ $DeliveredAmountM }}]
                            }, {
                                name: 'Canceled',
                                data: [{{ $CanceledAmountM }}]
                            }],
                            chart: {
                                type: 'bar',
                                height: 325,
                                toolbar: {
                                    show: false,
                                },
                            },
                            plotOptions: {
                                bar: {
                                    horizontal: false,
                                    columnWidth: '10px',
                                    endingShape: 'rounded'
                                },
                            },
                            dataLabels: {
                                enabled: false
                            },
                            legend: {
                                show: false,
                            },
                            colors: ['#2377FC', '#FFA500', '#078407', '#FF0000'],
                            stroke: {
                                show: false,
                            },
                            xaxis: {
                                labels: {
                                    style: {
                                        colors: '#212529',
                                    },
                                },
                                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                            },
                            yaxis: {
                                show: false,
                            },
                            fill: {
                                opacity: 1
                            },
                            tooltip: {
                                y: {
                                    formatter: function (val) {
                                        return "$ " + val + ""
                                    }
                                }
                            }
                        };

                        chart = new ApexCharts(
                            document.querySelector("#line-chart-8"),
                            options
                        );
                        if ($("#line-chart-8").length > 0) {
                            chart.render();
                        }
                    };

                    /* Function ============ */
                    return {
                        init: function () { },

                        load: function () {
                            chartBar();
                        },
                        resize: function () { },
                    };
                })();

                jQuery(document).ready(function () { });

                jQuery(window).on("load", function () {
                    tfLineChart.load();
                });

                jQuery(window).on("resize", function () { });
            })(jQuery);
        </script>
@endpush
