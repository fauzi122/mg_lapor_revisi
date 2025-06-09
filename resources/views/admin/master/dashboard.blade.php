@extends('layouts.blackand.app')

@section('content')

<div id="kt_app_toolbar" class="app-toolbar py-4 py-lg-8">
    <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack flex-wrap">
        <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
            <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                <h3 class="text-dark fw-bold">Dashboard</h3>
            </div>
            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0">
                    <li class="breadcrumb-item text-muted">Dashboard</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div id="kt_app_content" class="app-content flex-column-fluid mt-n13">
    <div id="kt_app_content_container" class="app-container container-xxl">
        <div class="card-body p-3">
            <div class="card mb-5 mb-xl-8 shadow">
                <form action="{{ url('/master') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row justify-content-center mb-2 mt-4">
                        <div class="col-3">
                            <input type="month" class="form-control" id="period" name="period"
                                value="{{ old('period', request('period', \Carbon\Carbon::now()->format('Y-m'))) }}">
                        </div>
                        <div class="col-2">
                            <button type="submit" class="btn btn-primary waves-effect waves-light">Filter Periode</button>
                        </div>
                    </div>
                </form>
                <div class="row">
                    <div class="col-xl col-md">
                        <!-- card -->
                        <div class="card card-h-100">
                            <!-- card body -->
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div id="mainChart"></div>
                                </div>
                            </div><!-- end card body -->
                        </div><!-- end card -->
                    </div><!-- end col -->
                </div>
            </div>
        </div>
    </div>
</div>


    <script type="text/javascript">
        var period = <?php echo json_encode($period); ?>,
            date = <?php echo json_encode($date); ?>,
            countMB = <?php echo json_encode($countMB); ?>,
            countGAS = <?php echo json_encode($countGAS); ?>;

        // Function to generate the link based on category and series
        function getCategoryLink(series, category) {
            // Laravel route with parameters
            return '{{ route('chart.detail', ['series' => '__series__', 'category' => '__category__', 'date' => '__date__']) }}'
                .replace('__series__', encodeURIComponent(series))
                .replace('__category__', encodeURIComponent(category))
                .replace('__date__', encodeURIComponent(date));
        }

        Highcharts.chart('mainChart', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Grafik Pelaporan Minyak Bumi & Gas Periode: ' + period + ' (Berdasarkan Jenis Izin Usaha)',
                align: 'center'
            },
            xAxis: {
                categories: ['Niaga', 'Pengolahan', 'Pengangkutan', 'Penyimpanan'],
                crosshair: true,
                accessibility: {
                    description: 'Jenis Izin Usaha'
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Jumlah Laporan'
                }
            },
            tooltip: {
                valueSuffix: ' (Total Laporan)'
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 1
                }
            },
            series: [{
                    name: 'Minyak Bumi',
                    data: countMB,
                    // Add click event to navigate to a new page for Minyak Bumi with category
                    events: {
                        click: function(event) {
                            var category = event.point.category;
                            // Redirect to the page with series and category as query parameters
                            window.open(getCategoryLink('Minyak Bumi', category), '_blank');
                        }
                    }
                },
                {
                    name: 'Gas',
                    data: countGAS,
                    events: {
                        click: function(event) {
                            var category = event.point.category;
                            // Redirect to the page with series and category as query parameters
                            window.open(getCategoryLink('Gas', category), '_blank');
                        }
                    }
                }
            ]
        });
    </script>
@endsection
