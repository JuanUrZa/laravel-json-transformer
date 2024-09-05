<?php

namespace App\Models\Ses;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

namespace App\Models\Ses;

class CommonHeaders
{
    public string $returnPath;
    public array $from;
    public string $date;
    public array $to;
    public string $messageId;
    public string $subject;

    public function __construct(
        string $returnPath,
        array $from,
        string $date,
        array $to,
        string $messageId,
        string $subject
    ) {
        $this->returnPath = $returnPath;
        $this->from = $from;
        $this->date = $date;
        $this->to = $to;
        $this->messageId = $messageId;
        $this->subject = $subject;
    }
}

