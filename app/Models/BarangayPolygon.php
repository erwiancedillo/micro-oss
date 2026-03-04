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
        $stmt = $this->db->prepare("SELECT ST_AsText(polygon) AS polygon, ST_X(center) AS center_lat, ST_Y(center) AS center_lng FROM barangay_polygons WHERE name=?");
        $stmt->execute([$name]);
        return $stmt->fetch();
    }

    public function getSitiosInPolygon(string $polygonWKT)
    {
        // Construct point from lat/lng in SQL
        $query = "
            SELECT sitio_name, latitude, longitude
            FROM sitios
            WHERE ST_Contains(
                ST_GeomFromText(?),
                ST_PointFromText(CONCAT('POINT(', latitude, ' ', longitude, ')'))
            )
        ";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$polygonWKT]);
        return $stmt->fetchAll();
    }
}
