<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Controllers\AuthController;
use App\Controllers\EvacuationController;
use App\Controllers\AdminController;
use App\Controllers\HazardController;
use App\Controllers\MapController;
use App\Controllers\AlertController;
use App\Controllers\FloodController;
use App\Controllers\KnowledgeController;
use App\Controllers\GalleryController;
use App\Controllers\SocioController;
use App\Controllers\VulnerabilityController;
use App\Controllers\PurokDemographicsController;
use App\Controllers\HouseholdMaterialsController;
use App\Controllers\PurokEvacuationController;


// simple autoloader
spl_autoload_register(function ($class) {
    if (strncmp('App\\', $class, 4) !== 0) return;
    $file = __DIR__ . '/../app/' . str_replace('\\', '/', substr($class, 4)) . '.php';
    if (file_exists($file)) require $file;
});

$route = $_GET['route'] ?? 'login';

// Define routing map: 'route_name' => [ControllerClass::class, 'methodName']
// Or a closure for simple includes
$routes = [
    'login' => ['App\\Controllers\\AuthController', $_SERVER['REQUEST_METHOD'] === 'POST' ? 'login' : 'loginForm'],
    'register' => ['App\\Controllers\\AuthController', $_SERVER['REQUEST_METHOD'] === 'POST' ? 'register' : 'registerForm'],
    'logout' => ['App\\Controllers\\AuthController', 'logout'],
    'dashboard' => ['App\\Controllers\\AuthController', 'dashboard'],
    'user-profile' => ['App\\Controllers\\AuthController', 'userProfile'],

    'evacuation' => ['App\\Controllers\\EvacuationController', 'index'],
    
    'admin-dashboard' => ['App\\Controllers\\AdminController', 'dashboard'],
    'admin-alerts' => ['App\\Controllers\\AdminController', 'alerts'],
    'admin-hazard-maps' => ['App\\Controllers\\AdminController', 'hazardMaps'],
    'admin-hazard-map-create' => ['App\\Controllers\\AdminController', 'createHazardMap'],
    'admin-hazard-map-edit' => ['App\\Controllers\\AdminController', 'editHazardMap'],
    'admin-hazard-map-delete' => ['App\\Controllers\\AdminController', 'deleteHazardMap'],
    'admin-iks' => ['App\\Controllers\\AdminController', 'iks'],
    'admin-iks-create' => ['App\\Controllers\\AdminController', 'createIks'],
    'admin-iks-edit' => ['App\\Controllers\\AdminController', 'editIks'],
    'admin-iks-delete' => ['App\\Controllers\\AdminController', 'deleteIks'],
    'admin-flood-zones' => ['App\\Controllers\\AdminController', 'floodZones'],
    'admin-flood-zones-create' => ['App\\Controllers\\AdminController', 'createFloodZone'],
    'admin-flood-zones-edit' => ['App\\Controllers\\AdminController', 'editFloodZone'],
    'admin-flood-zones-delete' => ['App\\Controllers\\AdminController', 'deleteFloodZone'],
    'admin-users' => ['App\\Controllers\\AdminController', 'users'],
    'admin-create-user' => ['App\\Controllers\\AdminController', 'createUser'],
    'admin-edit-user' => ['App\\Controllers\\AdminController', 'editUser'],
    'admin-delete-user' => ['App\\Controllers\\AdminController', 'deleteUser'],

    'community-map' => ['App\\Controllers\\MapController', 'communityMap'],
    'alerts' => ['App\\Controllers\\AlertController', 'index'],
    'hazard' => ['App\\Controllers\\HazardController', 'index'],
    'flood-monitoring' => ['App\\Controllers\\FloodController', 'index'],

    'socio' => ['App\\Controllers\\SocioController', 'index'],
    'api-add-age-bracket' => ['App\\Controllers\\SocioController', 'addAgeBracket'],
    'api-update-socio-data' => ['App\\Controllers\\SocioController', 'updateSocioData'],

    'vulnerability' => ['App\\Controllers\\VulnerabilityController', 'index'],
    'api-hazard-data' => ['App\\Controllers\\VulnerabilityController', 'apiGetHazardData'],
    'api-update-hazard' => ['App\\Controllers\\VulnerabilityController', 'update'],

    'purok-demographics' => ['App\\Controllers\\PurokDemographicsController', 'index'],
    'api-get-purok-data' => ['App\\Controllers\\PurokDemographicsController', 'apiGetPurokData'],
    'api-update-purok-data' => ['App\\Controllers\\PurokDemographicsController', 'update'],

    'household-materials' => ['App\\Controllers\\HouseholdMaterialsController', 'index'],
    'api-update-material' => ['App\\Controllers\\HouseholdMaterialsController', 'updateMaterial'],
    'api-update-ownership' => ['App\\Controllers\\HouseholdMaterialsController', 'updateOwnership'],

    'purok-evacuation' => ['App\\Controllers\\PurokEvacuationController', 'index'],

    'gallery' => ['App\\Controllers\\GalleryController', 'index'],
    'gallery-upload' => ['App\\Controllers\\GalleryController', 'uploadPhoto'],
    'gallery-edit' => ['App\\Controllers\\GalleryController', 'editPhoto'],
    'gallery-delete' => ['App\\Controllers\\GalleryController', 'deletePhoto'],
    'api-locations' => ['App\\Controllers\\GalleryController', 'getLocationsApi'],

    'iks' => ['App\\Controllers\\KnowledgeController', 'iks'],

    'population' => function() { include __DIR__ . '/../app/Views/population.php'; },
    'publications' => function() { include __DIR__ . '/../app/Views/publications.php'; },
    'download' => function() { include __DIR__ . '/../app/Views/download.php'; }
];

if (array_key_exists($route, $routes)) {
    $handler = $routes[$route];
    if (is_callable($handler)) {
        // Closure or function
        $handler();
    } elseif (is_array($handler) && count($handler) === 2) {
        // Controller Action
        $controllerName = $handler[0];
        $method = $handler[1];
        if (class_exists($controllerName) && method_exists($controllerName, $method)) {
            $controller = new $controllerName();
            $controller->$method();
        } else {
            http_response_code(500);
            echo "Handler {$controllerName}::{$method} not found.";
        }
    }
} else {
    http_response_code(404);
    echo 'Page not found';
}
