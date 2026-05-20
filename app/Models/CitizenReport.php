<?php

namespace App\Models;

class CitizenReport
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function create(array $data)
    {
        $stmt = $this->db->prepare(
            'INSERT INTO citizen_reports (user_id, category, description, latitude, longitude, barangay, sitio, image, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)'
        );
        return $stmt->execute([
            $data['user_id'],
            $data['category'],
            $data['description'] ?? null,
            $data['latitude'] ?? null,
            $data['longitude'] ?? null,
            $data['barangay'] ?? null,
            $data['sitio'] ?? null,
            $data['image'] ?? null,
            $data['status'] ?? 'pending'
        ]);
    }

    public function getAllReports()
    {
        $stmt = $this->db->prepare(
            'SELECT cr.*, u.first_name, u.last_name 
             FROM citizen_reports cr 
             JOIN users u ON cr.user_id = u.id 
             ORDER BY cr.created_at DESC'
        );
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getReportsByBarangay(string $barangay)
    {
        $stmt = $this->db->prepare(
            'SELECT cr.*, u.first_name, u.last_name 
             FROM citizen_reports cr 
             JOIN users u ON cr.user_id = u.id 
             WHERE cr.barangay = ? 
             ORDER BY cr.created_at DESC'
        );
        $stmt->execute([$barangay]);
        return $stmt->fetchAll();
    }

    public function getReportsByCategory(string $category)
    {
        $stmt = $this->db->prepare(
            'SELECT cr.*, u.first_name, u.last_name 
             FROM citizen_reports cr 
             JOIN users u ON cr.user_id = u.id 
             WHERE cr.category = ? 
             ORDER BY cr.created_at DESC'
        );
        $stmt->execute([$category]);
        return $stmt->fetchAll();
    }

    public function updateStatus($id, $status)
    {
        $stmt = $this->db->prepare('UPDATE citizen_reports SET status = ? WHERE id = ?');
        return $stmt->execute([$status, $id]);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare('DELETE FROM citizen_reports WHERE id = ?');
        return $stmt->execute([$id]);
    }
}
