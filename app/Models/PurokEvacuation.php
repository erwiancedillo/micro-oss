<?php

namespace App\Models;

class PurokEvacuation
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAllData()
    {
        return [];
    }
}
