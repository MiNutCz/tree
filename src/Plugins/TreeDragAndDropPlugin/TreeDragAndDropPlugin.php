<?php

namespace MiNutCz\Tree\Plugins\TreeDragAndDropPlugin;

use MiNutCz\Tree\Plugins\PluginInterface;

class TreeDragAndDropPlugin implements PluginInterface
{

    public function getName(): string
    {
        return 'dnd';
    }

    /** @inheritDoc */
    public function getConfig(): ?array
    {
        return [];
    }
}