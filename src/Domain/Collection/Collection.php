<?php

declare(strict_types=1);

namespace App\Domain\Collection;

use App\Domain\Exception\Collection\CollectionItemInvalidException;
use ArrayIterator;
use EmptyIterator;
use Iterator;

/**
 * @template TKey
 * @template TValue
 *
 * @template-implements CollectionInterface<TKey, TValue>
 */
class Collection implements CollectionInterface
{
    /**
     * @var array<TKey, TValue>
     */
    protected array $items = [];

    /**
     * @param array<TKey, TValue> $items
     */
    public function __construct(iterable $items = [])
    {
        foreach ($items as $item) {
            $this->add($item);
        }
    }

    /**
     * @param TValue $item
     */
    public function add(mixed $item): void
    {
        if (!$this->isValid($item)) {
            throw new CollectionItemInvalidException();
        }

        $this->items[] = $item;
    }

    /**
     * @return array<int|string, TValue>
     */
    public function toArray(): array
    {
        return array_values($this->items);
    }

    public function count(): int
    {
        return count($this->items);
    }

    public function isEmpty(): bool
    {
        return 0 === $this->count();
    }

    /**
     * @return Iterator<TKey, TValue>
     */
    public function getIterator(): Iterator
    {
        if (!$this->isEmpty()) {
            // @phpstan-ignore-next-line
            return new ArrayIterator($this->toArray());
        }

        return new EmptyIterator();
    }

    public function reset(): void
    {
        $this->items = [];
    }

    /**
     * @param TValue $value
     */
    protected function isValid(mixed $value): bool
    {
        if (null === $value || 0 === count($this->items)) {
            return true;
        }

        $firstItem = $this->items[array_key_first($this->items)];
        $itemType = gettype($firstItem);

        if ('object' !== $itemType) {
            return $itemType === gettype($value);
        }

        assert(is_object($firstItem));

        $itemClass = get_class($firstItem);

        return $value instanceof $itemClass;
    }
}
