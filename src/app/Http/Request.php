<?php

namespace App\Http;

use App\Entities\Enums\PaymentMethods;
use InvalidArgumentException;

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
     * @return mixed
     */
    public function get(string $key): mixed
    {
        return $this->body[$key] ?? $this->query[$key] ?? null;
    }

    /**
     * @return array<string,mixed>
     */
    public function all(): array
    {
        return array_merge($this->query, $this->body);
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function query(string $key): mixed
    {
        return $this->query[$key] ?? null;
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function body(string $key): mixed
    {
        return $this->body[$key];
    }

    /**
     * @param array<string, string> $rules
     * @return void
     * @throws InvalidArgumentException
     */
    public function validate(array $rules): void
    {
        foreach ($rules as $field => $rule) {
            $value = $this->get($field);

            if (is_null($value)) {
                throw new InvalidArgumentException("$field is required");
            }
            $validationOptions = explode('|', $rule);
            foreach ($validationOptions as $validationOption) {
                $error = false;
                switch ($validationOption) {
                    case 'integer':
                        if (!is_int($value)) {
                            $error = true;
                        }
                        break;
                    case 'float':
                        if (!is_float($value)) {
                            $error = true;
                        }
                        break;
                    case 'string':
                        if (!is_string($value)) {
                            $error = true;
                        }
                        break;
                    case 'PaymentMethod':
                        if (!in_array(
                            $value,
                            array_map(fn (PaymentMethods $method) => $method->value, PaymentMethods::cases())
                        )) {
                            $error = true;
                        }
                        break;
                }
                if ($error) {
                    throw new InvalidArgumentException("$field must be of type $validationOption");
                }
            }
        }
    }
}
