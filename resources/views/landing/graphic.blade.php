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

<script>
    
    var ctx = document.getElementById("myChart1").getContext('2d');
    var myChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
        datasets: [{
        data: [
            80,
            50,
            40,
            30,
            20,
        ],
        backgroundColor: [
            '#191d21',
            '#63ed7a',
            '#ffa426',
            '#fc544b',
            '#6777ef',
        ],
        label: 'Dataset 1'
        }],
        labels: [
        'Black',
        'Green',
        'Yellow',
        'Red',
        'Blue'
        ],
    },
    options: {
        responsive: true,
        legend: {
        position: 'bottom',
        },
    }
    });

    var ctx = document.getElementById("myChart2").getContext('2d');
    var myChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
        datasets: [{
        data: [
            80,
            50,
            40,
            30,
            20,
        ],
        backgroundColor: [
            '#191d21',
            '#63ed7a',
            '#ffa426',
            '#fc544b',
            '#6777ef',
        ],
        label: 'Dataset 1'
        }],
        labels: [
        'Black',
        'Green',
        'Yellow',
        'Red',
        'Blue'
        ],
    },
    options: {
        responsive: true,
        legend: {
        position: 'bottom',
        },
    }
    });
</script>
@endpush