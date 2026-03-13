<?php

namespace App\Models;

class IKSModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getItemsByCategory($category)
    {
        $stmt = $this->db->prepare("SELECT * FROM iks_items WHERE category = ? ORDER BY order_index ASC");
        $stmt->execute([$category]);
        return $stmt->fetchAll();
    }

    public function getAllItems()
    {
        $stmt = $this->db->query("SELECT * FROM iks_items ORDER BY category, order_index ASC");
        return $stmt->fetchAll();
    }

    public function getItemById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM iks_items WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function createItem($data)
    {
        $stmt = $this->db->prepare("INSERT INTO iks_items (category, title, description, significance, icon_url, source_url, order_index) VALUES (?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([
            $data['category'],
            $data['title'],
            $data['description'],
            $data['significance'] ?? null,
            $data['icon_url'] ?? null,
            $data['source_url'] ?? null,
            $data['order_index'] ?? 0
        ]);
    }

    public function updateItem($id, $data)
    {
        $stmt = $this->db->prepare("UPDATE iks_items SET category = ?, title = ?, description = ?, significance = ?, icon_url = ?, source_url = ?, order_index = ? WHERE id = ?");
        return $stmt->execute([
            $data['category'],
            $data['title'],
            $data['description'],
            $data['significance'] ?? null,
            $data['icon_url'] ?? null,
            $data['source_url'] ?? null,
            $data['order_index'] ?? 0,
            $id
        ]);
    }

    public function deleteItem($id)
    {
        $stmt = $this->db->prepare("DELETE FROM iks_items WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
