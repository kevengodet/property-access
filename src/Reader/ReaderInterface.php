<?php

declare(strict_types=1);

namespace Keven\PropertyAccess\Reader;

use PropertyNotFound;

interface ReaderInterface
{
    public function canRead($data, string $propertyPath): bool;
    
    /**
     * @throws PropertyNotFound
     */
    public function read($data, string $propertyPath, $defaultValue = null);
}
