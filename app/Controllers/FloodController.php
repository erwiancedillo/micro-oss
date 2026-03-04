<?php

namespace App\Controllers;

use App\Models\FloodZone;
use App\Models\BarangayAlert;

class FloodController
{
    private $floodModel;
    private $alertModel;

    public function __construct()
    {
        $this->floodModel = new FloodZone();
        $this->alertModel = new BarangayAlert();
    }

    public function index()
    {
        $zones = $this->floodModel->getAllZones();
        
        // Fetch Real-time Weather Data for Toril, Davao (Lat: 7.028, Lng: 125.448)
        $weather = [
            'temp' => '28°C', // Fallback
            'condition' => 'Mostly Cloudy',
            'rainfall' => '0mm',
            'icon' => 'fas fa-cloud'
        ];

        $forecast = [];
        $openWeatherKey = '40892b0c34bed7aea164a8845a3eaef6';

        try {
            // OpenWeather API call (Current Conditions)
            $urlCurrent = "https://api.openweathermap.org/data/2.5/weather?lat=7.028&lon=125.448&units=metric&appid=" . $openWeatherKey;
            $response = @file_get_contents($urlCurrent);
            if ($response) {
                $data = json_decode($response, true);
                if (isset($data['main']['temp'])) {
                    $weather['temp'] = round($data['main']['temp']) . "°C";
                    $weather['condition'] = ucwords($data['weather'][0]['description']);
                    $weather['icon'] = $this->getOpenWeatherIcon($data['weather'][0]['icon'] ?? '');
                    
                    // Specific rainfall depth if provided
                    if (isset($data['rain']['1h'])) {
                        $weather['rainfall'] = $data['rain']['1h'] . "mm";
                    } else {
                        $weather['rainfall'] = "0mm";
                    }
                }
            }
        } catch (\Exception $e) { }
        
        // OpenWeather API call (5-Day / 3-Hour Forecast grouped by day)
        try {
            $urlForecast = "https://api.openweathermap.org/data/2.5/forecast?lat=7.028&lon=125.448&units=metric&appid=" . $openWeatherKey;
            $response = @file_get_contents($urlForecast);
            if ($response) {
                $data = json_decode($response, true);
                if (isset($data['list'])) {
                    $dailyData = [];
                    foreach ($data['list'] as $item) {
                        $date = date('Y-m-d', $item['dt']);
                        if (!isset($dailyData[$date])) {
                            $dailyData[$date] = [
                                'dt' => $item['dt'],
                                'temp_max' => $item['main']['temp_max'],
                                'temp_min' => $item['main']['temp_min'],
                                'rain' => isset($item['rain']['3h']) ? $item['rain']['3h'] : 0,
                                'icon' => $item['weather'][0]['icon'],
                                'text' => ucwords($item['weather'][0]['description'])
                            ];
                        } else {
                            if ($item['main']['temp_max'] > $dailyData[$date]['temp_max']) {
                                $dailyData[$date]['temp_max'] = $item['main']['temp_max'];
                            }
                            if ($item['main']['temp_min'] < $dailyData[$date]['temp_min']) {
                                $dailyData[$date]['temp_min'] = $item['main']['temp_min'];
                            }
                            if (isset($item['rain']['3h'])) {
                                $dailyData[$date]['rain'] += $item['rain']['3h'];
                            }
                            // Update icon to represent the mid-day condition rather than midnight
                            if (strpos($item['dt_txt'], '12:00:00') !== false) {
                                $dailyData[$date]['icon'] = $item['weather'][0]['icon'];
                                $dailyData[$date]['text'] = ucwords($item['weather'][0]['description']);
                            }
                        }
                    }
                    
                    $i = 0;
                    foreach ($dailyData as $date => $dayTime) {
                        if ($i >= 7) break;
                        $timestamp = strtotime($date);
                        $forecast[] = [
                            'day' => ($i === 0) ? 'Today' : date('D', $timestamp),
                            'date' => date('M d', $timestamp),
                            'temp_max' => round($dayTime['temp_max']) . "°",
                            'temp_min' => round($dayTime['temp_min']) . "°",
                            'rain' => round($dayTime['rain'], 1) . "mm",
                            'icon' => $this->getOpenWeatherIcon($dayTime['icon']),
                            'text' => $dayTime['text']
                        ];
                        $i++;
                    }
                }
            }
        } catch (\Exception $e) { }

        // Final fallbacks (if OpenWeather failed)
        if (empty($forecast)) {
            for($i=0; $i<7; $i++) {
                $forecast[] = ['day' => date('D', strtotime("+$i days")), 'date' => date('M d', strtotime("+$i days")), 'temp_max' => '31°', 'temp_min' => '24°', 'icon' => 'fas fa-cloud-sun', 'rain' => '0mm', 'text' => 'Partly Cloudy'];
            }
        }
        
        // Pad 5-day forecast to 7 days if UI expects exactly 7 days
        if (count($forecast) > 0 && count($forecast) < 7) {
            $lastFormatDate = date('Y-m-d', strtotime($forecast[count($forecast)-1]['date']));
            while (count($forecast) < 7) {
                $lastFormatDate = date('Y-m-d', strtotime('+1 day', strtotime($lastFormatDate)));
                $forecast[] = [
                    'day' => date('D', strtotime($lastFormatDate)),
                    'date' => date('M d', strtotime($lastFormatDate)),
                    'temp_max' => '30°',
                    'temp_min' => '24°',
                    'rain' => '0mm',
                    'icon' => 'fas fa-cloud',
                    'text' => 'Cloudy (Est.)'
                ];
            }
        }

        // Mock sensor data for the dashboard
        $sensors = [
            ['name' => 'Davao River - Toril Section', 'level' => '1.2m', 'status' => 'Normal', 'trend' => 'Stable'],
            ['name' => 'Lipadas River Bridge', 'level' => '2.5m', 'status' => 'Warning', 'trend' => 'Rising'],
            ['name' => 'Talomo Creek', 'level' => '0.8m', 'status' => 'Normal', 'trend' => 'Falling']
        ];

        // Fetch barangay alerts for the map overlay
        $alertColors = [0 => 'Green', 1 => 'Yellow', 2 => 'Orange', 3 => 'Red'];
        $barangayAlerts = [];
        $alertSummary = ['Green' => 0, 'Yellow' => 0, 'Orange' => 0, 'Red' => 0];
        try {
            $alertsRaw = $this->alertModel->getAllAlerts();
            foreach ($alertsRaw as $a) {
                $level = (int)($a['alert_level'] ?? 0);
                $colorName = $alertColors[$level] ?? 'Green';
                $barangayAlerts[] = [
                    'name'     => $a['name'],
                    'level'    => $level,
                    'color'    => $colorName,
                    'advisory' => $a['flood_advisory'] ?? '',
                    'lat'      => (float)$a['center_lat'],
                    'lng'      => (float)$a['center_lng']
                ];
                $alertSummary[$colorName]++;
            }
        } catch (\Exception $e) { }

        $title = 'Flood Monitoring Dashboard';
        
        // Using output buffering to fit into the layout
        ob_start();
        include __DIR__ . '/../Views/flood_monitoring.php';
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
