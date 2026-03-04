<?php

namespace App\Controllers;

use App\Models\HazardMap;

class HazardController
{
    private $hazardModel;

    public function __construct()
    {
        $this->hazardModel = new HazardMap();
    }

    public function index()
    {
        $maps = $this->hazardModel->getAllHazardMaps();
        
        // Format maps for JSON if needed by JS, or pass to view
        $formattedMaps = [];
        foreach ($maps as $map) {
            $formattedMaps[] = [
                'id' => $map['id'],
                'name' => $map['name'],
                'image_url' => $map['image_url'],
                'description' => $map['description']
            ];
        }

        include __DIR__ . '/../Views/hazard.php';
    }
}
