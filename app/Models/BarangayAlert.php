<?php

namespace App\Models;

class BarangayAlert
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getByName(string $name)
    {
        $stmt = $this->db->prepare("SELECT alert_level, flood_advisory FROM barangay_polygons WHERE name = ? LIMIT 1");
        $stmt->execute([$name]);
        return $stmt->fetch();
    }

    public function getBarangayNames()
    {
        $stmt = $this->db->query("SELECT name FROM barangay_polygons ORDER BY name ASC");
        return $stmt->fetchAll(\PDO::FETCH_COLUMN);
    }

    public function getSitioAlerts(string $barangay)
    {
        $stmt = $this->db->prepare("SELECT sitio_name, flood_level, flood_advisory FROM sitios WHERE barangay = ?");
        $stmt->execute([$barangay]);
        return $stmt->fetchAll();
    }

    /**
     * Get all barangay alerts with center coordinates for map display.
     */
    public function getAllAlerts()
    {
        $stmt = $this->db->query(
            "SELECT name, alert_level, flood_advisory, 
                    ST_X(center) AS center_lat, ST_Y(center) AS center_lng
             FROM barangay_polygons 
             WHERE center IS NOT NULL
             ORDER BY alert_level DESC, name ASC"
        );
        return $stmt->fetchAll();
    }

    public function save(array $data)
    {
        $name = $data['name'];
        $level = $data['level'];
        $advisory = $data['advisory'] ?? '';
        $address = $data['address'] ?? '';
        $lat = $data['latitude'] ?? null;
        $lng = $data['longitude'] ?? null;

        // Check if exists
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM barangay_polygons WHERE name = ?");
        $stmt->execute([$name]);
        $exists = $stmt->fetchColumn() > 0;

        if ($exists) {
            if ($lat !== null && $lng !== null) {
                $stmt = $this->db->prepare("UPDATE barangay_polygons SET alert_level = ?, flood_advisory = ?, full_address = ?, center = POINT(?, ?) WHERE name = ?");
                return $stmt->execute([$level, $advisory, $address, $lat, $lng, $name]);
            } else {
                $stmt = $this->db->prepare("UPDATE barangay_polygons SET alert_level = ?, flood_advisory = ?, full_address = ? WHERE name = ?");
                return $stmt->execute([$level, $advisory, $address, $name]);
            }
        } else {
            if ($lat !== null && $lng !== null) {
                $stmt = $this->db->prepare("INSERT INTO barangay_polygons (name, alert_level, flood_advisory, full_address, center) VALUES (?, ?, ?, ?, POINT(?, ?))");
                return $stmt->execute([$name, $level, $advisory, $address, $lat, $lng]);
            } else {
                $stmt = $this->db->prepare("INSERT INTO barangay_polygons (name, alert_level, flood_advisory, full_address) VALUES (?, ?, ?, ?)");
                return $stmt->execute([$name, $level, $advisory, $address]);
            }
        }
    }
}
