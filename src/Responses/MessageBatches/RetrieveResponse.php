<?php

declare(strict_types=1);

namespace Anthropic\Responses\MessageBatches;

use Anthropic\Contracts\ResponseContract;
use Anthropic\Responses\Concerns\ArrayAccessible;
use Anthropic\Responses\Concerns\HasMetaInformation;
use Anthropic\Responses\Meta\MetaInformation;

/**
 * @implements ResponseContract<array{id: string, type: string, processing_status: string, request_counts: array, created_at: string, expires_at: string, ended_at?: string, archived_at?: string, cancel_initiated_at?: string, results_url?: string}>
 */
final class RetrieveResponse implements ResponseContract
{
    use ArrayAccessible;
    use HasMetaInformation;

    /**
     * @param  array{id: string, type: string, processing_status: string, request_counts: array, created_at: string, expires_at: string, ended_at?: string, archived_at?: string, cancel_initiated_at?: string, results_url?: string}  $attributes
     */
    private function __construct(
        public readonly string $id,
        public readonly string $type,
        public readonly string $processingStatus,
        public readonly array $requestCounts,
        public readonly string $createdAt,
        public readonly string $expiresAt,
        public readonly ?string $endedAt,
        public readonly ?string $archivedAt,
        public readonly ?string $cancelInitiatedAt,
        public readonly ?string $resultsUrl,
        private readonly array $attributes,
        private readonly MetaInformation $meta,
    ) {
    }

    /**
     * Acts as static factory, and returns a new Response instance.
     *
     * @param  array{id: string, type: string, processing_status: string, request_counts: array, created_at: string, expires_at: string, ended_at?: string, archived_at?: string, cancel_initiated_at?: string, results_url?: string}  $attributes
     */
    public static function from(array $attributes, MetaInformation $meta): self
    {
        return new self(
            $attributes['id'],
            $attributes['type'],
            $attributes['processing_status'],
            $attributes['request_counts'],
            $attributes['created_at'],
            $attributes['expires_at'],
            $attributes['ended_at'] ?? null,
            $attributes['archived_at'] ?? null,
            $attributes['cancel_initiated_at'] ?? null,
            $attributes['results_url'] ?? null,
            $attributes,
            $meta,
        );
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return $this->attributes;
    }
}