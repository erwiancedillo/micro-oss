<?php

namespace App\Models;

class FloodZone
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAllZones()
    {
        if (isset($_SESSION['admin_barangay']) && $_SESSION['admin_barangay'] === 'master') {
            $stmt = $this->db->query("
                SELECT id, zone_name, risk_level, polygon FROM flood_zones_lizada
                UNION ALL
                SELECT id, zone_name, risk_level, polygon FROM flood_zones_dalio
            ");
        } else {
            $table = Database::getTableName('flood_zones');
            $stmt = $this->db->query("SELECT * FROM `$table`");
        }
        $zones = $stmt->fetchAll();
        foreach ($zones as &$row) {
            $row['polygon'] = json_decode($row['polygon']);
        }
        return $zones;
    }

    public function getZoneById($id)
    {
        $table = Database::getTableName('flood_zones');
        $stmt = $this->db->prepare("SELECT * FROM `$table` WHERE id = ?");
        $stmt->execute([$id]);
        $zone = $stmt->fetch();
        if ($zone) {
            $zone['polygon'] = json_decode($zone['polygon'], true);
        }
        return $zone;
    }

    public function createZone($data)
    {
        $table = Database::getTableName('flood_zones');
        $stmt = $this->db->prepare("INSERT INTO `$table` (zone_name, risk_level, polygon) VALUES (?, ?, ?)");
        return $stmt->execute([$data['zone_name'], $data['risk_level'], $data['polygon']]);
    }

    public function updateZone($id, $data)
    {
        $table = Database::getTableName('flood_zones');
        $stmt = $this->db->prepare("UPDATE `$table` SET zone_name = ?, risk_level = ?, polygon = ? WHERE id = ?");
        return $stmt->execute([$data['zone_name'], $data['risk_level'], $data['polygon'], $id]);
    }

    public function deleteZone($id)
    {
        $table = Database::getTableName('flood_zones');
        $stmt = $this->db->prepare("DELETE FROM `$table` WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
