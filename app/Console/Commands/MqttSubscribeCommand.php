<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpMqtt\Client\MqttClient;
use PhpMqtt\Client\ConnectionSettings;
use App\Models\SensorLog;
use Illuminate\Support\Facades\Log;

class MqttSubscribeCommand extends Command
{
    protected $signature = 'mqtt:subscribe';
    protected $description = 'Subscribe ke topik MQTT dari ESP32 dan simpan ke database';

    public function handle()
    {
        $server = '10.2.3.50';
        $port = 1883;
        $clientId = 'subscriber-local-' . uniqid();

        $mqtt = new MqttClient($server, $port, $clientId);

        $connectionSettings = (new ConnectionSettings())
            ->setKeepAliveInterval(60)
            ->setLastWillTopic('client/status')
            ->setLastWillMessage('Client disconnected')
            ->setLastWillQualityOfService(0);

        $mqtt->connect($connectionSettings, true);

        $this->info('✅ Terhubung ke Mosquitto Broker!');

        $topic = 'iot/x9d2ab/Plants/PlantsVirtu972i1';

        $mqtt->subscribe($topic, function (string $topic, string $message) {

            $this->info("📥 Topik: $topic | Pesan: $message");
            $data = json_decode($message, true);

            if (!is_array($data)) {
                $this->warn('⚠️ Payload bukan JSON yang valid');
                return;
            }

            SensorLog::create([
                'suhu'       => $data['suhu'] ?? null,
                'kelembapan' => $data['kelembapan'] ?? null,
                'moisture'   => $data['moisture'] ?? null,
            ]);

            $this->info('✅ Data berhasil disimpan ke database!');
        }, 0);

        $mqtt->loop(true);
    }
}