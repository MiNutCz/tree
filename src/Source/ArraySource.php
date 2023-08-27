<?php

namespace MiNutCz\Tree\Source;


readonly class ArraySource implements SourceInterface
{
    /**
     * @param array<int,mixed> $data
     */
    public function __construct(private array $data)
    {
    }

    /** @inheritDoc */
    public function getTreeNodes(): array
    {
        return $this->data;
    }

}