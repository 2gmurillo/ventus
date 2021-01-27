<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Support\Facades\Http;

trait ConsumeExternalServices
{
    public function makeRequest($method, $requestUrl, $queryParameters = []): array
    {
        if (method_exists($this, 'resolveAuthorization')) {
            $this->resolveAuthorization($queryParameters);
        }
        $response = Http::$method($this->endpointBase . $requestUrl, $queryParameters);
        if (method_exists($this, 'decodeResponse')) {
            $response = $this->decodeResponse($response);
        }
        return $response;
    }
}
