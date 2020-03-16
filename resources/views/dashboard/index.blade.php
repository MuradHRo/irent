@extends('layouts.dashboard.app')

@section('content')
    <!-- Main content -->
    <section class="content pt-3">
        <div class="row">
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-info elevation-1"><i class="fa fa-th"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">@lang('site.categories')</span>
                        <span class="info-box-number">{{$count['categories']}}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-danger elevation-1"><i class="fa fa-th-list"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">@lang('site.subcategories')</span>
                        <span class="info-box-number">{{$count['subcategories']}}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->

            <!-- fix for small devices only -->
            <div class="clearfix hidden-md-up"></div>

            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-ad"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">@lang('site.advertisements')</span>
                        <span class="info-box-number">{{$count['advertisements']}}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">@lang('site.users')</span>
                        <span class="info-box-number">{{$count['users']}}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
        </div>
        <div class="card">
            <div class="card-header ui-sortable-handle">
                <h3 class="card-title">
                    <i class="fas fa-chart-pie mr-1"></i>
                    @lang('site.ads_statistics')
                </h3>
            </div><!-- /.card-header -->
            <div class="card-body">
                <canvas id="myChart"  height="300"></canvas>
            </div><!-- /.card-body -->
        </div>

    </section>
    <!-- /.content -->
    @push('scripts')
        <script>
            var salesChartCanvas = document.getElementById('myChart').getContext('2d');
            //$('#revenue-chart').get(0).getContext('2d');

            var salesChartData = {
                labels  : [
                    @foreach($ads_data as $ad_data)
                    "{{$ad_data->year}}-{{$ad_data->month}}",
                    @endforeach
                ],
                datasets: [
                    {
                        label               : 'Digital Goods',
                        backgroundColor     : 'rgba(60,141,188,0.9)',
                        borderColor         : 'rgba(60,141,188,0.8)',
                        pointRadius          : false,
                        pointColor          : '#3b8bba',
                        pointStrokeColor    : 'rgba(60,141,188,1)',
                        pointHighlightFill  : '#fff',
                        pointHighlightStroke: 'rgba(60,141,188,1)',
                        fill: false,
                        data                : [
                            @foreach($ads_data as $ad_data)
                                "{{$ad_data->count}}",
                            @endforeach
                        ]
                    },
                ]
            }

            var salesChartOptions = {
                maintainAspectRatio : false,
                responsive : true,
                legend: {
                    display: false
                },
                scales: {
                    xAxes: [{
                        gridLines : {
                            display : false,
                        }
                    }],
                    yAxes: [{
                        gridLines : {
                            display : false,
                        }
                    }]
                }
            }

            // This will get the first returned node in the jQuery collection.
            // var salesChart = new Chart(salesChartCanvas, {
            //         type: 'line',
            //         data: salesChartData,
            //         options: salesChartOptions
            //     }
            // )
            var myLineChart = new Chart(document.getElementById('myChart'), {
                type: 'line',
                data: salesChartData,
                options: salesChartOptions
            });
        </script>
    @endpush
@endsection