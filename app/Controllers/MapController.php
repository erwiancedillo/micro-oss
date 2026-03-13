<?php

namespace App\Controllers;

use App\Models\BarangayPolygon;
use App\Models\EvacuationCenter;
use App\Models\FloodZone;

class MapController
{
    protected $polygonModel;

    public function __construct()
    {
        $this->polygonModel = new BarangayPolygon();
    }

    public function communityMap()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /micro-oss/index.php?route=login');
            exit();
        }

        $barangay = $_GET['barangay'] ?? 'Lizada';
        $result = $this->polygonModel->getByName($barangay);

        $markers = [];
        $polygonCoordsJS = '[]';
        $mapCenter = ['lat' => 6.996, 'lng' => 125.493];
        $notFound = false;

        if ($result) {
            $mapCenter = ['lat' => floatval($result['latitude'] ?? 0), 'lng' => floatval($result['longitude'] ?? 0)];
            $polygonWKT = $result['polygon'];

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

            $markers = $this->polygonModel->getSitiosInPolygon($polygonWKT);
        } else {
            $notFound = true;
        }

        $evacModel = new EvacuationCenter();
        $evacuationCenters = $evacModel->getAll();

        $floodModel = new FloodZone();
        $floodZones = $floodModel->getAllZones();

        $title = 'Community Map';
        ob_start();
        include __DIR__ . '/../Views/community_maps.php';
        $content = ob_get_clean();
        include __DIR__ . '/../Views/layout.php';
    }
}
