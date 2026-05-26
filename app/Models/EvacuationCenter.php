<?php

namespace App\Models;

class EvacuationCenter
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAll()
    {
        if (isset($_SESSION['admin_barangay']) && $_SESSION['admin_barangay'] === 'master') {
            $stmt = $this->db->query("
                SELECT id, name, latitude, longitude, capacity, occupied, barangay,
                CASE 
                    WHEN occupied = 0 THEN 'Vacant'
                    WHEN occupied >= capacity THEN 'Full'
                    ELSE 'Limited'
                END AS status 
                FROM evacuation_centers_lizada
                UNION ALL
                SELECT id, name, latitude, longitude, capacity, occupied, barangay,
                CASE 
                    WHEN occupied = 0 THEN 'Vacant'
                    WHEN occupied >= capacity THEN 'Full'
                    ELSE 'Limited'
                END AS status 
                FROM evacuation_centers_dalio
            ");
            return $stmt->fetchAll();
        } else {
            $table = Database::getTableName('evacuation_centers');
            $stmt = $this->db->query("SELECT *, 
                CASE 
                    WHEN occupied = 0 THEN 'Vacant'
                    WHEN occupied >= capacity THEN 'Full'
                    ELSE 'Limited'
                END AS status 
                FROM `$table`");
            return $stmt->fetchAll();
        }
    }

    public function create(array $data)
    {
        $table = Database::getTableName('evacuation_centers');
        $stmt = $this->db->prepare("INSERT INTO `$table` (name, latitude, longitude, capacity, occupied, barangay) VALUES (?, ?, ?, ?, ?, ?)");
        return $stmt->execute([
            $data['name'],
            $data['latitude'],
            $data['longitude'],
            $data['capacity'],
            $data['occupied'] ?? 0,
            $data['barangay'] ?? null
        ]);
    }

    public function update(int $id, array $data)
    {
        $table = Database::getTableName('evacuation_centers');
        if (isset($_SESSION['admin_barangay']) && $_SESSION['admin_barangay'] === 'master') {
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM evacuation_centers_lizada WHERE id = ?");
            $stmt->execute([$id]);
            if ($stmt->fetchColumn() > 0) {
                $table = 'evacuation_centers_lizada';
            } else {
                $table = 'evacuation_centers_dalio';
            }
        }
        $stmt = $this->db->prepare("UPDATE `$table` SET name = ?, latitude = ?, longitude = ?, capacity = ?, occupied = ? WHERE id = ?");
        return $stmt->execute([
            $data['name'],
            $data['latitude'],
            $data['longitude'],
            $data['capacity'],
            $data['occupied'],
            $id
        ]);
    }

    public function delete(int $id)
    {
        $table = Database::getTableName('evacuation_centers');
        if (isset($_SESSION['admin_barangay']) && $_SESSION['admin_barangay'] === 'master') {
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM evacuation_centers_lizada WHERE id = ?");
            $stmt->execute([$id]);
            if ($stmt->fetchColumn() > 0) {
                $table = 'evacuation_centers_lizada';
            } else {
                $table = 'evacuation_centers_dalio';
            }
        }
        $stmt = $this->db->prepare("DELETE FROM `$table` WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function getStats()
    {
        if (isset($_SESSION['admin_barangay']) && $_SESSION['admin_barangay'] === 'master') {
            $stmt = $this->db->query("SELECT 
                SUM(total_centers) as total_centers,
                SUM(total_capacity) as total_capacity,
                SUM(total_occupied) as total_occupied
                FROM (
                    SELECT COUNT(*) as total_centers, IFNULL(SUM(capacity), 0) as total_capacity, IFNULL(SUM(occupied), 0) as total_occupied FROM evacuation_centers_lizada
                    UNION ALL
                    SELECT COUNT(*) as total_centers, IFNULL(SUM(capacity), 0) as total_capacity, IFNULL(SUM(occupied), 0) as total_occupied FROM evacuation_centers_dalio
                ) AS combined");
            return $stmt->fetch();
        } else {
            $table = Database::getTableName('evacuation_centers');
            $stmt = $this->db->query("SELECT 
                COUNT(*) as total_centers,
                SUM(capacity) as total_capacity,
                SUM(occupied) as total_occupied
                FROM `$table`");
            return $stmt->fetch();
        }
    }

    public function incrementOccupied(int $id)
    {
        $table = Database::getTableName('evacuation_centers');
        if (isset($_SESSION['admin_barangay']) && $_SESSION['admin_barangay'] === 'master') {
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM evacuation_centers_lizada WHERE id = ?");
            $stmt->execute([$id]);
            if ($stmt->fetchColumn() > 0) {
                $table = 'evacuation_centers_lizada';
            } else {
                $table = 'evacuation_centers_dalio';
            }
        }
        $stmt = $this->db->prepare("SELECT capacity, occupied FROM `$table` WHERE id = ?");
        $stmt->execute([$id]);
        $center = $stmt->fetch();

        if ($center && $center['occupied'] < $center['capacity']) {
            $stmt = $this->db->prepare("UPDATE `$table` SET occupied = occupied + 1 WHERE id = ?");
            return $stmt->execute([$id]);
        }
        return false;
    }
}
