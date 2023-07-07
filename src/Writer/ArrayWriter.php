<?php

declare(strict_types=1);

namespace Keven\PropertyAccess\Writer;

final class ArrayWriter implements WriterInterface
{
    public function canWrite($data, string $propertyPath): bool
    {
        return is_array($data);
    }

    /**
     * @param array $data
     * @param string $propertyPath
     * @param $value
     * @return mixed|null
     */
    public function write($data, string $propertyPath, $value): void
    {
        $path = explode('.', $propertyPath);
        $current = &$data;
        foreach ($path as $key) {
            if (!isset($current[$key])) {
                $current[$key] = [];
            }
            $current = &$current[$key];
        }
        $current = $value;
    }
}
