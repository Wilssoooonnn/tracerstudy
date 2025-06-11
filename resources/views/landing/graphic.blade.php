<div class="container section-title" data-aos="fade-up">
    <h2>GRAPHIC</h2>
    <p>GRAPHIC SEBARAN LULUSAN</p>

    <div class="row">
        <div class="col-12 col-md-6 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4>Data Pekerjaan Alumni</h4>
                </div>
                <div class="card-body">
                    <canvas id="myChart1"></canvas>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4>Data Jenis Instansi</h4>
                </div>
                <div class="card-body">
                    <canvas id="myChart2"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')

    <!-- JS Libraies -->
    <script src="{{ asset('library/chart.js/dist/Chart.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@1.0.0"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/modules-chartjs.js') }}"></script>

    {{-- js untuk pie chart --}}
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            fetch("{{ route('chart.topProfesi') }}")
            .then(response => response.json())
            .then(data => {
                const labels = data.map(item => item.profesi);
                const values = data.map(item => item.jumlah);

                const ctx = document.getElementById("myChart1").getContext('2d');
                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: labels,
                        datasets: [{
                            data: values,
                            backgroundColor: ['#FFD5E5', '#AD88C6', '#B4E4FF', '#A5D6A7', '#F7B5CA'],
                        }]
                    },
                    options: {
                        plugins: {
                            legend: {
                                position: 'bottom'
                            },
                            datalabels: {
                                formatter: (value, context) => {
                                    const total = context.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                                    return ((value / total) * 100).toFixed(1) + '%';
                                },
                                color: '#fff',
                                font: {
                                    weight: 'bold',
                                    size: 14
                                }
                            }
                        }
                    },
                    plugins: [ChartDataLabels]
                });
            });

            // Chart untuk Data Jenis Instansi (myChart2)
                fetch("{{ route('chart.jenisInstansi') }}")
                    .then(response => response.json())
                    .then(data => {
                        const labels = data.map(item => item.instansi_nama);
                        const values = data.map(item => item.jumlah);
                        const ctx = document.getElementById("myChart2").getContext('2d');
                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: labels,
                        datasets: [{
                            data: values,
                            backgroundColor: ['#FF8A80', '#FFD180', '#A5D6A7', '#B39DDB'],
                        }]
                    },
                    options: {
                        plugins: {
                            legend: {
                                position: 'bottom',
                            },
                            datalabels: {
                                formatter: (value, context) => {
                                    const total = context.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                                    return ((value / total) * 100).toFixed(1) + '%';
                                },
                                color: '#fff',
                                font: {
                                    weight: 'bold',
                                    size: 14
                                }
                            }
                        }
                    },
                    plugins: [ChartDataLabels]
                });
            });
        });
</script>
@endpush