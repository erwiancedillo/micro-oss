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
        if (isset($_SESSION['admin_barangay']) && $_SESSION['admin_barangay'] === 'master') {
            $sql = "SELECT * FROM (
                        SELECT *, 'Lizada' as barangay FROM purok_evacuation_plan_lizada
                        UNION ALL
                        SELECT *, 'Dalio' as barangay FROM purok_evacuation_plan_dalio
                    ) AS combined ORDER BY purok_name ASC LIMIT :offset, :per_page";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':offset', $offset, \PDO::PARAM_INT);
            $stmt->bindValue(':per_page', $per_page, \PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } else {
            $table = Database::getTableName('purok_evacuation_plan');
            $stmt = $this->db->prepare("SELECT * FROM `$table` ORDER BY purok_name ASC LIMIT :offset, :per_page");
            $stmt->bindValue(':offset', $offset, \PDO::PARAM_INT);
            $stmt->bindValue(':per_page', $per_page, \PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
    }

    public function getTotalCount()
    {
        if (isset($_SESSION['admin_barangay']) && $_SESSION['admin_barangay'] === 'master') {
            $stmt = $this->db->query("
                SELECT COUNT(*) as total FROM (
                    SELECT purok_id FROM purok_evacuation_plan_lizada
                    UNION ALL
                    SELECT purok_id FROM purok_evacuation_plan_dalio
                ) AS combined
            ");
            $row = $stmt->fetch(\PDO::FETCH_ASSOC);
            return $row ? (int)$row['total'] : 0;
        } else {
            $table = Database::getTableName('purok_evacuation_plan');
            $stmt = $this->db->query("SELECT COUNT(*) as total FROM `$table`");
            $row = $stmt->fetch(\PDO::FETCH_ASSOC);
            return $row ? (int)$row['total'] : 0;
        }
    }
}
