<?php

namespace App\Models;

class CitizenReport
{
    private $db;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE && !headers_sent()) {
            session_start();
        }
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
        if (isset($_SESSION['admin_barangay']) && $_SESSION['admin_barangay'] === 'master') {
            $stmt = $this->db->prepare(
                "SELECT cr.*, u.first_name, u.last_name, 'Lizada' as source_table 
                 FROM citizen_reports_lizada cr 
                 LEFT JOIN users_lizada u ON cr.user_id = u.id 
                 UNION ALL
                 SELECT cr.*, u.first_name, u.last_name, 'Dalio' as source_table 
                 FROM citizen_reports_dalio cr 
                 LEFT JOIN users_dalio u ON cr.user_id = u.id 
                 UNION ALL
                 SELECT cr.*, u.first_name, u.last_name, 'Base' as source_table 
                 FROM citizen_reports cr 
                 LEFT JOIN users u ON cr.user_id = u.id 
                 ORDER BY created_at DESC"
            );
            $stmt->execute();
            return $stmt->fetchAll();
        } else {
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
        if (isset($_SESSION['admin_barangay']) && $_SESSION['admin_barangay'] === 'master') {
            foreach (['citizen_reports_lizada', 'citizen_reports_dalio', 'citizen_reports'] as $t) {
                $chk = $this->db->prepare("SELECT COUNT(*) FROM `$t` WHERE id = ?");
                $chk->execute([$id]);
                if ($chk->fetchColumn() > 0) {
                    $stmt = $this->db->prepare("UPDATE `$t` SET status = ? WHERE id = ?");
                    return $stmt->execute([$status, $id]);
                }
            }
            return false;
        } else {
            $table = Database::getTableName('citizen_reports');
            $stmt = $this->db->prepare("UPDATE `$table` SET status = ? WHERE id = ?");
            return $stmt->execute([$status, $id]);
        }
    }

    public function delete($id)
    {
        if (isset($_SESSION['admin_barangay']) && $_SESSION['admin_barangay'] === 'master') {
            foreach (['citizen_reports_lizada', 'citizen_reports_dalio', 'citizen_reports'] as $t) {
                $this->db->prepare("DELETE FROM `$t` WHERE id = ?")->execute([$id]);
            }
            return true;
        } else {
            $table = Database::getTableName('citizen_reports');
            $stmt = $this->db->prepare("DELETE FROM `$table` WHERE id = ?");
            return $stmt->execute([$id]);
        }
    }
}
