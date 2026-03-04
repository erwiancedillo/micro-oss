<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../vendor/autoload.php';
use App\Models\BarangayAlert;
use App\Models\Database;

try {
    $alertModel = new BarangayAlert();
    $barangays = $alertModel->getAll();
    
    // Legacy support for sitos check (if needed)
    $db = Database::getInstance()->getConnection();
    $sitios = [];
    $checkSitios = $db->query("SHOW TABLES LIKE 'sitios'");
    if ($checkSitios->rowCount() > 0) {
        $sitios = $db->query("SELECT id, barangay, sitio_name, flood_level, flood_advisory FROM sitios")->fetchAll();
    }

    echo json_encode([
        'barangays' => $barangays,
        'sitios' => $sitios
    ], JSON_PRETTY_PRINT);

} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
