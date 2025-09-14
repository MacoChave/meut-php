<?php

namespace DTO;

class LoginResponseDTO
{
    public int $userId;
    public string $token;

    public function __construct(int $userId, string $token)
    {
        $this->userId = $userId;
        $this->token = $token;
    }
}
