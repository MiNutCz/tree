<?php

namespace MiNutCz\Tree\Plugins\ContextmenuPlugin\Actions;

use MiNutCz\Tree\Enum\MenuActionType;

class MenuActionCallback extends MenuAction
{

    public function getType(): MenuActionType
    {
        return MenuActionType::CALLBACK;
    }
}