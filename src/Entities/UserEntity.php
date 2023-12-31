<?php

namespace App\Entities;

class UserEntity implements \JsonSerializable
{
    private int $id;
    private string $username;
    private string $description;
    private string $email;
    private string $password;

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'description' => $this->description,
            'email' => $this->email
        ];
    }
}