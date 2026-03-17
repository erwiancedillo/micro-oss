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
        $stmt = $this->db->query("SELECT *, 
            CASE 
                WHEN occupied = 0 THEN 'Vacant'
                WHEN occupied >= capacity THEN 'Full'
                ELSE 'Limited'
            END AS status 
            FROM evacuation_centers");
        return $stmt->fetchAll();
    }

    public function create(array $data)
    {
        $stmt = $this->db->prepare("INSERT INTO evacuation_centers (name, latitude, longitude, capacity, occupied) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([
            $data['name'],
            $data['latitude'],
            $data['longitude'],
            $data['capacity'],
            $data['occupied'] ?? 0
        ]);
    }

    public function update(int $id, array $data)
    {
        $stmt = $this->db->prepare("UPDATE evacuation_centers SET name = ?, latitude = ?, longitude = ?, capacity = ?, occupied = ? WHERE id = ?");
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
        $stmt = $this->db->prepare("DELETE FROM evacuation_centers WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function getStats()
    {
        $stmt = $this->db->query("SELECT 
            COUNT(*) as total_centers,
            SUM(capacity) as total_capacity,
            SUM(occupied) as total_occupied
            FROM evacuation_centers");
        return $stmt->fetch();
    }

    public function incrementOccupied(int $id)
    {
        // First check if already at capacity
        $stmt = $this->db->prepare("SELECT capacity, occupied FROM evacuation_centers WHERE id = ?");
        $stmt->execute([$id]);
        $center = $stmt->fetch();

        if ($center && $center['occupied'] < $center['capacity']) {
            $stmt = $this->db->prepare("UPDATE evacuation_centers SET occupied = occupied + 1 WHERE id = ?");
            return $stmt->execute([$id]);
        }
        return false;
    }
}
