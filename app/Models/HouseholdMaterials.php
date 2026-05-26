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
        $table = Database::getTableName('household_materials');
        $stmt = $this->db->query("SELECT * FROM `$table` ORDER BY id");
        return $stmt->fetchAll();
    }

    public function getOwnershipTypes()
    {
        $table = Database::getTableName('household_ownership');
        $stmt = $this->db->query("SELECT * FROM `$table` ORDER BY id");
        return $stmt->fetchAll();
    }

    public function getMaterialsTotals()
    {
        $table = Database::getTableName('household_materials');
        $stmt = $this->db->query("SELECT SUM(households) as total FROM `$table`");
        return $stmt->fetch()['total'] ?? 0;
    }

    public function getOwnershipTotals()
    {
        $table = Database::getTableName('household_ownership');
        $stmt = $this->db->query("SELECT SUM(households) as total FROM `$table`");
        return $stmt->fetch()['total'] ?? 0;
    }

    public function getMostCommonMaterial()
    {
        $table = Database::getTableName('household_materials');
        $stmt = $this->db->query("SELECT material_name FROM `$table` ORDER BY households DESC LIMIT 1");
        return $stmt->fetch()['material_name'] ?? 'N/A';
    }

    public function getOwnedHouseholdsCount()
    {
        $table = Database::getTableName('household_ownership');
        $stmt = $this->db->prepare("SELECT SUM(households) as total FROM `$table` WHERE ownership_type LIKE :owned");
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
