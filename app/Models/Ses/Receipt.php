<?php

namespace App\Models\Ses;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receipt
{
    public string $timestamp;
    public int $processingTimeMillis;
    public array $recipients;
    public SpamVerdict $spamVerdict;
    public VirusVerdict $virusVerdict;
    public SpfVerdict $spfVerdict;
    public DkimVerdict $dkimVerdict;
    public DmarcVerdict $dmarcVerdict;
    public string $dmarcPolicy;
    public Action $action;

    public function __construct(
        string $timestamp,
        int $processingTimeMillis,
        array $recipients,
        SpamVerdict $spamVerdict,
        VirusVerdict $virusVerdict,
        SpfVerdict $spfVerdict,
        DkimVerdict $dkimVerdict,
        DmarcVerdict $dmarcVerdict,
        string $dmarcPolicy,
        Action $action
    ) {
        $this->timestamp = $timestamp;
        $this->processingTimeMillis = $processingTimeMillis;
        $this->recipients = $recipients;
        $this->spamVerdict = $spamVerdict;
        $this->virusVerdict = $virusVerdict;
        $this->spfVerdict = $spfVerdict;
        $this->dkimVerdict = $dkimVerdict;
        $this->dmarcVerdict = $dmarcVerdict;
        $this->dmarcPolicy = $dmarcPolicy;
        $this->action = $action;
    }
}
