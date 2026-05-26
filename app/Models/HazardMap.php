<?php

namespace App\Models;

class HazardMap
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAllHazardMaps()
    {
        if (isset($_SESSION['admin_barangay']) && $_SESSION['admin_barangay'] === 'master') {
            $stmt = $this->db->query("
                SELECT id, name, image_url, description FROM hazard_maps_lizada
                UNION ALL
                SELECT id, name, image_url, description FROM hazard_maps_dalio
                ORDER BY name ASC
            ");
        } else {
            $table = Database::getTableName('hazard_maps');
            $stmt = $this->db->query("SELECT * FROM `$table` ORDER BY name ASC");
        }
        return $stmt->fetchAll();
    }

    public function getHazardMapById($id)
    {
        $table = Database::getTableName('hazard_maps');
        $stmt = $this->db->prepare("SELECT * FROM `$table` WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function getFocusPoints($hazardMapId)
    {
        $table = Database::getTableName('hazard_focus_points');
        $stmt = $this->db->prepare("SELECT * FROM `$table` WHERE hazard_map_id = ?");
        $stmt->execute([$hazardMapId]);
        return $stmt->fetchAll();
    }

    public function createHazardMap($data)
    {
        $table = Database::getTableName('hazard_maps');
        $stmt = $this->db->prepare("INSERT INTO `$table` (name, image_url, description) VALUES (?, ?, ?)");
        $stmt->execute([$data['name'], $data['image_url'], $data['description']]);
        return $this->db->lastInsertId();
    }

    public function updateHazardMap($id, $data)
    {
        $table = Database::getTableName('hazard_maps');
        $stmt = $this->db->prepare("UPDATE `$table` SET name = ?, image_url = ?, description = ? WHERE id = ?");
        return $stmt->execute([$data['name'], $data['image_url'], $data['description'], $id]);
    }

    public function deleteHazardMap($id)
    {
        $table = Database::getTableName('hazard_maps');
        $stmt = $this->db->prepare("DELETE FROM `$table` WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function addFocusPoint($hazardMapId, $sitioName, $x, $y)
    {
        $table = Database::getTableName('hazard_focus_points');
        $stmt = $this->db->prepare("INSERT INTO `$table` (hazard_map_id, sitio_name, x_pos, y_pos) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$hazardMapId, $sitioName, $x, $y]);
    }

    public function deleteFocusPoints($hazardMapId)
    {
        $table = Database::getTableName('hazard_focus_points');
        $stmt = $this->db->prepare("DELETE FROM `$table` WHERE hazard_map_id = ?");
        return $stmt->execute([$hazardMapId]);
    }
}
