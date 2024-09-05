<?php

namespace App\Models\Ses;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ses
{
    public Receipt $receipt;
    public Mail $mail;

    public function __construct(Receipt $receipt, Mail $mail)
    {
        $this->receipt = $receipt;
        $this->mail = $mail;
    }
}
