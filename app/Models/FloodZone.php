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
        // Using PDO since Database::getInstance()->getConnection() returns a PDO instance
        $stmt = $this->db->query("SELECT * FROM flood_zones");
        $zones = $stmt->fetchAll();
        
        foreach ($zones as &$row) {
            $row['polygon'] = json_decode($row['polygon']);
            // The enum in MySQL can be returned as a string by PDO.
            // Leaving it as a string for floodzones.js getRiskColor(level)
            // which expects "high", "moderate", "low".
        }
        
        return $zones;
    }

    public function getZoneById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM flood_zones WHERE id = ?");
        $stmt->execute([$id]);
        $zone = $stmt->fetch();
        if ($zone) {
            $zone['polygon'] = json_decode($zone['polygon'], true);
        }
        return $zone;
    }

    public function createZone($data)
    {
        $stmt = $this->db->prepare("INSERT INTO flood_zones (zone_name, risk_level, polygon) VALUES (?, ?, ?)");
        return $stmt->execute([$data['zone_name'], $data['risk_level'], $data['polygon']]);
    }

    public function updateZone($id, $data)
    {
        $stmt = $this->db->prepare("UPDATE flood_zones SET zone_name = ?, risk_level = ?, polygon = ? WHERE id = ?");
        return $stmt->execute([$data['zone_name'], $data['risk_level'], $data['polygon'], $id]);
    }

    public function deleteZone($id)
    {
        $stmt = $this->db->prepare("DELETE FROM flood_zones WHERE id = ?");
        return $stmt->execute([$id]);
    }

}
