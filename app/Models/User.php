<?php

namespace App\Models;

class User
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function findByEmail(string $email)
    {
        $table = Database::getTableName('users');
        $stmt = $this->db->prepare("SELECT * FROM `$table` WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    public function create(array $data)
    {
        $table = Database::getTableName('users');
        $stmt = $this->db->prepare(
            "INSERT INTO `$table` (first_name, last_name, email, password, token, status, barangay, created_at) VALUES (?,?,?,?,?,?,?, NOW())"
        );
        return $stmt->execute([
            $data['first_name'],
            $data['last_name'],
            $data['email'],
            $data['password'],
            $data['token'],
            $data['status'],
            $data['barangay'] ?? null
        ]);
    }

    public function activate(string $email)
    {
        $table = Database::getTableName('users');
        $stmt = $this->db->prepare("UPDATE `$table` SET status='active', token='' WHERE email=?");
        return $stmt->execute([$email]);
    }

    public function getAllUsers()
    {
        $table = Database::getTableName('users');
        $stmt = $this->db->prepare("SELECT id, first_name, last_name, email, role, status, barangay, created_at FROM `$table` ORDER BY created_at DESC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getUserById($id)
    {
        $table = Database::getTableName('users');
        $stmt = $this->db->prepare("SELECT id, first_name, last_name, email, role, status, barangay, created_at FROM `$table` WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function updateUser($id, $data)
    {
        $table = Database::getTableName('users');
        $stmt = $this->db->prepare(
            "UPDATE `$table` SET first_name = ?, last_name = ?, email = ?, role = ?, status = ?, barangay = ? WHERE id = ?"
        );
        return $stmt->execute([
            $data['first_name'],
            $data['last_name'],
            $data['email'],
            $data['role'],
            $data['status'],
            $data['barangay'] ?? null,
            $id
        ]);
    }

    public function updateUserPassword($id, $password)
    {
        $table = Database::getTableName('users');
        $stmt = $this->db->prepare("UPDATE `$table` SET password = ? WHERE id = ?");
        return $stmt->execute([$password, $id]);
    }

    public function deleteUser($id)
    {
        $table = Database::getTableName('users');
        $stmt = $this->db->prepare("DELETE FROM `$table` WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function emailExists($email, $excludeId = null)
    {
        $table = Database::getTableName('users');
        $sql = "SELECT id FROM `$table` WHERE email = ?";
        $params = [$email];
        
        if ($excludeId) {
            $sql .= ' AND id != ?';
            $params[] = $excludeId;
        }
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch() !== false;
    }

    public function getUserStats()
    {
        $table = Database::getTableName('users');
        $stats = [];
        
        // Total users
        $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM `$table`");
        $stmt->execute();
        $stats['total'] = $stmt->fetch()['total'];
        
        // Active users
        $stmt = $this->db->prepare("SELECT COUNT(*) as active FROM `$table` WHERE status = \"active\"");
        $stmt->execute();
        $stats['active'] = $stmt->fetch()['active'];
        
        // Inactive users
        $stmt = $this->db->prepare("SELECT COUNT(*) as inactive FROM `$table` WHERE status = \"inactive\"");
        $stmt->execute();
        $stats['inactive'] = $stmt->fetch()['inactive'];
        
        // Admin users
        $stmt = $this->db->prepare("SELECT COUNT(*) as admin FROM `$table` WHERE role = \"admin\" OR role LIKE \"admin_%\"");
        $stmt->execute();
        $stats['admin'] = $stmt->fetch()['admin'];
        
        // Regular users
        $stmt = $this->db->prepare("SELECT COUNT(*) as user FROM `$table` WHERE role = \"user\"");
        $stmt->execute();
        $stats['user'] = $stmt->fetch()['user'];
        
        return $stats;
    }
}
