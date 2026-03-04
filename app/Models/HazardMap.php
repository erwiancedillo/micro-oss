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
        $stmt = $this->db->query("SELECT * FROM hazard_maps ORDER BY name ASC");
        return $stmt->fetchAll();
    }

    public function getHazardMapById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM hazard_maps WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function getFocusPoints($hazardMapId)
    {
        $stmt = $this->db->prepare("SELECT * FROM hazard_focus_points WHERE hazard_map_id = ?");
        $stmt->execute([$hazardMapId]);
        return $stmt->fetchAll();
    }

    public function createHazardMap($data)
    {
        $stmt = $this->db->prepare("INSERT INTO hazard_maps (name, image_url, description) VALUES (?, ?, ?)");
        $stmt->execute([$data['name'], $data['image_url'], $data['description']]);
        return $this->db->lastInsertId();
    }

    public function updateHazardMap($id, $data)
    {
        $stmt = $this->db->prepare("UPDATE hazard_maps SET name = ?, image_url = ?, description = ? WHERE id = ?");
        return $stmt->execute([$data['name'], $data['image_url'], $data['description'], $id]);
    }

    public function deleteHazardMap($id)
    {
        $stmt = $this->db->prepare("DELETE FROM hazard_maps WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function addFocusPoint($hazardMapId, $sitioName, $x, $y)
    {
        $stmt = $this->db->prepare("INSERT INTO hazard_focus_points (hazard_map_id, sitio_name, x_pos, y_pos) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$hazardMapId, $sitioName, $x, $y]);
    }

    public function deleteFocusPoints($hazardMapId)
    {
        $stmt = $this->db->prepare("DELETE FROM hazard_focus_points WHERE hazard_map_id = ?");
        return $stmt->execute([$hazardMapId]);
    }
}
