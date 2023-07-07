<?php

declare(strict_types=1);

namespace Keven\PropertyAccess\Reader;

use PropertyNotFound;

final class ObjectReader implements ReaderInterface
{
    public function canRead($data, string $propertyPath): bool
    {
        return is_object($data);
    }

    public function read($data, string $propertyPath, $defaultValue = null)
    {
        if (property_exists($data, $propertyPath)) {
            return $data->{$propertyPath};
        }

        $methodName = 'get' . ucfirst($propertyPath);
        if (method_exists($data, $methodName)) {
            return $data->{$methodName}();
        }

        if (func_num_args() === 2) {
            throw PropertyNotFound::create($propertyPath, get_class($data));
        }

        return $defaultValue;
    }
}
