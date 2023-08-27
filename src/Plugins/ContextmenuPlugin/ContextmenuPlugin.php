<?php

namespace MiNutCz\Tree\Plugins\ContextmenuPlugin;

use MiNutCz\Tree\Handlers\HandlerArgs;
use MiNutCz\Tree\Plugins\PluginInterface;
use MiNutCz\Tree\Response\JsonTreeResponse;

class ContextmenuPlugin implements PluginInterface
{
    use SubItemsTrait;

    public bool $selectNodeOnContextMenuOpen = false;

    public function getName(): string
    {
        return 'contextmenu';
    }

    /**
     * If true, node is selected when context menu is opened.
     * @param bool $selectNodeOnContextMenuOpen
     * @return void
     */
    public function setSelectNodeOnContextMenuOpen(bool $selectNodeOnContextMenuOpen = true): void
    {
        $this->selectNodeOnContextMenuOpen = $selectNodeOnContextMenuOpen;
    }

    /** @inheritDoc */
    public function getConfig(): ?array
    {
        return [
            'select_node' => $this->selectNodeOnContextMenuOpen,
            'menuItems' => $this->items
        ];
    }

    public function handle(HandlerArgs $args, JsonTreeResponse $response): void
    {
        if (array_key_exists($args->getCommand(), $this->items)) {
            $action = $this->findAction($args->getCommand());
            if ($action !== null) {
                $response->refreshTree();
                $action->execute($args, $response);
            }
        }
    }

}