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

$auth = new AuthController();
$evac = new EvacuationController();
$admin = new AdminController();
$hazard = new HazardController();
$map = new MapController();
$alert = new AlertController();
$flood = new FloodController();
$knowledge = new KnowledgeController();
$gallery = new GalleryController();
$socio = new SocioController();
$vulnerability = new VulnerabilityController();
$purokDemographics = new PurokDemographicsController();
$householdMaterials = new HouseholdMaterialsController();
$purokEvacuation = new PurokEvacuationController();

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
        $socio->index();
        break;
    case 'api-add-age-bracket':
        $socio->addAgeBracket();
        break;
    case 'api-update-socio-data':
        $socio->updateSocioData();
        break;
    case 'population':
        include __DIR__ . '/../app/Views/population.php';
        break;
    case 'vulnerability':
        $vulnerability->index();
        break;
    case 'api-hazard-data':
        $vulnerability->apiGetHazardData();
        break;
    case 'api-update-hazard':
        $vulnerability->update();
        break;
    case 'purok-demographics':
        $purokDemographics->index();
        break;
    case 'api-get-purok-data':
        $purokDemographics->apiGetPurokData();
        break;
    case 'api-update-purok-data':
        $purokDemographics->update();
        break;
    case 'household-materials':
        $householdMaterials->index();
        break;
    case 'api-update-material':
        $householdMaterials->updateMaterial();
        break;
    case 'api-update-ownership':
        $householdMaterials->updateOwnership();
        break;
    case 'purok-evacuation':
        $purokEvacuation->index();
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
        include __DIR__ . '/../app/Views/publications.php';
        break;
    case 'download':
        include __DIR__ . '/../app/Views/download.php';
        break;
    default:
        http_response_code(404);
        echo 'Page not found';
}
