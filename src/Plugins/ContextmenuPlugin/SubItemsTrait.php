<?php

namespace MiNutCz\Tree\Plugins\ContextmenuPlugin;

use MiNutCz\Tree\Enum\MenuActionType;
use MiNutCz\Tree\Exceptions\InvalidStateException;
use MiNutCz\Tree\Plugins\ContextmenuPlugin\Actions\MenuAction;
use MiNutCz\Tree\Plugins\ContextmenuPlugin\Actions\MenuActionCallback;
use MiNutCz\Tree\Plugins\ContextmenuPlugin\Actions\MenuActionCreate;
use MiNutCz\Tree\Plugins\ContextmenuPlugin\Actions\MenuActionDelete;
use MiNutCz\Tree\Plugins\ContextmenuPlugin\Actions\MenuActionEdit;

trait SubItemsTrait
{
    /** @var MenuItem[] */
    protected array $items = [];

    public function addItem(MenuItem $item): void
    {
        $this->items[$item->getName()] = $item;
    }

    /**
     * @param string $label Name of menu item
     * @param MenuActionType|null $menuActionType Type of menu item. If null, menu item can be used as a parent for other menu items.
     * @param callable|null $callback Callback function for menu item. Is required only if $menuActionType is not null.
     *                                function(HandlerArgs $args, JsonTreeResponse $response):void
     * @return MenuItem
     */
    public function createAndAddItem(string $label, ?MenuActionType $menuActionType = null, ?callable $callback = null): MenuItem
    {
        if ($menuActionType === null) {
            $item = new MenuItem($label);
        } else {
            if ($callback === null) {
                throw new InvalidStateException('Callback is required for menu item with action.');
            }
            $item = new MenuItem($label, match ($menuActionType) {
                MenuActionType::CALLBACK => new MenuActionCallback($callback),
                MenuActionType::CREATE => new MenuActionCreate($callback),
                MenuActionType::EDIT => new MenuActionEdit($callback),
                MenuActionType::DELETE => new MenuActionDelete($callback),
            });
        }
        $this->addItem($item);
        return $item;
    }


    public function findAction(string $name): ?MenuAction
    {
        $action = array_key_exists($name, $this->items) ? $this->items[$name]->getAction() : null;
        if ($action === null) {
            foreach ($this->items as $item) {
                $action = $item->findAction($name);
                if ($action !== null) {
                    return $action;
                }
            }
        }
        return $action;
    }
}