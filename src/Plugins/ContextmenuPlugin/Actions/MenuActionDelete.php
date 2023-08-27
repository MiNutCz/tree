<?php

namespace MiNutCz\Tree\Plugins\ContextmenuPlugin\Actions;

use MiNutCz\Tree\Enum\MenuActionType;

class MenuActionDelete extends MenuAction
{
    public function getType(): MenuActionType
    {
        return MenuActionType::DELETE;
    }
}