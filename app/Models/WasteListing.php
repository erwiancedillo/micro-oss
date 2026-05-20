<?php

namespace App\Models;

class WasteListing
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function create(array $data)
    {
        $stmt = $this->db->prepare(
            'INSERT INTO waste_listings (user_id, type, weight, location, latitude, longitude, status) VALUES (?, ?, ?, ?, ?, ?, ?)'
        );
        return $stmt->execute([
            $data['user_id'],
            $data['type'],
            $data['weight'] ?? null,
            $data['location'] ?? null,
            !empty($data['latitude']) ? $data['latitude'] : null,
            !empty($data['longitude']) ? $data['longitude'] : null,
            $data['status'] ?? 'pending'
        ]);
    }

    public function getAllListings()
    {
        $stmt = $this->db->prepare(
            'SELECT wl.*, u.first_name, u.last_name 
             FROM waste_listings wl 
             JOIN users u ON wl.user_id = u.id 
             ORDER BY wl.created_at DESC'
        );
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getListingsByUser($userId)
    {
        $stmt = $this->db->prepare(
            'SELECT * FROM waste_listings WHERE user_id = ? ORDER BY created_at DESC'
        );
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    public function updateStatus($id, $status)
    {
        $stmt = $this->db->prepare('UPDATE waste_listings SET status = ? WHERE id = ?');
        return $stmt->execute([$status, $id]);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare('DELETE FROM waste_listings WHERE id = ?');
        return $stmt->execute([$id]);
    }
}
