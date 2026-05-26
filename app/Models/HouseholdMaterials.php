<?php

namespace App\Models;

class HouseholdMaterials
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getConstructionMaterials()
    {
        if (isset($_SESSION['admin_barangay']) && $_SESSION['admin_barangay'] === 'master') {
            $stmt = $this->db->query("
                SELECT material_name, SUM(households) as households
                FROM (
                    SELECT material_name, households FROM household_materials_lizada
                    UNION ALL
                    SELECT material_name, households FROM household_materials_dalio
                ) AS combined
                GROUP BY material_name
                ORDER BY material_name
            ");
        } else {
            $table = Database::getTableName('household_materials');
            $stmt = $this->db->query("SELECT * FROM `$table` ORDER BY id");
        }
        return $stmt->fetchAll();
    }

    public function getOwnershipTypes()
    {
        if (isset($_SESSION['admin_barangay']) && $_SESSION['admin_barangay'] === 'master') {
            $stmt = $this->db->query("
                SELECT ownership_type, SUM(households) as households
                FROM (
                    SELECT ownership_type, households FROM household_ownership_lizada
                    UNION ALL
                    SELECT ownership_type, households FROM household_ownership_dalio
                ) AS combined
                GROUP BY ownership_type
                ORDER BY ownership_type
            ");
        } else {
            $table = Database::getTableName('household_ownership');
            $stmt = $this->db->query("SELECT * FROM `$table` ORDER BY id");
        }
        return $stmt->fetchAll();
    }

    public function getMaterialsTotals()
    {
        if (isset($_SESSION['admin_barangay']) && $_SESSION['admin_barangay'] === 'master') {
            $stmt = $this->db->query("SELECT SUM(households) as total FROM (SELECT households FROM household_materials_lizada UNION ALL SELECT households FROM household_materials_dalio) AS c");
        } else {
            $table = Database::getTableName('household_materials');
            $stmt = $this->db->query("SELECT SUM(households) as total FROM `$table`");
        }
        return $stmt->fetch()['total'] ?? 0;
    }

    public function getOwnershipTotals()
    {
        if (isset($_SESSION['admin_barangay']) && $_SESSION['admin_barangay'] === 'master') {
            $stmt = $this->db->query("SELECT SUM(households) as total FROM (SELECT households FROM household_ownership_lizada UNION ALL SELECT households FROM household_ownership_dalio) AS c");
        } else {
            $table = Database::getTableName('household_ownership');
            $stmt = $this->db->query("SELECT SUM(households) as total FROM `$table`");
        }
        return $stmt->fetch()['total'] ?? 0;
    }

    public function getMostCommonMaterial()
    {
        if (isset($_SESSION['admin_barangay']) && $_SESSION['admin_barangay'] === 'master') {
            $stmt = $this->db->query("
                SELECT material_name, SUM(households) as total
                FROM (SELECT material_name, households FROM household_materials_lizada UNION ALL SELECT material_name, households FROM household_materials_dalio) AS c
                GROUP BY material_name ORDER BY total DESC LIMIT 1
            ");
        } else {
            $table = Database::getTableName('household_materials');
            $stmt = $this->db->query("SELECT material_name FROM `$table` ORDER BY households DESC LIMIT 1");
        }
        return $stmt->fetch()['material_name'] ?? 'N/A';
    }

    public function getOwnedHouseholdsCount()
    {
        if (isset($_SESSION['admin_barangay']) && $_SESSION['admin_barangay'] === 'master') {
            $stmt = $this->db->prepare("SELECT SUM(households) as total FROM (SELECT households, ownership_type FROM household_ownership_lizada UNION ALL SELECT households, ownership_type FROM household_ownership_dalio) AS c WHERE ownership_type LIKE :owned");
        } else {
            $table = Database::getTableName('household_ownership');
            $stmt = $this->db->prepare("SELECT SUM(households) as total FROM `$table` WHERE ownership_type LIKE :owned");
        }
        $stmt->execute(['owned' => '%Owned%']);
        return $stmt->fetch()['total'] ?? 0;
    }

    public function updateMaterialHouseholds($materialName, $households)
    {
        $table = Database::getTableName('household_materials');
        $stmt = $this->db->prepare("UPDATE `$table` SET households = :households WHERE material_name = :material_name");
        return $stmt->execute([
            'households' => $households,
            'material_name' => $materialName
        ]);
    }

    public function updateOwnershipHouseholds($ownershipType, $households)
    {
        $table = Database::getTableName('household_ownership');
        $stmt = $this->db->prepare("UPDATE `$table` SET households = :households WHERE ownership_type = :ownership_type");
        return $stmt->execute([
            'households' => $households,
            'ownership_type' => $ownershipType
        ]);
    }
}
