<?php

namespace App\Http;

readonly class Request
{
    /**
     * @param array<string,string> $query
     * @param array<string,string> $body
     */
    public function __construct(
        private array $query = [],
        private array $body = [],
    ) {
    }

    /**
     * @param string $key
     * @param mixed|null $default
     * @return string|null
     */
    public function get(string $key, mixed $default = null): ?string
    {
        $value = $this->body[$key] ?? $this->query[$key] ?? $default;
        return is_scalar($value) ? (string) $value : null;
    }

    /**
     * @return array<string,string>
     */
    public function all(): array
    {
        return array_merge($this->query, $this->body);
    }

    /**
     * @param string $key
     * @param mixed|null $default
     * @return string|null
     */
    public function query(string $key, mixed $default = null): ?string
    {
        $value = $this->query[$key] ?? $default;
        return is_scalar($value) ? (string) $value : null;
    }

    /**
     * @param string $key
     * @param mixed|null $default
     * @return string|null
     */
    public function body(string $key, mixed $default = null): ?string
    {
        $value = $this->body[$key] ?? $default;
        return is_scalar($value) ? (string) $value : null;
    }
}
