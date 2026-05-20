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
        $stmt = $this->db->prepare(
            'INSERT INTO junkshops (name, lat, lng, contact) VALUES (?, ?, ?, ?)'
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
        $stmt = $this->db->query('SELECT * FROM junkshops');
        return $stmt->fetchAll();
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare('DELETE FROM junkshops WHERE id = ?');
        return $stmt->execute([$id]);
    }
}
