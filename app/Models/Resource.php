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
        $stmt = $this->db->prepare(
            'INSERT INTO resources (barangay, type, quantity, status) VALUES (?, ?, ?, ?)'
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
        $stmt = $this->db->query('SELECT * FROM resources ORDER BY barangay, type');
        return $stmt->fetchAll();
    }

    public function getResourcesByBarangay(string $barangay)
    {
        $stmt = $this->db->prepare('SELECT * FROM resources WHERE barangay = ? ORDER BY type');
        $stmt->execute([$barangay]);
        return $stmt->fetchAll();
    }

    public function updateQuantity($id, $quantity)
    {
        $stmt = $this->db->prepare('UPDATE resources SET quantity = ? WHERE id = ?');
        return $stmt->execute([$quantity, $id]);
    }

    public function updateStatus($id, $status)
    {
        $stmt = $this->db->prepare('UPDATE resources SET status = ? WHERE id = ?');
        return $stmt->execute([$status, $id]);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare('DELETE FROM resources WHERE id = ?');
        return $stmt->execute([$id]);
    }
}
