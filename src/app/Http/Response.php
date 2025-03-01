<?php

namespace App\Http;

trait Response
{
    /**
     * @param int $statusCode
     * @param array<string,mixed> $data
     * @return void
     */
    protected function json(int $statusCode, array $data = []): void
    {
        header('Content-Type: application/json');
        http_response_code($statusCode);
        if (!empty($data)) {
            echo json_encode($data, JSON_PRETTY_PRINT);
        }
    }
}
