<?php

namespace App\Models;

class WasteListing
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function create(array $data)
    {
        $table = Database::getTableName('socio_data');
        $stmt = $this->db->prepare(
            "INSERT INTO `$table` (household_head, purok, members, monthly_income, plastic_waste_kg) VALUES (?, ?, ?, ?, ?)"
        );
        return $stmt->execute([
            $data['household_head'],
            $data['purok'] ?? null,
            $data['members'] ?? 1,
            $data['monthly_income'] ?? 0.0,
            $data['plastic_waste_kg'] ?? 0.0
        ]);
    }

    public function getAll()
    {
        if (isset($_SESSION['admin_barangay']) && $_SESSION['admin_barangay'] === 'master') {
            $stmt = $this->db->query("
                SELECT id, household_head, purok, members, monthly_income, plastic_waste_kg, 'Lizada' AS source FROM socio_data_lizada
                UNION ALL
                SELECT id, household_head, purok, members, monthly_income, plastic_waste_kg, 'Dalio' AS source FROM socio_data_dalio
                ORDER BY purok, household_head
            ");
        } else {
            $table = Database::getTableName('socio_data');
            $stmt = $this->db->query("SELECT * FROM `$table` ORDER BY purok, household_head");
        }
        return $stmt->fetchAll();
    }
}
