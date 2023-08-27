<?php

namespace MiNutCz\Tree\Plugins\TypesPlugin;

use MiNutCz\Tree\Plugins\PluginInterface;

class TypesPlugin implements PluginInterface
{
    /** @var Type[] */
    private array $types = [];

    public function getName(): string
    {
        return 'types';
    }

    public function addType(Type $type): void
    {
        $this->types[$type->getName()] = $type;
    }

    /** @inheritDoc */
    public function getConfig(): ?array
    {
        return $this->types;
    }

}