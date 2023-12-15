<?php

namespace App\Entities;

class NoodleEntity implements \JsonSerializable
{
    private int $id;
    private string $time;
    private string $noodle;

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'time' => $this->time,
            'noodle' => $this->noodle
        ];
    }
}
