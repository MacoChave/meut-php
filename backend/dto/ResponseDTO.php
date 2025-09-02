<?php

namespace DTO;

class ResponseDTO
{
    public int $status;
    public ?array $data;
    public ?string $error;

    public function __construct(int $status, ?array $data = null, ?string $error = null)
    {
        $this->status = $status;
        $this->data = $data;
        $this->error = $error;
    }
}
