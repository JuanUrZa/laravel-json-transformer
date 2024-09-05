<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransformJsonRequest;
use App\Services\JsonTransformerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;


class TheEasyOneController extends Controller
{

    protected JsonTransformerService $jsonTransformerService;

    public function __construct(JsonTransformerService $jsonTransformerService)
    {
        $this->jsonTransformerService = $jsonTransformerService;
    }

    /**
     * Handle the transformation of the incoming JSON request.
     *
     * This method receives a JSON payload, processes it, and returns a transformed JSON response.
     * The request is validated and mapped to a specific structure using the defined rules.
     *
     * @param  \App\Http\Requests\TransformJsonRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function transformJson(TransformJsonRequest $request): JsonResponse
    {
        $json = $request->all();

        try {
            $out = $this->jsonTransformerService->transformJson($json);
        } catch (\Throwable $e) {
            Log::error('Data transformation error', [
                'exception' => $e,
                'input' => $json
            ]);

            return response()->json([
                'error' => 'An error occurred during data transformation.',
                'message' => 'Please try again later.'
            ], 500);
        }

        return response()->json($out, 200);
    }
}
