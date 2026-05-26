<?php

namespace App\Models;

class Junkshop
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAllJunkshops()
    {
        if (isset($_SESSION['admin_barangay']) && $_SESSION['admin_barangay'] === 'master') {
            $stmt = $this->db->query("
                SELECT id, name, owner, address, contact, materials_accepted, operating_hours, 'Lizada' AS source FROM junkshops_lizada
                UNION ALL
                SELECT id, name, owner, address, contact, materials_accepted, operating_hours, 'Dalio' AS source FROM junkshops_dalio
                ORDER BY name ASC
            ");
        } else {
            $table = Database::getTableName('junkshops');
            $stmt = $this->db->query("SELECT * FROM `$table` ORDER BY name ASC");
        }
        return $stmt->fetchAll();
    }

    public function getJunkshopById($id)
    {
        $table = Database::getTableName('junkshops');
        $stmt = $this->db->prepare("SELECT * FROM `$table` WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function createJunkshop($data)
    {
        $table = Database::getTableName('junkshops');
        $stmt = $this->db->prepare("INSERT INTO `$table` (name, owner, address, contact, materials_accepted, operating_hours) VALUES (?, ?, ?, ?, ?, ?)");
        return $stmt->execute([
            $data['name'],
            $data['owner'] ?? null,
            $data['address'] ?? null,
            $data['contact'] ?? null,
            $data['materials_accepted'] ?? null,
            $data['operating_hours'] ?? null,
        ]);
    }

    public function updateJunkshop($id, $data)
    {
        $table = Database::getTableName('junkshops');
        $stmt = $this->db->prepare("UPDATE `$table` SET name = ?, owner = ?, address = ?, contact = ?, materials_accepted = ?, operating_hours = ? WHERE id = ?");
        return $stmt->execute([
            $data['name'],
            $data['owner'] ?? null,
            $data['address'] ?? null,
            $data['contact'] ?? null,
            $data['materials_accepted'] ?? null,
            $data['operating_hours'] ?? null,
            $id
        ]);
    }

    public function deleteJunkshop($id)
    {
        $table = Database::getTableName('junkshops');
        $stmt = $this->db->prepare("DELETE FROM `$table` WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
