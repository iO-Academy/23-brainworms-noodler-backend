<?php


namespace App\Models;

use App\Factories\Entities\UserEntity;
use PDO;

class UserModel
{
    private PDO $db;

    /**
     * Creates UserModel constructor.
     */
    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    /**
     * Gets email and password from database to login.
     */
    public function getUserByEmail($userEmail): array
    {
        if ($this->validateEmail($userEmail) !== false) {
            $query = $this->db->prepare("SELECT `id`, `email`, `password` FROM `users` WHERE `email` = :email;");
            $query->bindParam(':email', $userEmail);
            $query->execute();
            $result = $query->fetch();
            if($result) {
                return $result;
            } else {
                return [];
            }
        }
        return [];
    }

    public function getUserByEmailOrUsername($userEmail, $username): array
    {
        if ($this->validateEmail($userEmail) !== false) {
            $query = $this->db->prepare("SELECT `email`, `username` FROM `users` WHERE `email` = :email OR `username` = :username;");
            $query->bindParam(':email', $userEmail);
            $query->bindParam(':username', $username);
            $query->execute();
            $result = $query->fetch();
            if($result) {
                return $result;
            } else {
                return [];
            }
        }
        return [];
    }


    /**
     * Verifies user credentials by comparing form input with email and hashed password in database
     */
    public function userLoginVerify(string $userEmail, string $password, $userCredentials): bool
    {
        if (
            (!empty($userCredentials)) &&
            ($userEmail === $userCredentials['email']) &&
            (password_verify($password, $userCredentials['password']))
        ) {
            return true;
        }
        return false;
    }

    /**
     * Inserts new user into database - registering.
     */
    public function insertNewUserToDb(string $registerUsername, string $registerDescription, string $registerEmail, string $registerPassword): int
    {
        $query = $this->db->prepare(
            "INSERT INTO `users` (`username`, `description`, `email`, `password`) VALUES (:username, :description, :email, :password);"
        );
        $query->bindParam(':username', $registerUsername);
        $query->bindParam(':description', $registerDescription);
        $query->bindParam(':email', $registerEmail);
        $query->bindParam(':password', $registerPassword);
        $query->execute();
        return $this->db->lastInsertId();
    }

    /** Validates if parameter is an email
     *
     * @return mixed returns the email as a string if its a valid email otherwise it returns false
     */
    public function validateEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public function getUserDataById($userId): ?UserEntity
    {
        $query = $this->db->prepare("SELECT `username`, `description` FROM `users` WHERE `id` = :id;");
        $query->setFetchMode(PDO::FETCH_CLASS, UserEntity::class);
        $query->execute([$userId]);
        return $query->fetch();
    }
}
