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
        $stmt = $this->db->prepare("DELETE FROM `$table` WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function getStats()
    {
        $table = Database::getTableName('evacuation_centers');
        $stmt = $this->db->query("SELECT 
            COUNT(*) as total_centers,
            SUM(capacity) as total_capacity,
            SUM(occupied) as total_occupied
            FROM `$table`");
        return $stmt->fetch();
    }

    public function incrementOccupied(int $id)
    {
        $table = Database::getTableName('evacuation_centers');
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
