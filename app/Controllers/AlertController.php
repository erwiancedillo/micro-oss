<?php

namespace App\Controllers;

use App\Models\BarangayAlert;

class AlertController
{
    protected $alertModel;

    public function __construct()
    {
        $this->alertModel = new BarangayAlert();
    }

    public function index()
    {
        session_start();
        
        $barangayList = $this->alertModel->getBarangayNames();
        $barangay = $_GET['barangay'] ?? null;
        if ($barangay && !in_array($barangay, $barangayList)) {
            $barangay = null;
        }

        $barangayAlert = 0;
        $barangayAdvisory = "";
        $sitios = [];
        $polygonCoordsJS = '[]';
        $mapCenter = ['lat' => 7.028, 'lng' => 125.448]; // Default Toril
        $alertColors = [0 => 'Green', 1 => 'Yellow', 2 => 'Orange', 3 => 'Red'];
        $educationMsg = [
            0 => "SAFE: No flood threat. Continue monitoring official advisories.",
            1 => "ADVISORY: Flood risk rising. Prepare emergency kits and secure important documents.",
            2 => "WATCH: Possible flooding. Prepare for evacuation and monitor water levels.",
            3 => "WARNING: Flooding imminent or ongoing. Evacuate immediately to designated evacuation centers."
        ];
        $timestamp = date("F d, Y h:i A");

        $allAlerts = $this->alertModel->getAll();
        
        if ($barangay) {
            $data = $this->alertModel->getByName($barangay);
            if ($data) {
                $barangayAlert = (int)($data['alert_level'] ?? 0);
                $barangayAdvisory = $data['flood_advisory'] ?? "";
                
                if (!empty($data['latitude']) && !empty($data['longitude'])) {
                    $mapCenter = ['lat' => floatval($data['latitude']), 'lng' => floatval($data['longitude'])];
                }

                $polygonWKT = $data['polygon'] ?? '';
                if (preg_match('/\(\((.*)\)\)/', $polygonWKT, $matches)) {
                    $coords = explode(',', $matches[1]);
                    $polygonCoords = [];
                    foreach ($coords as $coord) {
                        $pair = preg_split('/\s+/', trim($coord));
                        if (count($pair) >= 2) {
                            $polygonCoords[] = ['lat' => floatval($pair[0]), 'lng' => floatval($pair[1])];
                        }
                    }
                    $polygonCoordsJS = json_encode($polygonCoords);
                }
            }
            $sitios = $this->alertModel->getSitioAlerts($barangay);
        }

        // Fetch current weather for flood monitoring connection
        $weather = null;
        $openWeatherKey = '40892b0c34bed7aea164a8845a3eaef6';
        try {
            $urlCurrent = "https://api.openweathermap.org/data/2.5/weather?lat=7.028&lon=125.448&units=metric&appid=" . $openWeatherKey;
            $response = @file_get_contents($urlCurrent);
            if ($response) {
                $data = json_decode($response, true);
                if (isset($data['main']['temp'])) {
                    $weather = [
                        'temp' => round($data['main']['temp']) . "°C",
                        'condition' => ucwords($data['weather'][0]['description']),
                        'icon' => $this->getOpenWeatherIcon($data['weather'][0]['icon'] ?? ''),
                        'rainfall' => isset($data['rain']['1h']) ? $data['rain']['1h'] . "mm" : "0mm"
                    ];
                }
            }
        } catch (\Exception $e) { }

        $title = 'Flood Alerts';
        ob_start();
        include __DIR__ . '/../Views/alert.php';
        $content = ob_get_clean();
        include __DIR__ . '/../Views/layout.php';
    }

    private function getOpenWeatherIcon($code)
    {
        $map = [
            '01d' => 'fas fa-sun',       '01n' => 'fas fa-moon',
            '02d' => 'fas fa-cloud-sun', '02n' => 'fas fa-cloud-moon',
            '03d' => 'fas fa-cloud',     '03n' => 'fas fa-cloud',
            '04d' => 'fas fa-cloud',     '04n' => 'fas fa-cloud',
            '09d' => 'fas fa-cloud-showers-heavy', '09n' => 'fas fa-cloud-showers-heavy',
            '10d' => 'fas fa-cloud-rain', '10n' => 'fas fa-cloud-rain',
            '11d' => 'fas fa-bolt',       '11n' => 'fas fa-bolt',
            '13d' => 'fas fa-snowflake',  '13n' => 'fas fa-snowflake',
            '50d' => 'fas fa-smog',       '50n' => 'fas fa-smog'
        ];
        $baseCode = substr($code, 0, 2);
        return $map[$code] ?? ($map[$baseCode . 'd'] ?? 'fas fa-cloud');
    }
}
