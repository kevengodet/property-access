<?php

declare(strict_types=1);

namespace Keven\PropertyAccess\Reader;

use PropertyNotFound;

final class ArrayReader implements ReaderInterface
{
    public function canRead($data, string $propertyPath): bool
    {
        return is_array($data);
    }

    public function read($data, string $propertyPath, $defaultValue = null)
    {
        $path = explode('.', $propertyPath);
        $current = $data;
        foreach ($path as $property) {
            if (!is_array($current) || !array_key_exists($property, $current)) {
                if (func_num_args() === 2) {
                    throw PropertyNotFound::create($propertyPath);
                }

                return $defaultValue;
            }
            $current = $current[$property];
        }
        
        return $current;
    }
}
