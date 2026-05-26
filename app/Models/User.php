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
        if (isset($_SESSION['admin_barangay']) && $_SESSION['admin_barangay'] === 'master') {
            $stmt = $this->db->prepare("
                SELECT id, first_name, last_name, email, role, status, barangay, created_at, 'Lizada' as source_table FROM users_lizada
                UNION ALL
                SELECT id, first_name, last_name, email, role, status, barangay, created_at, 'Dalio' as source_table FROM users_dalio
                UNION ALL
                SELECT id, first_name, last_name, email, role, status, barangay, created_at, 'Base' as source_table FROM users 
                WHERE role = 'master' OR status = 'inactive'
                ORDER BY created_at DESC
            ");
            $stmt->execute();
            return $stmt->fetchAll();
        } else {
            $table = Database::getTableName('users');
            $stmt = $this->db->prepare("SELECT id, first_name, last_name, email, role, status, barangay, created_at FROM `$table` ORDER BY created_at DESC");
            $stmt->execute();
            return $stmt->fetchAll();
        }
    }

    public function getUserById($id)
    {
        if (isset($_SESSION['admin_barangay']) && $_SESSION['admin_barangay'] === 'master') {
            // Check Lizada first
            $stmt = $this->db->prepare("SELECT id, first_name, last_name, email, role, status, barangay, created_at FROM users_lizada WHERE id = ?");
            $stmt->execute([$id]);
            $user = $stmt->fetch();
            if ($user) return $user;
            
            // Check Dalio
            $stmt = $this->db->prepare("SELECT id, first_name, last_name, email, role, status, barangay, created_at FROM users_dalio WHERE id = ?");
            $stmt->execute([$id]);
            $user = $stmt->fetch();
            if ($user) return $user;

            // Check Base users table
            $stmt = $this->db->prepare("SELECT id, first_name, last_name, email, role, status, barangay, created_at FROM users WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch();
        } else {
            $table = Database::getTableName('users');
            $stmt = $this->db->prepare("SELECT id, first_name, last_name, email, role, status, barangay, created_at FROM `$table` WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch();
        }
    }

    public function updateUser($id, $data)
    {
        $table = Database::getTableName('users');
        $isMaster = isset($_SESSION['admin_barangay']) && $_SESSION['admin_barangay'] === 'master';

        // Map general admin role to barangay-specific role for dynamic mappings
        $role = $data['role'];
        $barangay = $data['barangay'] ?? '';
        if ($role === 'admin') {
            if (strtolower($barangay) === 'lizada') {
                $role = 'admin_lizada';
            } elseif (strtolower($barangay) === 'dalio') {
                $role = 'admin_dalio';
            }
        }

        if ($isMaster) {
            // Find which table has this user
            $targetTable = 'users'; // default
            
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM users_lizada WHERE id = ?");
            $stmt->execute([$id]);
            if ($stmt->fetchColumn() > 0) {
                $targetTable = 'users_lizada';
            } else {
                $stmt = $this->db->prepare("SELECT COUNT(*) FROM users_dalio WHERE id = ?");
                $stmt->execute([$id]);
                if ($stmt->fetchColumn() > 0) {
                    $targetTable = 'users_dalio';
                }
            }

            // 1. Update the record in the target table (either users_lizada, users_dalio, or base users)
            $stmt = $this->db->prepare(
                "UPDATE `$targetTable` SET first_name = ?, last_name = ?, email = ?, role = ?, status = ?, barangay = ? WHERE id = ?"
            );
            $stmt->execute([
                $data['first_name'],
                $data['last_name'],
                $data['email'],
                $role,
                $data['status'],
                $data['barangay'] ?? null,
                $id
            ]);

            // 2. Also keep the base users table updated so the main login can always authenticates them
            if ($targetTable !== 'users') {
                $stmt = $this->db->prepare(
                    "UPDATE users SET first_name = ?, last_name = ?, email = ?, role = ?, status = ?, barangay = ? WHERE id = ?"
                );
                $stmt->execute([
                    $data['first_name'],
                    $data['last_name'],
                    $data['email'],
                    $role,
                    $data['status'],
                    $data['barangay'] ?? null,
                    $id
                ]);
            }

            // 3. If approval is occurring (status changed from inactive to active in the base table)
            // and it hasn't been copied to the barangay-specific table yet
            if ($targetTable === 'users' && $data['status'] === 'active') {
                $bLower = strtolower($barangay);
                if (in_array($bLower, ['lizada', 'dalio'])) {
                    $destTable = "users_" . $bLower;
                    
                    // Fetch full user from base users to get the password
                    $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
                    $stmt->execute([$id]);
                    $fullUser = $stmt->fetch();
                    
                    if ($fullUser) {
                        // Check if already in destination
                        $checkStmt = $this->db->prepare("SELECT COUNT(*) FROM `$destTable` WHERE id = ?");
                        $checkStmt->execute([$id]);
                        if ($checkStmt->fetchColumn() == 0) {
                            $insertStmt = $this->db->prepare(
                                "INSERT INTO `$destTable` (id, first_name, last_name, email, password, role, status, barangay, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"
                            );
                            $insertStmt->execute([
                                $fullUser['id'],
                                $fullUser['first_name'],
                                $fullUser['last_name'],
                                $fullUser['email'],
                                $fullUser['password'],
                                $role,
                                'active',
                                $fullUser['barangay'],
                                $fullUser['created_at']
                            ]);
                        }
                    }
                }
            }
            
            return true;
        } else {
            $stmt = $this->db->prepare(
                "UPDATE `$table` SET first_name = ?, last_name = ?, email = ?, role = ?, status = ?, barangay = ? WHERE id = ?"
            );
            $res = $stmt->execute([
                $data['first_name'],
                $data['last_name'],
                $data['email'],
                $role,
                $data['status'],
                $data['barangay'] ?? null,
                $id
            ]);
            
            // Also update the base users table so authentication remains in sync
            $stmt = $this->db->prepare(
                "UPDATE users SET first_name = ?, last_name = ?, email = ?, role = ?, status = ?, barangay = ? WHERE id = ?"
            );
            $stmt->execute([
                $data['first_name'],
                $data['last_name'],
                $data['email'],
                $role,
                $data['status'],
                $data['barangay'] ?? null,
                $id
            ]);
            
            return $res;
        }
    }

    public function updateUserPassword($id, $password)
    {
        $table = Database::getTableName('users');
        $isMaster = isset($_SESSION['admin_barangay']) && $_SESSION['admin_barangay'] === 'master';

        if ($isMaster) {
            $tables = ['users', 'users_lizada', 'users_dalio'];
            foreach ($tables as $t) {
                $stmt = $this->db->prepare("SELECT COUNT(*) FROM `$t` WHERE id = ?");
                $stmt->execute([$id]);
                if ($stmt->fetchColumn() > 0) {
                    $stmt = $this->db->prepare("UPDATE `$t` SET password = ? WHERE id = ?");
                    $stmt->execute([$password, $id]);
                }
            }
            return true;
        } else {
            $stmt = $this->db->prepare("UPDATE `$table` SET password = ? WHERE id = ?");
            $res = $stmt->execute([$password, $id]);
            
            // Also update the base users table
            $stmt = $this->db->prepare("UPDATE users SET password = ? WHERE id = ?");
            $stmt->execute([$password, $id]);
            
            return $res;
        }
    }

    public function deleteUser($id)
    {
        if (isset($_SESSION['admin_barangay']) && $_SESSION['admin_barangay'] === 'master') {
            $this->db->prepare("DELETE FROM users WHERE id = ?")->execute([$id]);
            $this->db->prepare("DELETE FROM users_lizada WHERE id = ?")->execute([$id]);
            $this->db->prepare("DELETE FROM users_dalio WHERE id = ?")->execute([$id]);
            return true;
        } else {
            $table = Database::getTableName('users');
            $stmt = $this->db->prepare("DELETE FROM `$table` WHERE id = ?");
            return $stmt->execute([$id]);
        }
    }

    public function emailExists($email, $excludeId = null)
    {
        $table = Database::getTableName('users');
        $isMaster = isset($_SESSION['admin_barangay']) && $_SESSION['admin_barangay'] === 'master';

        if ($isMaster) {
            // Check across all tables for master account
            $tables = ['users', 'users_lizada', 'users_dalio'];
            foreach ($tables as $t) {
                $sql = "SELECT id FROM `$t` WHERE email = ?";
                $params = [$email];
                if ($excludeId) {
                    $sql .= ' AND id != ?';
                    $params[] = $excludeId;
                }
                $stmt = $this->db->prepare($sql);
                $stmt->execute($params);
                if ($stmt->fetch() !== false) return true;
            }
            return false;
        } else {
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
    }

    public function getUserStats()
    {
        if (isset($_SESSION['admin_barangay']) && $_SESSION['admin_barangay'] === 'master') {
            $stats = ['total' => 0, 'active' => 0, 'inactive' => 0, 'admin' => 0, 'user' => 0];
            
            $tables = ['users_lizada', 'users_dalio', 'users'];
            foreach ($tables as $t) {
                $whereClause = ($t === 'users') ? "WHERE role = 'master' OR status = 'inactive'" : "";
                
                $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM `$t` $whereClause");
                $stmt->execute();
                $stats['total'] += $stmt->fetch()['total'];
                
                $stmt = $this->db->prepare("SELECT COUNT(*) as active FROM `$t` " . ($t === 'users' ? "WHERE (role = 'master' OR status = 'inactive') AND status = 'active'" : "WHERE status = 'active'"));
                $stmt->execute();
                $stats['active'] += $stmt->fetch()['active'];
                
                $stmt = $this->db->prepare("SELECT COUNT(*) as inactive FROM `$t` " . ($t === 'users' ? "WHERE (role = 'master' OR status = 'inactive') AND status = 'inactive'" : "WHERE status = 'inactive'"));
                $stmt->execute();
                $stats['inactive'] += $stmt->fetch()['inactive'];
                
                $stmt = $this->db->prepare("SELECT COUNT(*) as admin FROM `$t` " . ($t === 'users' ? "WHERE (role = 'master' OR status = 'inactive') AND (role = 'admin' OR role LIKE 'admin_%' OR role = 'master')" : "WHERE role = 'admin' OR role LIKE 'admin_%'"));
                $stmt->execute();
                $stats['admin'] += $stmt->fetch()['admin'];
                
                $stmt = $this->db->prepare("SELECT COUNT(*) as user FROM `$t` " . ($t === 'users' ? "WHERE (role = 'master' OR status = 'inactive') AND role = 'user'" : "WHERE role = 'user'"));
                $stmt->execute();
                $stats['user'] += $stmt->fetch()['user'];
            }
            return $stats;
        } else {
            $table = Database::getTableName('users');
            $stats = [];
            
            $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM `$table`");
            $stmt->execute();
            $stats['total'] = $stmt->fetch()['total'];
            
            $stmt = $this->db->prepare("SELECT COUNT(*) as active FROM `$table` WHERE status = \"active\"");
            $stmt->execute();
            $stats['active'] = $stmt->fetch()['active'];
            
            $stmt = $this->db->prepare("SELECT COUNT(*) as inactive FROM `$table` WHERE status = \"inactive\"");
            $stmt->execute();
            $stats['inactive'] = $stmt->fetch()['inactive'];
            
            $stmt = $this->db->prepare("SELECT COUNT(*) as admin FROM `$table` WHERE role = \"admin\" OR role LIKE \"admin_%\"");
            $stmt->execute();
            $stats['admin'] = $stmt->fetch()['admin'];
            
            $stmt = $this->db->prepare("SELECT COUNT(*) as user FROM `$table` WHERE role = \"user\"");
            $stmt->execute();
            $stats['user'] = $stmt->fetch()['user'];
            
            return $stats;
        }
    }
}
