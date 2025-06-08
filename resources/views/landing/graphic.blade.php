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

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/modules-chartjs.js') }}"></script>

    {{-- js untuk pie chart --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Chart untuk Data Pekerjaan Alumni (myChart1)
            fetch("{{ route('chart.topProfesi') }}")
                .then(response => response.json())
                .then(data => {
                    const labels = data.map(item => item.profesi);
                    const values = data.map(item => item.jumlah);

                    const backgroundColors = [
                        '#FFD5E5', '#AD88C6', '#B4E4FF', '#A5D6A7', '#F7B5CA',
                        '#F5E8C7', '#EEC759', '#AB886D', '#CD5656', '#B0DB9C',
                        '#B4E4FF'
                    ];

                    var ctx = document.getElementById("myChart1").getContext('2d');
                    var myChart = new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Jumlah Lulusan',
                                data: values,
                                backgroundColor: backgroundColors.slice(0, labels.length),
                            }]
                        },
                        options: {
                            responsive: true,
                            legend: {
                                position: 'bottom'
                            }
                        }
                    });
                })
                .catch(error => {
                    console.error('Gagal mengambil data chart untuk profesi:', error);
                });

            // Chart untuk Data Jenis Instansi (myChart2)
            fetch("{{ route('chart.jenisInstansi') }}")
                .then(response => response.json())
                .then(data => {
                    const labels = data.map(item => item.instansi_nama);
                    const values = data.map(item => item.jumlah);

                    const backgroundColors = [
                        '#FF8A80', // Perguruan Tinggi
                        '#FFD180', // Instansi Pemerintah
                        '#A5D6A7', // Perusahaan Swasta
                        '#B39DDB' // BUMN
                    ];

                    var ctx = document.getElementById("myChart2").getContext('2d');
                    var myChart = new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Jenis Instansi',
                                data: values,
                                backgroundColor: backgroundColors.slice(0, labels.length),
                            }]
                        },
                        options: {
                            responsive: true,
                            legend: {
                                position: 'bottom'
                            }
                        }
                    });
                })
                .catch(error => {
                    console.error('Gagal mengambil data chart untuk Jenis Instansi:', error);
                });
        });
</script>
@endpush