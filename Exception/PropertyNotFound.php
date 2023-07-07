<?php

declare(strict_types=1);

final class PropertyNotFound extends \InvalidArgumentException implements PropertyAccessExceptionInterface
{
    static public function create(string $propertyPath, string $objectType = null): self
    {
        $message = sprintf('Property "%s" does not exist', $propertyPath);
        if (null !== $objectType) {
            $message .= sprintf(' on object of type "%s"', $objectType);
        }

        return new self($message);
    }
}
