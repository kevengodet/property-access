<?php

declare(strict_types=1);

namespace Keven\PropertyAccess\Reader;

use PropertyNotFound;

final class ChainReader implements ReaderInterface
{
    /** @var ReaderInterface[]  */
    private array $readers;
    private static ChainReader $instance;

    public function __construct(ReaderInterface ...$readers)
    {
        $this->readers = $readers;

        if (empty($readers)) {
            $this->readers = [
                new ArrayReader,
                new ObjectReader
            ];
        }

        self::$instance = $this;
    }

    public function canRead($data, string $propertyPath): bool
    {
        foreach ($this->readers as $reader) {
            if ($reader->canRead($data, $propertyPath)) {
                return true;
            }
        }

        return false;
    }

    public function read($data, string $propertyPath, $defaultValue = null)
    {
        foreach ($this->readers as $reader) {
            if ($reader->canRead($data, $propertyPath)) {
                return $reader->read($data, $propertyPath);
            }
        }

        if (func_num_args() === 2) {
            throw PropertyNotFound::create($propertyPath);
        }

        return $defaultValue;
    }

    public static function getInstance(): self
    {
        return  self::$instance ??= new self;
    }
}
