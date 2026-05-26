<?php

namespace App\Models;

class BarangayPolygon
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getByName(string $name)
    {
        $table = Database::getTableName('barangay_polygons');
        $stmt = $this->db->prepare("SELECT ST_AsText(polygon) AS polygon, ST_X(center) AS latitude, ST_Y(center) AS longitude FROM `$table` WHERE name=?");
        $stmt->execute([$name]);
        return $stmt->fetch();
    }

    public function getSitiosInPolygon(?string $polygonWKT)
    {
        if (empty($polygonWKT)) {
            return [];
        }
        $sitiosTable = Database::getTableName('sitios');
        // Construct point from lat/lng in SQL
        $query = "
            SELECT sitio_name, latitude, longitude
            FROM `$sitiosTable`
            WHERE ST_Contains(
                ST_GeomFromText(?),
                ST_PointFromText(CONCAT('POINT(', latitude, ' ', longitude, ')'))
            )
        ";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$polygonWKT]);
        return $stmt->fetchAll();
    }

    public function getAllPolygons()
    {
        $table = Database::getTableName('barangay_polygons');
        $stmt = $this->db->query("SELECT name, ST_AsText(polygon) AS polygon, ST_X(center) AS latitude, ST_Y(center) AS longitude FROM `$table`");
        return $stmt->fetchAll();
    }
}
