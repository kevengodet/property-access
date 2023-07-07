<?php

declare(strict_types=1);

namespace Keven\PropertyAccess\Writer;

interface WriterInterface
{
    public function canWrite($data, string $propertyPath): bool;
    public function write($data, string $propertyPath, $value): void;
}
