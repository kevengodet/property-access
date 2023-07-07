<?php

declare(strict_types=1);

namespace Keven\PropertyAccess\Writer;

final class ChainWriter implements WriterInterface
{
    /** @var WriterInterface[]  */
    private array $writers;
    private static ChainWriter $instance;

    public function __construct(WriterInterface ...$writers)
    {
        $this->writers = $writers;

        if (empty($writers)) {
            $this->writers = [
                new ArrayWriter,
                new ObjectWriter,
            ];
        }

        self::$instance = $this;
    }

    public function canWrite($data, string $propertyPath): bool
    {
        foreach ($this->writers as $reader) {
            if ($reader->canWrite($data, $propertyPath)) {
                return true;
            }
        }

        return false;
    }

    public function write($data, string $propertyPath, $value): void
    {
        foreach ($this->writers as $reader) {
            if ($reader->canWrite($data, $propertyPath)) {
                $reader->write($data, $propertyPath, $value);
                return;
            }
        }
    }

    public static function getInstance(): self
    {
        return  self::$instance ??= new self;
    }
}
