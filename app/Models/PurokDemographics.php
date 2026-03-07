<?php

namespace App\Models;

class PurokDemographics
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getPaginatedData($offset, $per_page)
    {
        $stmt = $this->db->prepare("SELECT * FROM flood_data LIMIT :offset, :per_page");
        $stmt->bindValue(':offset', $offset, \PDO::PARAM_INT);
        $stmt->bindValue(':per_page', $per_page, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getTotalCount()
    {
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM flood_data");
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $row ? (int)$row['total'] : 0;
    }

    public function getTotals()
    {
        $sql = "SELECT 
            SUM(total_families) as total_families,
            SUM(total_persons_male) as total_persons_male,
            SUM(total_persons_female) as total_persons_female,
            SUM(infant_male) as infant_male,
            SUM(infant_female) as infant_female,
            SUM(children_male) as children_male,
            SUM(children_female) as children_female,
            SUM(adult_male) as adult_male,
            SUM(adult_female) as adult_female,
            SUM(elderly_male) as elderly_male,
            SUM(elderly_female) as elderly_female,
            SUM(pwd_male) as pwd_male,
            SUM(pwd_female) as pwd_female,
            SUM(sickness_male) as sickness_male,
            SUM(sickness_female) as sickness_female,
            SUM(pregnant_women) as pregnant_women
            FROM flood_data";

        $stmt = $this->db->query($sql);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function getPurokByPurokName($purokName)
    {
        $stmt = $this->db->prepare("SELECT * FROM flood_data WHERE purok_name = :purok_name");
        $stmt->bindValue(':purok_name', $purokName, \PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function updatePurokData($purokName, $data)
    {
        $sql = "UPDATE flood_data SET 
                total_families = :total_families,
                total_persons_male = :total_persons_male,
                total_persons_female = :total_persons_female,
                infant_male = :infant_male,
                infant_female = :infant_female,
                children_male = :children_male,
                children_female = :children_female,
                adult_male = :adult_male,
                adult_female = :adult_female,
                elderly_male = :elderly_male,
                elderly_female = :elderly_female,
                pwd_male = :pwd_male,
                pwd_female = :pwd_female,
                sickness_male = :sickness_male,
                sickness_female = :sickness_female,
                pregnant_women = :pregnant_women
                WHERE purok_name = :purok_name";

        $stmt = $this->db->prepare($sql);
        foreach ($data as $key => $value) {
            $stmt->bindValue(':' . $key, $value);
        }
        $stmt->bindValue(':purok_name', $purokName, \PDO::PARAM_STR);
        return $stmt->execute();
    }
}
