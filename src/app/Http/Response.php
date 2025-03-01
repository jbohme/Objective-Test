<?php

namespace App\Http;

trait Response
{
    protected function json(int $statusCode, array $data = []): void
    {
        header('Content-Type: application/json');
        http_response_code($statusCode);
        if (!empty($data)) {
            echo json_encode($data, JSON_PRETTY_PRINT);
        }
    }
}
