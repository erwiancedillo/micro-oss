<?php

require_once __DIR__ . '/../app/Models/Database.php';

use App\Models\Database;

try {
    $db = Database::getInstance()->getConnection();
    echo "Connected to database successfully.\n";

    // 1. Get all base tables
    $stmt = $db->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);

    foreach ($tables as $table) {
        // Skip tables already suffixed with _lizada or _dalio
        if (preg_match('/_(lizada|dalio)$/', $table)) {
            continue;
        }

        echo "Processing table: $table\n";

        // Create Lizada and Dalio duplicates
        foreach (['lizada', 'dalio'] as $barangay) {
            $newTable = "{$table}_{$barangay}";
            
            // Re-create structure
            $db->exec("CREATE TABLE IF NOT EXISTS `$newTable` LIKE `$table`");
            echo "  Created table structure: $newTable\n";

            // Check if base table has a 'barangay' column
            $descStmt = $db->query("DESCRIBE `$table`");
            $columns = $descStmt->fetchAll(PDO::FETCH_COLUMN);
            $hasBarangayCol = in_array('barangay', $columns);

            if ($hasBarangayCol) {
                // Copy data
                $checkEmpty = $db->query("SELECT COUNT(*) FROM `$newTable`")->fetchColumn();
                if ($checkEmpty == 0) {
                    $insertSql = "INSERT INTO `$newTable` SELECT * FROM `$table` WHERE LOWER(`barangay`) = " . $db->quote($barangay);
                    $db->exec($insertSql);
                    echo "    Migrated data to $newTable where barangay = '$barangay'\n";
                }
            } else {
                echo "    No 'barangay' column, table created empty.\n";
            }
        }
    }

    // 2. Add foreign keys to duplicated hazard_focus_points tables if not already present
    // First, let's check if the base table hazard_focus_points exists and recreate the foreign keys
    if (in_array('hazard_focus_points', $tables)) {
        foreach (['lizada', 'dalio'] as $barangay) {
            $newTable = "hazard_focus_points_{$barangay}";
            $refTable = "hazard_maps_{$barangay}";
            
            // Check if foreign key constraint exists already
            $fkExists = $db->query("
                SELECT CONSTRAINT_NAME 
                FROM information_schema.REFERENTIAL_CONSTRAINTS 
                WHERE CONSTRAINT_SCHEMA = 'micro_oss' 
                  AND TABLE_NAME = '$newTable' 
                  AND CONSTRAINT_NAME = 'fk_{$newTable}_map_id'
            ")->fetchColumn();

            if (!$fkExists) {
                try {
                    $db->exec("
                        ALTER TABLE `$newTable` 
                        ADD CONSTRAINT `fk_{$newTable}_map_id` 
                        FOREIGN KEY (hazard_map_id) 
                        REFERENCES `$refTable`(id) 
                        ON DELETE CASCADE ON UPDATE CASCADE
                    ");
                    echo "  Added foreign key constraint to $newTable referencing $refTable\n";
                } catch (Exception $e) {
                    echo "  Could not add foreign key to $newTable: " . $e->getMessage() . "\n";
                }
            }
        }
    }

    // 3. Update existing admins in the base users table to have valid roles and barangay fields
    $adminsToUpdate = [
        'admin@gmail.com' => ['role' => 'admin_dalio', 'barangay' => 'Dalio'],
        'erwin.acedillo@gmail.com' => ['role' => 'admin_lizada', 'barangay' => 'Lizada'],
        'erwinacedillo@gmail.com' => ['role' => 'admin_lizada', 'barangay' => 'Lizada'],
        'vincentcrame14@gmail.com' => ['role' => 'admin_lizada', 'barangay' => 'Lizada'],
    ];

    foreach ($adminsToUpdate as $email => $info) {
        $checkStmt = $db->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
        $checkStmt->execute([$email]);
        if ($checkStmt->fetchColumn() > 0) {
            $updateStmt = $db->prepare("UPDATE users SET role = ?, barangay = ?, status = 'active' WHERE email = ?");
            $updateStmt->execute([$info['role'], $info['barangay'], $email]);
            echo "Updated admin user status for $email to {$info['role']} / {$info['barangay']}\n";
        }
    }

    echo "Migration completed successfully!\n";

} catch (Exception $e) {
    die("Migration failed: " . $e->getMessage() . "\n");
}
