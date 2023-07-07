<?php

declare(strict_types=1);

namespace Keven\PropertyAccess\Writer;

final class ObjectWriter implements WriterInterface
{
    public function canWrite($data, string $propertyPath): bool
    {
        return is_object($data);
    }

    public function write($data, string $propertyPath, $value): void
    {
        $methodName = 'set' . ucfirst($propertyPath);
        if (method_exists($data, $methodName)) {
            $data->{$methodName}($value);
            return;
        }

        $r = new \ReflectionClass($data);

        if (!$r->hasProperty($propertyPath)) {
            $data->{$propertyPath} = $value;
        }

        $property = $r->getProperty($propertyPath);
        $property->setAccessible(true);
        $property->setValue($data, $value);
    }
}
