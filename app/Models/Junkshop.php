<?php

namespace App\Models;

class Junkshop
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function create(array $data)
    {
        $table = Database::getTableName('junkshops');
        $stmt = $this->db->prepare(
            "INSERT INTO `$table` (name, lat, lng, contact) VALUES (?, ?, ?, ?)"
        );
        return $stmt->execute([
            $data['name'],
            $data['lat'] ?? null,
            $data['lng'] ?? null,
            $data['contact'] ?? null
        ]);
    }

    public function getAll()
    {
        $table = Database::getTableName('junkshops');
        $stmt = $this->db->query("SELECT * FROM `$table`");
        return $stmt->fetchAll();
    }

    public function delete($id)
    {
        $table = Database::getTableName('junkshops');
        $stmt = $this->db->prepare("DELETE FROM `$table` WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
