<?php

namespace App\Services;

use App\Factories\RecordFactory;
use App\Transformers\EmailAnalysisTransformer;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;

class JsonTransformerService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function transformJson($json): array
    {
        // Validate and parse JSON data
        if (!isset($json['Records']) || !is_array($json['Records'])) {
            throw new \InvalidArgumentException('Invalid JSON format.');
        }

        // Convert JSON data into a class instance using the Factory pattern
        $jsonClass = RecordFactory::createFromJsonArray($json['Records'])[0];

        // Create Fractal Manager and Transformer
        $fractal = new Manager();
        $transformer = new EmailAnalysisTransformer();
        $resource = new Item($jsonClass, $transformer);

        // Transform data
        return $fractal->createData($resource)->toArray()['data'] ?? [];
    }

}
