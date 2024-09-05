<?php

namespace App\Models\Ses;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Record {
    public string $eventVersion;

    public Ses $ses;
    public string $eventSource;

    public function __construct(string $eventVersion, SES $ses, string $eventSource) {
        $this->eventVersion = $eventVersion;
        $this->ses = $ses;
        $this->eventSource = $eventSource;
    }
}
