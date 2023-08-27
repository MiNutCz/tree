<?php

namespace MiNutCz\Tree\Source;


interface SourceInterface
{

    /**
     * Get tree nodes
     * @return array<int,mixed>
     */
    public function getTreeNodes(): array;

}