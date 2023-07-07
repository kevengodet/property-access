<?php

declare(strict_types=1);

namespace Keven\PropertyAccess;

use Keven\PropertyAccess\Reader\ReaderInterface;
use Keven\PropertyAccess\Reader\ChainReader;
use Keven\PropertyAccess\Writer\ChainWriter;
use Keven\PropertyAccess\Writer\WriterInterface;

final class Accessor implements ReaderInterface, WriterInterface
{
    private ReaderInterface $reader;
    private WriterInterface $writer;

    public function __construct(ReaderInterface $reader = null, WriterInterface $writer = null)
    {
        $this->reader = $reader ?? ChainReader::getInstance();
        $this->writer = $writer ?? ChainWriter::getInstance();
    }

    // ReaderInterface implementation

    public function canRead($data, string $propertyPath): bool
    {
        return $this->reader->canRead($data, $propertyPath);
    }

    public function read($data, string $propertyPath, $defaultValue = null)
    {
        return match(func_num_args()) {
            2 => $this->reader->read($data, $propertyPath),
            3 => $this->reader->read($data, $propertyPath, $defaultValue),
        };
    }

    // WriterInterface implementation

    public function canWrite($data, string $propertyPath): bool
    {
        return $this->writer->canWrite($data, $propertyPath);
    }

    public function write($data, string $propertyPath, $value): void
    {
        $this->writer->write($data, $propertyPath, $value);
    }
}
