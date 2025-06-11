<?php

declare(strict_types=1);

namespace Anthropic\Responses\MessageBatches;

use Anthropic\Contracts\ResponseContract;
use Anthropic\Responses\Concerns\ArrayAccessible;
use Anthropic\Responses\Concerns\HasMetaInformation;
use Anthropic\Responses\Meta\MetaInformation;

/**
 * @implements ResponseContract<array>
 */
final class ResultsResponse implements ResponseContract
{
    use ArrayAccessible;
    use HasMetaInformation;

    /**
     * @param  array<int, array{custom_id: string, result: array}>  $results
     * @param  array<int, array{custom_id: string, result: array}>  $attributes
     */
    private function __construct(
        public readonly array $results,
        private readonly array $attributes,
        private readonly MetaInformation $meta,
    ) {
    }

    /**
     * Acts as static factory, and returns a new Response instance.
     *
     * @param  array<int, array{custom_id: string, result: array}>  $attributes
     */
    public static function from(array $attributes, MetaInformation $meta): self
    {
        return new self(
            $attributes,
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