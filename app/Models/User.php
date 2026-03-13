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
}
