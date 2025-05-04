<?php

declare(strict_types=1);

namespace App\Domain\Collection;

use Countable;
use Iterator;
use IteratorAggregate;

/**
 * @template TKey
 * @template TValue
 *
 * @template-extends IteratorAggregate<TKey, TValue>
 */
interface CollectionInterface extends Countable, IteratorAggregate
{
    /**
     * @param TValue $item
     */
    public function add(mixed $item): void;

    /**
     * @return array<TKey, TValue>
     */
    public function toArray(): array;

    public function count(): int;

    public function isEmpty(): bool;

    /**
     * @return Iterator<TKey, TValue>
     */
    public function getIterator(): Iterator;

    public function reset(): void;
}
