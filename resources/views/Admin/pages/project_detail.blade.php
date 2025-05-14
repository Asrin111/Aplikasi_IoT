@extends('admin.layouts.base')
@section('title', 'Project Detail')
@section('content')

<h1 class="h3 mb-4 text-gray-800">Project Detail - Device: {{ $device->device_id }}</h1>

<div class="row">
    <div class="col-md-4">
        <div class="card border-left-primary shadow mb-4">
            <div class="card-body">
                <p class="mb-1"><strong>Status</strong></p>
                <h5 id="device-status" class="text-danger">Offline</h5>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-success shadow mb-4 text-center">
            <div class="card-body">
                <h5 class="card-title">Suhu</h5>
                <h1 id="suhu" style="font-size: 3rem;">0°C</h1>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-success shadow mb-4 text-center">
            <div class="card-body">
                <h5 class="card-title">Kelembapan</h5>
                <h1 id="kelembapan" style="font-size: 3rem;">0%</h1>
            </div>
        </div>
    </div>
</div>

<!-- GRAFIK -->
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h5 class="m-0 font-weight-bold text-primary">Grafik Data Sensor</h5>
            </div>
            <div class="card-body">
                <canvas id="sensorChart" style="height: 400px; width: 100%;"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- TABEL -->
<div class="card shadow mb-4 mt-4">
    <div class="card-header py-3">
        <h5 class="m-0 font-weight-bold text-primary">Riwayat Data Sensor</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Suhu (°C)</th>
                        <th>Kelembapan (%)</th>
                        <th>Kadar Air Tanah (%)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>2025-05-15 12:00:00</td>
                        <td>27.5</td>
                        <td>65.3</td>
                        <td>30.4</td>
                    </tr>
                    <tr>
                        <td>2025-05-15 13:00:00</td>
                        <td>28.2</td>
                        <td>63.1</td>
                        <td>32.1</td>
                    </tr>
                    <!-- Add more rows as needed -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Placeholder data for chart (static data)
    const labels = ['2025-05-15 12:00:00', '2025-05-15 13:00:00'];
    const suhuData = [27.5, 28.2];
    const kelembapanData = [65.3, 63.1];
    const moistureData = [30.4, 32.1];

    // Configuring Chart.js chart
    const ctx = document.getElementById('sensorChart').getContext('2d');

    const sensorChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                    label: 'Suhu (°C)',
                    data: suhuData,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    fill: false,
                    tension: 0.1
                },
                {
                    label: 'Kelembapan (%)',
                    data: kelembapanData,
                    borderColor: 'rgba(153, 102, 255, 1)',
                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                    fill: false,
                    tension: 0.1
                },
                {
                    label: 'Kadar Air Tanah (%)',
                    data: moistureData,
                    borderColor: 'rgba(255, 159, 64, 1)',
                    backgroundColor: 'rgba(255, 159, 64, 0.2)',
                    fill: false,
                    tension: 0.1
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Waktu'
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Nilai'
                    },
                    min: 0
                }
            }
        }
    });
});
</script>

@endsection