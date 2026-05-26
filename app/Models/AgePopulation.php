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
        if (isset($_SESSION['admin_barangay']) && $_SESSION['admin_barangay'] === 'master') {
            $stmt = $this->db->query("
                SELECT age_bracket, SUM(female) as female, SUM(male) as male, SUM(total) as total 
                FROM (
                    SELECT age_bracket, female, male, total FROM age_population_lizada
                    UNION ALL
                    SELECT age_bracket, female, male, total FROM age_population_dalio
                ) AS combined 
                WHERE age_bracket != 'TOTAL' 
                GROUP BY age_bracket
                ORDER BY age_bracket ASC
            ");
            return $stmt->fetchAll();
        } else {
            $table = Database::getTableName('age_population');
            $stmt = $this->db->query("SELECT * FROM `$table` WHERE age_bracket != 'TOTAL' ORDER BY id");
            return $stmt->fetchAll();
        }
    }

    public function getTotals()
    {
        if (isset($_SESSION['admin_barangay']) && $_SESSION['admin_barangay'] === 'master') {
            $stmt = $this->db->query("
                SELECT SUM(female) as total_female, SUM(male) as total_male, SUM(total) as total_population 
                FROM (
                    SELECT female, male, total, age_bracket FROM age_population_lizada
                    UNION ALL
                    SELECT female, male, total, age_bracket FROM age_population_dalio
                ) AS combined 
                WHERE age_bracket != 'TOTAL'
            ");
            return $stmt->fetch();
        } else {
            $table = Database::getTableName('age_population');
            $stmt = $this->db->query("SELECT SUM(female) as total_female, SUM(male) as total_male, SUM(total) as total_population FROM `$table` WHERE age_bracket != 'TOTAL'");
            return $stmt->fetch();
        }
    }

    public function getAgeGroups()
    {
        if (isset($_SESSION['admin_barangay']) && $_SESSION['admin_barangay'] === 'master') {
            $stmt = $this->db->query("SELECT 
                SUM(CASE WHEN age_bracket IN ('0-4', '5-9', '10-14') THEN total ELSE 0 END) as youth_0_14,
                SUM(CASE WHEN age_bracket NOT IN ('0-4', '5-9', '10-14', '65-69', '70-74', '75-79', '80+') THEN total ELSE 0 END) as adults_15_64,
                SUM(CASE WHEN age_bracket IN ('65-69', '70-74', '75-79', '80+') THEN total ELSE 0 END) as elderly_65_plus
                FROM (
                    SELECT total, age_bracket FROM age_population_lizada
                    UNION ALL
                    SELECT total, age_bracket FROM age_population_dalio
                ) AS combined 
                WHERE age_bracket != 'TOTAL'");
            return $stmt->fetch();
        } else {
            $table = Database::getTableName('age_population');
            $stmt = $this->db->query("SELECT 
                SUM(CASE WHEN age_bracket IN ('0-4', '5-9', '10-14') THEN total ELSE 0 END) as youth_0_14,
                SUM(CASE WHEN age_bracket NOT IN ('0-4', '5-9', '10-14', '65-69', '70-74', '75-79', '80+') THEN total ELSE 0 END) as adults_15_64,
                SUM(CASE WHEN age_bracket IN ('65-69', '70-74', '75-79', '80+') THEN total ELSE 0 END) as elderly_65_plus
                FROM `$table` WHERE age_bracket != 'TOTAL'");
            return $stmt->fetch();
        }
    }

    public function create(array $data)
    {
        $table = Database::getTableName('age_population');
        $stmt = $this->db->prepare(
            "INSERT INTO `$table` (age_bracket, female, male, total) VALUES (?,?,?,?)"
        );
        return $stmt->execute([
            $data['age_bracket'],
            $data['female'],
            $data['male'],
            $data['total']
        ]);
    }

    public function update(string $original_age_bracket, array $data)
    {
        $table = Database::getTableName('age_population');
        $stmt = $this->db->prepare(
            "UPDATE `$table` SET age_bracket = ?, female = ?, male = ?, total = ? WHERE age_bracket = ?"
        );
        return $stmt->execute([
            $data['age_bracket'],
            $data['female'],
            $data['male'],
            $data['total'],
            $original_age_bracket
        ]);
    }
}
