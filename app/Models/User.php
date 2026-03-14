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
        $stmt = $this->db->prepare('SELECT * FROM users WHERE email = ?');
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    public function create(array $data)
    {
        $stmt = $this->db->prepare(
            'INSERT INTO users (first_name, last_name, email, password, token, status, created_at) VALUES (?,?,?,?,?,?, NOW())'
        );
        return $stmt->execute([
            $data['first_name'],
            $data['last_name'],
            $data['email'],
            $data['password'],
            $data['token'],
            $data['status']
        ]);
    }

    public function activate(string $email)
    {
        $stmt = $this->db->prepare("UPDATE users SET status='active', token='' WHERE email=?");
        return $stmt->execute([$email]);
    }

    public function getAllUsers()
    {
        $stmt = $this->db->prepare('SELECT id, first_name, last_name, email, role, status, created_at FROM users ORDER BY created_at DESC');
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getUserById($id)
    {
        $stmt = $this->db->prepare('SELECT id, first_name, last_name, email, role, status, created_at FROM users WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function updateUser($id, $data)
    {
        $stmt = $this->db->prepare(
            'UPDATE users SET first_name = ?, last_name = ?, email = ?, role = ?, status = ? WHERE id = ?'
        );
        return $stmt->execute([
            $data['first_name'],
            $data['last_name'],
            $data['email'],
            $data['role'],
            $data['status'],
            $id
        ]);
    }

    public function updateUserPassword($id, $password)
    {
        $stmt = $this->db->prepare('UPDATE users SET password = ? WHERE id = ?');
        return $stmt->execute([$password, $id]);
    }

    public function deleteUser($id)
    {
        $stmt = $this->db->prepare('DELETE FROM users WHERE id = ?');
        return $stmt->execute([$id]);
    }

    public function emailExists($email, $excludeId = null)
    {
        $sql = 'SELECT id FROM users WHERE email = ?';
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
        $stats = [];
        
        // Total users
        $stmt = $this->db->prepare('SELECT COUNT(*) as total FROM users');
        $stmt->execute();
        $stats['total'] = $stmt->fetch()['total'];
        
        // Active users
        $stmt = $this->db->prepare('SELECT COUNT(*) as active FROM users WHERE status = "active"');
        $stmt->execute();
        $stats['active'] = $stmt->fetch()['active'];
        
        // Inactive users
        $stmt = $this->db->prepare('SELECT COUNT(*) as inactive FROM users WHERE status = "inactive"');
        $stmt->execute();
        $stats['inactive'] = $stmt->fetch()['inactive'];
        
        // Admin users
        $stmt = $this->db->prepare('SELECT COUNT(*) as admin FROM users WHERE role = "admin"');
        $stmt->execute();
        $stats['admin'] = $stmt->fetch()['admin'];
        
        // Regular users
        $stmt = $this->db->prepare('SELECT COUNT(*) as user FROM users WHERE role = "user"');
        $stmt->execute();
        $stats['user'] = $stmt->fetch()['user'];
        
        return $stats;
    }
}
