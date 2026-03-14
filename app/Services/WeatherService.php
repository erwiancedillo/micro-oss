<?php

namespace App\Services;

class WeatherService
{
    private $openMeteoUrl = 'https://api.open-meteo.com/v1/forecast';
    private $pagasaBaseUrl = 'https://tenday.pagasa.dost.gov.ph/api';
    private $fallbackApiKey = '40892b0c34bed7aea164a8845a3eaef6'; // OpenWeatherMap fallback
    
    /**
     * Get current weather and forecast using multiple sources
     * Priority: Open-Meteo -> PAGASA -> OpenWeatherMap
     */
    public function getWeatherData($lat = 7.028, $lng = 125.448)
    {
        // Try Open-Meteo first (free, no API key required)
        $openMeteoData = $this->getOpenMeteoData($lat, $lng);
        if ($openMeteoData) {
            return $openMeteoData;
        }
        
        // Try PAGASA second
        $pagasaData = $this->getPAGASAData($lat, $lng);
        if ($pagasaData) {
            return $pagasaData;
        }
        
        // Fallback to OpenWeatherMap if both fail
        return $this->getOpenWeatherFallback($lat, $lng);
    }
    
    /**
     * Fetch data from Open-Meteo API (free, no API key)
     */
    private function getOpenMeteoData($lat, $lng)
    {
        try {
            $url = $this->openMeteoUrl . '?latitude=' . $lat . '&longitude=' . $lng . 
                   '&daily=temperature_2m_max,temperature_2m_min,precipitation_sum,weathercode' .
                   '&timezone=Asia%2FManila&forecast_days=7';
            
            $context = stream_context_create([
                'http' => [
                    'timeout' => 10,
                    'user_agent' => 'Micro-OSS Flood Monitoring System'
                ]
            ]);
            
            $response = @file_get_contents($url, false, $context);
            
            if ($response) {
                $data = json_decode($response, true);
                
                if (isset($data['daily']) && !empty($data['daily']['time'])) {
                    return $this->formatOpenMeteoData($data);
                }
            }
        } catch (\Exception $e) {
            error_log("Open-Meteo API Error: " . $e->getMessage());
        }
        
        return null;
    }
    
    /**
     * Format Open-Meteo data for our system
     */
    private function formatOpenMeteoData($data)
    {
        $weather = [
            'temp' => '28°C',
            'condition' => 'Partly Cloudy',
            'rainfall' => '0mm',
            'icon' => 'fas fa-cloud-sun',
            'source' => 'Open-Meteo'
        ];
        
        $forecast = [];
        $dailyData = $data['daily'];
        
        for ($i = 0; $i < count($dailyData['time']) && $i < 7; $i++) {
            $date = $dailyData['time'][$i];
            $tempMax = round($dailyData['temperature_2m_max'][$i]) . '°';
            $tempMin = round($dailyData['temperature_2m_min'][$i]) . '°';
            $rainfall = ($dailyData['precipitation_sum'][$i] ?? 0) . 'mm';
            $weatherCode = $dailyData['weathercode'][$i] ?? 1;
            
            $dayData = [
                'day' => $i === 0 ? 'Today' : date('D', strtotime($date)),
                'date' => date('M d', strtotime($date)),
                'temp_max' => $tempMax,
                'temp_min' => $tempMin,
                'rain' => $rainfall,
                'icon' => $this->getOpenMeteoIcon($weatherCode),
                'text' => $this->getWeatherDescription($weatherCode)
            ];
            
            $forecast[] = $dayData;
            
            // Set current weather from today's data
            if ($i === 0) {
                $weather['temp'] = $tempMax;
                $weather['condition'] = $dayData['text'];
                $weather['rainfall'] = $rainfall;
                $weather['icon'] = $dayData['icon'];
            }
        }
        
        return [
            'weather' => $weather,
            'forecast' => $forecast,
            'source' => 'Open-Meteo'
        ];
    }
    
    /**
     * Convert Open-Meteo weather codes to FontAwesome icons
     * WMO Weather interpretation codes (https://open-meteo.com/docs/weatherdata-api/)
     */
    private function getOpenMeteoIcon($weatherCode)
    {
        $iconMap = [
            0 => 'fas fa-sun',           // Clear sky
            1 => 'fas fa-cloud-sun',     // Mainly clear
            2 => 'fas fa-cloud-sun',     // Partly cloudy
            3 => 'fas fa-cloud',         // Overcast
            45 => 'fas fa-smog',         // Fog
            48 => 'fas fa-smog',         // Fog
            51 => 'fas fa-cloud-rain',   // Drizzle light
            53 => 'fas fa-cloud-rain',   // Drizzle moderate
            55 => 'fas fa-cloud-rain',   // Drizzle dense
            56 => 'fas fa-cloud-rain',   // Drizzle light freezing
            57 => 'fas fa-cloud-rain',   // Drizzle dense freezing
            61 => 'fas fa-cloud-rain',   // Rain slight
            63 => 'fas fa-cloud-rain',   // Rain moderate
            65 => 'fas fa-cloud-showers-heavy', // Rain heavy
            66 => 'fas fa-cloud-rain',   // Rain light freezing
            67 => 'fas fa-cloud-showers-heavy', // Rain heavy freezing
            71 => 'fas fa-snowflake',    // Snow fall slight
            73 => 'fas fa-snowflake',    // Snow fall moderate
            75 => 'fas fa-snowflake',    // Snow fall heavy
            77 => 'fas fa-snowflake',    // Snow grains
            80 => 'fas fa-cloud-showers-heavy', // Rain showers slight
            81 => 'fas fa-cloud-showers-heavy', // Rain showers moderate
            82 => 'fas fa-cloud-showers-heavy', // Rain showers violent
            85 => 'fas fa-snowflake',    // Snow showers slight
            86 => 'fas fa-snowflake',    // Snow showers heavy
            95 => 'fas fa-bolt',         // Thunderstorm slight
            96 => 'fas fa-bolt',         // Thunderstorm moderate
            99 => 'fas fa-bolt'          // Thunderstorm violent
        ];
        
        return $iconMap[$weatherCode] ?? 'fas fa-cloud';
    }
    
    /**
     * Get weather description from Open-Meteo weather code
     */
    private function getWeatherDescription($weatherCode)
    {
        $descriptions = [
            0 => 'Clear',
            1 => 'Mainly Clear',
            2 => 'Partly Cloudy',
            3 => 'Overcast',
            45 => 'Fog',
            48 => 'Fog',
            51 => 'Light Drizzle',
            53 => 'Moderate Drizzle',
            55 => 'Heavy Drizzle',
            56 => 'Light Freezing Drizzle',
            57 => 'Heavy Freezing Drizzle',
            61 => 'Light Rain',
            63 => 'Moderate Rain',
            65 => 'Heavy Rain',
            66 => 'Light Freezing Rain',
            67 => 'Heavy Freezing Rain',
            71 => 'Light Snow',
            73 => 'Moderate Snow',
            75 => 'Heavy Snow',
            77 => 'Snow Grains',
            80 => 'Light Rain Showers',
            81 => 'Moderate Rain Showers',
            82 => 'Heavy Rain Showers',
            85 => 'Light Snow Showers',
            86 => 'Heavy Snow Showers',
            95 => 'Thunderstorm',
            96 => 'Thunderstorm',
            99 => 'Severe Thunderstorm'
        ];
        
        return $descriptions[$weatherCode] ?? 'Unknown';
    }
    
    /**
     * Fetch data from PAGASA 10-day forecast API
     */
    private function getPAGASAData($lat, $lng)
    {
        try {
            // PAGASA API endpoint for location-based forecast
            $url = $this->pagasaBaseUrl . '/forecast?lat=' . $lat . '&lng=' . $lng . '&days=7';
            
            $context = stream_context_create([
                'http' => [
                    'timeout' => 10,
                    'user_agent' => 'Micro-OSS Flood Monitoring System'
                ]
            ]);
            
            $response = @file_get_contents($url, false, $context);
            
            if ($response) {
                $data = json_decode($response, true);
                
                if (isset($data['forecast']) && !empty($data['forecast'])) {
                    return $this->formatPAGASAData($data);
                }
            }
        } catch (\Exception $e) {
            error_log("PAGASA API Error: " . $e->getMessage());
        }
        
        return null;
    }
    
    /**
     * Format PAGASA data for our system
     */
    private function formatPAGASAData($data)
    {
        $weather = [
            'temp' => '28°C',
            'condition' => 'Partly Cloudy',
            'rainfall' => '0mm',
            'icon' => 'fas fa-cloud-sun',
            'source' => 'PAGASA'
        ];
        
        $forecast = [];
        
        if (isset($data['forecast']) && is_array($data['forecast'])) {
            foreach ($data['forecast'] as $index => $day) {
                if ($index >= 7) break; // Limit to 7 days
                
                $forecast[] = [
                    'day' => $index === 0 ? 'Today' : date('D', strtotime('+' . $index . ' days')),
                    'date' => date('M d', strtotime('+' . $index . ' days')),
                    'temp_max' => $day['temp_max'] ?? '30°',
                    'temp_min' => $day['temp_min'] ?? '24°',
                    'rain' => ($day['rainfall'] ?? 0) . 'mm',
                    'icon' => $this->getPAGASAIcon($day['weather_condition'] ?? 'partly_cloudy'),
                    'text' => ucwords($day['weather_condition'] ?? 'Partly Cloudy')
                ];
            }
        }
        
        // Get current conditions from first day if available
        if (!empty($forecast)) {
            $weather['temp'] = $forecast[0]['temp_max'];
            $weather['condition'] = $forecast[0]['text'];
            $weather['rainfall'] = $forecast[0]['rain'];
            $weather['icon'] = $forecast[0]['icon'];
        }
        
        return [
            'weather' => $weather,
            'forecast' => $forecast,
            'source' => 'PAGASA'
        ];
    }
    
    /**
     * Convert PAGASA weather conditions to FontAwesome icons
     */
    private function getPAGASAIcon($condition)
    {
        $condition = strtolower($condition);
        
        $iconMap = [
            'sunny' => 'fas fa-sun',
            'clear' => 'fas fa-sun',
            'partly_cloudy' => 'fas fa-cloud-sun',
            'partly cloudy' => 'fas fa-cloud-sun',
            'cloudy' => 'fas fa-cloud',
            'overcast' => 'fas fa-cloud',
            'rainy' => 'fas fa-cloud-rain',
            'rain' => 'fas fa-cloud-rain',
            'showers' => 'fas fa-cloud-showers-heavy',
            'thunderstorm' => 'fas fa-bolt',
            'thunderstorms' => 'fas fa-bolt',
            'foggy' => 'fas fa-smog',
            'fog' => 'fas fa-smog',
            'hazy' => 'fas fa-smog'
        ];
        
        return $iconMap[$condition] ?? 'fas fa-cloud';
    }
    
    /**
     * Fallback to OpenWeatherMap API
     */
    private function getOpenWeatherFallback($lat, $lng)
    {
        try {
            // Current weather
            $urlCurrent = "https://api.openweathermap.org/data/2.5/weather?lat={$lat}&lon={$lng}&units=metric&appid={$this->fallbackApiKey}";
            $response = @file_get_contents($urlCurrent);
            
            $weather = [
                'temp' => '28°C',
                'condition' => 'Mostly Cloudy',
                'rainfall' => '0mm',
                'icon' => 'fas fa-cloud',
                'source' => 'OpenWeatherMap (Fallback)'
            ];
            
            if ($response) {
                $data = json_decode($response, true);
                if (isset($data['main']['temp'])) {
                    $weather['temp'] = round($data['main']['temp']) . "°C";
                    $weather['condition'] = ucwords($data['weather'][0]['description']);
                    $weather['icon'] = $this->getOpenWeatherIcon($data['weather'][0]['icon'] ?? '');
                    $weather['rainfall'] = isset($data['rain']['1h']) ? $data['rain']['1h'] . "mm" : "0mm";
                }
            }
            
            // 5-day forecast
            $urlForecast = "https://api.openweathermap.org/data/2.5/forecast?lat={$lat}&lon={$lng}&units=metric&appid={$this->fallbackApiKey}";
            $response = @file_get_contents($urlForecast);
            
            $forecast = [];
            if ($response) {
                $data = json_decode($response, true);
                if (isset($data['list'])) {
                    $dailyData = [];
                    foreach ($data['list'] as $item) {
                        $date = date('Y-m-d', $item['dt']);
                        if (!isset($dailyData[$date])) {
                            $dailyData[$date] = [
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
            
            // Fallback data if API fails
            if (empty($forecast)) {
                for($i = 0; $i < 7; $i++) {
                    $forecast[] = [
                        'day' => date('D', strtotime("+$i days")), 
                        'date' => date('M d', strtotime("+$i days")), 
                        'temp_max' => '31°', 
                        'temp_min' => '24°', 
                        'icon' => 'fas fa-cloud-sun', 
                        'rain' => '0mm', 
                        'text' => 'Partly Cloudy'
                    ];
                }
            }
            
            return [
                'weather' => $weather,
                'forecast' => $forecast,
                'source' => 'OpenWeatherMap (Fallback)'
            ];
            
        } catch (\Exception $e) {
            error_log("OpenWeatherMap fallback error: " . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Convert OpenWeatherMap icon codes to FontAwesome
     */
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
