<?php

namespace App\Models;

class Resource
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function create(array $data)
    {
        $table = Database::getTableName('resources');
        $stmt = $this->db->prepare(
            "INSERT INTO `$table` (barangay, type, quantity, status) VALUES (?, ?, ?, ?)"
        );
        return $stmt->execute([
            $data['barangay'],
            $data['type'],
            $data['quantity'] ?? 0,
            $data['status'] ?? 'available'
        ]);
    }

    public function getAllResources()
    {
        if (isset($_SESSION['admin_barangay']) && $_SESSION['admin_barangay'] === 'master') {
            $stmt = $this->db->query("
                SELECT id, barangay, type, quantity, status, 'Lizada' AS source FROM resources_lizada
                UNION ALL
                SELECT id, barangay, type, quantity, status, 'Dalio' AS source FROM resources_dalio
                ORDER BY barangay, type
            ");
        } else {
            $table = Database::getTableName('resources');
            $stmt = $this->db->query("SELECT * FROM `$table` ORDER BY barangay, type");
        }
        return $stmt->fetchAll();
    }

    public function getResourcesByBarangay(string $barangay)
    {
        $table = Database::getTableName('resources');
        $stmt = $this->db->prepare("SELECT * FROM `$table` WHERE barangay = ? ORDER BY type");
        $stmt->execute([$barangay]);
        return $stmt->fetchAll();
    }

    public function updateQuantity($id, $quantity)
    {
        $table = Database::getTableName('resources');
        $stmt = $this->db->prepare("UPDATE `$table` SET quantity = ? WHERE id = ?");
        return $stmt->execute([$quantity, $id]);
    }

    public function updateStatus($id, $status)
    {
        $table = Database::getTableName('resources');
        $stmt = $this->db->prepare("UPDATE `$table` SET status = ? WHERE id = ?");
        return $stmt->execute([$status, $id]);
    }

    public function delete($id)
    {
        $table = Database::getTableName('resources');
        $stmt = $this->db->prepare("DELETE FROM `$table` WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
