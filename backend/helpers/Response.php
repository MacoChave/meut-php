<?php

namespace Helpers;

use DTO\ResponseDTO;

class Response
{
    public static function jsonResponse(int $status, $data = null, ?string $error = null): void
    {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode(new ResponseDTO($status, $data, $error));
    }
}
