<?php

namespace MiNutCz\Tree\Plugins\ContextmenuPlugin\Actions;

use MiNutCz\Tree\Enum\MenuActionType;
use MiNutCz\Tree\Handlers\HandlerArgs;
use MiNutCz\Tree\Response\JsonTreeResponse;

abstract class MenuAction
{

    /** @var callable */
    private mixed $callback;

    public function __construct(callable $callback)
    {
        $this->callback = $callback;
    }

    abstract public function getType(): MenuActionType;

    public function execute(HandlerArgs $args, JsonTreeResponse $response): void
    {
        call_user_func($this->callback, $args, $response);
    }

}