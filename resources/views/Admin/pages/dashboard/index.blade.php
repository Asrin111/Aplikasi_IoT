@extends('admin.layouts.base')
@section('title', 'Project Detail')
@section('content')

<h1 class="h3 mb-4 text-gray-800 text-center">Monitoring PlantsVirtu972i1</h1>

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
                <h1 id="suhu" style="font-size: 3rem;">-</h1>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-success shadow mb-4 text-center">
            <div class="card-body">
                <h5 class="card-title">Kelembapan</h5>
                <h1 id="kelembapan" style="font-size: 3rem;">-</h1>
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
                    @forelse($logs as $log)
                    <tr>
                        <td>{{ $log->logged_at }}</td>
                        <td>{{ number_format($log->suhu, 1) }}</td>
                        <td>{{ number_format($log->kelembapan, 1) }}</td>
                        <td>{{ number_format($log->moisture, 1) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center">Belum ada data sensor</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://unpkg.com/mqtt/dist/mqtt.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const labels = [];
    const suhuData = [];
    const kelembapanData = [];
    const moistureData = [];

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
                    fill: false
                },
                {
                    label: 'Kelembapan (%)',
                    data: kelembapanData,
                    borderColor: 'rgba(153, 102, 255, 1)',
                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                    fill: false
                },
                {
                    label: 'Kadar Air Tanah (%)',
                    data: moistureData,
                    borderColor: 'rgba(255, 159, 64, 1)',
                    backgroundColor: 'rgba(255, 159, 64, 0.2)',
                    fill: false
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

    const client = mqtt.connect('ws://10.2.3.50:9001');
    const statusEl = document.getElementById('device-status');

    client.on('connect', () => {
        console.log('Connected to MQTT');
        client.subscribe('iot/x9d2ab/status/Plants/PlantsVirtu972i1');
        client.subscribe('iot/x9d2ab/Plants/PlantsVirtu972i1');
    });

    client.on('message', (topic, message) => {
        const payload = message.toString();
        console.log("Topic:", topic, "Payload:", payload);

        if (topic === 'iot/x9d2ab/status/Plants/PlantsVirtu972i1') {
            const isOnline = payload.trim().toLowerCase() === 'online';
            statusEl.textContent = isOnline ? 'Online' : 'Offline';
            statusEl.classList.toggle('text-success', isOnline);
            statusEl.classList.toggle('text-danger', !isOnline);
            return;
        }

        if (topic === 'iot/x9d2ab/Plants/PlantsVirtu972i1') {
            try {
                const data = JSON.parse(payload);
                const suhu = parseFloat(data.suhu);
                const kelembapan = parseFloat(data.kelembapan);
                const moisture = parseFloat(data.moisture);
                const timestamp = new Date().toLocaleTimeString();

                document.getElementById('suhu').textContent = suhu.toFixed(1) + '°C';
                document.getElementById('kelembapan').textContent = kelembapan.toFixed(1) + '%';

                // Update grafik
                labels.push(timestamp);
                suhuData.push(suhu);
                kelembapanData.push(kelembapan);
                moistureData.push(moisture);

                if (labels.length > 10) {
                    labels.shift();
                    suhuData.shift();
                    kelembapanData.shift();
                    moistureData.shift();
                }

                sensorChart.update();
            } catch (e) {
                console.error('Parsing JSON gagal:', e);
            }
        }
    });

    client.on('error', (err) => {
        console.error('MQTT Error:', err);
        statusEl.textContent = 'Offline';
        statusEl.classList.remove('text-success');
        statusEl.classList.add('text-danger');
    });

    client.on('close', () => {
        console.warn('MQTT connection closed');
        statusEl.textContent = 'Offline';
        statusEl.classList.remove('text-success');
        statusEl.classList.add('text-danger');
    });
});
</script>

@endsection