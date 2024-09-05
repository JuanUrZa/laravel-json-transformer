<?php
// app/Transformers/UserTransformer.php

namespace App\Transformers;

use App\Models\Ses\Record;
use League\Fractal\TransformerAbstract;

class EmailAnalysisTransformer extends TransformerAbstract
{
    public function transform(Record $record): array
    {
        $ses = $record->ses;

        $spamVerdict = $ses->receipt->spamVerdict->status === 'PASS';
        $virusVerdict = $ses->receipt->virusVerdict->status === 'PASS';
        $spfVerdict = $ses->receipt->spfVerdict->status === 'PASS';
        $dkimVerdict = $ses->receipt->dkimVerdict->status === 'PASS';
        $dmarcVerdict = $ses->receipt->dmarcVerdict->status === 'PASS';

        $dnsVerdict = $spfVerdict && $dkimVerdict && $dmarcVerdict;

        $timestamp = date('F', strtotime($ses->receipt->timestamp));
        $processingTimeMillis = $ses->receipt->processingTimeMillis;
        $retrasado = $processingTimeMillis > 1000;

        $emisor = explode('@', $ses->mail->source)[0] ?? '';
        $receptores = array_map(function($email) {
            return explode('@', $email)[0];
        }, $ses->mail->destination);

        return [
            'spam' => $spamVerdict,
            'virus' => $virusVerdict,
            'dns' => $dnsVerdict,
            'mes' => $timestamp,
            'retrasado' => $retrasado,
            'emisor' => $emisor,
            'receptor' => $receptores
        ];
    }

}
