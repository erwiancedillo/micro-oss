<?php

namespace App\Models;

class GalleryModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getFilteredPhotos($barangay = '', $sitio = '')
    {
        $sql = "SELECT id, barangay, sitio_purok, photo, description, latitude, longitude FROM flood_archive";
        $params = [];
        $types = "";

        if (!empty($sitio)) {
            if (!empty($barangay)) {
                $sql .= " WHERE sitio_purok = ? AND barangay = ?";
                $params[] = $sitio;
                $params[] = $barangay;
            } else {
                $sql .= " WHERE sitio_purok = ?";
                $params[] = $sitio;
            }
        } elseif (!empty($barangay)) {
            $sql .= " WHERE barangay = ?";
            $params[] = $barangay;
        }

        $sql .= " ORDER BY created_at DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function addPhoto($data)
    {
        $stmt = $this->db->prepare("INSERT INTO flood_archive (barangay, sitio_purok, photo, description, latitude, longitude) VALUES (?, ?, ?, ?, ?, ?)");
        return $stmt->execute([
            $data['barangay'],
            $data['sitio'],
            $data['photo'],
            $data['description'],
            $data['latitude'],
            $data['longitude']
        ]);
    }

    public function getPhotoById($id)
    {
        $stmt = $this->db->prepare("SELECT id, barangay, sitio_purok, description, latitude, longitude FROM flood_archive WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function updatePhoto($id, $data)
    {
        if (isset($data['photo']) && !empty($data['photo'])) {
            $stmt = $this->db->prepare("UPDATE flood_archive SET barangay = ?, sitio_purok = ?, photo = ?, description = ?, latitude = ?, longitude = ? WHERE id = ?");
            return $stmt->execute([
                $data['barangay'],
                $data['sitio'],
                $data['photo'],
                $data['description'],
                $data['latitude'],
                $data['longitude'],
                $id
            ]);
        } else {
            $stmt = $this->db->prepare("UPDATE flood_archive SET barangay = ?, sitio_purok = ?, description = ?, latitude = ?, longitude = ? WHERE id = ?");
            return $stmt->execute([
                $data['barangay'],
                $data['sitio'],
                $data['description'],
                $data['latitude'],
                $data['longitude'],
                $id
            ]);
        }
    }

    public function deletePhoto($id)
    {
        $stmt = $this->db->prepare("DELETE FROM flood_archive WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
