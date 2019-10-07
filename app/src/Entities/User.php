<?php declare(strict_types=1);

namespace App\Entities;

class User
{
    private $id;
    private $login;

    public function __construct(
        int $id,
        string $login
    )
    {
        $this->id = $id;
        $this->login = $login;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getLogin(): string
    {
        return $this->login;
    }
}