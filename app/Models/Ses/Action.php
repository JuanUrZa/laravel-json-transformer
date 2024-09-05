<?php

namespace App\Models\Ses;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Action
{
    public string $type;
    public string $topicArn;

    public function __construct(string $type, string $topicArn)
    {
        $this->type = $type;
        $this->topicArn = $topicArn;
    }
}
