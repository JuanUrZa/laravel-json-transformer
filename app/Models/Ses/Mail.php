<?php

namespace App\Models\Ses;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mail
{
    public string $timestamp;

    public string $source;
    public string $messageId;
    public array $destination;
    public bool $headersTruncated;
    public array $headers;
    public CommonHeaders $commonHeaders;

    public function __construct(
        string $timestamp,
        string $source,
        string $messageId,
        array $destination,
        bool $headersTruncated,
        array $headers,
        CommonHeaders $commonHeaders
    ) {
        $this->timestamp = $timestamp;
        $this->source = $source;
        $this->messageId = $messageId;
        $this->destination = $destination;
        $this->headersTruncated = $headersTruncated;
        $this->headers = $headers;
        $this->commonHeaders = $commonHeaders;
    }
}
