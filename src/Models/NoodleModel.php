<?php


namespace App\Models;

use App\Entities\NoodleEntity;
use PDO;

class NoodleModel
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getNoodlesByUserId($id): array
    {
        $query = $this->db->prepare("SELECT `id`, `time`, `noodle` FROM `noodles` WHERE `user_id` = :userId;");
        $query->bindParam(':userId', $id);
        $query->setFetchMode(PDO::FETCH_CLASS, NoodleEntity::class);
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    }
}
