<?php

namespace App\Models\Ses;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VirusVerdict
{
    public string $status;

    public function __construct(string $status)
    {
        $this->status = $status;
    }

    public static function fromArray(array $data): self
    {
        return new self($data['status']);
    }
}
