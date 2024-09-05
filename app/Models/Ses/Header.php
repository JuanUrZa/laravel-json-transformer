<?php

namespace App\Models\Ses;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Header
{
    public string $name;
    public string $value;

    public function __construct(string $name, string $value)
    {
        $this->name = $name;
        $this->value = $value;
    }

    public static function fromArray(array $data): self
    {
        return new self($data['name'], $data['value']);
    }
}
