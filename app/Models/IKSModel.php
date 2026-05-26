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
        $table = Database::getTableName('iks_items');
        $stmt = $this->db->prepare("SELECT * FROM `$table` WHERE category = ? ORDER BY order_index ASC");
        $stmt->execute([$category]);
        return $stmt->fetchAll();
    }

    public function getAllItems()
    {
        if (isset($_SESSION['admin_barangay']) && $_SESSION['admin_barangay'] === 'master') {
            $stmt = $this->db->query("
                SELECT id, category, title, description, significance, icon_url, source_url, order_index, 'Lizada' as source FROM iks_items_lizada
                UNION ALL
                SELECT id, category, title, description, significance, icon_url, source_url, order_index, 'Dalio' as source FROM iks_items_dalio
                ORDER BY category, order_index ASC
            ");
        } else {
            $table = Database::getTableName('iks_items');
            $stmt = $this->db->query("SELECT * FROM `$table` ORDER BY category, order_index ASC");
        }
        return $stmt->fetchAll();
    }

    public function getItemById($id)
    {
        $table = Database::getTableName('iks_items');
        $stmt = $this->db->prepare("SELECT * FROM `$table` WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function createItem($data)
    {
        $table = Database::getTableName('iks_items');
        $stmt = $this->db->prepare("INSERT INTO `$table` (category, title, description, significance, icon_url, source_url, order_index) VALUES (?, ?, ?, ?, ?, ?, ?)");
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
        $table = Database::getTableName('iks_items');
        $stmt = $this->db->prepare("UPDATE `$table` SET category = ?, title = ?, description = ?, significance = ?, icon_url = ?, source_url = ?, order_index = ? WHERE id = ?");
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
        $table = Database::getTableName('iks_items');
        $stmt = $this->db->prepare("DELETE FROM `$table` WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
