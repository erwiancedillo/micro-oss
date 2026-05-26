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
        $table = Database::getTableName('citizen_reports');
        $stmt = $this->db->prepare(
            "INSERT INTO `$table` (user_id, category, description, latitude, longitude, barangay, sitio, image, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"
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
        $table = Database::getTableName('citizen_reports');
        $usersTable = Database::getTableName('users');
        $stmt = $this->db->prepare(
            "SELECT cr.*, u.first_name, u.last_name 
             FROM `$table` cr 
             JOIN `$usersTable` u ON cr.user_id = u.id 
             ORDER BY cr.created_at DESC"
        );
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getReportsByBarangay(string $barangay)
    {
        $table = Database::getTableName('citizen_reports');
        $usersTable = Database::getTableName('users');
        $stmt = $this->db->prepare(
            "SELECT cr.*, u.first_name, u.last_name 
             FROM `$table` cr 
             JOIN `$usersTable` u ON cr.user_id = u.id 
             WHERE cr.barangay = ? 
             ORDER BY cr.created_at DESC"
        );
        $stmt->execute([$barangay]);
        return $stmt->fetchAll();
    }

    public function getReportsByCategory(string $category)
    {
        $table = Database::getTableName('citizen_reports');
        $usersTable = Database::getTableName('users');
        $stmt = $this->db->prepare(
            "SELECT cr.*, u.first_name, u.last_name 
             FROM `$table` cr 
             JOIN `$usersTable` u ON cr.user_id = u.id 
             WHERE cr.category = ? 
             ORDER BY cr.created_at DESC"
        );
        $stmt->execute([$category]);
        return $stmt->fetchAll();
    }

    public function updateStatus($id, $status)
    {
        $table = Database::getTableName('citizen_reports');
        $stmt = $this->db->prepare("UPDATE `$table` SET status = ? WHERE id = ?");
        return $stmt->execute([$status, $id]);
    }

    public function delete($id)
    {
        $table = Database::getTableName('citizen_reports');
        $stmt = $this->db->prepare("DELETE FROM `$table` WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
