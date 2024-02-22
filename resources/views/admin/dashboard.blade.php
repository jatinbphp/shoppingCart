@extends('admin.layouts.app')
@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-sm-6 col-md-3 mt-2">
                        <div class="info-box">
                            <span class="info-box-icon bg-info elevation-1">
                                <i class="fas fa-users"></i>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text">Total Users</span>
                                <span class="info-box-number">{{$total_users}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3 mt-2">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-danger elevation-1">
                                <i class="fas fa-tag"></i>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text">Total Products</span>
                                <span class="info-box-number">{{$total_products}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix hidden-md-up">
                    </div>
                    <div class="col-12 col-sm-6 col-md-3 mt-2">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-success elevation-1">
                                <i class="fas fa-shopping-cart">
                                </i>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text">Total Orders</span>
                                <span class="info-box-number">{{$total_orders}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3 mt-2">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-warning elevation-1">
                                <i class="fas fa-credit-card"></i>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text">Total Sales</span>
                                <span class="info-box-number">{{$total_amount_sum}}</span>
                            </div>
                        </div>
                    </div>
                </div>

                 <div class="row">
                    <div class="col-6">
                        <div class="card card-info card-outline">
                            <div class="card-header">
                                <h3 class="card-title">Total Sales</h3>
                                <div class="card-tools d-none">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="chart">
                                    <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-6">
                        <!-- LINE CHART -->
                        <div class="card card-info card-outline">
                            <div class="card-header">
                                <h3 class="card-title">Total Orders</h3>
                                <div class="card-tools d-none">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="chart">
                                    <div id="lineChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card card-info card-outline">
                            <div class="card-header">
                                <h3 class="card-title">Latest Orders</h3>
                            </div>
                            <div class="card-body">
                                <input type="hidden" id="route_name" value="{{ route('orders.index_dashboard')}}">
                                <table id="ordersDasboardTable" class="table table-bordered table-striped datatable-dynamic">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Order ID</th>
                                            <th>User</th>
                                            <th>Total</th>
                                            <th>Status</th>
                                            <th>Created Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@section('jquery')
<script type="text/javascript">
var areaChartData = {
    labels  : ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
    datasets: [
        {
            label               : 'Total Sales',
            backgroundColor     : '#343a40',
            borderColor         : '#343a40',
            pointRadius          : false,
            pointColor          : '#3b8bba',
            pointStrokeColor    : 'rgba(60,141,188,1)',
            pointHighlightFill  : '#fff',
            pointHighlightStroke: 'rgba(60,141,188,1)',
            data                : [20008, 48000, 40000, 19000, 8600, 27000, 10000]
        }
    ]
}

var barChartCanvas = $('#barChart').get(0).getContext('2d');
var barChartData = $.extend(true, {}, areaChartData);

// Remove the Electronics dataset
barChartData.datasets.splice(1, 1);

var barChartOptions = {
    responsive              : true,
    maintainAspectRatio     : false,
    datasetFill             : false
};

new Chart(barChartCanvas, {
    type: 'bar',
    data: barChartData,
    options: barChartOptions
});


$(function () {
    function getSize(elementId) {
        return {
            width: document.getElementById(elementId).offsetWidth,
            height: document.getElementById(elementId).offsetHeight,
        }
    }

    let data = [
        [0, 1, 2, 3, 4, 5, 6, 7],
        [28, 48, 40, 19, 86, 27, 90, 100],
        [65, 59, 80, 81, 56, 55, 40, 50]
    ];

    const optsLineChart = {
        ... getSize('lineChart'),
        scales: {
            x: {
                time: false,
            },
            y: {
                range: [0, 100],
            },
        },
        series: [
            {},
            {
              fill: 'transparent',
              width: 5,
              stroke: '#343a40',
            },
            {
              stroke: '#c1c7d1',
              width: 5,
              fill: 'transparent',
            },
        ],
    };

    let lineChart = new uPlot(optsLineChart, data, document.getElementById('lineChart'));
    window.addEventListener("resize", e => {
        lineChart.setSize(getSize('lineChart'));
    });
})
</script>
@endsection