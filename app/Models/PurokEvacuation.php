<?php

namespace App\Models;

class PurokEvacuation
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getPaginatedData($offset, $per_page)
    {
        $table = Database::getTableName('purok_evacuation_plan');
        $stmt = $this->db->prepare("SELECT * FROM `$table` ORDER BY purok_name ASC LIMIT :offset, :per_page");
        $stmt->bindValue(':offset', $offset, \PDO::PARAM_INT);
        $stmt->bindValue(':per_page', $per_page, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getTotalCount()
    {
        $table = Database::getTableName('purok_evacuation_plan');
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM `$table`");
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $row ? (int)$row['total'] : 0;
    }
}
