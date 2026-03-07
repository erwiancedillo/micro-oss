<?php

namespace App\Models;

class AgePopulation
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAll()
    {
        $stmt = $this->db->query("SELECT * FROM age_population WHERE age_bracket != 'TOTAL' ORDER BY id");
        return $stmt->fetchAll();
    }

    public function getTotals()
    {
        $stmt = $this->db->query("SELECT SUM(female) as total_female, SUM(male) as total_male, SUM(total) as total_population FROM age_population WHERE age_bracket != 'TOTAL'");
        return $stmt->fetch();
    }

    public function getAgeGroups()
    {
        $stmt = $this->db->query("SELECT 
            SUM(CASE WHEN age_bracket IN ('0-4', '5-9', '10-14') THEN total ELSE 0 END) as youth_0_14,
            SUM(CASE WHEN age_bracket NOT IN ('0-4', '5-9', '10-14', '65-69', '70-74', '75-79', '80+') THEN total ELSE 0 END) as adults_15_64,
            SUM(CASE WHEN age_bracket IN ('65-69', '70-74', '75-79', '80+') THEN total ELSE 0 END) as elderly_65_plus
            FROM age_population WHERE age_bracket != 'TOTAL'");
        return $stmt->fetch();
    }

    public function create(array $data)
    {
        $stmt = $this->db->prepare(
            'INSERT INTO age_population (age_bracket, female, male, total) VALUES (?,?,?,?)'
        );
        return $stmt->execute([
            $data['age_bracket'],
            $data['female'],
            $data['male'],
            $data['total']
        ]);
    }
}
