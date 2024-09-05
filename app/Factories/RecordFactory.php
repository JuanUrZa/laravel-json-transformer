<?php

namespace App\Factories;

use App\Models\Ses\Record;
use App\Models\Ses\Ses;
use App\Models\Ses\Receipt;
use App\Models\Ses\Mail;
use App\Models\Ses\Action;
use App\Models\Ses\SpamVerdict;
use App\Models\Ses\VirusVerdict;
use App\Models\Ses\SpfVerdict;
use App\Models\Ses\DkimVerdict;
use App\Models\Ses\DmarcVerdict;
use App\Models\Ses\CommonHeaders;
use App\Models\Ses\Header;

class RecordFactory
{
    public static function createFromJson(array $data): Record
    {
        $action = new Action(
            $data['ses']['receipt']['action']['type'],
            $data['ses']['receipt']['action']['topicArn']
        );

        $receipt = new Receipt(
            $data['ses']['receipt']['timestamp'],
            $data['ses']['receipt']['processingTimeMillis'],
            $data['ses']['receipt']['recipients'],
            new SpamVerdict($data['ses']['receipt']['spamVerdict']['status']),
            new VirusVerdict($data['ses']['receipt']['virusVerdict']['status']),
            new SpfVerdict($data['ses']['receipt']['spfVerdict']['status']),
            new DkimVerdict($data['ses']['receipt']['dkimVerdict']['status']),
            new DmarcVerdict($data['ses']['receipt']['dmarcVerdict']['status']),
            $data['ses']['receipt']['dmarcPolicy'],
            $action
        );

        $headers = [];
        foreach ($data['ses']['mail']['headers'] as $header) {
            $headers[] = Header::fromArray($header);
        }

        $commonHeaders = new CommonHeaders(
            $data['ses']['mail']['commonHeaders']['returnPath'],
            $data['ses']['mail']['commonHeaders']['from'],
            $data['ses']['mail']['commonHeaders']['date'],
            $data['ses']['mail']['commonHeaders']['to'],
            $data['ses']['mail']['commonHeaders']['messageId'],
            $data['ses']['mail']['commonHeaders']['subject']
        );

        $mail = new Mail(
            $data['ses']['mail']['timestamp'],
            $data['ses']['mail']['source'],
            $data['ses']['mail']['messageId'],
            $data['ses']['mail']['destination'],
            $data['ses']['mail']['headersTruncated'],
            $headers,
            $commonHeaders
        );

        $ses = new Ses($receipt, $mail);

        return new Record(
            $data['eventVersion'],
            $ses,
            $data['eventSource']
        );
    }

    public static function createFromJsonArray(array $jsonArray): array
    {
        $records = [];
        foreach ($jsonArray as $recordData) {
            $records[] = self::createFromJson($recordData);
        }
        return $records;
    }
}
