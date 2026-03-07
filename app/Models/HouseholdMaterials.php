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
        $stmt = $this->db->query("SELECT * FROM household_materials ORDER BY id");
        return $stmt->fetchAll();
    }

    public function getOwnershipTypes()
    {
        $stmt = $this->db->query("SELECT * FROM household_ownership ORDER BY id");
        return $stmt->fetchAll();
    }

    public function getMaterialsTotals()
    {
        $stmt = $this->db->query("SELECT SUM(households) as total FROM household_materials");
        return $stmt->fetch()['total'] ?? 0;
    }

    public function getOwnershipTotals()
    {
        $stmt = $this->db->query("SELECT SUM(households) as total FROM household_ownership");
        return $stmt->fetch()['total'] ?? 0;
    }

    public function getMostCommonMaterial()
    {
        $stmt = $this->db->query("SELECT material_name FROM household_materials ORDER BY households DESC LIMIT 1");
        return $stmt->fetch()['material_name'] ?? 'N/A';
    }

    public function getOwnedHouseholdsCount()
    {
        $stmt = $this->db->prepare("SELECT SUM(households) as total FROM household_ownership WHERE ownership_type LIKE :owned");
        $stmt->execute(['owned' => '%Owned%']);
        return $stmt->fetch()['total'] ?? 0;
    }

    public function updateMaterialHouseholds($materialName, $households)
    {
        $stmt = $this->db->prepare("UPDATE household_materials SET households = :households WHERE material_name = :material_name");
        return $stmt->execute([
            'households' => $households,
            'material_name' => $materialName
        ]);
    }

    public function updateOwnershipHouseholds($ownershipType, $households)
    {
        $stmt = $this->db->prepare("UPDATE household_ownership SET households = :households WHERE ownership_type = :ownership_type");
        return $stmt->execute([
            'households' => $households,
            'ownership_type' => $ownershipType
        ]);
    }
}
