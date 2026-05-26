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
        $table = Database::getTableName('barangay_polygons');
        $stmt = $this->db->prepare("SELECT alert_level, flood_advisory, ST_AsText(polygon) AS polygon, ST_X(center) AS latitude, ST_Y(center) AS longitude FROM `$table` WHERE name = ? LIMIT 1");
        $stmt->execute([$name]);
        return $stmt->fetch();
    }

    public function getBarangayNames()
    {
        $table = Database::getTableName('barangay_polygons');
        $stmt = $this->db->query("SELECT name FROM `$table` ORDER BY name ASC");
        return $stmt->fetchAll(\PDO::FETCH_COLUMN);
    }

    public function getSitioAlerts(string $barangay)
    {
        $table = Database::getTableName('sitios');
        $stmt = $this->db->prepare("SELECT sitio_name, flood_level, flood_advisory, latitude, longitude FROM `$table` WHERE barangay = ?");
        $stmt->execute([$barangay]);
        return $stmt->fetchAll();
    }

    /**
     * Get all barangay alerts.
     */
    public function getAll()
    {
        $table = Database::getTableName('barangay_polygons');
        $stmt = $this->db->query(
            "SELECT name, alert_level, flood_advisory, full_address,
                    ST_X(center) AS latitude, ST_Y(center) AS longitude
             FROM `$table` 
             ORDER BY alert_level DESC, name ASC"
        );
        return $stmt->fetchAll();
    }

    public function save(array $data)
    {
        $table = Database::getTableName('barangay_polygons');
        $name = trim($data['name']);
        $level = $data['level'];
        $advisory = trim($data['advisory'] ?? '');
        $address = trim($data['address'] ?? '');
        $lat = !empty($data['latitude']) ? floatval($data['latitude']) : null;
        $lng = !empty($data['longitude']) ? floatval($data['longitude']) : null;

        // Check if exists
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM `$table` WHERE name = ?");
        $stmt->execute([$name]);
        $exists = $stmt->fetchColumn() > 0;

        if ($exists) {
            if ($lat !== null && $lng !== null) {
                $stmt = $this->db->prepare("UPDATE `$table` SET alert_level = ?, flood_advisory = ?, full_address = ?, center = POINT(?, ?) WHERE name = ?");
                return $stmt->execute([$level, $advisory, $address, $lat, $lng, $name]);
            } else {
                $stmt = $this->db->prepare("UPDATE `$table` SET alert_level = ?, flood_advisory = ?, full_address = ? WHERE name = ?");
                return $stmt->execute([$level, $advisory, $address, $name]);
            }
        } else {
            if ($lat !== null && $lng !== null) {
                $stmt = $this->db->prepare("INSERT INTO `$table` (name, alert_level, flood_advisory, full_address, center) VALUES (?, ?, ?, ?, POINT(?, ?))");
                return $stmt->execute([$name, $level, $advisory, $address, $lat, $lng]);
            } else {
                $stmt = $this->db->prepare("INSERT INTO `$table` (name, alert_level, flood_advisory, full_address) VALUES (?, ?, ?, ?)");
                return $stmt->execute([$name, $level, $advisory, $address]);
            }
        }
    }

    public function saveSitio(array $data)
    {
        $table = Database::getTableName('sitios');
        $id = $data['id'] ?? null;
        $barangay = trim($data['barangay'] ?? '');
        $sitio_name = trim($data['name'] ?? '');
        $level = $data['level'] ?? 0;
        $advisory = trim($data['advisory'] ?? '');
        $lat = !empty($data['latitude']) ? floatval($data['latitude']) : null;
        $lng = !empty($data['longitude']) ? floatval($data['longitude']) : null;

        if ($id) {
            $stmt = $this->db->prepare("UPDATE `$table` SET barangay = ?, sitio_name = ?, flood_level = ?, flood_advisory = ?, latitude = ?, longitude = ? WHERE id = ?");
            return $stmt->execute([$barangay, $sitio_name, $level, $advisory, $lat, $lng, $id]);
        } else {
            // Check if exists by name within barangay
            $stmt = $this->db->prepare("SELECT id FROM `$table` WHERE sitio_name = ? AND barangay = ? LIMIT 1");
            $stmt->execute([$sitio_name, $barangay]);
            $existingId = $stmt->fetchColumn();

            if ($existingId) {
                $stmt = $this->db->prepare("UPDATE `$table` SET flood_level = ?, flood_advisory = ?, latitude = ?, longitude = ? WHERE id = ?");
                return $stmt->execute([$level, $advisory, $lat, $lng, $existingId]);
            } else {
                $stmt = $this->db->prepare("INSERT INTO `$table` (barangay, sitio_name, flood_level, flood_advisory, latitude, longitude) VALUES (?, ?, ?, ?, ?, ?)");
                return $stmt->execute([$barangay, $sitio_name, $level, $advisory, $lat, $lng]);
            }
        }
    }
}
