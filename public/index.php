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

// simple autoloader
spl_autoload_register(function ($class) {
    if (strncmp('App\\', $class, 4) !== 0) return;
    $file = __DIR__ . '/../app/' . str_replace('\\', '/', substr($class, 4)) . '.php';
    if (file_exists($file)) require $file;
});

$route = $_GET['route'] ?? 'login';

$auth = new AuthController();
$evac = new EvacuationController();
$admin = new AdminController();
$hazard = new HazardController();
$map = new MapController();
$alert = new AlertController();
$flood = new FloodController();
$knowledge = new KnowledgeController();
$gallery = new GalleryController();

switch ($route) {
    case 'login':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth->login();
        } else {
            $auth->loginForm();
        }
        break;
    case 'register':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth->register();
        } else {
            $auth->registerForm();
        }
        break;
    case 'logout':
        $auth->logout();
        break;
    case 'dashboard':
        $auth->dashboard();
        break;
    case 'evacuation':
        $evac->index();
        break;
    case 'admin-dashboard':
        $admin->dashboard();
        break;
    case 'admin-alerts':
        $admin->alerts();
        break;
    case 'admin-hazard-maps':
        $admin->hazardMaps();
        break;
    case 'admin-hazard-map-create':
        $admin->createHazardMap();
        break;
    case 'admin-hazard-map-edit':
        $admin->editHazardMap();
        break;
    case 'admin-hazard-map-delete':
        $admin->deleteHazardMap();
        break;
    case 'admin-iks':
        $admin->iks();
        break;
    case 'admin-iks-create':
        $admin->createIks();
        break;
    case 'admin-iks-edit':
        $admin->editIks();
        break;
    case 'admin-iks-delete':
        $admin->deleteIks();
        break;
    case 'admin-flood-zones':
        $admin->floodZones();
        break;
    case 'admin-flood-zones-create':
        $admin->createFloodZone();
        break;
    case 'admin-flood-zones-edit':
        $admin->editFloodZone();
        break;
    case 'admin-flood-zones-delete':
        $admin->deleteFloodZone();
        break;
    case 'community-map':
        $map->communityMap();
        break;
    case 'alerts':
        $alert->index();
        break;
    case 'hazard':
        $hazard->index();
        break;
    case 'flood-monitoring':
        $flood->index();
        break;
    case 'socio':
        include __DIR__ . '/../socio.php';
        break;
    case 'gallery':
        $gallery->index();
        break;
    case 'gallery-upload':
        $gallery->uploadPhoto();
        break;
    case 'gallery-edit':
        $gallery->editPhoto();
        break;
    case 'gallery-delete':
        $gallery->deletePhoto();
        break;
    case 'api-locations':
        $gallery->getLocationsApi();
        break;
    case 'iks':
        $knowledge->iks();
        break;
    case 'publications':
        include __DIR__ . '/../Publications.php';
        break;
    case 'download':
        include __DIR__ . '/../download.php';
        break;
    default:
        http_response_code(404);
        echo 'Page not found';
}
