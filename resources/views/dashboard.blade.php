@extends('layouts.user_type.auth')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cog"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Hospitals</span>
                        <span class="info-box-number">
                            {{ $total_hospitals }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-thumbs-up"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Doctors</span>
                        <span class="info-box-number">{{ $total_doctors }}</span>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Open Queries</span>
                        <span class="info-box-number">{{ $open_queries }}</span>
                    </div>

                </div>

            </div>

            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Confirmed Queries</span>
                        <span class="info-box-number">{{ $confirmed_queries }}</span>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">New Members</span>
                        <span class="info-box-number">{{ $new_users }}</span>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Teleconsultations</span>
                        <span class="info-box-number">{{ $teleconsultation }}</span>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Active Teleconsultations</span>
                        <span class="info-box-number">{{ $active_teleconsultation }}</span>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Specializations</span>
                        <span class="info-box-number">{{ $specializations }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header border-0">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title">Users</h3>
                            <a href="javascript:void(0);">View Report</a>
                        </div>
                    </div>
                    <div class="card-body">
                        {!! $user_chart->renderHtml() !!}
                    </div>
                </div>

                <div class="card">
                    <div class="card-header border-0">
                        <h3 class="card-title">Queries By Language</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="query_language" style="width:100%;max-width:700px"></canvas>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header border-0">
                        <h3 class="card-title">Queries</h3>
                        <div class="card-tools">
                            <a href="#" class="btn btn-tool btn-sm">
                                <i class="fas fa-download"></i>
                            </a>
                            <a href="#" class="btn btn-tool btn-sm">
                                <i class="fas fa-bars"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-striped table-valign-middle">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>On Step</th>
                                    <th>Open</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($last_queries as $item)
                                <tr>
                                    <td>
                                        {{ $item->query_hash }}@if($item->current_step == 1)<span class="badge bg-danger">NEW</span>@endif
                                    </td>
                                    <td>{{ $item->query_type }}</td>
                                    <td>
                                        {{ $item->current_step }}
                                    </td>
                                    <td>
                                        <a href="{{ route('query.show', ['query' => $item->id]) }}" class="btn btn-info btn-sm"><i
                                            class="fa fa-edit"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header border-0">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title">Queries By Country</h3>
                            <a href="javascript:void(0);">View Report</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="query_country" style="width:100%;max-width:700px"></canvas>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header border-0">
                        <h3 class="card-title">Queries By City</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="query_city" style="width:100%;max-width:700px"></canvas>
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection
@push('scripts')
    <script>
        {!! $user_chart->renderChartJsLibrary() !!}
        {!! $user_chart->renderJs() !!}
    </script>
    <script>
        const chartStringData = '{!! $chart_data !!}';
        const chartData = JSON.parse(chartStringData);
        console.log(Object.keys(chartData.countryQueryCount));

        const myChart = new Chart("query_country", {
            type: "line",
            data: {
                labels: Object.keys(chartData.countryQueryCount),
                datasets: [{
                    label: 'Queries by Country',
                    data: Object.values(chartData.countryQueryCount),
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Queries by Country'
                    }
                }
            },
        });
        const queryCityChart = new Chart("query_city", {
            type: "line",
            data: {
                labels: Object.keys(chartData.cityQueryCount),
                datasets: [{
                    label: 'Queries by City',
                    data: Object.values(chartData.cityQueryCount),
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Queries by Country'
                    }
                }
            },
        });
        const queryLanguageChart = new Chart("query_language", {
            type: "line",
            data: {
                labels: Object.keys(chartData.languageQueryCount),
                datasets: [{
                    label: 'Queries by Language',
                    data: Object.values(chartData.languageQueryCount),
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Queries by Language'
                    }
                }
            },
        });
        // window.onload = function() {
        //     var ctx = document.getElementById("chart-bars").getContext("2d");

        //     new Chart(ctx, {
        //         type: "bar",
        //         data: {
        //             labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        //             datasets: [{
        //                 label: "Sales",
        //                 tension: 0.4,
        //                 borderWidth: 0,
        //                 borderRadius: 4,
        //                 borderSkipped: false,
        //                 backgroundColor: "#fff",
        //                 data: [450, 200, 100, 220, 500, 100, 400, 230, 500],
        //                 maxBarThickness: 6
        //             }, ],
        //         },
        //         options: {
        //             responsive: true,
        //             maintainAspectRatio: false,
        //             plugins: {
        //                 legend: {
        //                     display: false,
        //                 }
        //             },
        //             interaction: {
        //                 intersect: false,
        //                 mode: 'index',
        //             },
        //             scales: {
        //                 y: {
        //                     grid: {
        //                         drawBorder: false,
        //                         display: false,
        //                         drawOnChartArea: false,
        //                         drawTicks: false,
        //                     },
        //                     ticks: {
        //                         suggestedMin: 0,
        //                         suggestedMax: 500,
        //                         beginAtZero: true,
        //                         padding: 15,
        //                         font: {
        //                             size: 14,
        //                             family: "Open Sans",
        //                             style: 'normal',
        //                             lineHeight: 2
        //                         },
        //                         color: "#fff"
        //                     },
        //                 },
        //                 x: {
        //                     grid: {
        //                         drawBorder: false,
        //                         display: false,
        //                         drawOnChartArea: false,
        //                         drawTicks: false
        //                     },
        //                     ticks: {
        //                         display: false
        //                     },
        //                 },
        //             },
        //         },
        //     });


        //     var ctx2 = document.getElementById("chart-line").getContext("2d");

        //     var gradientStroke1 = ctx2.createLinearGradient(0, 230, 0, 50);

        //     gradientStroke1.addColorStop(1, 'rgba(203,12,159,0.2)');
        //     gradientStroke1.addColorStop(0.2, 'rgba(72,72,176,0.0)');
        //     gradientStroke1.addColorStop(0, 'rgba(203,12,159,0)'); //purple colors

        //     var gradientStroke2 = ctx2.createLinearGradient(0, 230, 0, 50);

        //     gradientStroke2.addColorStop(1, 'rgba(20,23,39,0.2)');
        //     gradientStroke2.addColorStop(0.2, 'rgba(72,72,176,0.0)');
        //     gradientStroke2.addColorStop(0, 'rgba(20,23,39,0)'); //purple colors

        //     new Chart(ctx2, {
        //         type: "line",
        //         data: {
        //             labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        //             datasets: [{
        //                     label: "Mobile apps",
        //                     tension: 0.4,
        //                     borderWidth: 0,
        //                     pointRadius: 0,
        //                     borderColor: "#cb0c9f",
        //                     borderWidth: 3,
        //                     backgroundColor: gradientStroke1,
        //                     fill: true,
        //                     data: [50, 40, 300, 220, 500, 250, 400, 230, 500],
        //                     maxBarThickness: 6

        //                 },
        //                 {
        //                     label: "Websites",
        //                     tension: 0.4,
        //                     borderWidth: 0,
        //                     pointRadius: 0,
        //                     borderColor: "#3A416F",
        //                     borderWidth: 3,
        //                     backgroundColor: gradientStroke2,
        //                     fill: true,
        //                     data: [30, 90, 40, 140, 290, 290, 340, 230, 400],
        //                     maxBarThickness: 6
        //                 },
        //             ],
        //         },
        //         options: {
        //             responsive: true,
        //             maintainAspectRatio: false,
        //             plugins: {
        //                 legend: {
        //                     display: false,
        //                 }
        //             },
        //             interaction: {
        //                 intersect: false,
        //                 mode: 'index',
        //             },
        //             scales: {
        //                 y: {
        //                     grid: {
        //                         drawBorder: false,
        //                         display: true,
        //                         drawOnChartArea: true,
        //                         drawTicks: false,
        //                         borderDash: [5, 5]
        //                     },
        //                     ticks: {
        //                         display: true,
        //                         padding: 10,
        //                         color: '#b2b9bf',
        //                         font: {
        //                             size: 11,
        //                             family: "Open Sans",
        //                             style: 'normal',
        //                             lineHeight: 2
        //                         },
        //                     }
        //                 },
        //                 x: {
        //                     grid: {
        //                         drawBorder: false,
        //                         display: false,
        //                         drawOnChartArea: false,
        //                         drawTicks: false,
        //                         borderDash: [5, 5]
        //                     },
        //                     ticks: {
        //                         display: true,
        //                         color: '#b2b9bf',
        //                         padding: 20,
        //                         font: {
        //                             size: 11,
        //                             family: "Open Sans",
        //                             style: 'normal',
        //                             lineHeight: 2
        //                         },
        //                     }
        //                 },
        //             },
        //         },
        //     });
        // }
    </script>
@endpush
