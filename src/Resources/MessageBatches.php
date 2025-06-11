<?php

declare(strict_types=1);

namespace Anthropic\Resources;

use Anthropic\ValueObjects\Transporter\Payload;
use Anthropic\Responses\MessageBatches\CreateResponse;
use Anthropic\Responses\MessageBatches\RetrieveResponse;
use Anthropic\Responses\MessageBatches\ListResponse;
use Anthropic\Responses\MessageBatches\CancelResponse;
use Anthropic\Responses\MessageBatches\ResultsResponse;

final class MessageBatches
{
    use Concerns\Transportable;

    /**
     * Create a message batch
     */
    public function create(array $parameters): CreateResponse
    {
        $payload = Payload::create('messages/batches', $parameters);
        
        $response = $this->transporter->requestObject($payload);
        
        return CreateResponse::from($response->data(), $response->meta());
    }

    /**
     * Retrieve a message batch
     */
    public function retrieve(string $messageBatchId): RetrieveResponse
    {
        $payload = Payload::retrieve('messages/batches', $messageBatchId);
        
        $response = $this->transporter->requestObject($payload);
        
        return RetrieveResponse::from($response->data(), $response->meta());
    }

    /**
     * List message batches
     */
    public function list(array $parameters = []): ListResponse
    {
        $payload = Payload::list('messages/batches', $parameters);
        
        $response = $this->transporter->requestObject($payload);
        
        return ListResponse::from($response->data(), $response->meta());
    }

    /**
     * Cancel a message batch
     */
    public function cancel(string $messageBatchId): CancelResponse
    {
        // Create a POST payload for the cancel endpoint
        $payload = new Payload(
            contentType: 'application/json',
            method: 'POST',
            uri: "messages/batches/{$messageBatchId}/cancel",
            parameters: [],
        );
        
        $response = $this->transporter->requestObject($payload);
        
        return CancelResponse::from($response->data(), $response->meta());
    }

    /**
     * Get batch results
     */
    public function results(string $messageBatchId): ResultsResponse
    {
        // Create a GET payload for the results endpoint
        $payload = new Payload(
            contentType: 'application/json',
            method: 'GET',
            uri: "messages/batches/{$messageBatchId}/results",
            parameters: [],
        );
        
        $response = $this->transporter->requestObject($payload);
        
        return ResultsResponse::from($response->data(), $response->meta());
    }
}