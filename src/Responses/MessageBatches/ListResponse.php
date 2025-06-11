<?php

declare(strict_types=1);

namespace Anthropic\Responses\MessageBatches;

use Anthropic\Contracts\ResponseContract;
use Anthropic\Responses\Concerns\ArrayAccessible;
use Anthropic\Responses\Concerns\HasMetaInformation;
use Anthropic\Responses\Meta\MetaInformation;

/**
 * @implements ResponseContract<array{data: array, has_more: bool, first_id?: string, last_id?: string}>
 */
final class ListResponse implements ResponseContract
{
    use ArrayAccessible;
    use HasMetaInformation;

    /**
     * @param  array<int, array{id: string, type: string, processing_status: string, request_counts: array, created_at: string, expires_at: string, ended_at?: string, archived_at?: string, cancel_initiated_at?: string, results_url?: string}>  $data
     * @param  array{data: array, has_more: bool, first_id?: string, last_id?: string}  $attributes
     */
    private function __construct(
        public readonly array $data,
        public readonly bool $hasMore,
        public readonly ?string $firstId,
        public readonly ?string $lastId,
        private readonly array $attributes,
        private readonly MetaInformation $meta,
    ) {
    }

    /**
     * Acts as static factory, and returns a new Response instance.
     *
     * @param  array{data: array, has_more: bool, first_id?: string, last_id?: string}  $attributes
     */
    public static function from(array $attributes, MetaInformation $meta): self
    {
        return new self(
            $attributes['data'],
            $attributes['has_more'],
            $attributes['first_id'] ?? null,
            $attributes['last_id'] ?? null,
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