<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TheEasyOneController extends TestCase
{
    public function testTransformJson()
    {
        $json = [
            "Records" => [
                [
                    "eventVersion" => "1.0",
                    "ses" => [
                        "receipt" => [
                            "timestamp" => "2015-09-11T20:32:33.936Z",
                            "processingTimeMillis" => 222,
                            "recipients" => [
                                "recipient@example.com"
                            ],
                            "spamVerdict" => [
                                "status" => "PASS"
                            ],
                            "virusVerdict" => [
                                "status" => "PASS"
                            ],
                            "spfVerdict" => [
                                "status" => "PASS"
                            ],
                            "dkimVerdict" => [
                                "status" => "PASS"
                            ],
                            "dmarcVerdict" => [
                                "status" => "PASS"
                            ],
                            "dmarcPolicy" => "reject",
                            "action" => [
                                "type" => "SNS",
                                "topicArn" => "arn:aws:sns:us-east-1:012345678912:example-topic"
                            ]
                        ],
                        "mail" => [
                            "timestamp" => "2015-09-11T20:32:33.936Z",
                            "source" => "61967230-7A45-4A9D-BEC9-87CBCF2211C9@example.com",
                            "messageId" => "d6iitobk75ur44p8kdnnp7g2n800",
                            "destination" => [
                                "recipient@example.com"
                            ],
                            "headersTruncated" => false,
                            "headers" => [
                                [
                                    "name" => "Return-Path",
                                    "value" => "<0000014fbe1c09cf-7cb9f704-7531-4e53-89a1-5fa9744f5eb6-000000@amazonses.com>"
                                ],
                                [
                                    "name" => "Received",
                                    "value" => "from a9-183.smtp-out.amazonses.com (a9-183.smtp-out.amazonses.com [54.240.9.183]) by inbound-smtp.us-east-1.amazonaws.com with SMTP id d6iitobk75ur44p8kdnnp7g2n800 for recipient@example.com; Fri, 11 Sep 2015 20:32:33 +0000 (UTC)"
                                ],
                            ],
                            "commonHeaders" => [
                                "returnPath" => "0000014fbe1c09cf-7cb9f704-7531-4e53-89a1-5fa9744f5eb6-000000@amazonses.com",
                                "from" => [
                                    "sender@example.com"
                                ],
                                "date" => "Fri, 11 Sep 2015 20:32:32 +0000",
                                "to" => [
                                    "recipient@example.com"
                                ],
                                "messageId" => "<61967230-7A45-4A9D-BEC9-87CBCF2211C9@example.com>",
                                "subject" => "Example subject"
                            ]
                        ]
                    ],
                    "eventSource" => "aws:ses"
                ]
            ]
        ];

        $response = $this->postJson('/api/theEasyOne/transformJson', $json);


        $response->assertStatus(200);


        $response->assertJsonStructure([
            'spam',
            'virus',
            'dns',
            'mes',
            'retrasado',
            'emisor',
            'receptor'
        ]);


        $response->assertJson([
            'spam' => true,
            'virus' => true,
            'dns' => true,
            'mes' => 'September',
            'retrasado' => false,
            'emisor' => '61967230-7A45-4A9D-BEC9-87CBCF2211C9',
            'receptor' => [
                'recipient'
            ]
        ]);
    }

    public function testTransformJsonFails()
    {
        $incorrectJson = [
                "Records" => [
                    [
                        "eventVersion" => "1.0",
                        "ses" => [
                            "receipt" => [
                                "timestamp" => "2015-09-11T20:32:33.936Z",
                                "processingTimeMillis" => "incorrect_value",
                                "recipients" => "recipient@example.com",
                                "spamVerdict" => [
                                    "status" => 123
                                ],
                                "virusVerdict" => [],
                                "spfVerdict" => [
                                    "status" => "PASS"
                                ]
                            ]
                        ],
                        "eventSource" => 1234
                    ]
                ]
        ];

        $response = $this->postJson('/api/theEasyOne/transformJson', $incorrectJson);

        $response->assertStatus(400);

        $response->assertJson([
            'message' => 'Validation errors',
        ]);
    }
}
